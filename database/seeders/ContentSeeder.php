<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AlumniEvent;
use App\Models\SuccessStory;
use App\Models\Resource;
use Faker\Factory as Faker;

class ContentSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('en_US');

        // Clear existing to avoid language mixing
        AlumniEvent::truncate();
        SuccessStory::truncate();
        Resource::truncate();

        // Generate 35 Events
        for ($i = 0; $i < 35; $i++) {
            $date = $faker->dateTimeBetween('now', '+1 year');
            AlumniEvent::create([
                'title' => $faker->catchPhrase . ' Summit',
                'date' => $date->format('j'),
                'month' => strtoupper($date->format('M')),
                'time' => $faker->time('g:i A') . ' - ' . $faker->time('g:i A'),
                'location' => $faker->city . ' & Virtual',
                'description' => $faker->realText(150),
            ]);
        }

        // Generate 35 Stories
        $storyTopics = [
            'How I Built My First Startup',
            'From Intern to Executive Director',
            'Navigating the World of Tech',
            'My Journey in Renewable Energy',
            'Lessons Learned in Finance',
            'Overcoming Failure in Business',
            'Leading a Global Remote Team',
            'Breaking into Artificial Intelligence',
            'My Experience in the Nonprofit Sector',
            'Pivoting My Career in My 30s'
        ];

        for ($i = 0; $i < 35; $i++) {
            $name = $faker->name;
            SuccessStory::create([
                'title' => $faker->randomElement($storyTopics) . ' - ' . $faker->company,
                'author' => $name,
                'content' => $faker->realText(500),
                'image' => 'https://ui-avatars.com/api/?name='.urlencode($name).'&background=random&color=fff',
            ]);
        }

        // Generate 35 Resources
        $types = ['Guide', 'Template', 'Document', 'Video', 'Toolkit'];
        $resourceTitles = [
            'Software Engineering Interview Prep',
            'Marketing Resume Template',
            'Project Management Toolkit',
            'Investment Banking Guide',
            'Startup Pitch Deck Template',
            'Negotiation Tactics Document',
            'Data Science Learning Path',
            'Freelancing Tax Guide',
            'UI/UX Design Portfolio Template',
            'Remote Work Productivity Video'
        ];

        for ($i = 0; $i < 35; $i++) {
            \App\Models\Resource::create([
                'title' => $faker->randomElement($resourceTitles) . ' ' . $faker->year,
                'type' => $faker->randomElement($types),
                'link' => $faker->url,
                'description' => $faker->realText(100),
            ]);
        }

        // Generate 15 Campus News
        \App\Models\CampusNews::truncate();
        $newsTitles = [
            'Annual Tech Fest Dates Announced',
            'New AI Research Lab Opening Next Month',
            'Campus Placement Drive Hits Record High',
            'Alumni Association Donates New Library Books',
            'Robotics Team Wins National Championship',
            'University Ranked #1 in Innovation',
            'Upcoming Seminar on Green Energy',
            'Student Council Elections Complete',
            'Campus Connectivity Project Finished',
            'New Scholarships Announced for Engineering Students'
        ];

        for ($i = 0; $i < 15; $i++) {
            $date = $faker->dateTimeBetween('-1 year', 'now');
            \App\Models\CampusNews::create([
                'title' => $faker->randomElement($newsTitles),
                'content' => $faker->realText(200),
                'date' => $date->format('M d, Y'),
            ]);
        }
    }
}
