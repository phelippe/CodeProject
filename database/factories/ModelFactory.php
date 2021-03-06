<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(CodeProject\Entities\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(CodeProject\Entities\Client::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'responsible' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'obs' => $faker->sentence,
    ];
});

$factory->define(CodeProject\Entities\Project::class, function (Faker\Generator $faker) {
    return [
        'owner_id' => \CodeProject\Entities\User::all()->lists('id')->random(1),
        'client_id' => \CodeProject\Entities\Client::all()->lists('id')->random(1),
        'name' => $faker->name,
        'description' => $faker->sentence,
        'progress' => $faker->NumberBetween(0,100),
        'status' => $faker->numberBetween(1,3),
        'due_date' => $faker->dateTime,
    ];
});

$factory->define(CodeProject\Entities\ProjectNote::class, function (Faker\Generator $faker) {
    return [
        'project_id' => \CodeProject\Entities\Project::all()->lists('id')->random(1),
        'title' => $faker->word,
        'note' => $faker->paragraph,
    ];
});

$factory->define(CodeProject\Entities\ProjectTask::class, function (Faker\Generator $faker) {
    return [
        'project_id' => \CodeProject\Entities\Project::all()->lists('id')->random(1),
        'name' => $faker->word,
        'start_date' => $faker->dateTime,
        'due_date' => $faker->dateTime,
        'status' => $faker->numberBetween(1,2),
    ];
});

$factory->define(CodeProject\Entities\ProjectMember::class, function (Faker\Generator $faker) {
    return [
        'project_id' => \CodeProject\Entities\Project::all()->lists('id')->random(1),
        'user_id' => \CodeProject\Entities\User::all()->lists('id')->random(1),
    ];
});
