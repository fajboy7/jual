<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->string('setting_key')->primary();
            $table->text('setting_value')->nullable();
        });
    }
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}