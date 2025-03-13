<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        setlocale(LC_TIME, 'id_ID.utf8');
        $dateNow = now(env('APP_TIMEZONE', 'Asia/Jakarta'));

        $id_penduduk = DB::table('penduduk')->insertGetId([
            'fullname' => 'root',
            'created_at' => $dateNow
        ]);

        $id_user = DB::table('users')->insertGetId([
            'username' => 'root',
            'email' => 'root@skuad.com',
            'id_role' => 1,
            'id_penduduk' => $id_penduduk,
            'password' => Hash::make('1234'),
            'created_at' => $dateNow
        ]);
    }
}
