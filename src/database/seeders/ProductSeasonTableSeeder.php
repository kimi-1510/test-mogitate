<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeasonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_season')->insert([
            // キウイ：秋、冬
            ['product_id' => 1, 'season_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 1, 'season_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            // ストロベリー：春
            ['product_id' => 2, 'season_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            // オレンジ：冬
            ['product_id' => 3, 'season_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            // スイカ：夏
            ['product_id' => 4, 'season_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            // ピーチ：夏
            ['product_id' => 5, 'season_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            // シャインマスカット：夏、秋
            ['product_id' => 6, 'season_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 6, 'season_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            // パイナップル：春、夏
            ['product_id' => 7, 'season_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 7, 'season_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            // ブドウ：夏、秋
            ['product_id' => 8, 'season_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 8, 'season_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            // バナナ：夏
            ['product_id' => 9, 'season_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            // メロン：春、夏
            ['product_id' => 10, 'season_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['product_id' => 10, 'season_id' => 2, 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
