<?php

use App\Models\GlobalNumbering;
use Illuminate\Database\Seeder;

class GlobalNumberingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'module'  => GlobalNumbering::module['principal_claim'],
                'for'     => GlobalNumbering::for['principal_claim'],
                'format'  => '[Y][m][iiiiii]',
                'prefix'  => 'PC',
                'clause'  => GlobalNumbering::DEFAULT,
                'example' => 'PC2312000001',
            ],
            [
                'module'  => GlobalNumbering::module['forward_order'],
                'for'     => GlobalNumbering::for['forward_order'],
                'format'  => '[Y][m][iiiiii]',
                'prefix'  => 'PB',
                'clause'  => GlobalNumbering::DEFAULT,
                'example' => 'PB2312000001',
            ],
            [
                'module'  => GlobalNumbering::module['claim_third_party'],
                'for'     => GlobalNumbering::for['claim_third_party'],
                'format'  => '[Y][m][iiiiii]',
                'prefix'  => 'CTP',
                'clause'  => GlobalNumbering::DEFAULT,
                'example' => 'CTP242000001',
            ],
            [
                'module'  => GlobalNumbering::module['pipeline'],
                'for'     => GlobalNumbering::for['pipeline'],
                'format'  => '[Y][m][iiii]',
                'prefix'  => 'PL',
                'clause'  => GlobalNumbering::DEFAULT,
                'example' => 'PL24020001',
            ],
            [
                'module'  => GlobalNumbering::module['huawei_invoice'],
                'for'     => GlobalNumbering::for['huawei_invoice'],
                'format'  => '[iiiiiiii]',
                'prefix'  => 'SMH',
                'clause'  => GlobalNumbering::DEFAULT,
                'example' => 'SMH00000001',
            ],
            [
                'module'  => GlobalNumbering::module['price_inquiry'],
                'for'     => GlobalNumbering::for['price_inquiry'],
                'format'  => '[Y][m][iiiii]',
                'prefix'  => 'PQY',
                'clause'  => GlobalNumbering::DEFAULT,
                'example' => 'PQY240100001',
            ],
            [
                'module'  => GlobalNumbering::module['rent_stock'],
                'for'     => GlobalNumbering::for['rent_stock'],
                'format'  => '[Y][m][iiiii]',
                'prefix'  => 'RNT',
                'clause'  => GlobalNumbering::DEFAULT,
                'example' => 'RNT240100001',
            ],
            [
                'module'  => GlobalNumbering::module['engineering'],
                'for'     => GlobalNumbering::for['engineering'],
                'format'  => '[Y][m][iiii]',
                'prefix'  => 'ER',
                'clause'  => GlobalNumbering::RESET,
                'example' => 'ER24100001',
            ],
        ];

        foreach ($data as $item) {
            $globalNumber = GlobalNumbering::where('module', $item['module'])->first();

            if (!$globalNumber) {
                GlobalNumbering::create($item);
            }
        }
    }
}
