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
            ['first_name' => 'Muhammad', 'last_name' => 'Syahmi', 'email' => 'syahmi@gmail.com', 'date_of_birth' => '1996-07-11', 'password' => Hash::make('password'), 'user_type' => 'student', 'profile_picture' => 'profile_pictures/placeholder.jpg'],
            ['first_name' => 'Cao', 'last_name' => 'Qi', 'email' => 'caoqi@gmail.com', 'date_of_birth' => '1996-07-11', 'password' => Hash::make('password'), 'user_type' => 'professor', 'profile_picture' => 'profile_pictures/placeholder.jpg'],
            ['first_name' => 'John', 'last_name' => 'Binder', 'email' => 'binder@gmail.com', 'date_of_birth' => '1992-07-11', 'password' => Hash::make('password'), 'user_type' => 'professor', 'profile_picture' => 'profile_pictures/placeholder.jpg'],
            ['first_name' => 'Jane', 'last_name' => 'Doe', 'email' => 'jane.doe@example.com', 'date_of_birth' => '1986-07-11', 'password' => Hash::make('password'), 'user_type' => 'student', 'profile_picture' => 'profile_pictures/placeholder.jpg'],
            ['first_name' => 'Alex', 'last_name' => 'Smith', 'email' => 'alex.smith@example.com', 'date_of_birth' => '1999-08-11', 'password' => Hash::make('password'), 'user_type' => 'student', 'profile_picture' => 'profile_pictures/placeholder.jpg'],
            ['first_name' => 'Emily', 'last_name' => 'Brown', 'email' => 'emily.brown@example.com', 'date_of_birth' => '1992-09-11', 'password' => Hash::make('password'), 'user_type' => 'student', 'profile_picture' => 'profile_pictures/placeholder.jpg'],
            ['first_name' => 'Michael', 'last_name' => 'Johnson', 'email' => 'michael.johnson@example.com', 'date_of_birth' => '1986-01-11', 'password' => Hash::make('password'), 'user_type' => 'professor', 'profile_picture' => 'profile_pictures/placeholder.jpg'],
            ['first_name' => 'Sarah', 'last_name' => 'Davis', 'email' => 'sarah.davis@example.com', 'date_of_birth' => '2001-02-12', 'password' => Hash::make('password'), 'user_type' => 'student', 'profile_picture' => 'profile_pictures/placeholder.jpg'],
            ['first_name' => 'David', 'last_name' => 'Miller', 'email' => 'david.miller@example.com', 'date_of_birth' => '2002-03-22', 'password' => Hash::make('password'), 'user_type' => 'student', 'profile_picture' => 'profile_pictures/placeholder.jpg'],
            ['first_name' => 'Laura', 'last_name' => 'Wilson', 'email' => 'laura.wilson@example.com', 'date_of_birth' => '2003-04-23', 'password' => Hash::make('password'), 'user_type' => 'student', 'profile_picture' => 'profile_pictures/placeholder.jpg'],
            ['first_name' => 'James', 'last_name' => 'Taylor', 'email' => 'james.taylor@example.com', 'date_of_birth' => '2004-05-24', 'password' => Hash::make('password'), 'user_type' => 'student', 'profile_picture' => 'profile_pictures/placeholder.jpg'],
            ['first_name' => 'Maria', 'last_name' => 'Anderson', 'email' => 'maria.anderson@example.com', 'date_of_birth' => '2005-06-12', 'password' => Hash::make('password'), 'user_type' => 'professor', 'profile_picture' => 'profile_pictures/placeholder.jpg'],
            ['first_name' => 'Robert', 'last_name' => 'Thomas', 'email' => 'robert.thomas@example.com', 'date_of_birth' => '2006-08-22', 'password' => Hash::make('password'), 'user_type' => 'professor', 'profile_picture' => 'profile_pictures/placeholder.jpg'],
            ['first_name' => 'Linda', 'last_name' => 'Jackson', 'email' => 'linda.jackson@example.com', 'date_of_birth' => '2007-08-30', 'password' => Hash::make('password'), 'user_type' => 'professor', 'profile_picture' => 'profile_pictures/placeholder.jpg'],
            ['first_name' => 'Charles', 'last_name' => 'White', 'email' => 'charles.white@example.com', 'date_of_birth' => '2008-08-12', 'password' => Hash::make('password'), 'user_type' => 'professor', 'profile_picture' => 'profile_pictures/placeholder.jpg'],
            ['first_name' => 'Susan', 'last_name' => 'Harris', 'email' => 'susan.harris@example.com', 'date_of_birth' => '2009-07-12', 'password' => Hash::make('password'), 'user_type' => 'student', 'profile_picture' => 'profile_pictures/placeholder.jpg'],
            ['first_name' => 'Joseph', 'last_name' => 'Martin', 'email' => 'joseph.martin@example.com', 'date_of_birth' => '2002-07-15', 'password' => Hash::make('password'), 'user_type' => 'professor', 'profile_picture' => 'profile_pictures/placeholder.jpg'],
            ['first_name' => 'Karen', 'last_name' => 'Thompson', 'email' => 'karen.thompson@example.com', 'date_of_birth' => '2001-07-16', 'password' => Hash::make('password'), 'user_type' => 'student', 'profile_picture' => 'profile_pictures/placeholder.jpg'],
            ['first_name' => 'Thomas', 'last_name' => 'Garcia', 'email' => 'thomas.garcia@example.com', 'date_of_birth' => '2001-07-17', 'password' => Hash::make('password'), 'user_type' => 'student', 'profile_picture' => 'profile_pictures/placeholder.jpg'],
            ['first_name' => 'Lisa', 'last_name' => 'Martinez', 'email' => 'lisa.martinez@example.com', 'date_of_birth' => '2001-07-18', 'password' => Hash::make('password'), 'user_type' => 'professor', 'profile_picture' => 'profile_pictures/placeholder.jpg'],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}