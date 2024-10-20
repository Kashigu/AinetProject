<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CategoriesSeeder extends Seeder
{
    // Categories - usar esta tabela para associar aos seeds dos tshirtImages
    public static $categories = [
        "fun" => ["Engraçado", "Funny"],
        "geek" => ["Geeks", "Geeks"],
        "memes" => ["Memes", "Memes"],
        "insp" => ["Inspiração", "Inspiration"],
        "plain" => ["Simples", "Plain"],
        "filme" => ["Filmes", "Movies"],
        "music" => ["Musica", "Music"],
        "places" => ["Locais", "Places"],
        "logo" => ["Logotipos", "Logos"],
        "pub" => ["Publicidade e marcas", "Advertising and brands"],
        "abst" => ["Desenhos Abstratos", "Abstract Drawings"],
        "drinks" => ["Bebidas", "Drinks"],
        "nosense" => ["Sem Sentido", "Meaningless"],
        "infantil" => ["Infantil", "Childish"],
        "sports" => ["Desporto", "Sports"],
        "summer" => ["Verão", "Summer"],
        "surf" => ["Surf", "Surf"],
        "tattoo" => ["Tattoo", "Tattoo"],
        "vintage" => ["Vintage", "Vintage"],
        "cool" => ["Cool", "Cool"],
        "words" => ["Frases", "Phrases"]
        //"null" => "Sem category definida"
    ];

    public function run()
    {
        $this->command->info("Categories de tshirtImages");
        foreach (CategoriesSeeder::$categories as $key => $value) {
            $id = DB::table('categories')->insertGetId(['name' => DatabaseSeeder::$language == 'pt' ? $value[0] : $value[1]]);
            CategoriesSeeder::$categories[$key] = $id;
        }
    }
}
