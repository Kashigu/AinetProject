<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public static $language = 'pt';

    public function run(): void
    {
        $this->command->info("-----------------------------------------------");
        $this->command->info("START of database seeder");
        $this->command->info("-----------------------------------------------");

        $resposta = $this->command->choice('Deseja simular dados de uma loja Portuguesa (português) ou Internacional (inglês)?', ['Portuguesa', 'Internacional'], 0);

        DatabaseSeeder::$language = $resposta == 'Portuguesa' ? 'pt' : 'eng';

        DB::statement("SET foreign_key_checks=0");

        DB::table('users')->delete();
        DB::table('customers')->delete();
        DB::table('tshirt_images')->delete();
        DB::table('colors')->delete();
        DB::table('categories')->delete();
        DB::table('prices')->delete();
        DB::table('orders')->delete();
        DB::table('order_items')->delete();

        DB::statement('ALTER TABLE users AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE tshirt_images AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE categories AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE prices AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE orders AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE order_items AUTO_INCREMENT = 0');

        DB::statement("SET foreign_key_checks=1");


        $this->call(PricesSeeder::class);
        $this->call(ColorsSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(TshirtImagesSeeder::class);
        $this->call(OrdersSeeder::class);

        $this->command->info("-----------------------------------------------");
        $this->command->info("END of database seeder");
        $this->command->info("-----------------------------------------------");
    }
}
