<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->string('client_name');
            $table->string('code');
            $table->string('name');
            $table->string('site_address')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('status')->default('planned');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
            $table->unique(['tenant_id', 'code']);
        });

        Schema::create('samples', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('sample_code');
            $table->string('material_type');
            $table->string('source_location')->nullable();
            $table->timestamp('received_at');
            $table->string('status')->default('received');
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->unique(['tenant_id', 'sample_code']);
        });

        Schema::create('test_methods', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('standard_code');
            $table->string('material_type');
            $table->unsignedInteger('turnaround_hours')->default(24);
            $table->decimal('unit_rate', 10, 2)->default(0);
            $table->text('acceptance_criteria')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('test_methods');
        Schema::dropIfExists('samples');
        Schema::dropIfExists('projects');
    }
};
