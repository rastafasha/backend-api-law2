<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresupuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presupuestos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('amount', 250);
            // $table->string('amount')->nullable();
            $table->text('description')->nullable();
            $table->text('diagnostico')->nullable();
            $table->json('medical')->nullable();
            
            $table->tinyInteger('confimation')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->json('n_doc')->nullable();
            
            
            // Provider IDs
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('speciality_id')->nullable();


            $table->timestamps();
            $table->softDeletes();

            // Foreign keys for provider relationships
            // $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            // $table->foreign('client_id')->references('id')->on('clients')->nullOnDelete();
            // $table->foreign('speciality_id')->references('id')->on('specialities')->nullOnDelete();
            // $table->foreign('n_doc')->references('n_doc')->on('patients')->nullOnDelete();
            // $table->foreign('doctor_schedule_join_hour_id')->references('id')->on('doctor_schedule_join_hours')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presupuestos');
    }
}
