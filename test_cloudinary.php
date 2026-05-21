<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    cloudinary()->upload('invalid_file');
} catch (\Throwable $e) {
    echo $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
