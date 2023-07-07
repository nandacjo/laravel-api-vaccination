<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Medical;
use App\Models\Society;
use App\Models\Regional;
use App\Models\Spot;
use App\Models\SpotVaccine;
use App\Models\User;
use App\Models\Vaccine;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('regionals')->insert([
            'province' => 'Aceh',
            'district' => 'singkil'
        ]);

        (new Society([
            'id_card_number' => '332',
            'name' => 'Nanda',
            'password' => Hash::make('password'),
            'born_date' => '1997-01-22',
            'gender' => 'male',
            'address' => 'singkil',
            'regional_id' => 1,
            'login_tokens' => null,
        ]))->save();

        (new Spot([
            'regional_id' => 1,
            'name' => 'RSUD Aceh Singkil',
            'address' => 'Aceh Singkil',
            'serve' => 1,
            'capacity' => 3,
        ]))->save();

        (new Spot([
            'regional_id' => 1,
            'name' => 'Puskesma Aceh Singkil',
            'address' => 'Rimo',
            'serve' => 21,
            'capacity' => 300,
        ]))->save();

        (new User([
            'username' => 'husni',
            'password' => Hash::make('password')
        ]))->save();

        (new Medical([
            'user_id' => 1,
            'spot_id' => 1,
            'role' => 'docter',
            'name' => 'Hesti Sukmawati',
        ]))->save();

        $vaccines = ['sinovac', 'astrazeneca', 'moderna', 'pfizer', 'sinnopharm'];

        for ($i=0; $i < count($vaccines); $i++) {
            (new Vaccine([
                'name' => $vaccines[$i],
            ]))->save();
        }

      for ($i=1; $i <= 5; $i++) {
        (new SpotVaccine([
            'spot_id' => 1,
            'vaccine_id' => $i,
        ]))->save();
      }

    }
}
