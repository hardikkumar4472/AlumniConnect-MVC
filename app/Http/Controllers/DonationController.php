<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\DonationCampaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    // -----------------------------------------------------------------------
    // Razorpay DUMMY credentials (hardcoded for demo)
    // In production replace with config('services.razorpay.key_id') etc.
    // -----------------------------------------------------------------------
    const RAZORPAY_KEY_ID     = 'rzp_test_XXXXXXXXXXXXXXXX';
    const RAZORPAY_KEY_SECRET = 'XXXXXXXXXXXXXXXXXXXXXXXX';

    /**
     * Show the main donations page.
     */
    public function index()
    {
        $campaigns    = DonationCampaign::where('is_active', true)
                            ->orderBy('created_at', 'desc')
                            ->get();

        $my_donations = Donation::where('user_id', Auth::id())
                            ->where('status', 'success')
                            ->orderBy('created_at', 'desc')
                            ->get();

        $total_raised = Donation::where('status', 'success')->sum('amount');
        $donor_count  = Donation::where('status', 'success')
                            ->distinct('user_id')
                            ->count('user_id');

        $my_total     = Donation::where('user_id', Auth::id())
                            ->where('status', 'success')
                            ->sum('amount');

        // Aggregations using collections for maximum safety and compatibility
        $all_success = Donation::where('status', 'success')->get();

        // 1. Individual Donors Leaderboard
        $individual_leaderboard = $all_success->groupBy('user_id')->map(function($group) {
            return [
                'name'  => $group->first()->user_name ?? 'Alumni Contributor',
                'total' => $group->sum('amount'),
                'count' => $group->count(),
            ];
        })->sortByDesc('total')->take(5)->values();

        // 2. Batch Leaderboard (Grouped by graduation year)
        $batch_leaderboard = $all_success->map(function($d) {
            $user = \App\Models\User::find($d->user_id);
            $d->graduation_year = $user->graduation_year ?? 'N/A';
            return $d;
        })->groupBy('graduation_year')->map(function($group, $year) {
            return [
                'year'  => $year === 'N/A' ? 'Unknown' : 'Batch of ' . $year,
                'total' => $group->sum('amount'),
                'count' => $group->count(),
            ];
        })->sortByDesc('total')->take(5)->values();

        // 3. Dynamic Trends data for Chart.js
        $trends = $all_success->groupBy(function($d) {
            return $d->created_at ? $d->created_at->format('M Y') : now()->format('M Y');
        })->map(function($group) {
            return $group->sum('amount');
        })->take(6);

        return view('pages.donations', compact(
            'campaigns', 'my_donations', 'total_raised', 'donor_count', 'my_total',
            'individual_leaderboard', 'batch_leaderboard', 'trends'
        ));
    }

    /**
     * Create a Razorpay order (dummy).
     */
    public function createOrder(Request $request)
    {
        $request->validate([
            'amount'      => 'required|numeric|min:1',
            'purpose'     => 'required|string|max:255',
            'campaign_id' => 'nullable|string',
        ]);

        $amountPaise = (int) ($request->amount * 100);

        // Dummy Razorpay order
        $dummyOrder = [
            'id'       => 'order_' . strtoupper(substr(md5(uniqid()), 0, 16)),
            'amount'   => $amountPaise,
            'currency' => 'INR',
            'receipt'  => 'rcpt_' . time(),
            'status'   => 'created',
        ];

        $donation = Donation::create([
            'user_id'     => Auth::id(),
            'user_name'   => Auth::user()->name,
            'campaign_id' => $request->campaign_id ?? null,
            'purpose'     => $request->purpose,
            'amount'      => (float) $request->amount,
            'order_id'    => $dummyOrder['id'],
            'payment_id'  => null,
            'status'      => 'pending',
            'message'     => $request->message ?? null,
        ]);

        return response()->json([
            'order'       => $dummyOrder,
            'donation_id' => (string) $donation->_id,
            'key_id'      => self::RAZORPAY_KEY_ID,
            'name'        => Auth::user()->name,
            'email'       => Auth::user()->email,
        ]);
    }

    /**
     * Verify & confirm payment (dummy – always succeeds for demo).
     */
    public function verifyPayment(Request $request)
    {
        $request->validate([
            'donation_id'          => 'required|string',
            'razorpay_order_id'    => 'required|string',
            'razorpay_payment_id'  => 'required|string',
        ]);

        $donation = Donation::findOrFail($request->donation_id);

        $donation->update([
            'payment_id' => $request->razorpay_payment_id,
            'status'     => 'success',
        ]);

        // Update campaign raised amount
        if ($donation->campaign_id) {
            $campaign = DonationCampaign::find($donation->campaign_id);
            if ($campaign) {
                $campaign->increment('raised_amount', $donation->amount);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment verified! Thank you for your generous contribution.',
        ]);
    }

    /**
     * Alumni creates a new donation campaign.
     */
    public function createCampaign(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'goal_amount' => 'required|numeric|min:1000',
            'category'    => 'required|string',
        ]);

        DonationCampaign::create([
            'created_by'    => Auth::id(),
            'creator_name'  => Auth::user()->name,
            'title'         => $request->title,
            'description'   => $request->description,
            'goal_amount'   => (float) $request->goal_amount,
            'raised_amount' => 0,
            'category'      => $request->category,
            'is_active'     => true,
        ]);

        return back()->with('campaign_success', 'Your campaign has been created!');
    }
}
