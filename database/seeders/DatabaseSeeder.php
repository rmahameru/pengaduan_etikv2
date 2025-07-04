<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Petugas::create([
            'nama_petugas'  => 'Administrator',
            'username'  => 'admin',
            'telp' => '082117564354',
            'password'  => bcrypt('indonesia'),
            'roles' => 'admin'
        ]);

        \App\Models\Masyarakat::create([
            'nik'  => '3573087627649992',
            'name'  => 'user1',
            'username'  => 'user',
            'email'  => 'user@gmail.com',
            'telp' => '082117564354',
            'jenis_kelamin'  => 'P',
            'password'  => bcrypt('user1234'),
        ]);
    }
}
