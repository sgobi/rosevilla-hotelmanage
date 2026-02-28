<?php echo \
\\nRESERVATIONS:
\\n\ . json_encode(App\Models\Reservation::where('status', '!=', 'cancelled')->get()->toArray(), JSON_PRETTY_PRINT);
