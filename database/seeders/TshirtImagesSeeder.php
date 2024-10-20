<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;

class TshirtImagesSeeder extends Seeder
{
    private $imagens_tshirtImage_set1 = [
        ["filme", "set1/filme/pngwing11.png", "Lucky one", "O sortudo"],
        ["filme", "set1/filme/pngwing13.png", "Bad bones", "Ossos maus"],
        ["filme", "set1/filme/pngwing19.png", "Route 66", "Rota 66"],
        ["filme", "set1/filme/pngwing26.png", "El gato negro", "O gato preto"],
        ["filme", "set1/filme/pngwing34.png", "Lords of vengeance", "Senhores da vingança"],
        ["filme", "set1/filme/pngwing42.png", "Hulk", "Hulk"],
        ["filme", "set1/filme/pngwing60.png", "The last king", "O último rei"],
        ["filme", "set1/filme/pngwing70.png", "American choppers", "Choppers americanos"],
        ["filme", "set1/filme/pngwing74.png", "Night fever", "Febre da noite"],
        ["filme", "set1/filme/pngwing87.png", "Bad monkey", "Macaco mau"],
        ["filme", "set1/filme/pngwing89.png", "Superman", "Superhomem"],
        ["filme", "set1/filme/pngwing108.png", "Zombie", "Zombie"],
        ["filme", "set1/filme/pngwing128.png", "Superman 2", "Superhomem 2"],
        ["filme", "set1/filme/pngwing131.png", "My religion", "Minha Religião"],
        ["filme", "set1/filme/pngwing136.png", "Death from above", "Morte de cima"],
        ["filme", "set1/filme/pngwing140.png", "Incredible", "Incrivel"],
        ["filme", "set1/filme/pngwing150.png", "Saloon", "Salão"],
        ["abst", "set1/abst/pngwing9.png", "Cat with flowers", "Gato com flores"],
        ["abst", "set1/abst/pngwing21.png", "Death", "Morte"],
        ["abst", "set1/abst/pngwing25.png", "Blue woman", "Mulher azul"],
        ["abst", "set1/abst/pngwing29.png", "Colour cat", "Gato colorido"],
        ["abst", "set1/abst/pngwing48.png", "Colours", "Cores"],
        ["abst", "set1/abst/pngwing66.png", "Man on fire", "Homem em fogo"],
        ["abst", "set1/abst/pngwing73.png", "Heretic", "Herege"],
        ["abst", "set1/abst/pngwing100.png", "Brown trail", "Trilho castanho"],
        ["abst", "set1/abst/pngwing116.png", "Montains", "Montanhas"],
        ["abst", "set1/abst/pngwing117.png", "Rose woman", "Mulher rosa"],
        ["abst", "set1/abst/pngwing138.png", "Skull with one eye", "Crânio com um olho"],
        ["abst", "set1/abst/pngwing149.png", "Blue bird", "Passaro azul"],
        ["abst", "set1/abst/pngwing151.png", "Blue skulls", "Crânios azuis"],
        ["cool", "set1/cool/pngwing4.png", "That is cool", "Isso é cool"],
        ["cool", "set1/cool/pngwing6.png", "Woman with a rose", "Mulher com uma rosa"],
        ["cool", "set1/cool/pngwing22.png", "Go scoot", "Vai scoot"],
        ["cool", "set1/cool/pngwing76.png", "Ice skrull scratcher", "Skrull de gelo"],
        ["cool", "set1/cool/pngwing78.png", "Home run monkey", "Macaco home run"],
        ["fun", "set1/fun/pngwing54.png", "Wave I am comming", "Onda, estou a chegar"],
        ["fun", "set1/fun/pngwing55.png", "Funny gesture", "Gesto engraçado"],
        ["fun", "set1/fun/pngwing69.png", "Smoking man", "Homem fumador"],
        ["fun", "set1/fun/pngwing72.png", "Scoot 66", "Scoot 66"],
        ["fun", "set1/fun/pngwing81.png", "Burn the road", "Queima a estrada"],
        ["fun", "set1/fun/pngwing98.png", "Schedule for murder", "Programado para matar"],
        ["fun", "set1/fun/pngwing101.png", "Funny tongue", "Lingua engraçada"],
        ["fun", "set1/fun/pngwing106.png", "Bone to rock", "Osso para a rocha"],
        ["fun", "set1/fun/pngwing113.png", "Throw dice", "Jogar dados"],
        ["fun", "set1/fun/pngwing114.png", "Funny skate", "Skate engraçado"],
        ["fun", "set1/fun/pngwing115.png", "Stand", "Stand"],
        ["insp", "set1/insp/pngwing15.png", "Rider", "Rider"],
        ["insp", "set1/insp/pngwing17.png", "Blue rider", "Rider azul"],
        ["insp", "set1/insp/pngwing31.png", "Ride or die", "Montar ou morrer"],
        ["insp", "set1/insp/pngwing77.png", "Enjoy the ride", "Aproveita o passeio"],
        ["insp", "set1/insp/pngwing80.png", "Live fast", "Vive rápido"],
        ["insp", "set1/insp/pngwing84.png", "Birds in love", "Pássaros apaixonados"],
        ["insp", "set1/insp/pngwing103.png", "Christ", "Cristo"],
        ["insp", "set1/insp/pngwing148.png", "Pink life", "Vida rosa"],
        ["memes", "set1/memes/pngwing3.png", "I love to ride", "Eu amo montar"],
        ["memes", "set1/memes/pngwing14.png", "Toxic summer", "Verão tóxico"],
        ["memes", "set1/memes/pngwing20.png", "Catch you", "Apanho-te"],
        ["memes", "set1/memes/pngwing47.png", "Fear this", "Tem medo disto"],
        ["memes", "set1/memes/pngwing83.png", "My gun is much bigger than yours", "Minha arma é muito maior que a tua"],
        ["memes", "set1/memes/pngwing130.png", "We can do it", "Nós conseguimos"],
        ["memes", "set1/memes/pngwing156.png", "Quiet", "Silêncio"],
        ["music", "set1/music/pngwing24.png", "Sounds", "Sons"],
        ["music", "set1/music/pngwing32.png", "Guitar", "Guitarra"],
        ["music", "set1/music/pngwing33.png", "Clefs", "Claves"],
        ["music", "set1/music/pngwing39.png", "Cool DJ", "DJ porreiro"],
        ["music", "set1/music/pngwing41.png", "Rock and roll", "Rock and roll"],
        ["music", "set1/music/pngwing50.png", "Music sheet", "Pauta musical"],
        ["music", "set1/music/pngwing53.png", "Rock Accident", "Acidente de rock"],
        ["music", "set1/music/pngwing59.png", "Flower clef", ""],
        ["music", "set1/music/pngwing65.png", "Snake guitar", "Guitarra de cobra"],
        ["music", "set1/music/pngwing68.png", "Rainbow of clefs", "Arco-íris de claves"],
        ["music", "set1/music/pngwing92.png", "Party sounds", "Sons de festa"],
        ["music", "set1/music/pngwing96.png", "Touch to play", "Toca para jogar"],
        ["music", "set1/music/pngwing99.png", "Sing with the colours", "Canta com as cores"],
        ["music", "set1/music/pngwing107.png", "Grab the microphone", "Agarra o microfone"],
        ["music", "set1/music/pngwing110.png", "Headphones", "Headphones"],
        ["music", "set1/music/pngwing133.png", "Piano and clef", "Piano e clave"],
        ["music", "set1/music/pngwing139.png", "Music is cool", "Música é porreira"],
        ["music", "set1/music/pngwing145.png", "It is a boy", "É um rapaz"],
        ["music", "set1/music/pngwing154.png", "Guitar sounds", "Sons da guitarra"],
        ["nosense", "set1/nosense/pngwing10.png", "Lucky dead", "Morto sortudo"],
        ["nosense", "set1/nosense/pngwing16.png", "Hooligan", "Vândalo"],
        ["nosense", "set1/nosense/pngwing36.png", "Militar style", "Estilo militar"],
        ["nosense", "set1/nosense/pngwing43.png", "Guns", "Armas"],
        ["nosense", "set1/nosense/pngwing45.png", "Anarchy", "Anarquia"],
        ["nosense", "set1/nosense/pngwing58.png", "Skull in nature", "Crânio na natureza"],
        ["nosense", "set1/nosense/pngwing67.png", "Osiris", "Osiris"],
        ["nosense", "set1/nosense/pngwing75.png", "Catch the skull", "Apanha o crânio"],
        ["nosense", "set1/nosense/pngwing79.png", "Nightmare", "Pesadelo"],
        ["nosense", "set1/nosense/pngwing90.png", "Muerte", "Morte"],
        ["nosense", "set1/nosense/pngwing95.png", "Heretic", "Herege"],
        ["nosense", "set1/nosense/pngwing122.png", "La muerte", "A morte"],
        ["nosense", "set1/nosense/pngwing135.png", "The police", "A polícia"],
        ["null", "set1/null/pngwing1.png", "Woman with pink flowers", "Mulher com flores cor de rosa"],
        ["null", "set1/null/pngwing8.png", "Red dragon", "Dragão vermelho"],
        ["null", "set1/null/pngwing18.png", "Hand with crucifix", "Mão com crucifixo"],
        ["null", "set1/null/pngwing30.png", "Fenix", "Fenix"],
        ["null", "set1/null/pngwing35.png", "Chinese snake", "Cobra chinesa"],
        ["null", "set1/null/pngwing38.png", "Eighties", "Oitentas"],
        ["null", "set1/null/pngwing40.png", "Family", "Família"],
        ["null", "set1/null/pngwing44.png", "Yellow sun", "Sol amarelo"],
        ["null", "set1/null/pngwing49.png", "Love my family", "Amo a minha família"],
        ["null", "set1/null/pngwing52.png", "Boom cloud", "Núvem explosiva"],
        ["null", "set1/null/pngwing56.png", "Anchor", "Âncora"],
        ["null", "set1/null/pngwing57.png", "Butterflies", "Borboletas"],
        ["null", "set1/null/pngwing61.png", "Burning skull", "Crânio em fogo"],
        ["null", "set1/null/pngwing64.png", "Hindu god", "Deus hindu"],
        ["null", "set1/null/pngwing71.png", "Football", "Futebol"],
        ["null", "set1/null/pngwing88.png", "Astronaut", "Astronauta"],
        ["null", "set1/null/pngwing104.png", "Cool cat", "Gato fixe"],
        ["null", "set1/null/pngwing109.png", "Skull with red roses", "Crânio com rosas vermelhas"],
        ["null", "set1/null/pngwing118.png", "Red car", "Carro vermelho"],
        ["null", "set1/null/pngwing126.png", "Pink moose", "Alce rosa"],
        ["null", "set1/null/pngwing129.png", "Dark flowers", "Flores escuras"],
        ["null", "set1/null/pngwing132.png", "Children playing football", "Crianças a jogar futebol"],
        ["null", "set1/null/pngwing134.png", "Wolf", "Lobo"],
        ["null", "set1/null/pngwing143.png", "Lion", "Leão"],
        ["null", "set1/null/pngwing146.png", "Woman in a bike", "Mulher numa bicicleta"],
        ["null", "set1/null/pngwing153.png", "The king lion", "O rei leão"],
        ["places", "set1/places/pngwing37.png", "Salut Paris", "Salut Paris"],
        ["places", "set1/places/pngwing62.png", "I love dance in Paris", "Eu amo dançar em Paris"],
        ["places", "set1/places/pngwing82.png", "Cuba libre", "Cuba livre"],
        ["places", "set1/places/pngwing86.png", "California", "California"],
        ["places", "set1/places/pngwing94.png", "Purple liberty", "Liberdade roxa"],
        ["places", "set1/places/pngwing120.png", "Postcard", "Cartão postal"],
        ["places", "set1/places/pngwing152.png", "People in Paris", "Pessoa em Paris"],
        ["plain", "set1/plain/pngwing23.png", "Happy birthday to you", "Parabêns a você"],
        ["plain", "set1/plain/pngwing27.png", "Colour Happy birthday", "Parabêns coloridos"],
        ["plain", "set1/plain/pngwing28.png", "Red Happy Birthday", "Parabêns vermelhos"],
        ["plain", "set1/plain/pngwing46.png", "I love you", "Eu amo-te"],
        ["plain", "set1/plain/pngwing51.png", "Boom", "Explosão"],
        ["plain", "set1/plain/pngwing63.png", "Happy Halloween", "Feliz Halloween"],
        ["plain", "set1/plain/pngwing91.png", "Best Friends", "Melhores amigos"],
        ["plain", "set1/plain/pngwing93.png", "Merry Christmas", "Feliz natal"],
        ["plain", "set1/plain/pngwing97.png", "Happy Halloween", "Feliz Halloween"],
        ["plain", "set1/plain/pngwing111.png", "OMG", "Ó meu deus"],
        ["plain", "set1/plain/pngwing112.png", "Happy New Year", "Feliz ano novo"],
        ["plain", "set1/plain/pngwing121.png", "Hello Summer", "Feliz verão"],
        ["plain", "set1/plain/pngwing123.png", "Happy new year", "Feliz ano novo"],
        ["plain", "set1/plain/pngwing127.png", "Happy birthday with balloons", "Parabêns com balões"],
        ["plain", "set1/plain/pngwing137.png", "Boom", "Explosão"],
        ["plain", "set1/plain/pngwing144.png", "Funny happy birthday", "Parabêns engraçados"],
        ["pub", "set1/pub/pngwing2.png", "Freestyler", "Freestyler"],
        ["pub", "set1/pub/pngwing5.png", "Vintage classic car", "Carro clássico vintage"],
        ["pub", "set1/pub/pngwing7.png", "Speedway grade", "Speedway grade"],
        ["pub", "set1/pub/pngwing12.png", "Vintage motorcycle", "Moto vintage"],
        ["pub", "set1/pub/pngwing105.png", "Dark shoe", "Sapato escuro"],
        ["pub", "set1/pub/pngwing119.png", "Gazette Sport", "Gazette Sport"],
        ["pub", "set1/pub/pngwing124.png", "Right Rider", "Right Rider"],
        ["pub", "set1/pub/pngwing125.png", "Super truck", "Super camião"],
        ["pub", "set1/pub/pngwing141.png", "Car show", "Car show"],
        ["pub", "set1/pub/pngwing142.png", "Nike", "Mike"],
        ["pub", "set1/pub/pngwing147.png", "My shoe", "Meus sapatos"],
        ["pub", "set1/pub/pngwing155.png", "River city Tigers", "River city Tigers"],
    ];

