<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\TrackController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoice.index');
Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoice.show');

Route::get('/playlists', [PlaylistController::class, 'index'])->name('playlist.index');
Route::get('/playlists/{id}', [PlaylistController::class, 'show'])->name('playlist.show');
Route::get('/playlists/{id}/edit', [PlaylistController::class, 'edit'])->name('playlist.edit');
Route::post('/playlists/{id}', [PlaylistController::class, 'update'])->name('playlist.update');
Route::get('/playlists/{id}/delete', [PlaylistController::class, 'delete'])->name('playlist.delete');
Route::post('/playlists/{id}/delete', [PlaylistController::class, 'deleted'])->name('playlist.deleted');

Route::get('/albums', [AlbumController::class, 'index'])->name('album.index');
Route::get('/albums/create', [AlbumController::class, 'create'])->name('album.create');
Route::post('/albums', [AlbumController::class, 'store'])->name('album.store');
Route::get('/albums/{id}/edit', [AlbumController::class, 'edit'])->name('album.edit');
Route::post('/albums/{id}', [AlbumController::class, 'update'])->name('album.update');

Route::get('/tracks', [TrackController::class, 'index'])->name('track.index');
Route::get('/tracks/new', [TrackController::class, 'insert'])->name('track.insert');
Route::post('/tracks', [TrackController::class, 'store'])->name('track.store');

Route::fallback(function () {
    return view('welcome');
});
