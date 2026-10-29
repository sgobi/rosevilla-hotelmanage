<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Heritage Room Configuration
    |--------------------------------------------------------------------------
    |
    | Centralized settings for the Heritage Room. Update these values to keep
    | room details (bed type, capacity, description, etc.) consistent across
    | the website. Easily modified here or via environment variables.
    |
    */
    'heritage_room' => [
        'bed_type' => env('HERITAGE_ROOM_BED_TYPE', 'Queen bed + daybed'),
        'capacity' => (int) env('HERITAGE_ROOM_CAPACITY', 3), // up to 3 guests
        'capacity_label' => env('HERITAGE_ROOM_CAPACITY_LABEL', 'Up to 3 Guests'),
        'description' => env(
            'HERITAGE_ROOM_DESCRIPTION',
            'Soak in the calm Uduvil retreat, featuring a comfortable Queen bed + daybed, warm wooden finishes, and a peaceful sit-out that opens directly onto the garden'
        ),
        'amenities' => [
            'Ensuite rain shower',
            'Private verandah with courtyard view',
            'Breakfast with heritage recipes',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Social Media Links
    |--------------------------------------------------------------------------
    |
    | Set real URLs for social media profiles. If null, empty, or '#',
    | the respective social media icon is hidden in the footer.
    |
    */
    'social' => [
        'facebook' => env('SOCIAL_FACEBOOK_URL', null),
        'instagram' => env('SOCIAL_INSTAGRAM_URL', null),
        'tripadvisor' => env('SOCIAL_TRIPADVISOR_URL', null),
    ],

    /*
    |--------------------------------------------------------------------------
    | Google Reviews URL
    |--------------------------------------------------------------------------
    |
    | Destination URL for the "Read more reviews on Google" button.
    |
    */
    'google_reviews_url' => env('GOOGLE_REVIEWS_URL', 'https://search.google.com/local/reviews?placeid=ChIJ3xCkuJhU-ToRiBdgVXBUI9g'),

    /*
    |--------------------------------------------------------------------------
    | Google Maps Embed URL
    |--------------------------------------------------------------------------
    |
    | The iframe embed link for Google Maps in the Find Us section.
    |
    */
    'google_maps_embed_url' => env('GOOGLE_MAPS_EMBED_URL', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7864.813244882406!2d80.00654078217246!3d9.73158141202129!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3afe5498b86410df%3A0xd820147055601788!2sRose%20Villa%20Heritage%20Homes%20(pvt)%20Ltd!5e0!3m2!1sen!2slk!4v1769480636437!5m2!1sen!2slk'),

    /*
    |--------------------------------------------------------------------------
    | WhatsApp Contact Number
    |--------------------------------------------------------------------------
    |
    | Default WhatsApp number for direct guest inquiries and concierge bookings.
    |
    */
    'whatsapp_number' => env('WHATSAPP_NUMBER', '94765692476'),

    /*
    |--------------------------------------------------------------------------
    | Currency Conversion Rate (USD Rate)
    |--------------------------------------------------------------------------
    |
    | Exchange rate used to convert base LKR amounts into USD across the site.
    | Formula: USD Price = LKR Amount / USD_RATE.
    | E.g., if USD_RATE = 310, LKR 31,000 becomes $100.
    | Update this value here or via USD_RATE in your .env file.
    |
    */
    'usd_rate' => (float) env('USD_RATE', 310.0),

    /*
    |--------------------------------------------------------------------------
    | Site Meta / SEO Title
    |--------------------------------------------------------------------------
    |
    | Default HTML <title> tag for the website landing page.
    |
    */
    'meta_title' => env('SITE_META_TITLE', 'Rose Villa Heritage Homes | Boutique Heritage Stay in Jaffna, Sri Lanka'),

];

