<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('search_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('city');
            $table->float('temperature');
            $table->string('weather_condition');
            $table->float('wind_speed');
            $table->enum('unit', ['Celsius', 'Fahrenheit']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('search_history');
    }
};
