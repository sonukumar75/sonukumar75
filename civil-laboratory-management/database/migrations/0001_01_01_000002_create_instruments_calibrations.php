<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instruments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->string('asset_code');
            $table->string('name');
            $table->string('serial_number')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('location')->nullable();
            $table->string('status')->default('available');
            $table->date('purchase_date')->nullable();
            $table->date('next_calibration_due')->nullable();
            $table->text('maintenance_notes')->nullable();
            $table->timestamps();
            $table->unique(['tenant_id', 'asset_code']);
        });


        Schema::create('lab_tests', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sample_id')->constrained()->cascadeOnDelete();
            $table->foreignId('test_method_id')->constrained()->cascadeOnDelete();
            $table->foreignId('instrument_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->timestamp('scheduled_at');
            $table->timestamp('completed_at')->nullable();
            $table->decimal('result_value', 12, 4)->nullable();
            $table->string('result_unit')->nullable();
            $table->string('status')->default('scheduled');
            $table->text('review_notes')->nullable();
            $table->foreignId('approved_by')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('calibrations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('instrument_id')->constrained()->cascadeOnDelete();
            $table->date('calibrated_on');
            $table->date('due_on');
            $table->string('certificate_number');
            $table->string('agency_name');
            $table->string('result')->default('pass');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calibrations');
        Schema::dropIfExists('lab_tests');
        Schema::dropIfExists('instruments');
    }
};
