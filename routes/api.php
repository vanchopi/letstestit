<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});

Route::get('/categories/getlist', function () {
    $categories = [];
    $cat0 = [];
    $cat1 = [];
    $cat2 = [];
    $cat3 = [];
    $cat4 = [];
    $cat5 = [];
    $categories[] = [
        $cat0[] = (object) [ 
            "id" => 0,
            "txt" => "Тесты по фильмам",
            "url" => 0
        ],
        $cat1[] = (object) [ 
            "id" => 1,
            "txt" => "Тесты по книгам",
            "url" => 1
        ],
        $cat2[] = (object) [ 
            "id" => 2,
            "txt" => "Тесты по физике",
            "url" => 2
        ],
        $cat3[] = (object) [ 
            "id" => 3,
            "txt" => "Тесты по астрономии",
            "url" => 3
        ],
        $cat4[] = (object) [ 
            "id" => 4,
            "txt" => "Тесты по музыке",
            "url" => 4
        ],
        $cat4[] = (object) [ 
            "id" => 6,
            "txt" => "Тесты по истории",
            "url" => 6
        ],
    ];

    return response()->json($categories); 
});

Route::post('/tests/getresults', function (  ) {
    $results = [];
    $results[] = (object) [
        "img" => 'dobbie.jpg',
        "result" => 'Ты - Добби!',
        "description" => 'Судьба была неблагосклонна: твое предназначение — быть на посылках у настоящих волшебников. Но смелость, благородство и вера в добро помогли тебе добиться самого желанного — свободы. Наглядный пример того, что даже один в поле может быть еще каким воином.',
        "id" => 0
    ];
    return response()->json($results);
});

Route::post('/tests/getmore', function (  ) {
    $tests = [];
    $tags = [];
    $tag0 = [];
    $tag1 = [];
    $tag2 = [];
    for ( $i = 0; $i < 3; $i++) {
        $tests[] = (object) [
            "img" => $i+1 .'.png',
            "url" => $i ,
            "title" => "Какой ты покемон" . $i . "?",
            "tags" => $tags[] = (object) [
                $tag0[] = (object) [ 
                    "title" => "Хогвартс",
                    "url" => "welcome"
                ],
                $tag1[] = (object) [ 
                    "title" => "Хогвартс1",
                    "url" => "welcome"
                ],
                $tag2[] = (object) [ 
                    "title" => "Хогвартс2",
                    "url" => "welcome"
                ],
            ]
        ];
    }

    return response()->json($tests);
});

Route::post('/tests/getlist', function () {
    $tests = [];
    $tags = [];
    $tag0 = [];
    $tag1 = [];
    $tag2 = [];
    for ( $i = 0; $i < 6; $i++) {
        $tests[] = (object) [
            "img" => $i+1 .'.png',
            "url" => $i,
            "title" => "Какой ты покемон" . $i . "?",
            "tags" => $tags[] = (object) [
                $tag0[] = (object) [ 
                    "title" => "Хогвартс",
                    "url" => "welcome"
                ],
                $tag1[] = (object) [ 
                    "title" => "Хогвартс1",
                    "url" => "welcome"
                ],
                $tag2[] = (object) [ 
                    "title" => "Хогвартс2",
                    "url" => "welcome"
                ],
            ]
        ];
    }

    return response()->json($tests);

});

Route::get('/test/{id}', function ($id) {
    $test = [];   
    $answers = [];
    $ans = [];
    $ans0 = [];
    $ans1 = [];
    $ans2 = [];
    $ans3 = [];
    for ( $i=0; $i < 6; $i++) {      
      $test[] = (object) [
        "num" => $i,
        "queston" => 'Ты чё, э'. $i . '?',        
        "answers" => $answers[] = (object) [
            $ans0[] = (object) [ 
                "id" => 0,
                "dsc" => "ни чё" . $i
            ],
            $ans1[] = (object) [ 
                "id" => 1,
                "dsc" => "а чё?". $i
            ],
            $ans2[] = (object) [ 
                "id" => 2,
                "dsc" => "и чё?". $i
            ],
            $ans3[] = (object) [ 
                "id" => 3,
                "dsc" => "а сам чё?". $i
            ],
        ]
      ];
    }

    return response()->json($test);
});
