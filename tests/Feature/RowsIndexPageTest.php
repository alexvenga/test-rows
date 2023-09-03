<?php

namespace Tests\Feature;

use Tests\TestCase;

class RowsIndexPageTest extends TestCase
{

    public function testRowsIndexPageStatus(): void
    {
        $response = $this->get('/rows');

        $response->assertOk();
    }
}
