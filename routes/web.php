<?php

use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/user/toggle-lang', function () {
    $user = auth()->user();
    if ($user) {
        $newLang = $user->lang === 'ar' ? 'en' : 'ar';
        $user->update(['lang' => $newLang]);
        app()->setLocale($newLang);
    }
    return back();
})->name('user.toggle-lang')->middleware(['auth']);


