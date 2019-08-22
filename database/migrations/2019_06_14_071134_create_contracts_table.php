<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_room');
            $table->integer('id_customer');
            $table->integer('contract_electric_number');
            $table->integer('contract_water_number');
            $table->integer('contract_people_count');
            $table->integer('contract_deposits_money');
            $table->date('contract_date_rented');
            $table->integer('contract_date_calc_money');
            $table->boolean('contract_status');//false = huy, true = con hieu luc
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
        Schema::dropIfExists('contracts');
    }
}
