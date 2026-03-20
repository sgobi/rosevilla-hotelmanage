<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
foreach(\App\Models\Room::all() as $r) {
    echo $r->id . ": " . $r->title . "\n";
}
