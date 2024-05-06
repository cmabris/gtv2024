<?php

use App\Livewire\Admin\Point\ShowPoint;
use App\Livewire\Admin\Photography\Photographs;
use App\Livewire\Admin\Places\ListPlaces;
use App\Livewire\Admin\ThematicArea\ThematicAreas;
use App\Livewire\Admin\User\ListUsers;
use App\Livewire\Admin\Video\ListVideos;
use App\Livewire\Admin\VideoItem\ListVideoItems;
use App\Livewire\Admin\Visit\ShowVisits;
use App\Livewire\Welcome;
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

Route::get('/', Welcome::class)->name('welcome');
Route::get('points-of-interest', ShowPoint::class)->name('points.index');
Route::get('videos', ListVideos::class)->name('videos.index');
Route::get('photographies', Photographs::class)->name('photographies.index');
