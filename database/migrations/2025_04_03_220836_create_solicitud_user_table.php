<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_user', function (Blueprint $table) {
            $table->id();  
            $table->foreignId('solicitud_id')->constrained('solicituds')->onDelete('cascade')->nullable();  
            $table->foreignId('cliente_id')->constrained('users')->onDelete('cascade')->nullable();  
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->nullable();  
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
        Schema::dropIfExists('solicitud_user');
    }
}
