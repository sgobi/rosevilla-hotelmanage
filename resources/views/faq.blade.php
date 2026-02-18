<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- SEO Meta Tags -->
    <title>FAQ - Rose Villa Heritage Homes | Your Questions Answered</title>
    <meta name="description" content="Find answers to frequently asked questions about Rose Villa Heritage Homes in Jaffna. Learn about booking, amenities, location, and our heritage experience.">
    <meta name="keywords" content="Rose Villa FAQ, Jaffna hotel questions, heritage home booking, Rose Villa amenities, Jaffna accommodation help">
    <meta name="author" content="Rose Villa Heritage Homes">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url('/faq') }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/faq') }}">
    <meta property="og:title" content="FAQ - Rose Villa Heritage Homes">
    <meta property="og:description" content="Find answers to frequently asked questions about Rose Villa Heritage Homes in Jaffna.">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alegreya+SC:wght@400;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-rose-text antialiased bg-white">

    <!-- Header -->
    <header class="bg-rose-primary shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex justify-between items-center">
                <a href="{{ route('home') }}" class="text-white font-serif text-2xl tracking-widest uppercase hover:text-rose-accent transition">
                    Rose Villa
                </a>
                <a href="{{ route('home') }}" class="text-white text-sm uppercase tracking-wider hover:text-rose-accent transition">
                    ← Back to Home
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-rose-primary to-rose-dark text-white py-20">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h1 class="font-serif text-5xl md:text-6xl mb-6 uppercase tracking-wide">
                Frequently Asked Questions
            </h1>
            <p class="text-xl text-white/90 max-w-2xl mx-auto">
                Everything you need to know about Rose Villa Heritage Homes in Jaffna
            </p>
        </div>
    </section>

    <!-- FAQ Content -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4">
            
            <!-- Category: General Information -->
            <div class="mb-16">
                <h2 class="font-serif text-3xl text-rose-primary mb-8 uppercase tracking-wide border-b-2 border-rose-gold pb-4">
                    General Information
                </h2>
                
                <div class="space-y-6" itemscope itemtype="https://schema.org/FAQPage">
                    
                    <!-- Question 1 -->
                    <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <h3 class="text-xl font-bold text-rose-accent mb-4 flex items-start gap-3" itemprop="name">
                            <span class="text-rose-gold">Q:</span>
                            What is Rose Villa Heritage Homes?
                        </h3>
                        <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                            <div itemprop="text">
                                <p class="text-gray-700 leading-relaxed ml-8">
                                    <strong>A:</strong> Rose Villa Heritage Homes is a luxury boutique heritage hotel located in Jaffna, Sri Lanka. We are a beautifully restored colonial-era villa that combines authentic heritage architecture with modern luxury amenities. Our property offers an immersive cultural experience in the heart of Jaffna's historic district, perfect for travelers seeking authenticity, elegance, and a connection to Sri Lanka's rich colonial past.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Question 2 -->
                    <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <h3 class="text-xl font-bold text-rose-accent mb-4 flex items-start gap-3" itemprop="name">
                            <span class="text-rose-gold">Q:</span>
                            Where is Rose Villa located in Jaffna?
                        </h3>
                        <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                            <div itemprop="text">
                                <p class="text-gray-700 leading-relaxed ml-8">
                                    <strong>A:</strong> Rose Villa Heritage Homes is centrally located at 123 Heritage Lane, Jaffna, in the Northern Province of Sri Lanka. We are situated in the historic heart of Jaffna, within walking distance of major cultural landmarks including Jaffna Fort, Nallur Kandaswamy Temple, and the Jaffna Public Library. The property is approximately 15 minutes from Jaffna International Airport (KKS) and easily accessible from all parts of the city.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Question 3 -->
                    <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <h3 class="text-xl font-bold text-rose-accent mb-4 flex items-start gap-3" itemprop="name">
                            <span class="text-rose-gold">Q:</span>
                            What makes Rose Villa different from other hotels in Jaffna?
                        </h3>
                        <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                            <div itemprop="text">
                                <p class="text-gray-700 leading-relaxed ml-8">
                                    <strong>A:</strong> Rose Villa stands out as Jaffna's premier heritage accommodation for several reasons: (1) Authentic colonial architecture preserved from the 1800s, (2) Personalized boutique service with a maximum of 12 guests, (3) Curated cultural experiences including heritage tours and traditional cuisine, (4) Prime location in the historic district, (5) Blend of period charm with modern luxury amenities like air conditioning, Wi-Fi, and premium bedding, and (6) Commitment to sustainable tourism and cultural preservation.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category: Booking & Reservations -->
            <div class="mb-16">
                <h2 class="font-serif text-3xl text-rose-primary mb-8 uppercase tracking-wide border-b-2 border-rose-gold pb-4">
                    Booking & Reservations
                </h2>
                
                <div class="space-y-6">
                    
                    <!-- Question 4 -->
                    <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <h3 class="text-xl font-bold text-rose-accent mb-4 flex items-start gap-3" itemprop="name">
                            <span class="text-rose-gold">Q:</span>
                            How do I book a room at Rose Villa?
                        </h3>
                        <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                            <div itemprop="text">
                                <p class="text-gray-700 leading-relaxed ml-8">
                                    <strong>A:</strong> Booking at Rose Villa is simple and convenient. You can: (1) Book directly through our website reservation form for the best rates, (2) Call us at +94 77 123 4567 to speak with our concierge team, (3) Email us at info@rosevilla.com with your preferred dates, or (4) Book through major travel platforms like Booking.com, Agoda, or Expedia. We recommend booking directly for exclusive perks and personalized service.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Question 5 -->
                    <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <h3 class="text-xl font-bold text-rose-accent mb-4 flex items-start gap-3" itemprop="name">
                            <span class="text-rose-gold">Q:</span>
                            What is the cancellation policy?
                        </h3>
                        <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                            <div itemprop="text">
                                <p class="text-gray-700 leading-relaxed ml-8">
                                    <strong>A:</strong> Our cancellation policy is flexible and guest-friendly: Free cancellation up to 48 hours before check-in for full refund. Cancellations within 48 hours of check-in incur a one-night charge. No-shows are charged the full reservation amount. For special events, weddings, or group bookings, custom cancellation terms may apply. We recommend purchasing travel insurance for added protection.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Question 6 -->
                    <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <h3 class="text-xl font-bold text-rose-accent mb-4 flex items-start gap-3" itemprop="name">
                            <span class="text-rose-gold">Q:</span>
                            What are the check-in and check-out times?
                        </h3>
                        <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                            <div itemprop="text">
                                <p class="text-gray-700 leading-relaxed ml-8">
                                    <strong>A:</strong> Check-in time is 2:00 PM and check-out time is 11:00 AM. Early check-in and late check-out are subject to availability and may incur additional charges. We offer complimentary luggage storage if you arrive early or need to depart late. Please contact us in advance if you require special timing arrangements.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category: Rooms & Amenities -->
            <div class="mb-16">
                <h2 class="font-serif text-3xl text-rose-primary mb-8 uppercase tracking-wide border-b-2 border-rose-gold pb-4">
                    Rooms & Amenities
                </h2>
                
                <div class="space-y-6">
                    
                    <!-- Question 7 -->
                    <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <h3 class="text-xl font-bold text-rose-accent mb-4 flex items-start gap-3" itemprop="name">
                            <span class="text-rose-gold">Q:</span>
                            What types of rooms do you offer?
                        </h3>
                        <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                            <div itemprop="text">
                                <p class="text-gray-700 leading-relaxed ml-8">
                                    <strong>A:</strong> Rose Villa offers four distinct room categories: (1) Heritage Suite - Our premium offering with colonial four-poster beds and private balconies, (2) Deluxe Room - Spacious rooms with period furniture and modern bathrooms, (3) Classic Room - Comfortable accommodations with heritage charm, and (4) Garden View Room - Ground-floor rooms overlooking our lush courtyards. All rooms feature air conditioning, Wi-Fi, premium linens, and en-suite bathrooms.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Question 8 -->
                    <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <h3 class="text-xl font-bold text-rose-accent mb-4 flex items-start gap-3" itemprop="name">
                            <span class="text-rose-gold">Q:</span>
                            What amenities are included in the rooms?
                        </h3>
                        <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                            <div itemprop="text">
                                <p class="text-gray-700 leading-relaxed ml-8">
                                    <strong>A:</strong> All rooms at Rose Villa include: Air conditioning, High-speed Wi-Fi, Premium bedding and linens, En-suite bathroom with hot water, Complimentary toiletries, Mini-bar, Tea/coffee making facilities, Safe deposit box, Writing desk, and Daily housekeeping. Select rooms also feature balconies, bathtubs, and garden views.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Question 9 -->
                    <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <h3 class="text-xl font-bold text-rose-accent mb-4 flex items-start gap-3" itemprop="name">
                            <span class="text-rose-gold">Q:</span>
                            Is Wi-Fi available and is it free?
                        </h3>
                        <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                            <div itemprop="text">
                                <p class="text-gray-700 leading-relaxed ml-8">
                                    <strong>A:</strong> Yes, high-speed Wi-Fi is complimentary throughout the property, including all guest rooms, common areas, and gardens. We provide reliable connectivity suitable for video calls, streaming, and remote work. The network is secure and password-protected.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category: Dining & Food -->
            <div class="mb-16">
                <h2 class="font-serif text-3xl text-rose-primary mb-8 uppercase tracking-wide border-b-2 border-rose-gold pb-4">
                    Dining & Food
                </h2>
                
                <div class="space-y-6">
                    
                    <!-- Question 10 -->
                    <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <h3 class="text-xl font-bold text-rose-accent mb-4 flex items-start gap-3" itemprop="name">
                            <span class="text-rose-gold">Q:</span>
                            Does Rose Villa have a restaurant?
                        </h3>
                        <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                            <div itemprop="text">
                                <p class="text-gray-700 leading-relaxed ml-8">
                                    <strong>A:</strong> Yes, we have an in-house dining experience featuring authentic Jaffna cuisine and international dishes. Meals are served in our heritage dining room or in the garden courtyard. We specialize in traditional Tamil cuisine, fresh seafood, and vegetarian options. All meals are prepared with locally-sourced ingredients and can be customized to dietary requirements.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Question 11 -->
                    <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <h3 class="text-xl font-bold text-rose-accent mb-4 flex items-start gap-3" itemprop="name">
                            <span class="text-rose-gold">Q:</span>
                            Can you accommodate dietary restrictions?
                        </h3>
                        <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                            <div itemprop="text">
                                <p class="text-gray-700 leading-relaxed ml-8">
                                    <strong>A:</strong> Absolutely! We cater to all dietary requirements including vegetarian, vegan, gluten-free, halal, and specific allergies. Please inform us of your dietary needs at the time of booking or at least 24 hours in advance, and our chef will prepare customized meals for you.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Question 12 -->
                    <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <h3 class="text-xl font-bold text-rose-accent mb-4 flex items-start gap-3" itemprop="name">
                            <span class="text-rose-gold">Q:</span>
                            Is breakfast included in the room rate?
                        </h3>
                        <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                            <div itemprop="text">
                                <p class="text-gray-700 leading-relaxed ml-8">
                                    <strong>A:</strong> Yes, complimentary breakfast is included with all room bookings. We serve a traditional Sri Lankan breakfast with options like string hoppers, dosa, idli, and fresh tropical fruits, as well as continental options including eggs, toast, and pastries. Breakfast is served from 7:00 AM to 10:00 AM.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category: Location & Transportation -->
            <div class="mb-16">
                <h2 class="font-serif text-3xl text-rose-primary mb-8 uppercase tracking-wide border-b-2 border-rose-gold pb-4">
                    Location & Transportation
                </h2>
                
                <div class="space-y-6">
                    
                    <!-- Question 13 -->
                    <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <h3 class="text-xl font-bold text-rose-accent mb-4 flex items-start gap-3" itemprop="name">
                            <span class="text-rose-gold">Q:</span>
                            How far is Rose Villa from Jaffna Airport?
                        </h3>
                        <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                            <div itemprop="text">
                                <p class="text-gray-700 leading-relaxed ml-8">
                                    <strong>A:</strong> Rose Villa is approximately 12 kilometers (7.5 miles) from Jaffna International Airport (Palaly Airport - KKS), which is about a 15-20 minute drive depending on traffic. We offer airport transfer services for your convenience at competitive rates. Please arrange this at the time of booking.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Question 14 -->
                    <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <h3 class="text-xl font-bold text-rose-accent mb-4 flex items-start gap-3" itemprop="name">
                            <span class="text-rose-gold">Q:</span>
                            What are the nearby attractions?
                        </h3>
                        <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                            <div itemprop="text">
                                <p class="text-gray-700 leading-relaxed ml-8">
                                    <strong>A:</strong> Rose Villa is ideally located near Jaffna's top attractions: Jaffna Fort (1 km), Nallur Kandaswamy Temple (2 km), Jaffna Public Library (1.5 km), Jaffna Market (1 km), Casuarina Beach (15 km), Nagadeepa Temple (boat ride from Kurikadduwan), Point Pedro Lighthouse (25 km), and various colonial-era churches and Hindu temples. We can arrange guided heritage tours to all these locations.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Question 15 -->
                    <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <h3 class="text-xl font-bold text-rose-accent mb-4 flex items-start gap-3" itemprop="name">
                            <span class="text-rose-gold">Q:</span>
                            Do you provide airport transfers?
                        </h3>
                        <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                            <div itemprop="text">
                                <p class="text-gray-700 leading-relaxed ml-8">
                                    <strong>A:</strong> Yes, we offer airport transfer services to and from Jaffna International Airport. Our comfortable, air-conditioned vehicles can be arranged for a nominal fee. We also provide transfers to Colombo (A9 highway, approximately 5-6 hours) and other destinations in Northern Sri Lanka. Please book transfers at least 24 hours in advance.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category: Experiences & Activities -->
            <div class="mb-16">
                <h2 class="font-serif text-3xl text-rose-primary mb-8 uppercase tracking-wide border-b-2 border-rose-gold pb-4">
                    Experiences & Activities
                </h2>
                
                <div class="space-y-6">
                    
                    <!-- Question 16 -->
                    <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <h3 class="text-xl font-bold text-rose-accent mb-4 flex items-start gap-3" itemprop="name">
                            <span class="text-rose-gold">Q:</span>
                            What experiences do you offer at Rose Villa?
                        </h3>
                        <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                            <div itemprop="text">
                                <p class="text-gray-700 leading-relaxed ml-8">
                                    <strong>A:</strong> We curate authentic cultural experiences including: Heritage walking tours of Jaffna, Traditional cooking classes (learn to make Jaffna curry), Temple visits with cultural guides, Cycling tours through historic neighborhoods, Sunset boat rides to nearby islands, Traditional music and dance performances, Artisan workshops (pottery, weaving), and Photography tours of colonial architecture. All experiences can be customized to your interests.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Question 17 -->
                    <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <h3 class="text-xl font-bold text-rose-accent mb-4 flex items-start gap-3" itemprop="name">
                            <span class="text-rose-gold">Q:</span>
                            Can you arrange guided tours of Jaffna?
                        </h3>
                        <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                            <div itemprop="text">
                                <p class="text-gray-700 leading-relaxed ml-8">
                                    <strong>A:</strong> Yes, we have partnerships with experienced local guides who specialize in Jaffna's history, culture, and heritage. Tours can be arranged for half-day or full-day excursions covering historical sites, temples, markets, and hidden gems. Our guides are fluent in English, Tamil, and Sinhala. Tours can be customized based on your interests.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category: Events & Special Occasions -->
            <div class="mb-16">
                <h2 class="font-serif text-3xl text-rose-primary mb-8 uppercase tracking-wide border-b-2 border-rose-gold pb-4">
                    Events & Special Occasions
                </h2>
                
                <div class="space-y-6">
                    
                    <!-- Question 18 -->
                    <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <h3 class="text-xl font-bold text-rose-accent mb-4 flex items-start gap-3" itemprop="name">
                            <span class="text-rose-gold">Q:</span>
                            Can I host a wedding at Rose Villa?
                        </h3>
                        <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                            <div itemprop="text">
                                <p class="text-gray-700 leading-relaxed ml-8">
                                    <strong>A:</strong> Absolutely! Rose Villa is a stunning venue for intimate heritage weddings. Our colonial architecture and lush gardens provide a romantic backdrop for ceremonies and receptions. We can accommodate up to 50 guests for seated dinners and 80 for cocktail-style events. Our team will work with you to create a bespoke wedding experience including catering, decoration, photography, and accommodation for guests.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Question 19 -->
                    <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <h3 class="text-xl font-bold text-rose-accent mb-4 flex items-start gap-3" itemprop="name">
                            <span class="text-rose-gold">Q:</span>
                            Do you host corporate events or retreats?
                        </h3>
                        <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                            <div itemprop="text">
                                <p class="text-gray-700 leading-relaxed ml-8">
                                    <strong>A:</strong> Yes, Rose Villa is ideal for corporate retreats, team-building events, and small conferences. We offer meeting spaces with modern AV equipment, high-speed Wi-Fi, and catering services. Our tranquil setting away from city noise provides the perfect environment for focused work and creative thinking. We can accommodate groups of up to 20 people for meetings and workshops.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category: Policies & Practical Information -->
            <div class="mb-16">
                <h2 class="font-serif text-3xl text-rose-primary mb-8 uppercase tracking-wide border-b-2 border-rose-gold pb-4">
                    Policies & Practical Information
                </h2>
                
                <div class="space-y-6">
                    
                    <!-- Question 20 -->
                    <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <h3 class="text-xl font-bold text-rose-accent mb-4 flex items-start gap-3" itemprop="name">
                            <span class="text-rose-gold">Q:</span>
                            Are children allowed at Rose Villa?
                        </h3>
                        <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                            <div itemprop="text">
                                <p class="text-gray-700 leading-relaxed ml-8">
                                    <strong>A:</strong> Yes, children of all ages are welcome at Rose Villa. We are a family-friendly property and can provide extra beds, cribs, and high chairs upon request. Children under 5 stay free when using existing bedding. We can also arrange child-friendly activities and meals. Please inform us of children in your party at the time of booking.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Question 21 -->
                    <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <h3 class="text-xl font-bold text-rose-accent mb-4 flex items-start gap-3" itemprop="name">
                            <span class="text-rose-gold">Q:</span>
                            Is smoking allowed on the property?
                        </h3>
                        <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                            <div itemprop="text">
                                <p class="text-gray-700 leading-relaxed ml-8">
                                    <strong>A:</strong> Rose Villa is a non-smoking property. Smoking is not permitted inside any buildings, including guest rooms and common areas. However, designated smoking areas are available in the outdoor gardens. We appreciate your cooperation in maintaining a healthy environment for all guests.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Question 22 -->
                    <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <h3 class="text-xl font-bold text-rose-accent mb-4 flex items-start gap-3" itemprop="name">
                            <span class="text-rose-gold">Q:</span>
                            What payment methods do you accept?
                        </h3>
                        <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                            <div itemprop="text">
                                <p class="text-gray-700 leading-relaxed ml-8">
                                    <strong>A:</strong> We accept multiple payment methods for your convenience: Cash (Sri Lankan Rupees, US Dollars, Euros), Credit/Debit cards (Visa, Mastercard, American Express), Bank transfers, and Online payment platforms. A deposit may be required at the time of booking. Final payment can be settled upon check-out.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Question 23 -->
                    <div class="bg-gray-50 rounded-2xl p-8 hover:shadow-lg transition" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <h3 class="text-xl font-bold text-rose-accent mb-4 flex items-start gap-3" itemprop="name">
                            <span class="text-rose-gold">Q:</span>
                            Is parking available?
                        </h3>
                        <div itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                            <div itemprop="text">
                                <p class="text-gray-700 leading-relaxed ml-8">
                                    <strong>A:</strong> Yes, complimentary on-site parking is available for all guests. Our secure parking area can accommodate cars, motorcycles, and bicycles. The parking is monitored 24/7 for your peace of mind.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Still Have Questions Section -->
            <div class="bg-gradient-to-br from-rose-primary to-rose-dark text-white rounded-3xl p-12 text-center">
                <h2 class="font-serif text-3xl mb-6">Still Have Questions?</h2>
                <p class="text-xl mb-8 text-white/90">
                    Our concierge team is here to help you 24/7
                </p>
                <div class="flex flex-col md:flex-row gap-6 justify-center items-center">
                    <a href="tel:+94771234567" class="inline-flex items-center gap-3 bg-white text-rose-primary px-8 py-4 rounded-full font-bold uppercase tracking-wider hover:bg-rose-gold hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        Call Us
                    </a>
                    <a href="mailto:info@rosevilla.com" class="inline-flex items-center gap-3 bg-white text-rose-primary px-8 py-4 rounded-full font-bold uppercase tracking-wider hover:bg-rose-gold hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Email Us
                    </a>
                    <a href="{{ route('home') }}#reservation" class="inline-flex items-center gap-3 bg-rose-gold text-white px-8 py-4 rounded-full font-bold uppercase tracking-wider hover:bg-white hover:text-rose-primary transition">
                        Book Now
                    </a>
                </div>
            </div>

        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-rose-dark text-white py-12 border-t border-rose-gold/20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-sm">&copy; {{ date('Y') }} Rose Villa Heritage Homes. All Rights Reserved.</p>
            <p class="mt-3 text-xs text-gray-400">
                Powered by Gobikrishna Subramaniyam (BEng Hons) | Mobile: <a href="tel:+94766383402" class="text-rose-gold hover:text-white transition">+94 76 638 3402</a>
            </p>
        </div>
    </footer>

</body>
</html>