    private $tshirtImagePublicPath = 'public/tshirt_images';
    private $tshirtImageCustomersPath = 'tshirt_images_private';

    public function run()
    {
        $this->command->info("TshirtImages do Catálogo");
        $faker = DatabaseSeeder::$language == 'pt' ? \Faker\Factory::create('pt_PT') : \Faker\Factory::create();
        $this->limparFicheirosTshirtImages();
        foreach ($this->imagens_tshirtImage_set1 as $info_tshirtImage) {
            $new_tshirtImage = $this->newTshirtImage($faker, $info_tshirtImage[0], $info_tshirtImage[1], DatabaseSeeder::$language == 'pt' ? $info_tshirtImage[3] : $info_tshirtImage[2]);
            DB::table('tshirt_images')->insert($new_tshirtImage);
        }
        $imagens_tshirtImage_set2 = $this->buildSet2();
        foreach ($imagens_tshirtImage_set2 as $info_tshirtImage) {
            $new_tshirtImage = $this->newTshirtImage($faker, $info_tshirtImage[0], $info_tshirtImage[1], $info_tshirtImage[2]);
            DB::table('tshirt_images')->insert($new_tshirtImage);
        }

        // A partir daqui, vamos tratar dos tshirtImages próprios:
        $this->command->info("TshirtImages Próprias");

        $IDsCustomers = $this->getCustomerIDsWithProprias();
        $imagens_tshirtImages_own = $this->buildSetProprias();
        foreach ($imagens_tshirtImages_own as $info_tshirtImage) {
            $idCustomer = $faker->randomElement($IDsCustomers);
            $new_tshirtImage = $this->newTshirtImage($faker, $info_tshirtImage[0], $info_tshirtImage[1], $info_tshirtImage[2], $idCustomer);
            DB::table('tshirt_images')->insert($new_tshirtImage);
        }

        // A partir daqui, vamos copiar as imagens dos tshirtImages e limpar categories
        $this->command->info("Copiar imagens dos tshirtImages");

        $imagens_tshirtImage = DB::table('tshirt_images')->get();
        foreach ($imagens_tshirtImage as $tshirtImage) {
            $this->saveTshirtImage($tshirtImage->id, $tshirtImage->image_url, !$tshirtImage->customer_id);
        }

        $this->tshirtImageSoftDeleted();
        $this->softDeleteCategoriesNaoUsadas($faker);
    }

