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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('father_name')->nullable();
            $table->date('dob')->nullable();
            $table->string('phone')->index(); // Mobile No
            $table->string('whatsapp_no')->nullable();
            $table->string('qualification')->nullable(); // 10th, 12th, Graduation, Diploma, etc.
            $table->string('gender')->nullable(); // Male, Female, Other
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('course_interested')->nullable();
            $table->string('email')->nullable();
            $table->string('alt_phone')->nullable();
            
            $table->string('source')->default('Counseling Form'); // Website, Walk-in, Bulk Upload, Referral, etc.
            $table->string('status')->default('New'); // New, Contacted, Interested, Follow-up, Not Interested, Converted, Closed
            $table->string('priority')->default('Medium'); // Low, Medium, High
            
            // Assignment info
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('assigned_at')->nullable();
            $table->foreignId('assigned_by')->nullable()->constrained('users')->nullOnDelete();

            // Contact & Remark tracking
            $table->timestamp('last_contacted_at')->nullable();
            $table->dateTime('next_followup_at')->nullable();
            $table->text('current_remarks')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
