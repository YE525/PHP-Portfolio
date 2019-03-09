<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageFileName extends Migration
{

    public function up()
    {
        Schema::table('microposts', function (Blueprint $table) {
            $table->string('image_file_name', 100);
        });
    }

    public function down()
    {
        Schema::table('microposts', function (Blueprint $table) {
            $table->dropColumn('image_file_name');
        });
    }
}