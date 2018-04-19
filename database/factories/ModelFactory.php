<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Task::class, function (Faker $faker) {
    $startingDate = $faker->dateTimeBetween('+1 day', '+6 day');
    $dueDate = $faker->dateTimeBetween('+9 days', '+20 day');

    return [
        'user_id' => function() {
            return factory('App\User')->create()->id;
        },
        'project_id'=> function() {
            return factory('App\Project')->create()->id;
        },
        'name' => $faker->sentence,
        'description' => $faker->paragraph,
        'status' => $faker->randomElement(['backlog', 'in_progress', 'completed']),
        'priority' => $faker->randomElement(['low', 'normal', 'high']),
        'start_date' => $startingDate,
        'due_date' => $dueDate
    ];
});

$factory->define(App\Project::class, function (Faker $faker) {
    $startingDate = $faker->dateTimeBetween('this week', '+90 days');
    $dueDate = $faker->dateTimeBetween('+120 days', '+300 days');
    $name = $faker->word;
    return [
        'name' => $name,
        'slug' => $name,
        'user_id' => function() {
            return factory('App\User')->create()->id;
        },
        'start_date' => $startingDate,
        'due_date' => $dueDate,
        'description' => $faker->paragraph,
        'status' => $faker->randomElement(['backlog', 'in_progress'])
    ];
});



$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'task_id' => function() {
            return factory('App\Task')->create()->id;
        },
        'user_id' => function() {
            return factory('App\User')->create()->id;
        },
        'comment' => $faker->paragraph
    ];
});
