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
        Schema::create('selections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vac_id')->nullable()->constrained(
                table : 'vacancies',
                indexName: 'vacancies_id'
            );
            $table->foreignId('applicant_id')->nullable()->constrained(
                table : 'users',
                indexName: 'applicants_id'
            );
            $table->foreignId('type_test_id')->nullable()->constrained(
                table : 'selection_types',
                indexName: 'selection_types_id'
            );
            $table->foreignId('app_by')->nullable()->constrained(
                table : 'users',
                indexName: 'app_selection_id'
            );
            $table->date('app_date')->nullable();
            $table->string('app_status')->default('p');
            $table->text('app_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selections');
    }
};
