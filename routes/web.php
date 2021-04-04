<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\EalbumController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\AdminController;
use App\Jobs\AnnounceNewAlbum;
use App\Mail\NewAlbum;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;

use App\Models\Track;
use App\Models\Artist;
use App\Models\Album;
use App\Models\Ealbum;
use App\Models\Genre;

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


if (env('APP_ENV') !== 'local') {
    URL::forceScheme('https');
}

Route::get('/', function () {
    return view('layouts.main');
});

Route::get('/mail', function () {
    /*
     *Mail::raw('What is your favorite framework?', function ($message) {
     *    $message->to('hern784@usc.edu')->subject('Hello Richard');
     *});
     */

    /*
     *dispatch(function () {
     *    $masterOfPuppets = Album::find(152);
     *    Mail::to('hern784@usc.edu')->send(new NewAlbum($masterOfPuppets));
     *});
     */

    /*
     *$jaggedLittlePill = Album::find(6);
     *Mail::to('hern784@usc.edu')->queue(new NewAlbum($jaggedLittlePill));
     */

    /*
     *$jaggedLittlePill = Album::find(6);
     *AnnounceNewAlbum::dispatch($jaggedLittlePill);
     */

    $jaggedLittlePill = Album::find(6);
    dispatch(new AnnounceNewAlbum($jaggedLittlePill));
});

Route::middleware(['maintenance'])->group(function () {

    Route::get('/playlists', [PlaylistController::class, 'index'])->name('playlist.index');
    Route::get('/playlists/{id}', [PlaylistController::class, 'show'])->name('playlist.show');
    Route::get('/playlists/{id}/edit', [PlaylistController::class, 'edit'])->name('playlist.edit');
    Route::post('/playlists/{id}', [PlaylistController::class, 'update'])->name('playlist.update');
    Route::get('/playlists/{id}/delete', [PlaylistController::class, 'delete'])->name('playlist.delete');
    Route::post('/playlists/{id}/delete', [PlaylistController::class, 'deleted'])->name('playlist.deleted');

    Route::get('/albums', [AlbumController::class, 'index'])->name('album.index');
    Route::middleware(['custom-auth'])->group(function () {
        Route::get('/albums/create', [AlbumController::class, 'create'])->name('album.create');
        Route::post('/albums', [AlbumController::class, 'store'])->name('album.store');
        Route::get('/albums/{id}/edit', [AlbumController::class, 'edit'])->name('album.edit');
        Route::post('/albums/{id}', [AlbumController::class, 'update'])->name('album.update');
    });

    // ASSIGNMENT 5  USING ELOQUENT
    Route::get('/ealbums', [EalbumController::class, 'index'])->name('ealbum.index');
    Route::get('/ealbums/create', [EalbumController::class, 'create'])->name('ealbum.create');
    Route::post('/ealbums', [EalbumController::class, 'store'])->name('ealbum.store');
    Route::get('/ealbums/{id}/edit', [EalbumController::class, 'edit'])->name('ealbum.edit');
    Route::post('/ealbums/{id}', [EalbumController::class, 'update'])->name('ealbum.update');

    Route::get('/tracks', [TrackController::class, 'index'])->name('track.index');
    Route::get('/tracks/new', [TrackController::class, 'insert'])->name('track.insert');
    Route::post('/tracks', [TrackController::class, 'store'])->name('track.store');


    Route::get('/eloquent', function () {
        // QUERYING
        // return Artist::all();
        // return Track::all();
        // return Artist::orderBy('name', 'desc')->get();
        // return Track::where('unit_price', '>', 0.99)->orderBy('name')->get();
        // return Artist::find(3);

        // CREATING
        // $genre = new Genre();
        // $genre->name = 'Hip Hop';
        // $genre->save();
        // return Genre::all();

        // DELETING
        // Genre::where('name', '=', 'Hip Hop')->delete();
        // return Genre::all();

        // UPDATING
        // $genre = Genre::where('name', '=', 'Alternative & Punk')->first();
        // $genre->name = 'Alternative and Punk';
        // $genre->save();
        // return Genre::all();

        // RELATIONSHIPS (ONE TO MANY)
        //return view('eloquent.one-to-many', [
        //'artist' => Artist::find(50),
        //]);

        //return view('eloquent.belongs-to', [
        //'album' => Album::find(152),
        //]);

        // return Artist::find(50); // 50 = Metallica
        // return Artist::find(50)->albums;
        // return Album::find(152)->artist; // 152 = Master of Puppets

        // return Track::find(1837); // 1837 = Seek and Destroy
        // return Track::find(1837)->genre;
        // return Genre::find(3)->tracks; // 3 = Metal

        // EAGER LOADING
        return view('eloquent.eager-loading', [
            //'tracks' => Track::where('unit_price', '>', 0.99)
            //->orderBy('name')
            //->limit(5)
            //->get()
            'tracks' => Track::with(['genre', 'album'])
                ->where('unit_price', '>', 0.99)
                ->orderBy('name')
                ->limit(5)
                ->get()
        ]);

        return view('eloquent');
    });

    Route::middleware(['custom-auth'])->group(function () {
        Route::middleware(['not-blocked'])->group(function () {
            Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
            Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoice.index');
            Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoice.show');
        });
        Route::view('/blocked', 'blocked')->name('blocked');
    });


    Route::get('/register', [RegistrationController::class, 'index'])->name('registration.index');
    Route::post('/register', [RegistrationController::class, 'register'])->name('registration.create');
});

Route::get('/login', [AuthController::class, 'loginForm'])->name('auth.loginForm');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');


Route::middleware(['custom-auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::middleware(['admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'maintenance'])->name('admin.maintenance');
    Route::post('/admin', [AdminController::class, 'update'])->name('admin.update');
    Route::post('/stats', [AdminController::class, 'email_user_stats'])->name('admin.email_user_stats');
});

Route::get('/maintenance', [ConfigurationController::class, 'maintenance'])->name('configuration.maintenance');
