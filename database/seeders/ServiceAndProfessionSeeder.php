<?php

namespace Database\Seeders;

use App\Models\Profession;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceAndProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profession::query()->create(['title' => "Առաքիչ"]);
        $services = [
                [
                    'parent' => 'Լոգասենյակ և խոհանոց',
                    'children' => [
                        [
                            'name' => 'Տեղադրում',
                            'services' => [
                                [
                                    'title' => 'Զուքարանակոնքերի տեղադրում',
                                    'price' => 8000
                                ],
                                [
                                    'title' => 'Ցնցուղի Տեղադրում',
                                    'price' => 6000
                                ],
                                [
                                    'title' => 'Ծորակի տեղադրում',
                                    'price' => 4500
                                ],
                                [
                                    'title' => 'Սենսորաին ծորակի տեղադրում',
                                    'price' => 1200
                                ],
                                [
                                    'title' => 'Պահարանի տեղադրում',
                                    'price' => 5000
                                ],
                                [
                                    'title' => 'Պահարանով և հայլիով լվացարանի տեղադրում',
                                    'price' => 13000
                                ],
                                [
                                    'title' => 'Փոքր հայլու տեղադրում',
                                    'price' => 3500
                                ],
                                [
                                    'title' => 'Մեծ հայլու տեղադրում',
                                    'price' => 4500
                                ],
                                [
                                    'title' => 'Հիդրոխցիկի տեղադրում',
                                    'price' => 20000
                                ],
                                [
                                    'title' => 'Հիդրոկանգնակի տեղադրում',
                                    'price' => 13000
                                ],
                                [
                                    'title' => 'Հիդրովանաի տեղադրում',
                                    'price' => 20000
                                ],
                                [
                                    'title' => 'Լվացարանի տեղադրում',
                                    'price' => 8000
                                ],
                                [
                                    'title' => 'Լվացքի մեքենաի տեղադրում',
                                    'price' => 5000
                                ],
                                [
                                    'title' => 'Վանաի տեղադրում',
                                    'price' => 9000
                                ],
                                [
                                    'title' => 'Տակդիրիր տեղադրում',
                                    'price' => 8000
                                ],
                                [
                                    'title' => 'Լոգասենյակի Էլ,սարքերի տեղադրում',
                                    'price' => 8000
                                ],
                                [
                                    'title' => 'Պատի մեջ տեղադրող ջրամանով զուգարանակոնքի տեղադրում',
                                    'price' => 30000
                                ],
                                [
                                    'title' => 'Կոյուղու մոնտաժ',
                                    'price' => 5500
                                ],
                                [
                                    'title' => 'Լոգաղցիկի տեղադրում',
                                    'price' => 10000
                                ],
                                [
                                    'title' => 'Օդափոխիչի տեղադրում',
                                    'price' => 4000
                                ],
                                [
                                    'title' => 'Լոգաղցիկի ապակե դռների և միջնապատերի տեղադրում',
                                    'price' => 16000
                                ],
                            ]
                        ],
                        [
                            'name' => 'Վերանորոգման աշխատանք',
                            'services' => [
                                [
                                    'title' => 'Ծորակի Տեղադրում',
                                    'price' => 4500
                                ],
                                [
                                    'title' => 'Աքսեսուարների վերանորոգում',
                                    'price' => 3500
                                ],
                                [
                                    'title' => 'Զուգարանակոնքերի վերանորոգում',
                                    'price' => 5000
                                ],
                                [
                                    'title' => 'Լոգախցիկի Վերանորոգում',
                                    'price' => 6000
                                ],
                                [
                                    'title' => 'Հիդրողցիկի վերանորոգում',
                                    'price' => 9000
                                ],
                                [
                                    'title' => 'Հիդրովանաի վերանորոգում',
                                    'price' => 7000
                                ],
                                [
                                    'title' => 'Սիֆոնի նորոգում',
                                    'price' => 3500
                                ],
                                [
                                    'title' => 'Օդափոխիչի նորոգում',
                                    'price' => 4500
                                ],
                                [
                                    'title' => 'Մեխանիզմների նորոգում',
                                    'price' => 3000
                                ],
                                [
                                    'title' => 'Էլ սարքերի նորոգում',
                                    'price' => 4500
                                ],
                            ]
                        ],
                        [
                            'name' => 'Փոխարինում',
                            'services' => [
                                [
                                    'title' => 'Ցնցուղի փոխարինում',
                                    'price' => 7000
                                ],
                                [
                                    'title' => 'Ճկուն խողովակների փոխարինում',
                                    'price' => 3500
                                ],
                            ]
                        ],
                        [
                            'name' => 'Կարգավորում',
                            'services' => [
                                [
                                    'title' => 'Լոգաղցիկների դռների կարգաորում',
                                    'price' => 3500
                                ],
                                [
                                    'title' => 'Հիդրովաննայի աշխատանքների կարգավորում',
                                    'price' => 7000
                                ],
                                [
                                    'title' => 'Հիդրոխցիկների  աշխատանքների կարգավորում',
                                    'price' => 7000
                                ],
                            ]
                        ],
                        [
                            'name' => 'Ապամոնտաժում',
                            'services' => [
                                [
                                    'title' => 'Զուգարանակոնքի ապամոնտաժում',
                                    'price' => 3500
                                ],
                                [
                                    'title' => 'Հիդրոխցիկի ապամոնտաժում',
                                    'price' => 5000
                                ],
                                [
                                    'title' => 'Լոգաղցիկի ապամոնտաժում',
                                    'price' => 5000
                                ],
                                [
                                    'title' => 'Ծորակի ապամոնտաժում',
                                    'price' => 5000
                                ],
                                [
                                    'title' => 'Վանաի ապամոնտաժում',
                                    'price' => 5000
                                ],
                            ]
                        ]

                    ]
                ],
                [
                    'parent' => 'Էլեկտրական տեղնիկա',
                    'children' => [
                        [
                            'name' => 'Տեղադրում',
                            'services' => [
                                [
                                    'title' => 'Լվացքի Մեքենաի տեղադրում',
                                    'price' => 5000
                                ],
                                [
                                    'title' => 'Սպասք լավացող մեքենաի տեղադրում',
                                    'price' => 4500
                                ],
                                [
                                    'title' => 'Սառնարանի տեղադրում',
                                    'price' => 5000
                                ],
                                [
                                    'title' => 'Գազոջածի տեղադրում',
                                    'price' => 4000
                                ],
                                [
                                    'title' => 'Սալոջախի տեղադրում',
                                    'price' => 4000
                                ],
                                [
                                    'title' => 'Հեռուստացույցի տեղադրում',
                                    'price' => 4000
                                ],
                                [
                                    'title' => 'Հեռուստացույցի հենակների տեղադրում',
                                    'price' => 3500
                                ],
                                [
                                    'title' => 'Օդաքաշ պահարանի տեղադրում',
                                    'price' => 10000
                                ],
                                [
                                    'title' => 'Փոքր օդորակիչների տեղադրում միջև 12000 BTU',
                                    'price' => 20000
                                ],
                                [
                                    'title' => 'Մեծ  օդորակիչների տեղադրում միջև 12000-24000 BTU',
                                    'price' => 25000
                                ],
                                [
                                    'title' => 'Ներկառուցվող վառարանի տեղադրում',
                                    'price' => 5000
                                ],
                                [
                                    'title' => 'Ներկառուցվող միկրովառարանի տեղադրում',
                                    'price' => 5000
                                ],
                            ]
                        ],
                        [
                            'name' => 'Ապամոնտաժում',
                            'services' => [
                                [
                                    'title' => 'Հեռուստացուըցի ապամոնտաժում',
                                    'price' => 3500
                                ],
                                [
                                    'title' => 'Հեռուստացուըցի հենակների ապամոնտաժում',
                                    'price' => 2500
                                ],
                                [
                                    'title' => 'Օդորակիչների ապամոնտաժում',
                                    'price' => 10000
                                ],
                                [
                                    'title' => 'Սառնարանի ապամոնտաժում',
                                    'price' => 2000
                                ],
                                [
                                    'title' => 'Ներկառուցվող միկրոալիքաին վառարանի ապամոնտաժում',
                                    'price' => 2000
                                ],
                                [
                                    'title' => 'Օդաքաշ պահարանի ապամոնտաժում',
                                    'price' => 2000
                                ],
                                [
                                    'title' => 'Գազոջախի ապամոնտաժում',
                                    'price' => 2000
                                ],
                                [
                                    'title' => 'Սալոջախի ապամոնտաժում',
                                    'price' => 2000
                                ],
                            ]
                        ],
                        [
                            'name' => 'Վերանորոգում',
                            'services' => [
                                [
                                    'title' => 'Լվացքի մեքենաի նորոգում',
                                    'price' => 6000
                                ],
                                [
                                    'title' => 'Սպասք Լվացող մեքենաի նորոգում',
                                    'price' => 6000
                                ],
                                [
                                    'title' => 'Հեռուստացույցի նորոգում',
                                    'price' => 6000
                                ],
                                [
                                    'title' => 'Սառնարանի նորոգում',
                                    'price' => 6000
                                ],
                                [
                                    'title' => 'Սառնարանի դիագնոստիկա',
                                    'price' => 3000
                                ],
                                [
                                    'title' => 'Մեծ սառնարանի նորոգում',
                                    'price' => 10000
                                ],
                                [
                                    'title' => 'Օդորակիչների նորոգում',
                                    'price' => 5000
                                ],
                                [
                                    'title' => 'Գազոջախի նորոգում',
                                    'price' => 6000
                                ],
                                [
                                    'title' => 'Օդաաքարշ պահարանի նորոգում',
                                    'price' => 7000
                                ],
                                [
                                    'title' => 'Օդորակիչների կոմպրեսորի նորոգում',
                                    'price' => 15000
                                ],
                                [
                                    'title' => 'Միկրովառելիքաին վառարանի նորոգում',
                                    'price' => 6000
                                ],
                                [
                                    'title' => 'Փոշեկուլի նորոգում',
                                    'price' => 5000
                                ],
                                [
                                    'title' => 'Բլենդեռի Նորոգում',
                                    'price' => 6000
                                ],
                                [
                                    'title' => 'Արդուկի նորոգում',
                                    'price' => 5000
                                ],
                            ]
                        ],
                        [
                            'name' => 'Կենցաղաին',
                            'services' => [
                                [
                                    'title' => 'Զուգարանակոնքի ապամոնտաժում',
                                    'price' => 3500
                                ],
                                [
                                    'title' => 'Հիդրոխցիկի ապամոնտաժում',
                                    'price' => 5000
                                ],
                                [
                                    'title' => 'Լոգաղցիկի ապամոնտաժում',
                                    'price' => 5000
                                ],
                                [
                                    'title' => 'Ծորակի ապամոնտաժում',
                                    'price' => 5000
                                ],
                                [
                                    'title' => 'Վանաի ապամոնտաժում',
                                    'price' => 5000
                                ],
                            ]
                        ],
                    ]
                ],
                [
                    'parent' => 'Էլեկտրականություն',
                    'children' => []
                ],
                [
                    'parent' => 'Քանդման Ծագման  Աշխատանքներ',
                    'children' => []
                ]

        ];

        foreach ($services as $service){
            $profession = Profession::query()->create(['title' => $service['parent']]);

            foreach ($service['children'] as $child) {
                $child_profession = $profession->child()->create(['title' => $child['name']]);

                foreach ($child['services'] as $single_service){
                    Service::query()->create($single_service + ['profession_id' => $child_profession->id]);
                }
            }
        }
    }
}
