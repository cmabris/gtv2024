<?php

use App\Http\Livewire\Admin\Point\ShowPoint;
use App\Http\Livewire\Admin\Photography\Photographies;
use App\Http\Livewire\Admin\Places\ListPlaces;
use App\Http\Livewire\Admin\ThematicArea\ThematicAreas;
use App\Http\Livewire\Admin\User\ListUsers;
use App\Http\Livewire\Admin\Video\ListVideos;
use App\Http\Livewire\Admin\VideoItem\ListVideoItems;
use App\Http\Livewire\Admin\Visit\ShowVisits;
use App\Http\Livewire\Admin\Email\EmailManager;
use App\Http\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'admin'], function () {
    Route::get('users', ListUsers::class)->name('users.index');
    Route::get('video-items', ListVideoItems::class)->name('video-items.index');
});

Route::group(['middleware' => 'admin_or_teacher'], function () {
    Route::get('visits', ShowVisits::class)->name('visit.index');
    Route::get('thematic-areas', ThematicAreas::class)->name('thematic-areas.index');
    Route::get('places', ListPlaces::class)->name('places.index');
});

Route::group(['middleware' => 'admin_or_teacher_or_student'], function () {
    Route::get('points-of-interest', ShowPoint::class)->name('points.index');
    Route::get('videos', ListVideos::class)->name('videos.index');
    Route::get('photographies', Photographies::class)->name('photographies.index');
});

Route::get('admin-emails', EmailManager::class)->name('admin.emails');
 /*   Route::get('email-cositas', function (){

        return view('email.user-created');
    } )->name('email-cositas');*/
Route::get('/', Welcome::class)->name('welcome');
