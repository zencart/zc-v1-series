<?php

namespace Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecordCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Capsule::schema()->create('record_company', function (Blueprint $table) {
            $table->increments('record_company_id');
            $table->string('record_company_name', 32)->default('')->index('idx_rec_company_name_zen');
            $table->string('record_company_image')->nullable();
            $table->dateTime('date_added')->nullable();
            $table->dateTime('last_modified')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Capsule::schema()->dropIfExists('record_company');
    }
}
