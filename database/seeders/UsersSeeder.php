<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    private $photoPath = 'public/photos';

    private $typesOfUsers =  ['A', 'E', 'C'];
    private $numberOfUsers = [6, 15, 500];
    private $numberOfSoftDeletedUsers = [1, 3, 45];
    private $numberOfBlocked = [1, 3, 30];
    private $files_M = [];
    private $files_F = [];
    private $used_emails = [];
    private $generos = [];

    public static $allUsers = [];
    public static $allCustomers = [];


    public function run()
    {
        $this->command->table(['Users table seeder notice'], [
            ['As photos serão armazenadas na path ' . storage_path('app/' . $this->photoPath)]
        ]);

        $this->limparFicheirosPhotos();
        $this->preencherNamesFicheirosPhotos();

        $faker = DatabaseSeeder::$language == 'pt' ? \Faker\Factory::create('pt_PT') : \Faker\Factory::create();


        $variosUsers = [];
        $totalGuardados = 0;
        $totalParaGuardar = 0;
        foreach ($this->typesOfUsers as $idxUserType => $user_typeUser) {
            $totalParaGuardar += $this->numberOfUsers[$idxUserType];
        }
        foreach ($this->typesOfUsers as $idxUserType => $user_typeUser) {
            $totalUsers = $this->numberOfUsers[$idxUserType];
            for ($i = 0; $i < $totalUsers; $i++) {
                $newUser = $this->newFakerUser($faker, $user_typeUser);
                $variosUsers[] = $newUser;
                if (count($variosUsers) >= 50) {
                    $totalGuardados += count($variosUsers);
                    $this->command->info("Guardados $totalGuardados/$totalParaGuardar users na base de dados");
                    DB::table('users')->insert($variosUsers);
                    $variosUsers = [];
                }
            }
        }
        if (count($variosUsers) > 0) {
            $totalGuardados += count($variosUsers);
            $this->command->info("Guardados $totalGuardados/$totalParaGuardar users na base de dados");
            DB::table('users')->insert($variosUsers);
        }
        UsersSeeder::$allUsers['A'] = DB::table('users')->where('user_type', 'A')->pluck('email', 'id');
        UsersSeeder::$allUsers['E'] = DB::table('users')->where('user_type', 'E')->pluck('email', 'id');
        UsersSeeder::$allUsers['C'] = DB::table('users')->where('user_type', 'C')->pluck('email', 'id');

        $this->fillGenders(UsersSeeder::$allUsers['A']);
        $this->fillGenders(UsersSeeder::$allUsers['E']);
        $this->fillGenders(UsersSeeder::$allUsers['C']);

        shuffle($this->files_M);
        shuffle($this->files_F);

        UsersSeeder::$allUsers['A'] = UsersSeeder::$allUsers['A']->shuffle();
        UsersSeeder::$allUsers['E'] = UsersSeeder::$allUsers['E']->shuffle();
        UsersSeeder::$allUsers['C'] = UsersSeeder::$allUsers['C']->shuffle();

        $this->copiarPhotos(UsersSeeder::$allUsers['A']);
        $this->copiarPhotos(UsersSeeder::$allUsers['E']);
        $this->copiarPhotos(UsersSeeder::$allUsers['C']);

        $idsToBlock = [];
        $idsToDelete = [];
        foreach ($this->typesOfUsers as $idxUserType => $user_typeUser) {
            $usersToBlock = $this->numberOfBlocked[$idxUserType];
            $usersToDelete = $this->numberOfSoftDeletedUsers[$idxUserType];
            foreach (UsersSeeder::$allUsers[$user_typeUser] as $user) {
                if ($usersToBlock > 0) {
                    $idsToBlock[] = $user['id'];
                    $usersToBlock--;
                } elseif (($usersToBlock == 0) && ($usersToDelete > 0)) {
                    $idsToDelete[] = $user['id'];
                    $usersToDelete--;
                }
                if (($usersToBlock == 0) && ($usersToDelete == 0)) {
                    continue;
                }
            }
        }

        if (count($idsToBlock) > 0) {
            $this->command->info("Bloquear " . count($idsToBlock) . " users na base de dados");
            DB::table('users')->whereIn('id', $idsToBlock)->update(['blocked' => 1]);
        }
        if (count($idsToDelete) > 0) {
            $this->command->info("Soft Delete " . count($idsToDelete) . " users na base de dados");
            DB::table('users')->whereNotIn('id', $idsToDelete)->update(['deleted_at' => null]);
        }


        UsersSeeder::$allCustomers = DB::table('users')->where('user_type', 'C')->pluck('id');

        $totalGuardados = 0;
        $totalParaGuardar = UsersSeeder::$allCustomers->count();
        $array_customers = [];
        foreach (UsersSeeder::$allCustomers as $id_customer) {
            $array_customers[] = $this->newFakerCustomer($faker, $id_customer);
            if (count($array_customers) >= 50) {
                $totalGuardados += count($array_customers);
                $this->command->info("Guardados $totalGuardados/$totalParaGuardar customers na base de dados");
                DB::table('customers')->insert($array_customers);
                $array_customers = [];
            }
        }
        if (count($array_customers) > 0) {
            $totalGuardados += count($array_customers);
            $this->command->info("Guardados $totalGuardados/$totalParaGuardar customers na base de dados");
            DB::table('users')->insert($array_customers);
        }

        $this->command->info("Atualizar timestamps dos customers");
        DB::update("update customers as c inner join (
                        select id, created_at, updated_at, deleted_at
                        from users
                        ) as u on c.id = u.id
                    set c.created_at = u.created_at, c.updated_at = u.updated_at, c.deleted_at = u.deleted_at");

        $this->command->info("Atualizar referencias de pagamento do Paypal");
        DB::update("update customers as c
                    inner join (
                        select id, email
                        from users
                        ) as u on c.id = u.id
                    set c.default_payment_ref = u.email
                    where c.default_payment_type = 'PAYPAL'");
    }

    private function fillGenders($users_array)
    {
        foreach ($users_array as $key => $value) {
            $users_array[$key] = [
                "id" => $key,
                "email" => $value,
                "genero" => $this->generos[$value]
            ];
        }
    }

    private function limparFicheirosPhotos()
    {
        Storage::deleteDirectory($this->photoPath);
        Storage::makeDirectory($this->photoPath);
    }

    private function preencherNamesFicheirosPhotos()
    {
        // LARAVEL 7:
        // $allFiles = collect(File::files(database_path('seeds/photos')));
        // LARAVEL 8:
        $allFiles = collect(File::files(database_path('seeders/photos')));
        foreach ($allFiles as $f) {
            if (strpos($f->getPathname(), 'M_')) {
                $this->files_M[] = $f->getPathname();
            } else {
                $this->files_F[] = $f->getPathname();
            }
        }
    }

    private function copiarPhotos($arrayUsers)
    {
        foreach ($arrayUsers as $user) {
            if ((count($this->files_M) == 0) && (count($this->files_F) == 0)) {
                break;
            }
            $file = $user['genero'] == 'M' ? array_shift($this->files_M) : array_shift($this->files_F);
            if ($file) {
                $this->savePhotoOfUser($user['id'], $file);
            }
        }
    }

    private function savePhotoOfUser($id, $file)
    {
        $targetDir = storage_path('app/' . $this->photoPath);
        $newfilename = $id . "_" . uniqid() . '.jpg';
        File::copy($file, $targetDir . '/' . $newfilename);
        DB::table('users')->where('id', $id)->update(['photo_url' => $newfilename]);
        $this->command->info("Atualizada photo do user $id. Name do ficheiro copiado = $newfilename");
    }

    private function stripAccents($stripAccents)
    {
        $from = 'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ';
        $to =   'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY';
        $keys = array();
        $values = array();
        preg_match_all('/./u', $from, $keys);
        preg_match_all('/./u', $to, $values);
        $mapping = array_combine($keys[0], $values[0]);
        return strtr($stripAccents, $mapping);
    }

    private function strtr_utf8($str, $from, $to)
    {
        $keys = array();
        $values = array();
        preg_match_all('/./u', $from, $keys);
        preg_match_all('/./u', $to, $values);
        $mapping = array_combine($keys[0], $values[0]);
        return strtr($str, $mapping);
    }
    private function randomName($faker, &$gender, &$fullname, &$email)
    {
        $gender = $faker->randomElement(['male', 'female']);
        $firstname = $faker->firstName($gender);
        $lastname = $faker->lastName();
        $secondname = $faker->numberBetween(1, 3) == 2 ? "" : " " . $faker->firstName($gender);
        $number_middlenames = $faker->numberBetween(1, 6);
        $number_middlenames = $number_middlenames == 1 ? 0 : ($number_middlenames >= 5 ? $number_middlenames - 3 : 1);
        $middlenames = "";
        for ($i = 0; $i < $number_middlenames; $i++) {
            $middlenames .= " " . $faker->lastName();
        }
        $mailSufix = DatabaseSeeder::$language == 'pt' ? "@mail.pt" : "@mail.com";
        $fullname = $firstname . $secondname . $middlenames . " " . $lastname;
        $email = strtolower($this->stripAccents($firstname) . "." . $this->stripAccents($lastname) . $mailSufix);
        $i = 2;
        while (in_array($email, $this->used_emails)) {
            $email = strtolower($this->stripAccents($firstname) . "." . $this->stripAccents($lastname) . "." . $i . $mailSufix);
            $i++;
        }
        $this->used_emails[] = $email;
        $gender = $gender == 'male' ? 'M' : 'F';
    }

    private function newFakerUser($faker, $user_type)
    {
        $fullname = "";
        $email = "";
        $gender = "";
        $this->randomName($faker, $gender, $fullname, $email);
        $createdAt = $faker->dateTimeBetween('-10 years', '-3 months');
        $email_verified_at = $faker->dateTimeBetween($createdAt, '-2 months');
        $updatedAt = $faker->dateTimeBetween($email_verified_at, '-1 months');
        $deletedAt = $faker->dateTimeBetween($updatedAt);
        $this->generos[$email] = $gender;
        return [
            'name' => $fullname,
            'email' => $email,
            'email_verified_at' => $email_verified_at,
            'password' => bcrypt('123'),
            'remember_token' => Str::random(10),
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
            'user_type' => $user_type,
            'blocked' => 0,
            'deleted_at' => $deletedAt,
        ];
    }


    private function newFakerCustomer($faker, $id)
    {
        return [
            'id' => $id,
            'nif' => $faker->randomNumber($nbDigits = 9, $strict = true),
            'address' => $faker->address,
            'default_payment_type' => $faker->randomElement(['VISA', 'MC', 'PAYPAL']),
            'default_payment_ref' => $faker->randomNumber($nbDigits = 8, $strict = true) . $faker->randomNumber($nbDigits = 8, $strict = true),
            'created_at' => null,
            'updated_at' => null,
            'deleted_at' => null
        ];
    }
}
