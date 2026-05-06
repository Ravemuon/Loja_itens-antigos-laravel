<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $itens = [
            // --- MÚSICA (Categorias 1-10) ---
            [
                'titulo' => 'Mamonas Assassinas',
                'artista_diretor' => 'Mamonas Assassinas',
                'empresa_produtora' => 'EMI',
                'preco' => 150.00,
                'quantidade_estoque' => 1,
                'capa' => null,
                'category_id' => 3, // Rock Nacional & Underground
                'media_format_id' => 1, // Vinil
                'descricao' => 'LP Original de 1995. Inclui encarte raro.',
                'user_id' => 1
            ],
            [
                'titulo' => 'Raining Blood (Single)',
                'artista_diretor' => 'Slayer',
                'empresa_produtora' => 'Def Jam',
                'preco' => 120.00,
                'quantidade_estoque' => 1,
                'capa' => null,
                'category_id' => 1, // Heavy Metal & Hard Rock
                'media_format_id' => 1, // Vinil
                'descricao' => 'Compacto 7 polegadas. Vinil vermelho transparente.',
                'user_id' => 1
            ],
            [
                'titulo' => 'Sobrevivendo no Inferno',
                'artista_diretor' => 'Racionais MC\'s',
                'empresa_produtora' => 'Cosa Nostra',
                'preco' => 320.00,
                'quantidade_estoque' => 1,
                'capa' => null,
                'category_id' => 4, // Hip Hop & Rap
                'media_format_id' => 1, // Vinil
                'descricao' => 'Reedição de luxo. Item fundamental do Rap Nacional.',
                'user_id' => 1
            ],
            [
                'titulo' => 'Santa Madre Cassino',
                'artista_diretor' => 'Matanza',
                'empresa_produtora' => 'Deckdisc',
                'preco' => 45.00,
                'quantidade_estoque' => 2,
                'capa' => null,
                'category_id' => 3, // Rock Nacional & Underground
                'media_format_id' => 2, // CD
                'descricao' => 'CD em excelente estado. Country-Core puro.',
                'user_id' => 1
            ],
            // Novidades brasileiras na música
            [
                'titulo' => 'Acabou Chorare',
                'artista_diretor' => 'Novos Baianos',
                'empresa_produtora' => 'Som Livre',
                'preco' => 180.00,
                'quantidade_estoque' => 1,
                'capa' => null,
                'category_id' => 6, // MPB & Bossa Nova
                'media_format_id' => 1, // Vinil
                'descricao' => 'Clássico de 1972. Vinil original em ótimo estado.',
                'user_id' => 1
            ],
            [
                'titulo' => 'Cabeça Dinossauro',
                'artista_diretor' => 'Titãs',
                'empresa_produtora' => 'WEA',
                'preco' => 250.00,
                'quantidade_estoque' => 1,
                'capa' => null,
                'category_id' => 3, // Rock Nacional
                'media_format_id' => 1, // Vinil
                'descricao' => 'LP de 1986, marco do rock brasileiro.',
                'user_id' => 1
            ],
            [
                'titulo' => 'Construção',
                'artista_diretor' => 'Chico Buarque',
                'empresa_produtora' => 'Philips',
                'preco' => 300.00,
                'quantidade_estoque' => 1,
                'capa' => null,
                'category_id' => 6, // MPB
                'media_format_id' => 1, // Vinil
                'descricao' => 'Álbum icônico de 1971. Capa e disco impecáveis.',
                'user_id' => 1
            ],

            // --- FILMES (Categorias 11-20) ---
            [
                'titulo' => 'O Auto da Compadecida',
                'artista_diretor' => 'Guel Arraes',
                'empresa_produtora' => 'Globo Filmes',
                'elenco_detalhes' => 'Selton Mello, Matheus Nachtergaele',
                'preco' => 40.00,
                'quantidade_estoque' => 3,
                'capa' => null,
                'category_id' => 13, // Clássicos do Cinema
                'media_format_id' => 4, // DVD
                'descricao' => 'DVD Edição Especial. Baseado na obra de Ariano Suassuna.',
                'user_id' => 1
            ],
            [
                'titulo' => 'Akira',
                'artista_diretor' => 'Katsuhiro Otomo',
                'empresa_produtora' => 'TMS Entertainment',
                'elenco_detalhes' => 'Mitsuo Iwata, Nozomu Sasaki',
                'preco' => 90.00,
                'quantidade_estoque' => 1,
                'capa' => null,
                'category_id' => 19, // Animes Clássicos
                'media_format_id' => 5, // Blu-ray
                'descricao' => 'Remasterizado em alta definição. Áudio original em Japonês.',
                'user_id' => 1
            ],
            [
                'titulo' => 'Evil Dead (Uma Noite Alucinante)',
                'artista_diretor' => 'Sam Raimi',
                'empresa_produtora' => 'Renaissance Pictures',
                'elenco_detalhes' => 'Bruce Campbell',
                'preco' => 55.00,
                'quantidade_estoque' => 2,
                'capa' => null,
                'category_id' => 12, // Terror
                'media_format_id' => 4, // DVD
                'descricao' => 'Capa Necronomicon de borracha. Raro para colecionadores.',
                'user_id' => 1
            ],
            // Novidades brasileiras e nerds (anime/mangá)
            [
                'titulo' => 'Cidade de Deus',
                'artista_diretor' => 'Fernando Meirelles',
                'empresa_produtora' => 'O2 Filmes',
                'elenco_detalhes' => 'Alexandre Rodrigues, Leandro Firmino',
                'preco' => 35.00,
                'quantidade_estoque' => 4,
                'capa' => null,
                'category_id' => 12, // Terror/drama
                'media_format_id' => 4, // DVD
                'descricao' => 'DVD especial com making of. Considerado um dos melhores filmes brasileiros.',
                'user_id' => 1
            ],
            [
                'titulo' => 'Dragon Ball Z: Box Completo (Saga Freeza)',
                'artista_diretor' => 'Akira Toriyama',
                'empresa_produtora' => 'Toei Animation',
                'elenco_detalhes' => 'Wendel Bezerra (dublagem BR)',
                'preco' => 120.00,
                'quantidade_estoque' => 2,
                'capa' => null,
                'category_id' => 19, // Animes
                'media_format_id' => 4, // DVD
                'descricao' => 'Box com 5 DVDs. Dublagem clássica brasileira.',
                'user_id' => 1
            ],

            // --- GAMES (Categorias 21-30) ---
            [
                'titulo' => 'Silent Hill',
                'artista_diretor' => 'Keiichiro Toyama',
                'empresa_produtora' => 'Konami',
                'preco' => 600.00,
                'quantidade_estoque' => 1,
                'capa' => null,
                'category_id' => 23, // Survival Horror Games
                'media_format_id' => 8, // CD-ROM (PS1)
                'descricao' => 'Versão Black Label original. Disco com marcas leves de uso.',
                'user_id' => 1
            ],
            [
                'titulo' => 'Pokémon Yellow',
                'artista_diretor' => 'Satoshi Tajiri',
                'empresa_produtora' => 'Nintendo / Game Freak',
                'preco' => 450.00,
                'quantidade_estoque' => 1,
                'capa' => null,
                'category_id' => 21, // Retro Gaming
                'media_format_id' => 7, // Cartucho
                'descricao' => 'Cartucho original GBC. Label preservada.',
                'user_id' => 1
            ],
            [
                'titulo' => 'The Legend of Zelda: Ocarina of Time',
                'artista_diretor' => 'Shigeru Miyamoto',
                'empresa_produtora' => 'Nintendo',
                'preco' => 380.00,
                'quantidade_estoque' => 1,
                'capa' => null,
                'category_id' => 22, // RPGs & Fantasia
                'media_format_id' => 7, // Cartucho
                'descricao' => 'Cartucho cinza de N64. Bateria de save nova.',
                'user_id' => 1
            ],
            // Jogos brasileiros e nerds
            [
                'titulo' => 'Momodora: Reverie Under the Moonlight',
                'artista_diretor' => 'rdein (Bombservice)',
                'empresa_produtora' => 'Playism',
                'preco' => 80.00,
                'quantidade_estoque' => 3,
                'capa' => null,
                'category_id' => 24, // Plataforma & Ação
                'media_format_id' => 11, // Mídia Digital
                'descricao' => 'Código de ativação para Steam. Indie brasileiro aclamado pela crítica.',
                'user_id' => 1
            ],
            [
                'titulo' => 'Dandara',
                'artista_diretor' => 'João Brant, Lucas Mattos',
                'empresa_produtora' => 'Long Hat House',
                'preco' => 45.00,
                'quantidade_estoque' => 5,
                'capa' => null,
                'category_id' => 24, // Plataforma
                'media_format_id' => 11, // Digital
                'descricao' => 'Chave digital para Nintendo Switch ou PC. Metroidvania brasileiro.',
                'user_id' => 1
            ],

            // --- HQs & Nerdices (categoria 30 - Colecionáveis, mas pode ser adaptada) ---
            [
                'titulo' => 'Turma da Mônica - Laços',
                'artista_diretor' => 'Vitor Cafaggi',
                'empresa_produtora' => 'Panini Comics',
                'preco' => 50.00,
                'quantidade_estoque' => 2,
                'capa' => null,
                'category_id' => 30, // Colecionáveis & Edições Limitadas
                'media_format_id' => 11, // Mídia Digital (ou crie formato HQ)
                'descricao' => 'Graphic MSP. Capa dura, edição de colecionador.',
                'user_id' => 1
            ],
            [
                'titulo' => 'Astronauta - Magnetar',
                'artista_diretor' => 'Danilo Beyruth',
                'empresa_produtora' => 'Panini Comics',
                'preco' => 55.00,
                'quantidade_estoque' => 1,
                'capa' => null,
                'category_id' => 30, // Colecionáveis
                'media_format_id' => 11,
                'descricao' => 'Primeiro volume da trilogia do Astronauta. Arte impressionante.',
                'user_id' => 1
            ],
            [
                'titulo' => 'Holy Avenger: O Tesouro de Kallyadranoch',
                'artista_diretor' => 'Marcelo Cassaro, Erica Awano',
                'empresa_produtora' => 'Jambô Editora',
                'preco' => 90.00,
                'quantidade_estoque' => 1,
                'capa' => null,
                'category_id' => 22, // RPGs & Fantasia (pode ser HQ de RPG)
                'media_format_id' => 11,
                'descricao' => 'Mangá brasileiro baseado em Tormenta. Edição especial.',
                'user_id' => 1
            ],
            [
                'titulo' => 'Watchmen (Edição Absoluta)',
                'artista_diretor' => 'Alan Moore, Dave Gibbons',
                'empresa_produtora' => 'DC Comics',
                'preco' => 200.00,
                'quantidade_estoque' => 1,
                'capa' => null,
                'category_id' => 30,
                'media_format_id' => 11,
                'descricao' => 'Formato gigante, capa dura, para colecionadores.',
                'user_id' => 1
            ],
            [
                'titulo' => 'O Chamado de Cthulhu - RPG (Livro Básico)',
                'artista_diretor' => 'Sandy Petersen',
                'empresa_produtora' => 'Chaosium / Devir',
                'preco' => 220.00,
                'quantidade_estoque' => 1,
                'capa' => null,
                'category_id' => 26, // Estratégia & Simulação (RPG de mesa)
                'media_format_id' => 11,
                'descricao' => 'Livro básico da 7ª edição. Terror cósmico.',
                'user_id' => 1
            ],
        ];

        foreach ($itens as $item) {
            Item::create($item);
        }
    }
}