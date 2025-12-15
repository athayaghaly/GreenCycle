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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // ADMIN ID BOLEH KOSONG (Karena nasabah yang input duluan)
            $table->foreignId('admin_id')->nullable()->constrained('users'); 
            
            $table->foreignId('trash_type_id')->constrained();
            $table->decimal('weight_kg', 8, 2);
            $table->decimal('total_price', 15, 2); // Ini jadi "Estimasi Pendapatan"
            
            // KOLOM BARU: STATUS
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
