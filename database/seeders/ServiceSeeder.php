<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'service_name'   => 'Reguler (3-4 hari)',
                'category'       => 'Reguler',
                'price_per_unit' => 7000,
                'unit_type'      => 'Kg',
                'description'    => 'Layanan cuci dan setrika reguler selesai 3-4 hari.',
            ],
            [
                'service_name'   => 'Ekspres (1-2 hari)',
                'category'       => 'Ekspres',
                'price_per_unit' => 12000,
                'unit_type'      => 'Kg',
                'description'    => 'Layanan cuci dan setrika cepat selesai 1-2 hari.',
            ],
            [
                'service_name'   => 'Superkilat (5 jam)',
                'category'       => 'Superkilat',
                'price_per_unit' => 25000,
                'unit_type'      => 'Kg',
                'description'    => 'Layanan cuci kilat prioritas selesai dalam 5 jam.',
            ],
            [
                'service_name'   => 'Bed Cover',
                'category'       => 'Satuan',
                'price_per_unit' => 25000,
                'unit_type'      => 'Pcs',
                'description'    => 'Pencucian bed cover dihitung per buah.',
            ],
            [
                'service_name'   => 'Cuci dan Setrika',
                'category'       => 'Ekspres',
                'price_per_unit' => 75000,
                'unit_type'      => 'Kg',
                'description'    => 'Layanan cuci dan setrika kualitas prima.',
            ],
            [
                'service_name'   => 'Cuci Express 3 Jam',
                'category'       => 'Ekspres',
                'price_per_unit' => 20000,
                'unit_type'      => 'Kg',
                'description'    => 'Layanan cuci dan setrika dengan waktu pengerjaan 3 jam.',
            ],
            [
                'service_name'   => 'Cuci Express 6 Jam',
                'category'       => 'Ekspres',
                'price_per_unit' => 15000,
                'unit_type'      => 'Kg',
                'description'    => 'Layanan cuci dan setrika dengan waktu pengerjaan 6 jam.',
            ],
            [
                'service_name'   => 'Cuci Kering',
                'category'       => 'Kiloan',
                'price_per_unit' => 5000,
                'unit_type'      => 'Kg',
                'description'    => 'Layanan pencucian dan pengeringan tanpa setrika.',
            ],
            [
                'service_name'   => 'Selimut',
                'category'       => 'Satuan',
                'price_per_unit' => 15000,
                'unit_type'      => 'Pcs',
                'description'    => 'Pencucian selimut dihitung per buah.',
            ],
            [
                'service_name'   => 'Setrika Saja',
                'category'       => 'Kiloan',
                'price_per_unit' => 4000,
                'unit_type'      => 'Kg',
                'description'    => 'Layanan setrika untuk pakaian bersih.',
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
