<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username',  250);
            $table->string('email')->unique()->comment('User email for login');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->comment('Hashed password');
            $table->boolean('is_active')->nullable();
            $table->rememberToken()->comment('For "remember me" functionality');
            $table->timestamps();
            $table->softDeletes();

            // Provider IDs
            // $table->unsignedBigInteger('speciality_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
