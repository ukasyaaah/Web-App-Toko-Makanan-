<?php

namespace Database\Seeders;
use App\Models\Province;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class ProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    // Fetch data dari API RajaOngkir
    $response = Http::withHeaders([
        'key' => config('rajaongkir.api_key'),
    ])->get('https://api.rajaongkir.com/starter/province');

    // Debug response dulu sebelum lanjut
    $data = $response->json();
    dd($data); // Lihat isi respons API sebelum di-loop

    // Cek apakah 'rajaongkir' dan 'results' ada di response
    if (!isset($data['rajaongkir']) || !isset($data['rajaongkir']['results'])) {
        dd("Error: Key 'rajaongkir' atau 'results' tidak ditemukan", $data);
    }

    // Loop data dari API
    foreach ($data['rajaongkir']['results'] as $province) {
        Province::create([
            'id'   => $province['province_id'],
            'name' => $province['province']
        ]);
    }
}

}
