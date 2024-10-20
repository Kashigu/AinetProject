<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Carbon\Carbon;


class OrdersSeeder extends Seeder
{
    private $numberOfDays = 1000;
    private $avgOrdersDay = [10, 5, 7, 9, 12, 6, 20]; // Domingo, Segunda, terça, ...
    private $qtys = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 3, 3, 3, 4, 4, 5, 6, 7, 8, 9, 10];
    private $num_tshirts = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 6, 6,  6,  6, 7, 7, 7, 8, 8, 9, 9, 10, 10, 11];
    private $status = ['closed', 'closed', 'closed', 'closed', 'closed', 'closed', 'closed', 'closed', 'closed', 'closed', 'closed', 'canceled'];
    private $sizes = ['XS', 'S', 'S', 'M', 'M', 'M', 'M', 'M', 'L', 'L', 'XL'];
    private $customers = [];
    private $customersComTshirtImagesProprias = [];
    private $tshirtImages_catalog = [];
    private $colors = [];

    public function run()
    {
        $faker = DatabaseSeeder::$language == 'pt' ? \Faker\Factory::create('pt_PT') : \Faker\Factory::create();

        $this->command->info("Orders");
        $this->criarPastaReceipts();
        $this->fillCustomers();
        $this->fillTshirtImages();
        $this->fillColors();
        $today = Carbon::today();
        $this->start_date = $today->copy();
        $this->start_date->subDays($this->numberOfDays);
        $d = $this->start_date->copy();
        $i = 0;
        $precoDelta = 3;
        while ($d->lessThanOrEqualTo($today)) {
            if ($i % 10 == 0) { /// 10 em 10 dias escreve no log e faz o shuffle dos customers
                $this->command->info("Orders para o dia " . $d->format('d-m-Y'));
                $this->shuffleCustomers();
            }
            if ($i % 100 == 0) { /// 100 em 100 dias negócio cresce (ou diminui)
                for ($j = 0; $j < count($this->avgOrdersDay); $j++) {
                    $fatorCrescimento = rand(-3, 5);
                    $this->avgOrdersDay[$j] += $this->avgOrdersDay[$j] * $fatorCrescimento / 100;
                }
            }

            if ($i % 300 == 0) { /// 300 em 300 dias preço cresce
                $precoDelta--;
            }

            $totalOrdersDay = intval($this->avgOrdersDay[$d->dayOfWeek] + $this->avgOrdersDay[$d->dayOfWeek] * rand(-100, 50) / 100);
            $totalOrdersDay = $totalOrdersDay < 0 ? 0 : $totalOrdersDay;
            $ordersDay = [];
            for ($num = 0; $num < $totalOrdersDay; $num++) {
                $ordersDay[] = $this->createOrderArray($faker, $d);
            }


            DB::table('orders')->insert($ordersDay);

            $ordersDoDia = DB::table('orders')->where('date', $d->format('Y-m-d'))->get();

            foreach ($ordersDoDia as $order) {
                $allTShirts = $this->createTShirtsOrders($faker, $order, $precoDelta);
                DB::table('order_items')->insert($allTShirts);
                //DB::update('update orders set total_price = ? where id = ?', [$total, $id]);
            }
            $i++;
            $d->addDays(1);
        }
        $this->command->info("Atualizar os preços totais das orders");
        DB::update('update orders set total_price = (select sum(sub_total) from order_items where order_items.order_id = orders.id)');

        $this->command->info("Todas as Orders foram criadas");
        $this->command->info("---- END ----");


        // // Para verificar possiveis erros de tshirtImages próprios usadas nas orders de outros,
        // // Usar o seguinte SQL - se devolver alguma linha, é porque algo está mal:
        // select distinct t.order_id, e.customer_id, t.tshirt_image_id, e.customer_id from order_items as t inner join tshirt_images as e on e.id = t.tshirt_image_id
        // inner join orders as enc on enc.id = t.order_id
        // where t.tshirt_image_id in (select id from tshirt_images where customer_id is not null)
        // AND (e.customer_id <> e.customer_id)
    }

    private function fillCustomers()
    {
        $this->customers = DB::table('customers')->select(DB::raw('id, nif, address, default_payment_type, default_payment_ref'))->get()->toArray();
        $this->customersComTshirtImagesProprias = DB::table('tshirt_images')->whereNotNull('customer_id')->select('customer_id')->distinct()->pluck('customer_id', 'customer_id')->toArray();
        foreach ($this->customersComTshirtImagesProprias as $customer_id => $valor) {
            $this->customersComTshirtImagesProprias[$customer_id] = [];
        }
    }

    private function fillTshirtImages()
    {
        $this->tshirtImages_catalog = DB::table('tshirt_images')->whereNull('customer_id')->select('id')->pluck('id')->toArray();
        $tshirtImage_customer = DB::table('tshirt_images')->whereNotNull('customer_id')->select('customer_id', 'id')->get()->toArray();
        foreach ($tshirtImage_customer as $tshirtImage) {
            $this->customersComTshirtImagesProprias[$tshirtImage->customer_id][] = $tshirtImage->id;
        }
    }

    private function fillColors()
    {
        $this->colors = DB::table('colors')->select('code')->pluck('code')->toArray();
    }

    private function shuffleCustomers()
    {
        $this->customers = Arr::shuffle($this->customers);
    }

    private function createOrderArray($faker, $date)
    {
        $customer = $faker->randomElement($this->customers);
        $inicio = $date->copy()->addSeconds(rand(39600, 78000));
        $fim = $inicio->copy()->addSeconds(rand(60, 300000));
        return [
            'status' => $faker->randomElement($this->status),
            'customer_id' => $customer->id,
            'date' => $date->format('Y-m-d'),
            'total_price' => 0,
            'notes' => rand(0, 20) == 1 ? $faker->realText(100) : null,
            'nif' => $customer->nif,
            'address' => $customer->address,
            'payment_type' => $customer->default_payment_type,
            'payment_ref' => $customer->default_payment_ref,
            'receipt_url' => null,
            'created_at' => $inicio,
            'updated_at' => $fim,
        ];
    }

    private function createTShirtsOrders($faker, $order, $precoDelta = 0)
    {
        $allItems = [];
        $precoDelta = $precoDelta < 0 ? 0 : $precoDelta;
        $totalItems = $faker->randomElement($this->qtys);
        $customer_id = $order->customer_id;
        $temProprio = array_key_exists($customer_id, $this->customersComTshirtImagesProprias);
        $tshirtImageProprias = $temProprio ? $this->customersComTshirtImagesProprias[$customer_id] : [];
        for ($i = 0; $i < $totalItems; $i++) {
            $usaPropria = $temProprio ? rand(1, 2) == 2 : false;
            $id_tshirtImage = $usaPropria ? $faker->randomElement($tshirtImageProprias) : $faker->randomElement($this->tshirtImages_catalog);
            $qty = $faker->randomElement($this->num_tshirts);
            $size = $faker->randomElement($this->sizes);
            $color = $faker->randomElement($this->colors);
            $unit_price = $usaPropria ? 15 : 10;
            if ($qty >= 5) {
                $unit_price = $usaPropria ? 12 : 8.5;
            }
            $unit_price -= $precoDelta;
            $subTotal = $qty * $unit_price;
            $allItems[] = [
                'order_id' => $order->id,
                'tshirt_image_id' => $id_tshirtImage,
                'color_code' => $color,
                'size' => $size,
                'qty' => $qty,
                'unit_price' => $unit_price,
                'sub_total' => $subTotal
            ];
        }
        return $allItems;
    }

    private function criarPastaReceipts()
    {
        Storage::deleteDirectory('pdf_receipts');
        Storage::makeDirectory('pdf_receipts');
    }
}
