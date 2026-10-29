<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Room;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $heritageRoom = Room::where('slug', 'heritage-room')
            ->orWhere('title', 'like', '%Heritage%')
            ->first();

        if ($heritageRoom) {
            $description = $heritageRoom->description;
            // Fix typo "opensdirectly" to "opens directly"
            $description = str_replace('opensdirectly', 'opens directly', $description);
            // Replace double bed with Queen bed + daybed
            $description = str_ireplace('comfortable double bed', 'comfortable Queen bed + daybed', $description);

            $amenities = is_array($heritageRoom->amenities) ? $heritageRoom->amenities : [];
            // Remove conflicting "King canopy bed" from amenities
            $amenities = array_values(array_filter($amenities, function ($item) {
                return !stripos($item, 'king canopy') && !stripos($item, 'double bed');
            }));

            // Make sure required amenities are present without conflicts
            if (!in_array('Ensuite rain shower', $amenities)) {
                array_unshift($amenities, 'Ensuite rain shower');
            }

            $heritageRoom->update([
                'bed_type' => 'Queen bed + daybed',
                'capacity' => 3,
                'description' => $description,
                'amenities' => $amenities,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reversal needed
    }
};

