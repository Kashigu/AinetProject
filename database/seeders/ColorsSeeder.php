<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ColorsSeeder extends Seeder
{
    public static $colors = [
        "00a2f2" => ["Azul marinho", "Navy blue"],
        "1e1e21" => ["Preto", "Black"],
        "201f30" => ["Azul escuro", "Dark blue"],
        "284d9d" => ["Azul", "Blue"],
        "4bd7ef" => ["Azul cyan", "Cyan"],
        "73336a" => ["Roxo", "Purple"],
        "ac283b" => ["Vermelho", "Red"],
        "bceb97" => ["Verde claro", "Light Green"],
        "cfdcd8" => ["", ""],
        "e7e0ee" => ["Branco sujo", "Off white"],
        "f0eff3" => ["Cinza clara", "Light gray"],
        "f9b014" => ["Amarelo torrado", "Roasted yellow"],
        "fcabd2" => ["Rosa clara", "Light pink"],
        "fd4083" => ["Rosa", "Pink"],
        "fef7db" => ["Amarelo esbatido", "Faded yellow"],
        "10534e" => ["Verde escuro", "Dark green"],
        "1fba8f" => ["Verde", "Green"],
        "282c48" => ["Azul escuro", "Dark blue"],
        "49302c" => ["Castanho", "Brown"],
        "684f2e" => ["", ""],
        "7f7277" => ["", ""],
        "b5c8eb" => ["Azul bebé", "Baby blue"],
        "c7c6cf" => ["Cinza", "Gray"],
        "dc192d" => ["Vermelho vivo", "Bright red"],
        "ecdb2e" => ["Amarelo", "Yellow"],
        "f3f46b" => ["Amarelo claro", "Light yellow"],
        "fafafa" => ["Branco", "White"],
        "fcfbff" => ["", ""],
        "fd890f" => ["Laranja", "Orange"],
        "ffd2c3" => ["Salmão", "Salmon"],
    ];

    private $tshirt_basePath = 'public/tshirt_base';

    public function run()
    {
        $this->command->info("Colors e TShirts de base");
        $faker = DatabaseSeeder::$language == 'pt' ? \Faker\Factory::create('pt_PT') : \Faker\Factory::create();

        $sourceFolder = database_path('seeders/tshirt_base');
        $targetFolder = storage_path('app/' . $this->tshirt_basePath);
        $this->limparFicheirosTShirtBase();
        foreach (ColorsSeeder::$colors as $code => $names) {
            $file = $sourceFolder . '/' . $code . '.jpg';
            File::copy($file, $targetFolder . '/' . $code . '.jpg');
            if (trim($names[0]) != "") {
                DB::table('colors')->insert([
                    'code' => $code,
                    'name' =>  DatabaseSeeder::$language == 'pt' ? $names[0] : $names[1]
                ]);
            }
        }
        $soft_deleted = ["4bd7ef", "f0eff3", "f9b014"];
        foreach ($soft_deleted as $code) {
            $deletedAt = $faker->dateTimeBetween('-2 years', '-3 months');
            DB::table('colors')
                ->where('code', $code)
                ->update(['deleted_at' => $deletedAt]);
        }
        $this->copia_tshirt_base_plain();
    }

    private function limparFicheirosTShirtBase()
    {
        Storage::deleteDirectory($this->tshirt_basePath);
        Storage::makeDirectory($this->tshirt_basePath);
    }

    private function copia_tshirt_base_plain()
    {
        $source = database_path('seeders/tshirt_base') . '/plain_white.png';
        $public_img_path = public_path('img');
        if (!File::isDirectory($public_img_path)) {
            File::makeDirectory($public_img_path);
        }
        File::copy($source, $public_img_path . '/plain_white.png');
        File::copy($source, storage_path('app/' . $this->tshirt_basePath) . '/plain_white.png');
    }
}
