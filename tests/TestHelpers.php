<?php

namespace Tests;

use App\Models\Photography;
use App\Models\Place;
use App\Models\PointOfInterest;
use App\Models\ThematicArea;
use App\Models\User;
use App\Models\Video;
use App\Models\VideoItem;
use App\Models\Visit;
use Faker\Factory;
use Spatie\Permission\Models\Role;

trait TestHelpers
{
    protected function createAdmin()
    {
        $adminRole = Role::create(['name' => 'Administrador']);

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        $user->assignRole($adminRole);

        return $user;
    }

    protected function createPlace()
    {
        return \factory(Place::class)->create();
    }

    protected function createPointOfInterest($placeId)
    {
        return \factory(PointOfInterest::class)->create([
            'place_id' => $placeId,
        ]);
    }

    protected function createVisit($pointId){
        return \factory(Visit::class)->create([
           'point_of_interest_id' => $pointId,
        ]);
    }

    protected function createThematicArea($pointOfInterestId)
    {
        $faker = Factory::create();

        $thematicArea = \factory(ThematicArea::class)->create();

        $thematicArea->pointsOfInterest()->attach($pointOfInterestId, [
            'title' => $faker->sentence,
            'description' => $faker->text,
        ]);

        return $thematicArea;
    }

    protected function createVideo()
    {
        $video = \factory(Video::class)->create();

        \factory(VideoItem::class)->create([
            'video_id' => $video->id,
        ]);

        return $video;
    }

    protected function createPhotography()
    {
        return \factory(Photography::class)->create();
    }

    public function createStudent(array $attributes = [])
    {
        $studentRole = Role::firstOrCreate(['name' => 'Alumno']);

        $defaultAttributes = [
            'name' => 'Student',
            'email' => 'student' . uniqid() . '@mail.com',
            'password' => bcrypt('password'),
        ];

        $userAttributes = array_merge($defaultAttributes, $attributes);

        $user = User::factory()->create($userAttributes);
        $user->assignRole($studentRole);
        return $user;
    }

    public function createExistingUser()
    {
        $existingUser = User::factory()->create([
            'name' => 'ExistingUser',
            'email' => 'existing@example.com',
            'password' => bcrypt('password'),
        ]);
        $existingRole = \Spatie\Permission\Models\Role::create(['name' => 'Alumno']);
        $existingUser->assignRole($existingRole);
        return $existingUser;
    }
}
