<?php

use App\Models\Document;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('name_category', 250);
            $table->string('name_file', 250);
            $table->string('size', 50);
            $table->string('resolution', 50);
            $table->string('file', 250);
            $table->string('type', 50);
            // Provider IDs
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign keys for provider relationships
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('client_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
