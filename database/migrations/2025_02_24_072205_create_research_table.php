<?php

use App\Models\Department;
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
        Schema::create('research', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Department::class)->constrained()->cascadeOnDelete();
            $table->string('title')->unique();
            $table->text('abstract');
            $table->string('author');
            $table->date('published_date');
            $table->enum('status', ['published', 'unpublished'])->default('unpublished');      
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('research');
    }
};
