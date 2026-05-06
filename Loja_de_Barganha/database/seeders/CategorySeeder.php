<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            // --- MÚSICA (IDs 1 a 10) ---
            ['id' => 1, 'nome' => 'Heavy Metal & Hard Rock', 'tipo_midia' => 'Música', 'icone' => 'bi-fire', 'descricao' => 'Mídias de vertentes do rock pesado e metal clássico.', 'publico_alvo' => 'Jovens e Adultos'],
            ['id' => 2, 'nome' => 'Indie & Alternative', 'tipo_midia' => 'Música', 'icone' => 'bi-megaphone', 'descricao' => 'Produções independentes e rock alternativo de baixa tiragem.', 'publico_alvo' => 'Geral'],
            ['id' => 3, 'nome' => 'Rock Nacional & Underground', 'tipo_midia' => 'Música', 'icone' => 'bi-vinyl-fill', 'descricao' => 'Relíquias do rock brasileiro, do punk ao pós-punk.', 'publico_alvo' => 'Colecionadores'],
            ['id' => 4, 'nome' => 'Hip Hop & Rap', 'tipo_midia' => 'Música', 'icone' => 'bi-mic', 'descricao' => 'Vinil e CD de rap nacional e internacional.', 'publico_alvo' => 'Jovens'],
            ['id' => 5, 'nome' => 'Pop & Synthwave', 'tipo_midia' => 'Música', 'icone' => 'bi-music-note', 'descricao' => 'Pop oitentista, synthwave e eletrônico.', 'publico_alvo' => 'Geral'],
            ['id' => 6, 'nome' => 'MPB & Bossa Nova', 'tipo_midia' => 'Música', 'icone' => 'bi-guitar', 'descricao' => 'Clássicos da música popular brasileira.', 'publico_alvo' => 'Adultos'],
            ['id' => 7, 'nome' => 'Blues & Jazz', 'tipo_midia' => 'Música', 'icone' => 'bi-sax', 'descricao' => 'Discos de blues e jazz em vinil.', 'publico_alvo' => 'Colecionadores'],
            ['id' => 8, 'nome' => 'Punk & Hardcore', 'tipo_midia' => 'Música', 'icone' => 'bi-lightning', 'descricao' => 'Punk rock, hardcore e screamo.', 'publico_alvo' => 'Adultos'],
            ['id' => 9, 'nome' => 'Trilhas Sonoras', 'tipo_midia' => 'Música', 'icone' => 'bi-film', 'descricao' => 'Trilhas de filmes, séries e games.', 'publico_alvo' => 'Geral'],
            ['id' => 10, 'nome' => 'Eletrônica & Dance', 'tipo_midia' => 'Música', 'icone' => 'bi-boombox', 'descricao' => 'House, techno, ambient.', 'publico_alvo' => 'Jovens'],

            // --- CINEMA & TV (IDs 11 a 20) ---
            ['id' => 11, 'nome' => 'Sci-Fi & Cyberpunk', 'tipo_midia' => 'Filme', 'icone' => 'bi-robot', 'descricao' => 'Ficção científica clássica, distopias e tecnologia futurista.', 'publico_alvo' => 'Fãs de Tecnologia'],
            ['id' => 12, 'nome' => 'Terror & Thriller Horror', 'tipo_midia' => 'Filme', 'icone' => 'bi-ghost', 'descricao' => 'Mídias físicas de horror, slasher e suspense psicológico.', 'publico_alvo' => 'Maiores de 16 anos'],
            ['id' => 13, 'nome' => 'Clássicos do Cinema', 'tipo_midia' => 'Filme', 'icone' => 'bi-film', 'descricao' => 'Grandes obras do cinema mundial em VHS e DVD.', 'publico_alvo' => 'Cinemaníacos'],
            ['id' => 14, 'nome' => 'Ação & Aventura', 'tipo_midia' => 'Filme', 'icone' => 'bi-sword', 'descricao' => 'Filmes de ação, aventura e super-heróis.', 'publico_alvo' => 'Geral'],
            ['id' => 15, 'nome' => 'Drama & Romance', 'tipo_midia' => 'Filme', 'icone' => 'bi-heart', 'descricao' => 'Dramas premiados e romances.', 'publico_alvo' => 'Adultos'],
            ['id' => 16, 'nome' => 'Comédia', 'tipo_midia' => 'Filme', 'icone' => 'bi-emoji-laughing', 'descricao' => 'Comédias clássicas e modernas.', 'publico_alvo' => 'Geral'],
            ['id' => 17, 'nome' => 'Documentários', 'tipo_midia' => 'Filme', 'icone' => 'bi-camera-reels', 'descricao' => 'Documentários de natureza, história e música.', 'publico_alvo' => 'Estudiosos'],
            ['id' => 18, 'nome' => 'Séries & Minisséries', 'tipo_midia' => 'Filme', 'icone' => 'bi-tv', 'descricao' => 'Box sets de séries de TV.', 'publico_alvo' => 'Geral'],
            ['id' => 19, 'nome' => 'Animes Clássicos & Modernos', 'tipo_midia' => 'Filme', 'icone' => 'bi-display', 'descricao' => 'Animes em DVD, Blu-ray e mídia física.', 'publico_alvo' => 'Otakus'],
            ['id' => 20, 'nome' => 'Far West & Samurai', 'tipo_midia' => 'Filme', 'icone' => 'bi-eye', 'descricao' => 'Westerns, filmes de samurai e chanbara.', 'publico_alvo' => 'Cultores'],

            // --- GAMES (IDs 21 a 30) ---
            ['id' => 21, 'nome' => 'Retro Gaming (8/16-bit)', 'tipo_midia' => 'Jogo', 'icone' => 'bi-joystick', 'descricao' => 'Cartuchos e CDs de consoles das gerações clássicas.', 'publico_alvo' => 'Retrogamers'],
            ['id' => 22, 'nome' => 'RPGs & Fantasia Medieval', 'tipo_midia' => 'Jogo', 'icone' => 'bi-dice-6', 'descricao' => 'Jogos de interpretação e fantasia.', 'publico_alvo' => 'Jovens'],
            ['id' => 23, 'nome' => 'Survival Horror Games', 'tipo_midia' => 'Jogo', 'icone' => 'bi-biohazard', 'descricao' => 'Jogos de sobrevivência e terror psicológico.', 'publico_alvo' => 'Adultos'],
            ['id' => 24, 'nome' => 'Plataforma & Ação', 'tipo_midia' => 'Jogo', 'icone' => 'bi-controller', 'descricao' => 'Jogos de plataforma e ação 2D/3D.', 'publico_alvo' => 'Infantojuvenil'],
            ['id' => 25, 'nome' => 'Esportes & Corrida', 'tipo_midia' => 'Jogo', 'icone' => 'bi-trophy', 'descricao' => 'Jogos de futebol, corrida, luta.', 'publico_alvo' => 'Geral'],
            ['id' => 26, 'nome' => 'Estratégia & Simulação', 'tipo_midia' => 'Jogo', 'icone' => 'bi-puzzle', 'descricao' => 'RTS, simulação de voo, tycoon.', 'publico_alvo' => 'Adultos'],
            ['id' => 27, 'nome' => 'Luta & Fighting Games', 'tipo_midia' => 'Jogo', 'icone' => 'bi-fist', 'descricao' => 'Jogos de luta clássicos.', 'publico_alvo' => 'Jovens'],
            ['id' => 28, 'nome' => 'FPS & Tiro', 'tipo_midia' => 'Jogo', 'icone' => 'bi-crosshair', 'descricao' => 'First-person shooters e rail shooters.', 'publico_alvo' => 'Adultos'],
            ['id' => 29, 'nome' => 'Puzzle & Party Games', 'tipo_midia' => 'Jogo', 'icone' => 'bi-grid', 'descricao' => 'Quebra-cabeças e jogos de festa.', 'publico_alvo' => 'Família'],
            ['id' => 30, 'nome' => 'Colecionáveis & Edições Limitadas', 'tipo_midia' => 'Jogo', 'icone' => 'bi-gem', 'descricao' => 'Edições raras, big boxes, steelbooks.', 'publico_alvo' => 'Colecionadores'],
        ];

        foreach ($categorias as $cat) {
            Category::updateOrCreate(['id' => $cat['id']], $cat);
        }
    }
}