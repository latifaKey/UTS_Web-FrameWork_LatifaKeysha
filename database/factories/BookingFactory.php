<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jenis_lapangan = $this->faker->randomElement(['futsal', 'badminton', 'tenis']);
        $tanggal_booking = $this->faker->dateTimeBetween('now', '+2 months')->format('Y-m-d');
        $jam_mulai = $this->faker->dateTimeBetween('08:00', '20:00')->format('H:i');
        $jam_selesai = $this->faker->dateTimeBetween($jam_mulai, '22:00')->format('H:i');

        return [
            'nama_pemesan' => $this->faker->name(),
            'jenis_lapangan' => $jenis_lapangan,
            'tanggal_booking' => $tanggal_booking,
            'jam_mulai' => $jam_mulai,
            'jam_selesai' => $jam_selesai,
            'kontak' => $this->faker->phoneNumber(),
            'status' => $this->faker->randomElement(['terkonfirmasi', 'pending']),
        ];
    }
}
