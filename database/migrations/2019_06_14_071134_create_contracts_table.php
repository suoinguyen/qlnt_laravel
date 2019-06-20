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
            $table->string('id_room');
            $table->string('id_customer');
            $table->string('contract_electric_number');
            $table->string('contract_water_number');
            $table->string('contract_people_count');
            $table->string('contract_deposits_money');
            $table->string('contract_date_rented');
            $table->string('contract_date_calc_money');
            $table->string('status');//0 = huy, 1 = con hieu luc
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
