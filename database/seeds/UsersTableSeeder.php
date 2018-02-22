<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Hui',
                'email' => 'hui@admin.com',
                'password' => Hash::make('admin'),
                'introduction' => 'This is Hui introduction',
                'picture' => 'https://lorempixel.com/640/480/?35573',
                'remember_token' => str_random(10),
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ]
        ];
        DB::table('users')->insert($users);

        factory(App\Models\User::class, 5) -> create();
    }
}
