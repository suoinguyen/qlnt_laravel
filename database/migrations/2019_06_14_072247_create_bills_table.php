<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {;
            $table->increments('id');
            $table->integer('id_room');
            $table->integer('id_customer');
            $table->integer('bill_people_count');
            $table->integer('bill_room_price');
            $table->date('bill_date_calc_last');
            $table->date('bill_date_calc_new');
            $table->integer('bill_electric_number_last');
            $table->integer('bill_electric_number_new');
            $table->integer('bill_water_number_last');
            $table->integer('bill_water_number_new');
            $table->string('bill_addition', 1000)->nullable();
            $table->boolean('bill_status');//da thanh toan, chua thanh toan, thanh toan 1 phan
            $table->string('bill_notes')->nullable();
            $table->integer('bill_debt_money')->nullable();//tien no
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
