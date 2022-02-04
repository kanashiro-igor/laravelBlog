<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\PostCommentsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::post('/newsletter', function () {

    request()->validate(['email' => ['required'], ['email']]);

    $mailchimp = new \MailchimpMarketing\ApiClient();

    $mailchimp->setConfig([
        'apiKey' => config('services.mailchimp.key'),
        'server' => 'us14'
    ]);

    try {
        $response = $mailchimp->lists->addListMember("a509c76680", [
            "email_address" => 'igorkanashirodesousa1995@gmail.com',
            "status" => 'subscribed'
        ]);
    } catch (\Exception $e) {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'email' => 'Your e-mail could not be added to our newsletter list'
        ]);
    }

    return  redirect('/')
        ->with('success', 'You are now signed in for our newsletter!');
});

Route::get('/', [PostController::class, 'index'])->name('home');

Route::get('posts/{post:slug}', [PostController::class, 'show']);


Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'create']);
    Route::post('register', [RegisterController::class, 'store']);
    Route::get('login', [SessionsController::class, 'create']);
    Route::post('login', [SessionsController::class, 'store']);
});

// Route::get('register', [RegisterController::class, 'create'])->middleware('guest');

// Route::post('register', [RegisterController::class, 'store'])->middleware('guest');

Route::middleware('auth')->group(function () {
    Route::post('logout', [SessionsController::class, 'destroy']);
    Route::post('posts/{post:slug}/comments', [PostCommentsController::class, 'store']);
});
