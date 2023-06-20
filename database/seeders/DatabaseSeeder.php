<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

use Hash;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void{
        DB::table('users')->insert([
            "name" => "John Doe",
            "email" => "johndoe@johndoe.johndoe",
            "password" => Hash::make("johndoe"),
        ]);

        $uid = User::where('name', 'John Doe')->first()->id;
        DB::table('nodes')->insert([
            ["user_id" => $uid, "id" => 1, "parent_id" => 0, "label" => "Fruits"],
            ["user_id" => $uid, "id" => 2, "parent_id" => 0, "label" => "Time Table"],
            ["user_id" => $uid, "id" => 3, "parent_id" => 0, "label" => "Fruits"],
            ["user_id" => $uid, "id" => 5, "parent_id" => 1, "label" => "Apple"],
            ["user_id" => $uid, "id" => 6, "parent_id" => 1, "label" => "Banana"],
            ["user_id" => $uid, "id" => 7, "parent_id" => 2, "label" => "New"],
            ["user_id" => $uid, "id" => 8, "parent_id" => 2, "label" => "Old"],
        ]);
    }
}
