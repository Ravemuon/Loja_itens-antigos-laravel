<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Busca os usuários criados
        $ana = User::where('email', 'ana@email.com')->first();
        $carlos = User::where('email', 'carlos@rock.com')->first();
        $fernanda = User::where('email', 'feh@retro.com')->first();
        $ricardo = User::where('email', 'ricardo@anime.com')->first();
        $patricia = User::where('email', 'patricia@mpb.com')->first();
        $admin = User::where('email', 'admin@barganha.com')->first();

        $avaliacoes = [
            // --- MÚSICA ---
            [
                'item_titulo' => 'Mamonas Assassinas',
                'user' => $patricia,
                'nota' => 5,
                'comentario' => 'LP Original de 1995 simplesmente impecável! O encarte está muito bem preservado e a prensagem é de alta qualidade. Um item obrigatório pra qualquer colecionador de rock nacional. [reference:0]'
            ],
            [
                'item_titulo' => 'Roots',
                'user' => $carlos,
                'nota' => 4,
                'comentario' => 'Primeira prensagem europeia, capa com desgaste lateral mas o vinil está VG++. Vale o investimento pra quem curte groove metal. O álbum é um dos mais importantes dos anos 90. [reference:1]'
            ],
            [
                'item_titulo' => 'Raining Blood (Single)',
                'user' => $carlos,
                'nota' => 5,
                'comentario' => 'Compacto 7" de vinil vermelho, simplesmente foda. A prensagem está perfeita e o encarte é raro. Recomendo!'
            ],
            [
                'item_titulo' => 'Sobrevivendo no Inferno',
                'user' => $carlos,
                'nota' => 5,
                'comentario' => 'Reedição de luxo indispensável. Racionais entregaram um dos maiores discos da música brasileira. O rap nacional nunca mais foi o mesmo depois desse álbum.'
            ],
            [
                'item_titulo' => 'Acabou Chorare',
                'user' => $patricia,
                'nota' => 5,
                'comentario' => 'Obra-prima de 1972! Vinil original em estado de conservação invejável. Os Novos Baianos em sua melhor fase. Clássico absoluto da MPB.'
            ],
            [
                'item_titulo' => 'Cabeça Dinossauro',
                'user' => $carlos,
                'nota' => 5,
                'comentario' => 'Marco do rock brasileiro de 1986. As músicas soam atuais até hoje. Pra quem curte punk rock e rock nacional, edição original imperdível.'
            ],
            [
                'item_titulo' => 'Matanza - Odiosa Natureza Humana',
                'user' => $carlos,
                'nota' => 5,
                'comentario' => 'Countrycore raiz. Country, hardcore e heavy metal na medida certa. Banda que definiu um gênero no Brasil. [reference:2]'
            ],
            [
                'item_titulo' => 'Garotos Podres - Canções para Ninar',
                'user' => $admin,
                'nota' => 5,
                'comentario' => 'Clássico do punk rock nacional de 1993. Mao e a banda entregam letras críticas com muito humor ácido. [reference:3]'
            ],
            [
                'item_titulo' => 'Angra - Temple of Shadows',
                'user' => $carlos,
                'nota' => 5,
                'comentario' => 'Power metal brasileiro de primeira linha. Edição em vinil duplo, capricho na prensagem.'
            ],

            // --- FILMES ---
            [
                'item_titulo' => 'Akira',
                'user' => $ricardo,
                'nota' => 5,
                'comentario' => 'Obra-prima do cyberpunk. Blu-ray com qualidade impecável e dublagem original. Um dos melhores animes de todos os tempos. [reference:4]'
            ],
            [
                'item_titulo' => 'O Auto da Compadecida',
                'user' => $admin,
                'nota' => 5,
                'comentario' => 'Melhor comédia brasileira de todos os tempos! Matheus Nachtergaele e Selton Mello estão impecáveis. O DVD tem menus animados, making of e extras. [reference:5]'
            ],
            [
                'item_titulo' => 'Cidade de Deus',
                'user' => $fernanda,
                'nota' => 5,
                'comentario' => 'Filmaço da porra. A versão em DVD tem making of e comentários que valem a pena. Um dos melhores filmes brasileiros já feitos. [reference:6]'
            ],
            [
                'item_titulo' => 'Blade Runner (The Final Cut)',
                'user' => $ricardo,
                'nota' => 5,
                'comentario' => 'Steelbook lindo demais. A qualidade do Blu-ray é monstra, áudio e imagem perfeitos. Clássico do sci-fi que todo nerd tem que ter na coleção.'
            ],

            // --- GAMES ---
            [
                'item_titulo' => 'Silent Hill',
                'user' => $fernanda,
                'nota' => 5,
                'comentario' => 'Clássico absoluto do survival horror. Atmosfera e terror psicológico que nenhum outro jogo conseguiu superar. PS1 original em ótimo estado. [reference:7]'
            ],
            [
                'item_titulo' => 'Pokémon Yellow',
                'user' => $fernanda,
                'nota' => 5,
                'comentario' => 'Pikachu te seguindo na tela é a maior nostalgia. O cartucho original GBC está salvo 100%. Diversão garantida pra quem cresceu vendo o desenho. [reference:8]'
            ],
            [
                'item_titulo' => 'The Legend of Zelda: Ocarina of Time',
                'user' => $fernanda,
                'nota' => 5,
                'comentario' => 'Melhor jogo de todos os tempos na minha humilde opinião. Cartucho de N64 em ótimo estado, a bateria foi trocada para salvar.'
            ],
            [
                'item_titulo' => 'Super Metroid',
                'user' => $fernanda,
                'nota' => 5,
                'comentario' => 'Cartucho original em perfeito estado. É um dos melhores jogos do SNES, exploração e ação na medida certa.'
            ],
            [
                'item_titulo' => 'The Mask (O Máskara) - SNES',
                'user' => $admin,
                'nota' => 4,
                'comentario' => 'Jogo muito divertido que captura bem a energia do filme. Gráficos bonitos pro SNES, mas alguns níveis são repetitivos. [reference:9]'
            ],
            [
                'item_titulo' => 'Top Gear - SNES',
                'user' => $fernanda,
                'nota' => 5,
                'comentario' => 'Melhor trilha sonora de jogo de corrida da era 16-bit. Gráficos bonitos e jogabilidade viciante. [reference:10]'
            ],
            [
                'item_titulo' => 'Castlevania: Symphony of the Night - PS1',
                'user' => $ricardo,
                'nota' => 5,
                'comentario' => 'Obra-prima do metroidvania. A música é fenomenal, exploração recompensadora. Edição original de PS1 com os dois CDs. [reference:11]'
            ],
            [
                'item_titulo' => 'Streets of Rage - Mega Drive',
                'user' => $fernanda,
                'nota' => 5,
                'comentario' => 'Socos que doem na alma, trilha sonora do Yuzo Koshiro e poder chamar a polícia com míssil. Combate simples mas satisfatório demais. [reference:12]'
            ],
            [
                'item_titulo' => 'Final Fantasy VII - PS1',
                'user' => $admin,
                'nota' => 5,
                'comentario' => 'RPG que definiu uma geração. Todos os 4 CDs e caixa original. História emocionante jogabilidade que ainda diverte. [reference:13]'
            ],
            [
                'item_titulo' => 'Mortal Kombat II - SNES',
                'user' => $fernanda,
                'nota' => 5,
                'comentario' => 'Melhor jogo de luta do SNES sem discussão. Sangue, fatalities e aquele monte de segredo. Imagem e som fiéis ao arcade. [reference:14]'
            ],
        ];

        foreach ($avaliacoes as $av) {
            if (!$av['user']) {
                continue;
            }

            $item = Item::where('titulo', $av['item_titulo'])->first();

            if ($item) {
                Review::updateOrCreate(
                    [
                        'item_id' => $item->id,
                        'user_id' => $av['user']->id,
                    ],
                    [
                        'nota' => $av['nota'],
                        'comentario' => $av['comentario'],
                    ]
                );
            }
        }
    }
}