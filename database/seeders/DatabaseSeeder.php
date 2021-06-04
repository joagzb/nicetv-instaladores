<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(){
        if (env('APP_DEBUG') && env('APP_ENV') == 'local') {
            DB::table('users')->delete();      //for cleaning earlier data to avoid duplicate entries
            DB::table('instalador')->delete(); //for cleaning earlier data to avoid duplicate entries
            DB::table('admin')->delete();      //for cleaning earlier data to avoid duplicate entries

            DB::table('users')->insert([
                'id'                => 5000,
                'name'              => 'Dummy Administrador',
                'email'             => 'admin@admin.com',
                'type'              => 'admin',
                'email_verified_at' => Carbon::now()->toDate(),
                'telefono'          => '37040000000',
                'password'          => Hash::make('212121'),
            ]);
            DB::table('admin')->insert([
                'id'    => 5000,
                'nivel' => 3,
            ]);

            // crear un usuario administrador y otro instalador
            DB::table('users')->insert([
                'id'                => 10,
                'name'              => 'Dummy instalador',
                'email'             => 'prueba@prueba.com',
                'email_verified_at' => Carbon::now()->toDate(),
                'telefono'          => '37040000000',
                'password'          => Hash::make('212121'),
            ]);
            DB::table('instalador')->insert([
                'id'                        => 10,
                'habilitado'                => 1,
                'id_admin_responsable_alta' => 5000,
            ]);
        }
    }
}
