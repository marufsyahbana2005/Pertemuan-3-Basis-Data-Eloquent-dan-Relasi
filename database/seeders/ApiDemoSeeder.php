<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;


use Illuminate\Database\Seeder;

class ApiDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // if (! app()->environment('local', 'testing')) {
        //     throw new \RuntimeException('Seeder hanya untuk latihan lokal.');
        // }
        foreach ([
            ['Ani', 'ani@example.test', false],
            ['Budi', 'budi@example.test', false],
            ['Admin', 'admin@example.test', true],
        ] as [$name, $email, $admin]) {
            $user = User::firstOrNew(['email' => $email]);
            $user->name = $name;
            $user->password = Hash::make('LatihanWeb2!2026');
            $user->is_admin = $admin;
            $user->save();
        }
        Category::firstOrCreate(['name' => 'Jaringan']);
    }
}
