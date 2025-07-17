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
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->nullable()->constrained(
                table : 'staff_requests',
                indexName: 'request_id'
            );
            $table->string('title');
            $table->integer('min_age')->nullable();
            $table->integer('max_age')->nullable();
            $table->foreignId('min_edu')->nullable()->constrained(
                table : 'education',
                indexName: 'min_edu_id'
            );
            $table->text('note');
            $table->string('status')->default('f');
            $table->decimal('sallary', total: 10, places: 2)->nullable();
            $table->foreignId('sallary_id')->nullable()->constrained(
                table : 'sallary_types',
                indexName: 'sallary_types_id'
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacancies');
    }
};
