<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rooms')->delete();
        for ($i = 1; $i <= 3; $i++){
            for ($j = 1; $j <= 16; $j++){
                if ($i == 1 && $j > 7){
                    continue;
                }
                if (strpos($j, '4') !== false) {
                    continue;
                }

                if ($j < 10){
                    $hihi = '0'.$j;
                }else{
                    $hihi = $j;
                }
                $room_name = $i.$hihi;
                DB::table('rooms')->insert([
                    'room_name' => $room_name,
                    'room_floor' => $i,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
        }
    }
}
