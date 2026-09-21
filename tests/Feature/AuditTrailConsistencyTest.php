<?php

namespace Tests\Feature;

use App\Models\AuditTrail;
use Tests\TestCase;

class AuditTrailConsistencyTest extends TestCase
{
    public function test_generic_action_names_are_normalized_consistently(): void
    {
        $this->assertSame('login', AuditTrail::normalizeAction('login', 'auth'));
        $this->assertSame('logout', AuditTrail::normalizeAction('logout', 'auth'));
        $this->assertSame('create_masyarakat', AuditTrail::normalizeAction('create', 'masyarakat'));
        $this->assertSame('update_program', AuditTrail::normalizeAction('update', 'program'));
        $this->assertSame('delete_mitra', AuditTrail::normalizeAction('delete', 'mitra'));
        $this->assertSame('create_program', AuditTrail::normalizeAction('create_program', 'program'));
    }
}
