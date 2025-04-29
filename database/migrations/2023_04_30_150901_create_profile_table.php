<?php

use App\Models\Profile;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('gender')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('avatar')->nullable();
            $table->string('n_doc', 50)->unique()->nullable();

            $table->string('nombre');
            $table->string('surname')->nullable();
            $table->text('direccion')->nullable();
            $table->text('description')->nullable();
            $table->string('pais')->nullable();
            $table->string('lang')->nullable();
            $table->string('estado')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('telhome')->nullable();
            $table->string('telmovil')->nullable();
            $table->json('redessociales')->nullable();
            $table->json('precios')->nullable();
            $table->string('rating')->nullable();

            // Provider IDs
            $table->unsignedBigInteger('speciality_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign keys for provider relationships
            // $table->foreign('speciality_id')->references('id')->on('specialities')->nullOnDelete();
            // $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            // $table->foreign('client_id')->references('id')->on('clients')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile');
    }
}
