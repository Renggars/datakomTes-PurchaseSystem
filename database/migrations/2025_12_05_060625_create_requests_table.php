<!-- create_requests_table -->

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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('requester_id')->constrained('users')->cascadeOnDelete();

            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();

            $table->enum('status', [
                'diajukan',
                'menunggu_approval',
                'approved',
                'checking_warehouse',
                'by_vendor',
                'selesai',
                'ditolak'
            ])->default('diajukan')->nullable(false);

            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
