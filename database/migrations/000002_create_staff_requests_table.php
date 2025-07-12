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
        Schema::create('staff_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained(
                table : 'users',
                indexName: 'request_user_id'
            );
            $table->string('number')->nullable()->unique();
            $table->string('title')->nullable();
            $table->date('date')->nullable();
            $table->foreignId('position_id')->nullable()->constrained(
                table : 'positions',
                indexName: 'position_id'
            );
            $table->integer('qty')->nullable();
            $table->text('note')->nullable();
            $table->foreignId('app_by')->nullable()->constrained(
                table : 'users',
                indexName: 'app_user_id'
            );
            $table->string('app_status')->default('p');
            $table->date('app_date')->nullable();
            $table->text('app_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_requests');
    }
};
