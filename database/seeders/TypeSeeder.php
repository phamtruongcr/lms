<?php

namespace Database\Seeders;

use App\Models\StatusTranslation;
use App\Models\TypeTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types=[
            [
                'value'=>1,
                'lang'=>'vi',
                'name'=>'Một đáp án',
            ],
            [
                'value'=>2,
                'lang'=>'vi',
                'name'=>'Nhiều đáp án',
            ],
            [
                'value'=>3,
                'lang'=>'vi',
                'name'=>'Tự luận',
            ],
            [
                'value'=>1,
                'lang'=>'en',
                'name'=>'One choice',
            ],
            [
                'value'=>2,
                'lang'=>'en',
                'name'=>'Multi choice',
            ],
            [
                'value'=>3,
                'lang'=>'en',
                'name'=>'Essay',
            ],
        ];
        TypeTranslation::insert($types);
        $status=[
           [
            'value'=>0,
            'lang'=>'en',
            'name'=>'No Active',
           ],
           [
            'value'=>1,
            'lang'=>'en',
            'name'=>'Active',
           ],
           [
            'value'=>0,
            'lang'=>'vi',
            'name'=>'Không sử dụng',
           ],
           [
            'value'=>1,
            'lang'=>'vi',
            'name'=>'Đang sử dụng',
           ],
        ];
        StatusTranslation::insert($status);

    }
}
