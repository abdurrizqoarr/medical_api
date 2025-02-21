<?php

namespace Database\Factories;

use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pegawai>
 */
class PegawaiFactory extends Factory
{
    protected $model = Pegawai::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nik' => $this->faker->unique()->numerify('################'),
            'npwp' => $this->faker->optional()->numerify('##.###.###.#-###.###'),
            'nip' => $this->faker->unique()->numerify('################'),
            'nama' => $this->faker->name(),
            'jenis_kelamin' => $this->faker->randomElement(['PRIA', 'WANITA']),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date('Y-m-d', '2005-01-01'), // Tanggal lahir max 2005
            'stts_nikah' => $this->faker->optional()->randomElement(['BELUM MENIKAH', 'MENIKAH', 'JANDA', 'DUDHA']),
            'alamat' => $this->faker->optional()->address(),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
