<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
                [
                    'parent' => 'Սանտեխնիկական Պարագաներ',
                    'children' => [
                        "Խաչուկներ սալիկի",
                        "Սանտեխնիկայի դետալներ",
                        "Ցնցուղներ",
                        "Փականներ և կցամասեր",
                        "Ֆում/պակլի",
                        "Պոմպեր",
                        "Սանկերամիկա",
                        "Ծորակներ",
                        "Ճկախողովակներ",
                        "Օդափոխություն",
                    ]
                ],
                [
                    'parent' => 'Ներկեր, սոսինձներ,ծեփամածիկներ',
                    'children' => [
                        "Ծեփամածիկ, սվաղանյութ,փոշեղեն",
                        "Սալիկի սոսինձ",
                        "Ջրաէմուլսիոն ներկեր",
                        "Դեկորատիվ ներկեր",
                        "Նիտրո ներկեր",
                        "Գունաներկեր",
                        "Նախահիմքեր",
                        "Յուղաներկ",
                        "Լաքեր և բայցեր",
                        "Լուծիչներ",
                        "Փչովի ներկեր",
                        "Ներկարարական ժապավեններ",
                        "Ներկարարական խոզանակներ",
                        "Ներկարարական գլանակներ/վալիկներ",
                        "Աերոզոլային հրակայուն ներկ",
                        "Էմուլսիա, սոսինձ, հերմետիկ,փրփուրներ",
                        "Վերջնահարդարման ներկեր",
                        "Ալկիդային ներկեր",
                        "Չոր շաղախներ",
                        "Դեկորներ",
                    ]
                ],
                [
                    'parent' => 'Ներքին հարդարման պարագաներ',
                    'children' => [
                        "Պրոֆիլի աքսեսուարներ",
                        "Պրոֆիլներ",
                        "Սալեր (Гипсокартон)",
                        "Փոշեղեն",
                        "Գիպսեստվարաթուղթ",
                        "Պենոպլաստ",
                        "Մեխ",
                        "Հատակի լամինատներ",
                        "Լցահարթիչներ",
                        "Գիպսեստվարաթղթե լյուկեր",
                        "Սալեր (Гипсокартон)",
                        "Պրոֆիլներ",
                        "Պրոֆիլներ",
                        "Պրոֆիլի աքսեսուարներ",
                        "Գիպսեստվարաթղթե լյուկեր",
                        "Գիպսեստվարաթղթե լյուկեր",
                        "Գիպսեստվարաթղթե լյուկեր",
                    ]
                ],
                [
                    'parent' => 'Սոսինձներ',
                    'children' => [
                        "Փրփուրներ",
                        "Սոսինձներ",
                        "Սիլիկոններ",
                    ]
                ],
                [
                    'parent' => 'Ծախսվող Նյութեր/расходные материалы',
                    'children' => [
                        "Գայլիկոն մետաղի/սվեռլո",
                        "Գայլիկոն հորատիչի/սվեռլո",
                        "Մեխ",
                        "կտրող դիսկեր",
                        "Սամառեզներ",
                        "Հղկման դիսկեր",
                        "շուշաթուխտ",
                        "բոլտ գայկա",
                        "Այլ",
                    ]
                ],
                [
                    'parent' => 'Անվտանգության պարագաներ',
                    'children' => [
                        "Պաշտպանիչ ակնոցներ",
                        "Անվտանգության գոտիներ",
                        "Սաղավարտներ/գլխարկներ",
                        "Դեմքի դիմակներ",
                        "Կոշիկներ",
                        "Ապակու բռնիչներ",
                        "Շինարարական արտահագուստ",
                        "Գործիքի արկղեր/պահոցներ",
                    ]
                ],
                [
                    'parent' => 'Էլեկտրական գործիքներ',
                    'children' => [
                        "Օդով գործիքներ",
                        "Հոսանքով գործիքներ",
                        "Մարտկոցով գործիքներ",
                        "Հաստոցներ",
                        "Գեներատոր",
                        "Սղոցներ",
                        "Սղոց շղթայավոր",
                        "Հղկող մեքենա",
                        "Էլեկտրական գործիքների կցորդիչներ",
                    ]
                ],
                [
                    'parent' => 'Ձեռքի գործիքներ',
                    'children' => [
                        "Գործիքների հավաքածուներ",
                        "Ձեռքի կտրող գործիքներ",
                        "Պտուտակահաններ",
                        "Պտուտակաբանալի/կլուչեր",
                        "Չափող գործիքներ",
                        "Հարվածող գործիքներ",
                        "Փայտագործի գործիքներ",
                        "Այլ ձեռքի գործիքներ",
                    ]
                ],
                [
                    'parent' => 'Աստիճաներ',
                    'children' => [
                        "Ալյումինե աստիճաններ",
                        "Երկկողմանի աստիճաններ",
                        "Երկհատվածանի և երեք հատվածանի աստիճաններ",
                        "Միակողմանի աստիճաններ",
                        "Փոխակերպվող աստիճաննե",
                        "Խառաչոներ",
                        "Աստիճան իրար մեջ մտնող",

                    ]
                ],
                [
                    'parent' => 'Շինարարական դետալներ,խողովակներ',
                    'children' => [
                        "Պողպատյա խողովակներ",
                        "Թիթեղներ",
                        "Պողպատյա երկայնաձիգ գլանվածքներ",
                        "Պողպատյա ձևավոր գլանվածքներ",
                        "Ցանցեր",
                        "Կլոր հատումով պողպատյա խողովակների կցամասեր",
                        "Մետիչ (стальная провод)",
                        "Եռակցման պարագաներ",
                    ]
                ],
                [
                    'parent' => 'Դռներ',
                    'children' => [
                        "Միջսենյակային դռներ",
                        "Բռնակներ և փականներ",
                        "Մեխանիզմներ և միջուկներ",
                        "Աքսեսուարներ",
                    ]
                ],
                [
                    'parent' => 'Ամեն ինչ տան համար',
                    'children' => [
                        "Տնտեսական ապրանքներ",
                        "Կողպեքներ",
                        "Կենցաղային տեխնիկա",
                        "Կենցաղային պարագաներ",
                        "Լույսեր",
                        "Հոսանքի պարագաներ",
                        "Ժանգ հանող հեղուկ",
                        "Դռան ծխնի/պետլի",
                    ]
                ],
                [
                    'parent' => 'Ջերմամեկուսիչ նյութեր',
                    'children' => [
                        "Հանքային բամբակ",
                        "Ապակե բամբակ",
                        "Այլ",
                    ]
                ],
                [
                    'parent' => 'Շինանյութեր',
                    'children' => [
                        "Ավազ/շիբին",
                        "Քար/ սալիկ",
                        "Ցեմենտ/գաջ",
                        "Ամրան/Ամրալար/Խամուտ",
                        "Տախտակ",
                        "Բլոկներ / աղյուս (կիրպիչ)",
                        "Հող/տորֆ",
                        "Երեսապատման սալիկներ",
                        "Եզրաքարեր",
                        "Մայթի սալիկներ",
                    ]
                ],
                [
                    'parent' => 'Այգեգործական Պարագաներ',
                    'children' => [
                        "Խոտհնձիչներ",
                        "Սղոց",
                        "Սրսկիչներ",
                        "Բահ/փոցխ/եղան",
                        "Շլանգ",
                        "Այգու ցնցուղներ",
                        "Գյուղատնտեսական տեխնիկա",
                        "Ձեռնասայլակներ",
                        "Այգու ձեռքի գործիքներ",
                    ]
                ],
        ];

        foreach ($categories as $category) {
            $parent_category = Category::query()->create(['title' => $category['parent']]);
            foreach ($category['children'] as $children) {
                $parent_category->child()->create(['title' => $children]);
            }
        }

    }
}
