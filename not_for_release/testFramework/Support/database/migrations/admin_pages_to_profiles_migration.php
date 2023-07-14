<?php

namespace Migrations;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdminPagesToProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Capsule::schema()->create('admin_pages_to_profiles', function (Blueprint $table) {
            $table->integer('profile_id')->default(0);
            $table->string('page_key', 191)->default('');

            $table->unique(['profile_id', 'page_key'], 'profile_page');
            $table->unique(['page_key', 'profile_id'], 'page_profile');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Capsule::schema()->dropIfExists('admin_pages_to_profiles');
    }
}
