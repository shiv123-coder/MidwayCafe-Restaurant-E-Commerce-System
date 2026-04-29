<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Seed the default super admin account.
     *
     * Credentials:
     *   Name    : Shivshankar Mali
     *   Email   : shivashankrmali7@gmail.com
     *   Password: Shivmali@123
     *
     * @return void
     */
    public function run()
    {
        $email = 'shivashankrmali7@gmail.com';

        $existing = DB::table('users')->where('email', $email)->first();

        if (!$existing) {
            DB::table('users')->insert([
                'name'       => 'Shivshankar Mali',
                'email'      => $email,
                'phone'      => '9999999999',
                'usertype'   => '1',
                'salary'     => 0,
                'password'   => Hash::make('Shivmali@123'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            // Update existing record if credentials have changed
            DB::table('users')->where('email', $email)->update([
                'name'       => 'Shivshankar Mali',
                'password'   => Hash::make('Shivmali@123'),
                'usertype'   => '1',
                'updated_at' => now(),
            ]);
        }

        // Also update any old placeholder admin record (admin@restaurant.com)
        DB::table('users')
            ->where('email', 'admin@restaurant.com')
            ->where('usertype', '1')
            ->update([
                'name'       => 'Shivshankar Mali',
                'email'      => $email,
                'password'   => Hash::make('Shivmali@123'),
                'updated_at' => now(),
            ]);

        // Also clean up any stale shivshankarmali7 entry (old spelling)
        DB::table('users')
            ->where('email', 'shivshankarmali7@gmail.com')
            ->where('usertype', '1')
            ->update([
                'email'      => $email,
                'updated_at' => now(),
            ]);
    }
}
