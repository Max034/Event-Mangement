<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $file = new \Illuminate\Http\UploadedFile(__FILE__, 'test.php');
    var_dump($file->hasMacro('storeOnCloudinary'));
} catch (\Throwable $e) {
    echo $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
