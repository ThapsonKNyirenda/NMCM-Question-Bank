<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $user = User::updateOrCreate(
            [ 'email' => 'thapsonknyirenda@gmail.com' ],
            ['name'=> 'Super User','password' =>Hash::make('Maren@100')]
        );

       $user->assignRole('Super User');
    }
}
