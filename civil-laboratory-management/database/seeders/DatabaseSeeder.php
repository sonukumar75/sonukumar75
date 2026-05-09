<?php

namespace Database\Seeders;

use App\Models\Instrument;
use App\Models\Project;
use App\Models\Role;
use App\Models\Sample;
use App\Models\Tenant;
use App\Models\TestMethod;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $roles = collect([
            ['name' => 'owner', 'label' => 'Owner', 'description' => 'Controls subscription, tenants, billing, and all modules.'],
            ['name' => 'admin', 'label' => 'Admin', 'description' => 'Manages users, projects, tests, and instruments.'],
            ['name' => 'lab_manager', 'label' => 'Lab Manager', 'description' => 'Approves schedules, results, and calibration decisions.'],
            ['name' => 'technician', 'label' => 'Technician', 'description' => 'Records test execution and instrument readings.'],
            ['name' => 'store_keeper', 'label' => 'Store Keeper', 'description' => 'Tracks issue/return and instrument availability.'],
            ['name' => 'client', 'label' => 'Client', 'description' => 'Views project progress and approved reports.'],
        ])->map(fn (array $role): Role => Role::updateOrCreate(['name' => $role['name']], $role));

        $tenant = Tenant::updateOrCreate(
            ['slug' => 'demo-civil-lab'],
            [
                'name' => 'Demo Civil Testing Laboratory',
                'billing_email' => 'billing@example.test',
                'plan' => 'professional',
                'trial_ends_at' => now()->addDays(14),
                'is_active' => true,
            ]
        );

        $user = User::updateOrCreate(
            ['email' => 'owner@example.test'],
            [
                'tenant_id' => $tenant->id,
                'name' => 'Demo Owner',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $user->roles()->sync($roles->whereIn('name', ['owner', 'admin', 'lab_manager'])->pluck('id'));

        $project = Project::updateOrCreate(
            ['tenant_id' => $tenant->id, 'code' => 'BRG-001'],
            [
                'client_name' => 'Metro Infrastructure Ltd.',
                'name' => 'Bridge Concrete Quality Audit',
                'site_address' => 'North River Expansion Site',
                'contact_person' => 'Asha Sharma',
                'status' => 'active',
                'start_date' => now()->subDays(5)->toDateString(),
            ]
        );

        $method = TestMethod::updateOrCreate(
            ['tenant_id' => $tenant->id, 'standard_code' => 'IS 516'],
            [
                'name' => 'Concrete Cube Compressive Strength',
                'material_type' => 'Concrete',
                'turnaround_hours' => 72,
                'unit_rate' => 850,
                'acceptance_criteria' => 'Average compressive strength must meet design grade requirement.',
                'is_active' => true,
            ]
        );

        Sample::updateOrCreate(
            ['tenant_id' => $tenant->id, 'sample_code' => 'CC-2026-001'],
            [
                'project_id' => $project->id,
                'material_type' => 'Concrete',
                'source_location' => 'Pier P2 pour',
                'received_at' => now()->subDay(),
                'status' => 'received',
                'remarks' => 'Three cubes received in sealed condition.',
            ]
        );

        Instrument::updateOrCreate(
            ['tenant_id' => $tenant->id, 'asset_code' => 'CTM-1000'],
            [
                'name' => 'Compression Testing Machine 1000kN',
                'serial_number' => 'CTM-26-1000',
                'manufacturer' => 'CivilTech Instruments',
                'location' => 'Strength Lab',
                'status' => 'available',
                'purchase_date' => now()->subYear()->toDateString(),
                'next_calibration_due' => now()->addDays(20)->toDateString(),
                'maintenance_notes' => 'Hydraulic oil inspected monthly.',
            ]
        );
    }
}
