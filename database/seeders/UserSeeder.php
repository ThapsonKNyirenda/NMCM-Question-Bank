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
            [ 'email' => 'robertjmaneno@gmail.com' ],
            ['name'=> 'Super User','password' =>Hash::make('Maneno@265')]
        );

       $user->assignRole('Super User');
    }
}
