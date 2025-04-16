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
            $table->unsignedBigInteger('solicitud_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->timestamps();

            // $table->foreignId('solicitud_id')->constrained('solicituds')->onDelete('cascade')->nullable();  
            // $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->nullable();  
            // $table->foreignId('client_id')->constrained('clients')->onDelete('cascade')->nullable();  
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
