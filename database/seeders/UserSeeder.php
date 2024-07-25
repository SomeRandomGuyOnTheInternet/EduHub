<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['first_name' => 'Muhammad', 'last_name' => 'Syahmi', 'email' => 'syahmi@eduhub.com', 'date_of_birth' => '1996-07-11', 'password' => Hash::make('password'), 'user_type' => 'student', 'profile_picture' => '/seeder-media/default-profiles/m.png'],
            ['first_name' => 'Cao', 'last_name' => 'Qi', 'email' => 'caoqi@eduhub.com', 'date_of_birth' => '1996-07-11', 'password' => Hash::make('password'), 'user_type' => 'professor', 'profile_picture' => '/seeder-media/default-profiles/c.png'],
            ['first_name' => 'John', 'last_name' => 'Binder', 'email' => 'binder@eduhub.com', 'date_of_birth' => '1992-07-11', 'password' => Hash::make('password'), 'user_type' => 'professor', 'profile_picture' => '/seeder-media/default-profiles/j.png'],
            ['first_name' => 'Jane', 'last_name' => 'Doe', 'email' => 'jane.doe@eduhub.com', 'date_of_birth' => '1986-07-11', 'password' => Hash::make('password'), 'user_type' => 'student', 'profile_picture' => '/seeder-media/default-profiles/j.png'],
            ['first_name' => 'Alex', 'last_name' => 'Smith', 'email' => 'alex.smith@eduhub.com', 'date_of_birth' => '1999-08-11', 'password' => Hash::make('password'), 'user_type' => 'student', 'profile_picture' => '/seeder-media/default-profiles/a.png'],
            ['first_name' => 'Vignesh', 'last_name' => 'Bala', 'email' => 'vignesh.bala@eduhub.com', 'date_of_birth' => '1933-08-22', 'password' => Hash::make('password'), 'user_type' => 'professor', 'profile_picture' => '/seeder-media/default-profiles/r.png'],
            ['first_name' => 'Hilman', 'last_name' => 'Afiq', 'email' => 'hilman.afiq@eduhub.com', 'date_of_birth' => '1996-11-05', 'password' => Hash::make('password'), 'user_type' => 'student', 'profile_picture' => '/seeder-media/default-profiles/h.png'],
            ['first_name' => 'Abdul', 'last_name' => 'Hakam', 'email' => 'abdul.hakam@eduhub.com', 'date_of_birth' => '1985-10-15', 'password' => Hash::make('password'), 'user_type' => 'professor', 'profile_picture' => '/seeder-media/default-profiles/a.png'],
            ['first_name' => 'Chris', 'last_name' => 'Kalendario', 'email' => 'chris.kalendario@eduhub.com', 'date_of_birth' => '1990-12-12', 'password' => Hash::make('password'), 'user_type' => 'student', 'profile_picture' => '/seeder-media/default-profiles/c.png'],
            ['first_name' => 'Nelson', 'last_name' => 'Mandela', 'email' => 'nelson.mandela@eduhub.com', 'date_of_birth' => '1998-07-18', 'password' => Hash::make('password'), 'user_type' => 'professor', 'profile_picture' => '/seeder-media/default-profiles/n.png'],
            ['first_name' => 'Zuhairi', 'last_name' => 'Hamzah', 'email' => 'zuhairi.hamzah@eduhub.com', 'date_of_birth' => '1992-06-21', 'password' => Hash::make('password'), 'user_type' => 'student', 'profile_picture' => '/seeder-media/default-profiles/z.png']
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}
