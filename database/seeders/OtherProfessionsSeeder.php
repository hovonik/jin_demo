<?php

namespace Database\Seeders;

use App\Models\Profession;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OtherProfessionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $professions = [
            ['title' => 'Քիմմաքրում', 'slug' => 'car_service'],
            ['title' => 'Շարժիչի լվացում', 'slug' => 'car_service'],
            ['title' => 'Շարժական վուլկանացում', 'slug' => 'car_service'],
            ['title' => 'էլեկտրականության հետ կապված խնդիրների  ախտորոշում և վերացում', 'slug' => 'car_service'],
            ['title' => 'Ընթացակարգի վերանորոգում', 'slug' => 'car_service'],
            ['title' => 'Ավտոքարշակի ծառայություն', 'slug' => 'car_service'],
            ['title' => 'Առաքում', 'slug' => 'shipment'],
            ['title' => 'Բեռնափոխադրում', 'slug' => 'shipment'],
            ['title' => 'Բեռնատարներ', 'slug' => 'commercial_transport'],
            ['title' => 'Վիշկա', 'slug' => 'commercial_transport'],
            ['title' => 'Շինարարական և ծանր տեխնիկա', 'slug' => 'commercial_transport'],
            ['title' => 'Այլ', 'slug' => 'commercial_transport'],
        ];

        foreach ($professions as $profession){
            Profession::query()->create($profession);
        }
    }
}
