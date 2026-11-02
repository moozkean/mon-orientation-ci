<?php

return [
    'secret' => env('JWT_SECRET', 'super_secret_jwt_key_mon_orientation_ci_2026_ci_orange_vert'),
    'ttl' => env('JWT_TTL', 1440), // 24 hours in minutes
    'refresh_ttl' => env('JWT_REFRESH_TTL', 20160), // 14 days in minutes
    'algo' => env('JWT_ALGO', 'HS256'),
];
