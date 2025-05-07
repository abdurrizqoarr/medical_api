<?php

namespace Database\Seeders;

use App\Models\Bangsal;
use App\Models\Bed;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class BangsalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data1 = Bangsal::create([
            'id' => Str::uuid(),
            'bangsal' => 'Berlian',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $data2 = Bangsal::create([
            'id' => Str::uuid(),
            'bangsal' => 'Zamrud',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $data3 = Bangsal::create([
            'id' => Str::uuid(),
            'bangsal' => 'Mutiara',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $data4 = Bangsal::create([
            'id' => Str::uuid(),
            'bangsal' => 'Ruby',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $data5 = Bangsal::create([
            'id' => Str::uuid(),
            'bangsal' => 'Safir',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Bed::create([
            'id' => Str::uuid(),
            'bed' => 'Berlian 1',
            'bangsal' => $data1->id,
            'tarif' => 60000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Bed::create([
            'id' => Str::uuid(),
            'bed' => 'Berlian 2',
            'bangsal' => $data1->id,
            'tarif' => 60000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Bed::create([
            'id' => Str::uuid(),
            'bed' => 'Berlian 3',
            'bangsal' => $data1->id,
            'tarif' => 60000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Bed::create([
            'id' => Str::uuid(),
            'bed' => 'Zamrud 1',
            'bangsal' => $data2->id,
            'tarif' => 60000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Bed::create([
            'id' => Str::uuid(),
            'bed' => 'Zamrud 2',
            'bangsal' => $data2->id,
            'tarif' => 60000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Bed::create([
            'id' => Str::uuid(),
            'bed' => 'Zamrud 3',
            'bangsal' => $data2->id,
            'tarif' => 60000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Bed::create([
            'id' => Str::uuid(),
            'bed' => 'Mutiara 1',
            'bangsal' => $data3->id,
            'tarif' => 60000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Bed::create([
            'id' => Str::uuid(),
            'bed' => 'Mutiara 2',
            'bangsal' => $data3->id,
            'tarif' => 60000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Bed::create([
            'id' => Str::uuid(),
            'bed' => 'Mutiara 3',
            'bangsal' => $data3->id,
            'tarif' => 60000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Bed::create([
            'id' => Str::uuid(),
            'bed' => 'Ruby 1',
            'bangsal' => $data4->id,
            'tarif' => 60000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Bed::create([
            'id' => Str::uuid(),
            'bed' => 'Ruby 2',
            'bangsal' => $data4->id,
            'tarif' => 60000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Bed::create([
            'id' => Str::uuid(),
            'bed' => 'Ruby 3',
            'bangsal' => $data4->id,
            'tarif' => 60000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Bed::create([
            'id' => Str::uuid(),
            'bed' => 'Safir 1',
            'bangsal' => $data5->id,
            'tarif' => 60000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Bed::create([
            'id' => Str::uuid(),
            'bed' => 'Safir 2',
            'bangsal' => $data5->id,
            'tarif' => 60000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Bed::create([
            'id' => Str::uuid(),
            'bed' => 'Safir 3',
            'bangsal' => $data5->id,
            'tarif' => 60000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Bed::create([
            'id' => Str::uuid(),
            'bed' => 'Safir 4',
            'bangsal' => $data5->id,
            'tarif' => 60000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Bed::create([
            'id' => Str::uuid(),
            'bed' => 'Safir 5',
            'bangsal' => $data5->id,
            'tarif' => 60000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