    private function newTshirtImage($faker, $abrCategory, $file, $name, $customer_id = null)
    {
        $createdAt = $faker->dateTimeBetween('-3 years', '-3 months');
        $email_verified_at = $faker->dateTimeBetween($createdAt, '-2 months');
        $updatedAt = $faker->dateTimeBetween($email_verified_at, '-1 months');
        $deletedAt = $faker->dateTimeBetween($updatedAt);
        $abrCategory = $abrCategory ?? "null";
        $category = $abrCategory == "null" ? null : CategoriesSeeder::$categories[$abrCategory];
        return [
            'customer_id' => $customer_id,
            'category_id' => $category,
            'name' => $name,
            'description' => $faker->realText(100),
            'image_url' => $file,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
            'deleted_at' => $deletedAt,
        ];
    }

    private function saveTshirtImage($id, $file, $publico = true)
    {
        $fileName = $publico ? database_path('seeders/tshirtImages_catalog') : database_path('seeders/tshirtImages_own');
        $fileName .= '/' . $file;
        $targetDir = $publico ? storage_path('app/' . $this->tshirtImagePublicPath) : storage_path('app/' . $this->tshirtImageCustomersPath);
        $newfilename = $id . "_" . uniqid() . '.png';
        File::copy($fileName, $targetDir . '/' . $newfilename);
        DB::table('tshirt_images')->where('id', $id)->update(['image_url' => $newfilename]);
        $this->command->info("Atualizada image da tshirtImage $id. Name do ficheiro copiado = $newfilename");
    }

