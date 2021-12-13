<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('description');
            $table->mediumText('details')->nullable();
            $table->string('image')->nullable();
            $table->string('slug');
            $table->string('file_size')->nullable();
            $table->string('license')->nullable();
            $table->string('developer');
            $table->string('url');
            $table->string('type');
            $table->integer('votes')->default(0);
            $table->integer('total_votes')->default(0);
            $table->integer('counter')->default(0);
            $table->integer('category');
            $table->integer('platform');
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
        Schema::dropIfExists('programs');
    }
}
