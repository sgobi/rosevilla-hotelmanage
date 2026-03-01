<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
try {
    $response = $kernel->handle(\Illuminate\Http\Request::create('/login', 'GET'));
    echo "Status: " . $response->getStatusCode() . "\n";
    if ($response->getStatusCode() == 500) {
        if (property_exists($response, 'exception') && $response->exception) {
            echo "Exception: " . $response->exception->getMessage() . "\n";
            echo $response->exception->getTraceAsString();
        } else {
            echo "No exception attached to response.\n";
            echo substr($response->getContent(), 0, 1000);
        }
    }
} catch (\Throwable $e) {
    echo "Caught Throwable: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
