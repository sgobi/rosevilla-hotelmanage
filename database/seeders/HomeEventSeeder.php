<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomeEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\HomeEvent::create([
            'title' => 'Weddings',
            'description' => 'Say "I do" amidst blooming frangipanis and colonial elegance. We curate intimate unions that become timeless memories.',
            'image_path' => 'images/wedding_event_rosevilla.png', // Note: using public folder for initial seed
            'icon' => 'heart',
            'sort_order' => 1,
        ]);

        \App\Models\HomeEvent::create([
            'title' => 'Corporate',
            'description' => 'Inspire your team in a sanctuary of calm. Our spaces are tailored for focused leadership retreats and strategy sessions.',
            'image_path' => 'images/corporate_event_rosevilla.png',
            'icon' => 'building',
            'sort_order' => 2,
        ]);

        \App\Models\HomeEvent::create([
            'title' => 'Private Dining',
            'description' => 'Experience curated culinary journeys under the stars. Authentic Jaffna flavors served with our signature grace.',
            'image_path' => 'images/private_dining_rosevilla.png',
            'icon' => 'cake',
            'sort_order' => 3,
        ]);
    }
}
