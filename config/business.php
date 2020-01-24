<?php

return [
    'genders' => ['male', 'female'],
    'userTypes' => ['player', 'developer'],
    'seedSize' => env('APP_ENV') == 'production' ? 1.5e6 : 1e3,
];