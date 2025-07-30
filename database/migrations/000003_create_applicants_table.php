<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained(
                table : 'users',
                indexName: 'user_id'
            );
            $table->string('gender')->nullable();
            $table->foreignId('religion')->nullable()->constrained(
                table : 'religions',
                indexName: 'religion_id'
            );
            $table->foreignId('last_edu')->nullable()->constrained(
                table : 'education',
                indexName: 'education_id'
            );
            $table->string('applicant_number')->nullable();
            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->text('address')->nullable();
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('photo')->nullable();
            $table->string('cv')->nullable();
            $table->string('ktp')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
