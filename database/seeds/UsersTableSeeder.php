<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;
use App\Profile;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('users')->delete();
		DB::table('role_user')->delete();

		$adminRole = Role::where('name', 'admin')->first();
		$premiumRole = Role::where('name', 'premium')->first();
		$standardRole = Role::where('name', 'standard')->first();

		$admin = User::create([
			'f_name' => 'Admin',
			'l_name' => 'User',
			'email' => 'admin@test.com',
			'password' => Hash::make('password')
		]);

		$admin->roles()->attach($adminRole);

		$premium = User::create([
			'f_name' => 'Premium',
			'l_name' => 'User',
			'email' => 'premium@test.com',
			'password' => Hash::make('password')
		]);

		$premium->roles()->attach($premiumRole);

		$standard = User::create([
			'f_name' => 'Standard',
			'l_name' => 'User',
			'email' => 'standard@test.com',
			'password' => Hash::make('password')
		]);

		$standard->roles()->attach($standardRole);


		$adminProfile = Profile::create([
			'user_id' => $admin->id
		]);

		$premiumProfile = Profile::create([
			'user_id' => $premium->id
		]);

		$standardProfile = Profile::create([
			'user_id' => $standard->id
		]);
    }
}
