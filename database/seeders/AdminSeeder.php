<?php

namespace Database\Seeders;

use App\Models\MemberTree;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(User::where('username', 'superadmin')->exists()) {
            return;
        }

        $User = User::create([
            'uuid' => (string) Str::orderedUuid(),
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => config('app.email'),
            'mobile' => config('app.phone'),
            'pin' => 1234,
            'password' => 12345678,
        ]);

        $User->assignRole('superadmin');

        MemberTree::create([
            'user_id' => $User->id,
            'sponsor_id' => null,
            'is_premium' => now(),
        ]);
    }
}
