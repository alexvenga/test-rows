<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{

    public function testHomePageStatus(): void
    {
        $response = $this->get('/');

        $response->assertOk();
    }
}
