<?php
header('Content-Type: application/json');
echo json_encode([
    "name" => "Saga",
    "short_name" => "Saga",
    "start_url" => "/index.php",
    "display" => "standalone",
    "background_color" => "#ffffff",
    "theme_color" => "#007bff",
    "icons" => [
        [
            "src" => "/img/logos/logo-n-colors-192.png",
            "sizes" => "192x192",
            "type" => "image/png"
        ],
        [
            "src" => "/img/logos/logo-n-colors-512.png",
            "sizes" => "512x512",
            "type" => "image/png"
        ]
    ]
]);
