<?php

namespace Database\Seeders;

use App\Models\Profession;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OtherServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            ['title' => 'Քիմմաքրում', 'price' => 5000],
            ['title' => 'Շարժիչի լվացում', 'price' => 5000],
            ['title' => 'Շարժական վուլկանացում', 'price' => 4000],
            ['title' => 'էլեկտրականության հետ կապված խնդիրների  ախտորոշում և վերացում', 'price' => 5000],
            ['title' => 'Ընթացակարգի վերանորոգում', 'price' => 5000],
            ['title' => 'Փոքր', 'price' => 2000],
            ['title' => 'Երկար թափք', 'price' => 3000],
            ['title' => 'Մեծ', 'price' => 6000],
            ['title' => 'Վիշկա', 'price' => 5000],
            ['title' => 'Կռան', 'price' => 35000],
            ['title' => 'Bobcat', 'price' => 13000],
            ['title' => 'Jeb', 'price' => 18000],
        ];

        foreach ($services as $service){
            $profession = Profession::query()->where('title', $service['title'])->first();
            $profession_id = 0;
            if($profession){
                $profession_id = $profession->id;
            }

            if(!$profession_id){
                if($service['title'] === 'Կռան' || $service['title'] === 'Bobcat' || $service['title'] === 'Jeb'){
                    $profession = Profession::query()->where('title', 'Շինարարական և ծանր տեխնիկա')->first();
                    $profession_id = $profession->id;
                }
            }

            if(!$profession_id){
                if($service['title'] === 'Փոքր' || $service['title'] === 'Երկար թափք' || $service['title'] === 'Մեծ'){
                    $profession = Profession::query()->where('title', 'Բեռնատարներ')->first();
                    $profession_id = $profession->id;
                }
            }

            Service::query()->create($service + ['profession_id' => $profession_id]);
        }
    }
}
