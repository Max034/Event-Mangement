<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing
        Booking::truncate();
        Event::truncate();
        Category::truncate();
        User::truncate();

        // Users
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@eventhub.test',
            'password' => 'password',
            'role' => User::ROLE_ADMIN,
        ]);

        $organizer = User::create([
            'name' => 'Jane Organizer',
            'email' => 'organizer@eventhub.test',
            'password' => 'password',
            'role' => User::ROLE_ORGANIZER,
            'phone' => '+91 9876543210',
        ]);

        $attendee = User::create([
            'name' => 'John Attendee',
            'email' => 'attendee@eventhub.test',
            'password' => 'password',
            'role' => User::ROLE_ATTENDEE,
        ]);

        // Categories
        $cats = collect([
            ['name' => 'Music',       'icon' => '🎵', 'description' => 'Concerts, gigs, festivals'],
            ['name' => 'Tech',        'icon' => '💻', 'description' => 'Conferences, hackathons, meetups'],
            ['name' => 'Workshop',    'icon' => '🛠️', 'description' => 'Hands-on learning sessions'],
            ['name' => 'Sports',      'icon' => '⚽', 'description' => 'Tournaments and matches'],
            ['name' => 'Food & Drink','icon' => '🍔', 'description' => 'Food fests, tastings'],
            ['name' => 'Arts',        'icon' => '🎨', 'description' => 'Exhibitions, theatre, dance'],
        ])->map(function ($c) {
            return Category::create([
                'name' => $c['name'],
                'slug' => Str::slug($c['name']),
                'icon' => $c['icon'],
                'description' => $c['description'],
            ]);
        });

        // Sample events
        $samples = [
            ['Bollywood Night Concert', 'Music',    'NSCI Stadium',     'Mumbai',    7,  799,  500, true, 'event_bollywood.png'],
            ['Laravel Mumbai Meetup',   'Tech',     'WeWork BKC',       'Mumbai',    14, 0,    80,  false, 'event_tech_meetup.png'],
            ['Generative AI Workshop',  'Workshop', 'Innov8 Coworking', 'Bengaluru', 10, 1499, 40,  true, 'event_ai_workshop.png'],
            ['Premier Football Cup',    'Sports',   'DY Patil Stadium', 'Mumbai',    21, 250,  10000, false, 'event_football.png'],
            ['Street Food Carnival',    'Food & Drink','Cubbon Park',   'Bengaluru', 5,  149,  1200,false, 'event_food.png'],
            ['Indie Theatre Night',     'Arts',     'Prithvi Theatre',  'Mumbai',    12, 399,  150, false, 'event_theatre.png'],
            ['DevOps Day India',        'Tech',     'Hyatt Regency',    'Pune',      30, 1999, 300, true, 'event_devops.png'],
            ['Acoustic Sunday Sessions','Music',    'Sky Lounge',       'Delhi',     3,  499,  120, false, 'event_acoustic.png'],
        ];

        foreach ($samples as $i => [$title, $catName, $venue, $city, $daysFromNow, $price, $capacity, $featured, $imgName]) {
            $cat = $cats->firstWhere('name', $catName);
            Event::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'description' => "Join us for {$title} — an unforgettable experience full of energy, networking and great moments. Don't miss out!\n\nWhat to expect:\n• Top-tier lineup\n• Food & drinks\n• Networking opportunities",
                'venue' => $venue,
                'address' => $venue,
                'city' => $city,
                'starts_at' => now()->addDays($daysFromNow)->setTime(18, 30),
                'ends_at' => now()->addDays($daysFromNow)->setTime(22, 0),
                'price' => (float) $price,
                'capacity' => (int) $capacity,
                'seats_booked' => 0,
                'category_id' => (string) $cat->_id,
                'organizer_id' => (string) $organizer->_id,
                'status' => Event::STATUS_PUBLISHED,
                'image' => 'events/' . $imgName,
                'is_featured' => $featured,
            ]);
        }

        $this->command->info('✅ Seeded users, categories, and sample events.');
        $this->command->info('   Admin:     admin@eventhub.test     / password');
        $this->command->info('   Organizer: organizer@eventhub.test / password');
        $this->command->info('   Attendee:  attendee@eventhub.test  / password');
    }
}
