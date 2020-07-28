<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create1591035159TestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('tests')) {
            Schema::create('tests', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title')->nullable();
                $table->string('main_image')->nullable();
                $table->string('bg_image')->nullable();
                $table->json('questions')->nullable();
                $table->string('test_type')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->index(['deleted_at']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tests');
    }
}
