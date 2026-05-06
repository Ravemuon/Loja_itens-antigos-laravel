<?php

namespace Database\Seeders;

use App\Models\MediaFormat;
use Illuminate\Database\Seeder;

class MediaFormatSeeder extends Seeder
{
    public function run(): void
    {
        $formatos = [
            ['id' => 1, 'nome' => 'Vinil (LP/EP)', 'sigla' => 'VINIL'],
            ['id' => 2, 'nome' => 'CD (Compact Disc)', 'sigla' => 'CD'],
            ['id' => 3, 'nome' => 'Fita Cassete', 'sigla' => 'CASS'],
            ['id' => 4, 'nome' => 'DVD', 'sigla' => 'DVD'],
            ['id' => 5, 'nome' => 'Blu-ray', 'sigla' => 'BD'],
            ['id' => 6, 'nome' => 'VHS', 'sigla' => 'VHS'],
            ['id' => 7, 'nome' => 'Cartucho', 'sigla' => 'CART'],
            ['id' => 8, 'nome' => 'CD-ROM', 'sigla' => 'CDROM'],
            ['id' => 9, 'nome' => 'DVD-ROM', 'sigla' => 'DVDROM'],
            ['id' => 10, 'nome' => 'Blu-ray Disc (PS3/PS4/Xbox)', 'sigla' => 'BROM'],
            ['id' => 11, 'nome' => 'Mídia Digital (código de ativação)', 'sigla' => 'DIG'],
        ];

        foreach ($formatos as $formato) {
            MediaFormat::updateOrCreate(['id' => $formato['id']], $formato);
        }
    }
}