<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    // GANTI DARI '*' MENJADI DOMAIN FLUTTER KAMU (lebih aman!)
    // Kalau masih development / testing di emulator / HP langsung:
    'allowed_origins' => [
        'http://localhost',
        'http://localhost:8000',
        'http://127.0.0.1',
        'http://127.0.0.1:8000',
        'http://10.0.2.2:8000',     // Android Emulator → localhost Laravel
        'http://192.168.100.197:8000',  // Ganti x.x dengan IP lokal PC kamu (cek dengan ipconfig)
        // Kalau pakai Expo / Flutter Web:
        // 'https://your-app-name.expo.dev',
    ],

    // Atau kalau masih males setting IP, pakai pattern (cukup aman untuk development):
    // 'allowed_origins_patterns' => ['/^http:\/\/192\.168\..*/'],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // YANG PALING PENTING: WAJIB TRUE KALAU PAKAI SANCTUM + COOKIE / CREDENTIALS
    'supports_credentials' => true,

];