<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class RoleConfigurationTest extends TestCase
{
    #[Test]
    public function role_matrix_contains_civil_lab_operational_roles(): void
    {
        $roles = ['owner', 'admin', 'lab_manager', 'technician', 'store_keeper', 'client'];

        $this->assertContains('owner', $roles);
        $this->assertContains('lab_manager', $roles);
        $this->assertContains('technician', $roles);
        $this->assertContains('store_keeper', $roles);
    }
}
