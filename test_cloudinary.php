<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    file_put_contents('test.jpg', 'fake image data 12345');
    $api = cloudinary()->uploadApi();
    $response = $api->upload('test.jpg');
    var_dump($response['secure_url']);
} catch (\Throwable $e) {
    echo $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