    private function limparFicheirosTshirtImages()
    {
        Storage::deleteDirectory($this->tshirtImagePublicPath);
        Storage::makeDirectory($this->tshirtImagePublicPath);
        Storage::deleteDirectory($this->tshirtImageCustomersPath);
        Storage::makeDirectory($this->tshirtImageCustomersPath);
    }

    private function softDeleteCategoriesNaoUsadas($faker)
    {
        $ids_nao_usados = DB::select("select id from categories
                                        WHERE NOT EXISTS (select distinct category_id from tshirt_images
                                        where tshirt_images.category_id = categories.id)");
        $ids_nao_usados = Arr::pluck($ids_nao_usados, 'id');
        $ids_nao_usados = Arr::shuffle($ids_nao_usados);
        $remove = intdiv(count($ids_nao_usados), 3);
        while ($remove) {
            array_shift($ids_nao_usados);
            $remove--;
        }
        foreach ($ids_nao_usados as $id) {
            $deletedAt = $faker->dateTimeBetween('-2 years', '-3 months');
            DB::table('categories')
                ->where('id', $id)
                ->update(['deleted_at' => $deletedAt]);
        }
    }

    private function buildSet2()
    {
        $path = database_path('seeders/tshirtImages_catalog') . '/set2';
        $categories = array_map('basename', File::directories($path));

        $tshirtImages = [];
        foreach ($categories as $category) {
            $path = database_path('seeders/tshirtImages_catalog') . '/set2/' . $category . '/';
            $files = File::files($path);
            foreach ($files as $file) {
                $tshirtImages[] = [
                    $category,
                    "set2/" . $category . "/" . $file->getFilename(),
                    $this->getNameFromFilename($file->getFilename())
                ];
            }
        }
        return $tshirtImages;
    }

    private function getNameFromFilename($filename)
    {
        $strName = str_replace(".png", "", $filename);
        $strName = str_replace("_", " ", $strName);
        $strName = str_replace("-", " ", $strName);
        return ucfirst($strName);
    }

    private function buildSetProprias()
    {
        $path = database_path('seeders/tshirtImages_own');
        $tshirtImages = [];
        $files = File::files($path);
        foreach ($files as $file) {
            $filename = $file->getFilename();
            $tshirtImages[] = [
                "null",
                $filename,
                $this->getNameFromFilename($filename)
            ];
        }
        return $tshirtImages;
    }

    private function getCustomerIDsWithProprias()
    {
        $arr = DB::table('customers')->pluck('id')->toArray();
        $arr = Arr::shuffle($arr);
        $total = intdiv(count($arr), 2);
        return array_slice($arr, 0, $total < 50 ? $total : 50);
    }

    private function tshirtImageSoftDeleted()
    {
        $idsToDelete = DB::table('tshirt_images')->pluck('id')->toArray();
        $idsToDelete = Arr::shuffle($idsToDelete);
        $total = intdiv(count($idsToDelete), 10);
        $idsToDelete = array_slice($idsToDelete, 0, $total < 20 ? $total : 20);
        if (count($idsToDelete) > 0) {
            $this->command->info("Soft Delete " . count($idsToDelete) . " tshirtImage na base de dados");
            DB::table('tshirt_images')->whereNotIn('id', $idsToDelete)->update(['deleted_at' => null]);
        }
    }
}
