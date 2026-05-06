<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class NovosItensSeeder extends Seeder
{
    public function run(): void
    {
        $itens = [
            // ===========================
            // ROCK NACIONAL
            // ===========================
            [
                'titulo' => 'Matanza - Santa Madre Cassino',
                'artista_diretor' => 'Matanza',
                'empresa_produtora' => 'Deckdisc',
                'preco' => 49.90,
                'quantidade_estoque' => 3,
                'capa' => null,
                'category_id' => 3, // Rock Nacional & Underground
                'media_format_id' => 2, // CD
                'descricao' => 'CD com o clássico "Ela Traiu o Rock and Roll". Country core de peso.',
                'user_id' => 1
            ],
            [
                'titulo' => 'Matanza - Odiosa Natureza Humana',
                'artista_diretor' => 'Matanza',
                'empresa_produtora' => 'Deckdisc',
                'preco' => 120.00,
                'quantidade_estoque' => 1,
                'capa' => null,
                'category_id' => 3, // Rock Nacional
                'media_format_id' => 1, // Vinil
                'descricao' => 'Vinil preto. Edição limitada com encarte.',
                'user_id' => 1
            ],
            [
                'titulo' => 'Garotos Podres - Canções para Ninar',
                'artista_diretor' => 'Garotos Podres',
                'empresa_produtora' => 'Devil Discos',
                'preco' => 89.90,
                'quantidade_estoque' => 2,
                'capa' => null,
                'category_id' => 8, // Punk & Hardcore
                'media_format_id' => 1, // Vinil
                'descricao' => 'Clássico do punk rock brasileiro. Vinil vermelho.',
                'user_id' => 1
            ],
            [
                'titulo' => 'Raimundos - Lavô Tá Novo',
                'artista_diretor' => 'Raimundos',
                'empresa_produtora' => 'Warner Music',
                'preco' => 79.90,
                'quantidade_estoque' => 2,
                'capa' => null,
                'category_id' => 3, // Rock Nacional
                'media_format_id' => 2, // CD
                'descricao' => 'CD original de 1996. Forrocore dos bons.',
                'user_id' => 1
            ],
            [
                'titulo' => 'Charlie Brown Jr. - Transpiração Contínua Prolongada',
                'artista_diretor' => 'Charlie Brown Jr.',
                'empresa_produtora' => 'EMI',
                'preco' => 199.90,
                'quantidade_estoque' => 1,
                'capa' => null,
                'category_id' => 3, // Rock Nacional
                'media_format_id' => 1, // Vinil
                'descricao' => 'Vinil duplo com os maiores sucessos. Edição comemorativa.',
                'user_id' => 1
            ],
            [
                'titulo' => 'Angra - Temple of Shadows',
                'artista_diretor' => 'Angra',
                'empresa_produtora' => 'Steamhammer',
                'preco' => 170.00,
                'quantidade_estoque' => 1,
                'capa' => null,
                'category_id' => 1, // Heavy Metal
                'media_format_id' => 1, // Vinil
                'descricao' => 'Power metal brasileiro. Vinil 180g.',
                'user_id' => 1
            ],

            // ===========================
            // ROCK INTERNACIONAL
            // ===========================
            [
                'titulo' => 'Metallica - Master of Puppets',
                'artista_diretor' => 'Metallica',
                'empresa_produtora' => 'Elektra Records',
                'preco' => 249.90,
                'quantidade_estoque' => 1,
                'capa' => null,
                'category_id' => 1, // Heavy Metal
                'media_format_id' => 1, // Vinil
                'descricao' => 'Edição remasterizada em vinil 180g. Clássico absoluto do trash metal.',
                'user_id' => 1
            ],
            [
                'titulo' => 'Iron Maiden - The Number of the Beast',
                'artista_diretor' => 'Iron Maiden',
                'empresa_produtora' => 'EMI',
                'preco' => 220.00,
                'quantidade_estoque' => 1,
                'capa' => null,
                'category_id' => 1,
                'media_format_id' => 1, // Vinil
                'descricao' => 'Vinil clássico com arte original. Inclui poster.',
                'user_id' => 1
            ],
            [
                'titulo' => 'Nirvana - Nevermind',
                'artista_diretor' => 'Nirvana',
                'empresa_produtora' => 'DGC Records',
                'preco' => 199.90,
                'quantidade_estoque' => 2,
                'capa' => null,
                'category_id' => 2, // Indie & Alternative
                'media_format_id' => 1, // Vinil
                'descricao' => 'Vinil 180g. O álbum que explodiu o grunge.',
                'user_id' => 1
            ],
            [
                'titulo' => 'Guns N\' Roses - Appetite for Destruction',
                'artista_diretor' => 'Guns N\' Roses',
                'empresa_produtora' => 'Geffen Records',
                'preco' => 235.00,
                'quantidade_estoque' => 1,
                'capa' => null,
                'category_id' => 1,
                'media_format_id' => 1, // Vinil
                'descricao' => 'Vinil primeira prensagem americana. Capa com a cruz esqueletos.',
                'user_id' => 1
            ],

            // ===========================
            // JOGOS ANTIGOS (CLÁSSICOS)
            // ===========================
            [
                'titulo' => 'The Mask (O Máskara) - SNES',
                'artista_diretor' => 'David Perry',
                'empresa_produtora' => 'Capcom / Ocean Software',
                'preco' => 380.00,
                'quantidade_estoque' => 1,
                'capa' => null,
                'category_id' => 21, // Retro Gaming
                'media_format_id' => 7, // Cartucho
                'descricao' => 'Cartucho original SNES. Platformer divertido e caótico como o filme.',
                'user_id' => 1
            ],
            [
                'titulo' => 'Top Gear - SNES',
                'artista_diretor' => 'Barry Leitch',
                'empresa_produtora' => 'Kemco / Gremlin',
                'preco' => 180.00,
                'quantidade_estoque' => 2,
                'capa' => null,
                'category_id' => 21, // Retro Gaming
                'media_format_id' => 7, // Cartucho
                'descricao' => 'Jogo de corrida com trilha sonora inesquecível. Cartucho limpo.',
                'user_id' => 1
            ],
            [
                'titulo' => 'Streets of Rage - Mega Drive',
                'artista_diretor' => 'Yuzo Koshiro',
                'empresa_produtora' => 'Sega',
                'preco' => 210.00,
                'quantidade_estoque' => 1,
                'capa' => null,
                'category_id' => 27, // Luta & Fighting Games
                'media_format_id' => 7, // Cartucho
                'descricao' => 'Beat \'em up clássico do Mega Drive. Cartucho com capa original.',
                'user_id' => 1
            ],
            [
                'titulo' => 'Castlevania: Symphony of the Night - PS1',
                'artista_diretor' => 'Koji Igarashi',
                'empresa_produtora' => 'Konami',
                'preco' => 650.00,
                'quantidade_estoque' => 1,
                'capa' => null,
                'category_id' => 22, // RPGs & Fantasia Medieval (Metroidvania)
                'media_format_id' => 8, // CD-ROM (PS1)
                'descricao' => 'Dois CDs em caixa jewel case. Relíquia do PS1.',
                'user_id' => 1
            ],
            [
                'titulo' => 'Super Mario World - SNES',
                'artista_diretor' => 'Shigeru Miyamoto',
                'empresa_produtora' => 'Nintendo',
                'preco' => 299.90,
                'quantidade_estoque' => 1,
                'capa' => null,
                'category_id' => 24, // Plataforma & Ação
                'media_format_id' => 7, // Cartucho
                'descricao' => 'Cartucho americano (label preservada). Jogabilidade impecável.',
                'user_id' => 1
            ],
            [
                'titulo' => 'Donkey Kong Country - SNES',
                'artista_diretor' => 'Tim Stamper',
                'empresa_produtora' => 'Rare / Nintendo',
                'preco' => 210.00,
                'quantidade_estoque' => 2,
                'capa' => null,
                'category_id' => 24, // Plataforma
                'media_format_id' => 7, // Cartucho
                'descricao' => 'Cartucho com gráficos pré-renderizados impecáveis.',
                'user_id' => 1
            ],
            [
                'titulo' => 'Mortal Kombat II - Mega Drive',
                'artista_diretor' => 'Ed Boon',
                'empresa_produtora' => 'Midway / Acclaim',
                'preco' => 195.00,
                'quantidade_estoque' => 3,
                'capa' => null,
                'category_id' => 27, // Luta
                'media_format_id' => 7, // Cartucho
                'descricao' => 'Versão do Mega Drive com sangue e fatality liberados via código.',
                'user_id' => 1
            ],
            [
                'titulo' => 'Street Fighter II Turbo - SNES',
                'artista_diretor' => 'Capcom',
                'empresa_produtora' => 'Capcom',
                'preco' => 190.00,
                'quantidade_estoque' => 2,
                'capa' => null,
                'category_id' => 27, // Luta
                'media_format_id' => 7, // Cartucho
                'descricao' => 'Cartucho original. A versão definitiva do clássico de luta.',
                'user_id' => 1
            ],
            [
                'titulo' => 'Final Fantasy VII - PS1 (Edição Internacional)',
                'artista_diretor' => 'Hironobu Sakaguchi',
                'empresa_produtora' => 'Square',
                'preco' => 550.00,
                'quantidade_estoque' => 1,
                'capa' => null,
                'category_id' => 22, // RPG
                'media_format_id' => 8, // CD-ROM
                'descricao' => '4 CDs completo com caixa original. RPG que marcou geração.',
                'user_id' => 1
            ],
        ];

        foreach ($itens as $item) {
            Item::create($item);
        }
    }
}