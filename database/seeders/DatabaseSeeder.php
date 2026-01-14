<?php

namespace Database\Seeders;

use App\Models\ContentSetting;
use App\Models\GalleryImage;
use App\Models\Landmark;
use App\Models\Review;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@rosevilla.com'],
            [
                'name' => 'Rosevilla Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        User::factory()->create([
            'name' => 'Rosevilla Team',
            'email' => 'staff@rosevilla.com',
            'role' => 'staff',
        ]);

        $rooms = [
            [
                'title' => 'Heritage Suite',
                'slug' => 'heritage-suite',
                'subtitle' => 'Handcrafted teak interiors overlooking the courtyard',
                'description' => 'Soak in calm Jaffna mornings from a canopy bed, with brass fixtures, handwoven linens, and a private sit-out that spills onto the garden.',
                'amenities' => [
                    'King canopy bed',
                    'Ensuite rain shower',
                    'Private verandah with courtyard view',
                    'Breakfast with heritage recipes',
                ],
                'price_per_night' => 55500,
                'capacity' => 3,
                'bed_type' => 'King + daybed',
                'featured_image' => 'https://rosevillaheritagehomes.com/wp-content/uploads/2025/05/Things-to-do-Jaffna-Sri-lanka-nature-pool-648x810-1.jpg',
                'gallery_urls' => [
                    'https://rosevillaheritagehomes.com/wp-content/uploads/2025/05/WhatsApp-Image-2024-08-31-at-4.16.49-PM.jpeg',
                    'https://rosevillaheritagehomes.com/wp-content/uploads/2025/05/WhatsApp-Image-2024-08-08-at-5.40.14-PM.jpeg',
                    'https://rosevillaheritagehomes.com/wp-content/uploads/2025/05/Fj2DQHfUoAApqX01-1024x868.jpg',
                ],
                'is_active' => true,
            ],
            [
                'title' => 'Garden Villa',
                'slug' => 'garden-villa',
                'subtitle' => 'Sunlit suite surrounded by palms and frangipani',
                'description' => 'Open your doors to birdsong and a lush courtyard. Ideal for slow days, hammock lounging, and dinners under lantern-lit pergolas.',
                'amenities' => [
                    'Queen bed + optional twin',
                    'Outdoor seating nook',
                    'Herbal welcome drink',
                    'Complimentary bicycles',
                ],
                'price_per_night' => 46500,
                'capacity' => 3,
                'bed_type' => 'Queen + twin',
                'featured_image' => 'https://rosevillaheritagehomes.com/wp-content/uploads/2025/05/Fj2DQHfUoAApqX01.jpg',
                'gallery_urls' => [
                    'https://rosevillaheritagehomes.com/wp-content/uploads/2025/05/WhatsApp-Image-2024-08-08-at-5.40.15-PM.jpeg',
                    'https://rosevillaheritagehomes.com/wp-content/uploads/2025/05/WhatsApp-Image-2024-08-07-at-6.45.39-PM.jpeg',
                    'https://rosevillaheritagehomes.com/wp-content/uploads/2025/05/WhatsApp-Image-2024-08-07-at-6.45.39-PM2.jpeg',
                ],
                'is_active' => true,
            ],
        ];

        foreach ($rooms as $room) {
            Room::updateOrCreate(['slug' => $room['slug']], $room);
        }

        $galleryImages = [
            [
                'title' => 'Poolside dawn',
                'category' => 'villa',
                'image_url' => 'https://rosevillaheritagehomes.com/wp-content/uploads/2025/05/Things-to-do-Jaffna-Sri-lanka-nature-pool-648x810-1.jpg',
                'description' => 'Morning light across the courtyard pool.',
                'is_featured' => true,
            ],
            [
                'title' => 'Garden archways',
                'category' => 'villa',
                'image_url' => 'https://rosevillaheritagehomes.com/wp-content/uploads/2025/05/Fj2DQHfUoAApqX01-1024x868.jpg',
                'description' => 'Shaded corridors framed by palms.',
            ],
            [
                'title' => 'Courtyard evening glow',
                'category' => 'garden',
                'image_url' => 'https://rosevillaheritagehomes.com/wp-content/uploads/2025/05/WhatsApp-Image-2024-08-31-at-4.16.49-PM.jpeg',
                'description' => 'Lanterns and jasmine fill the night air.',
                'is_featured' => true,
            ],
            [
                'title' => 'Heritage dining',
                'category' => 'dining',
                'image_url' => 'https://rosevillaheritagehomes.com/wp-content/uploads/2025/05/WhatsApp-Image-2024-08-08-at-5.40.14-PM.jpeg',
                'description' => 'Jaffna crab curry and family recipes.',
            ],
            [
                'title' => 'Garden breakfast',
                'category' => 'dining',
                'image_url' => 'https://rosevillaheritagehomes.com/wp-content/uploads/2025/05/WhatsApp-Image-2024-08-08-at-5.40.15-PM.jpeg',
                'description' => 'Hoppers, sambol, and fresh fruits under palms.',
            ],
            [
                'title' => 'Suite details',
                'category' => 'villa',
                'image_url' => 'https://rosevillaheritagehomes.com/wp-content/uploads/2025/05/WhatsApp-Image-2024-08-07-at-6.45.39-PM.jpeg',
                'description' => 'Woodwork and woven textiles sourced in Jaffna.',
            ],
        ];

        foreach ($galleryImages as $image) {
            GalleryImage::updateOrCreate(
                ['image_url' => $image['image_url']],
                $image
            );
        }

        $reviews = [
            [
                'guest_name' => 'Meena & Arjun',
                'rating' => 5,
                'comment' => 'Warm, gracious hosts. The heritage suite felt like a private sanctuary and breakfast was phenomenal.',
                'source' => 'Google',
                'is_published' => true,
            ],
            [
                'guest_name' => 'Sophia L.',
                'rating' => 5,
                'comment' => 'Loved the quiet gardens, the curated Jaffna experiences, and the gentle service. A true boutique gem.',
                'source' => 'Direct Booking',
                'is_published' => true,
            ],
            [
                'guest_name' => 'Naveen',
                'rating' => 4,
                'comment' => 'Close to temples and markets, with lovely local meals. The team handled our itinerary with care.',
                'source' => 'Booking.com',
                'is_published' => true,
            ],
        ];

        foreach ($reviews as $review) {
            Review::updateOrCreate(
                ['guest_name' => $review['guest_name'], 'comment' => $review['comment']],
                $review
            );
        }

        $landmarks = [
            [
                'title' => 'Nallur Kandaswamy Temple',
                'description' => 'A revered 15th-century temple famed for its grand gopuram and evening rituals.',
                'distance' => '10 minutes',
                'map_link' => 'https://maps.google.com/?q=Nallur+Kandaswamy+Temple',
                'image_url' => 'https://rosevillaheritagehomes.com/wp-content/uploads/2025/05/WhatsApp-Image-2024-08-07-at-6.45.39-PM2.jpeg',
                'category' => 'culture',
            ],
            [
                'title' => 'Jaffna Fort',
                'description' => 'Dutch and Portuguese history along the lagoon with sunset views.',
                'distance' => '12 minutes',
                'map_link' => 'https://maps.google.com/?q=Jaffna+Fort',
                'image_url' => 'https://rosevillaheritagehomes.com/wp-content/uploads/2025/05/WhatsApp-Image-2024-08-07-at-6.45.39-PM.jpeg',
                'category' => 'heritage',
            ],
            [
                'title' => 'Keerimalai Springs',
                'description' => 'Sacred seaside springs believed to be healing, perfect for a coastal drive.',
                'distance' => '35 minutes',
                'map_link' => 'https://maps.google.com/?q=Keerimalai+Sacred+Water+Spring',
                'image_url' => 'https://rosevillaheritagehomes.com/wp-content/uploads/2025/05/WhatsApp-Image-2024-08-08-at-5.40.14-PM.jpeg',
                'category' => 'nature',
            ],
        ];

        foreach ($landmarks as $landmark) {
            Landmark::updateOrCreate(['title' => $landmark['title']], $landmark);
        }

        $content = [
            'hero_title' => 'Experience the Extraordinary in Jaffna',
            'hero_subtitle' => 'A boutique heritage villa with soulful hospitality, lush courtyards, and authentic northern flavors.',
            'about_text' => 'Rosevilla Heritage Homes weaves timeless Jaffna architecture with modern comfort. Wake to birdsong, dine on heirloom recipes, wander through palm-framed gardens, and return to suites dressed in handcrafted woodwork and soft linen. Our team curates rituals, temple visits, cycling routes, and coastal escapes so every stay feels personal.',
            'footer_text' => 'Guest support is a call away — we are here to make every stay effortless.',
            'contact_phone' => '+94 76 319 3311',
            'contact_email' => 'stay@rosevillaheritagehomes.com',
            'contact_address' => 'Rosevilla Heritage Homes, Jaffna, Sri Lanka',
            'map_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126743.4021487821!2d79.989!3d9.6615!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3afe56f0c3c3361d%3A0xb4b29d0d553cae62!2sJaffna!5e0!3m2!1sen!2slk!4v1700000000000',
        ];

        foreach ($content as $key => $value) {
            ContentSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
