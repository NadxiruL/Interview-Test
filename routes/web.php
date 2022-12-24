<?php

use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ProfileController;
use App\Models\Newsletter;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/welcome', function () {

    $newsletters = Newsletter::all();

    return view('guest.index', [
        'newsletters' => $newsletters,

    ]);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [NewsletterController::class, 'index'])->name('newsletter.index');
Route::get('/show/{id}', [NewsletterController::class, 'show'])->name('newsletter.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('dashboard', [NewsletterController::class, 'store'])->name('newsletter.submit');
    Route::get('/edit/{id}', [NewsletterController::class, 'edit'])->name('newsletter.edit');
    Route::delete('/{id}', [NewsletterController::class, 'delete'])->name('newsletter.delete');
    Route::put('edit/{id}', [NewsletterController::class, 'update'])->name('newsletter.update');
    Route::get('/restore/{id}', [NewsletterController::class, 'restore'])->name('newsletter.restore');

});

require __DIR__ . '/auth.php';
