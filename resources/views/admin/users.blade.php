@extends('layouts.app')

@section('content')
<div class="page-header">
    <h2>User Management</h2>
    <p>Perform administrative actions, manage roles, and monitor user accounts.</p>
</div>

<div class="card" style="margin-top: 2rem;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; border-bottom: 1px solid #f1f5f9; color: #718096; font-size: 0.85rem; background: #f8fafc;">
                <th style="padding: 1.5rem;">USER</th>
                <th style="padding: 1.5rem;">STATUS / ROLE</th>
                <th style="padding: 1.5rem;">DETAILS</th>
                <th style="padding: 1.5rem;">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr style="border-bottom: 1px solid #f8fafc;">
                <td style="padding: 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" style="width: 40px; height: 40px; border-radius: 12px;">
                        <div>
                            <p style="font-weight: 700; margin: 0;">{{ $user->name }}</p>
                            <p style="font-size: 0.8rem; color: #a0aec0; margin: 0;">{{ $user->email }}</p>
                        </div>
                    </div>
                </td>
                <td style="padding: 1.5rem;">
                    <form action="{{ route('admin.users.role', $user->id) }}" method="POST" style="display: flex; gap: 5px;">
                        @csrf
                        <select name="role" onchange="this.form.submit()" style="padding: 5px 10px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.8rem; font-weight: 600; color: #4a5568;">
                            <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Student</option>
                            <option value="alumni" {{ $user->role == 'alumni' ? 'selected' : '' }}>Alumni</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </form>
                </td>
                <td style="padding: 1.5rem; font-size: 0.85rem; color: #718096;">
                    {{ $user->department }}<br>
                    Class of {{ $user->graduation_year }}
                </td>
                <td style="padding: 1.5rem;">
                    <div style="display: flex; gap: 10px;">
                        <button class="social-btn" style="padding: 0.5rem; color: #3182ce;"><i class="fa-solid fa-pen-to-square"></i></button>
                        <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="social-btn" style="padding: 0.5rem; color: #e53e3e;"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="padding: 1.5rem; border-top: 1px solid #f1f5f9;">
        {{ $users->links() }}
    </div>
</div>
@endsection
