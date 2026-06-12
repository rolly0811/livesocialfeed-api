<?php

namespace Database\Seeders;

use App\Models\EventCategory;
use Illuminate\Database\Seeder;

class EventCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EventCategory::truncate();
        EventCategory::create([
            'name' => 'Wedding',
            'type' => 'wedding',
            'icon' => 'mdi-ring'
        ]);

        EventCategory::create([
            'name' => 'Honeymoon',
            'type' => 'travel',
            'icon' => 'mdi-beach'
        ]);

        EventCategory::create([
            'name' => 'Anniversary',
            'type' => 'celebration',
            'icon' => 'mdi-cake-variant'
        ]);

        EventCategory::create([
            'name' => 'Proposal',
            'type' => 'celebration',
            'icon' => 'mdi-account-heart'
        ]);

        EventCategory::create([
            'name' => 'Birthday Celebration',
            'icon' => 'mdi-cake-variant',
            'type' => 'celebration'
        ]);

        EventCategory::create([
            'name' => 'Corporate Event',
            'icon' => 'mdi-account-group',
            'type' => 'celebration'
        ]);

        EventCategory::create([
            'name' => 'Team Building',
            'icon' => 'mdi-account-group',
            'type' => 'celebration'
        ]);

        EventCategory::create([
            'name' => 'Incentive Travel',
            'icon' => 'mdi-account-group',
            'type' => 'travel'
        ]);

        EventCategory::create([
            'name' => 'Family Vacation',
            'icon' => 'mdi-account-group',
            'type' => 'travel'
        ]);

        EventCategory::create([
            'name' => 'Destination Event',
            'icon' => 'mdi-account-group',
            'type' => 'travel'
        ]);

        EventCategory::create([
            'name' => 'Other Celebration',
            'icon' => 'mdi-account-group',
            'type' => 'celebration'
        ]);
    }
}
