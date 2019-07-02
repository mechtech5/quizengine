<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      User::create([
      	'name' => 'Ayush',
      	'email' => 'a@gmail.com',
      	'password' => bcrypt('123123123'),
      	'created_at' => now(),
      	'updated_at' => now()
      ]);

      User::create([
      	'name' => 'Bittu',
      	'email' => 'b@gmail.com',
      	'password' => bcrypt('123123123'),
      	'created_at' => now(),
      	'updated_at' => now()
      ]);
    }
}
