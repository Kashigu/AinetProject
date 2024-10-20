<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PricesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("Configuracação de preços");
        DB::table('prices')->insert([
            "unit_price_catalog" => 10,
            "unit_price_own" => 15,
            "unit_price_catalog_discount" => 8.5,
            "unit_price_own_discount" => 12,
            "qty_discount" => 5,
        ]);
    }
}
