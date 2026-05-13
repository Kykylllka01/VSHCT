<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ideas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('problem')->nullable();
            $table->text('solution')->nullable();
            $table->text('expected_result')->nullable();
            $table->text('required_resources')->nullable();
            $table->text('technology_stack')->nullable();
            $table->string('status')->default('draft'); // draft, published, approved, rejected, in_project
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ideas');
    }
};
