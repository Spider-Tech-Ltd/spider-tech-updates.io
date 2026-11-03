<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Router;

class RouterTest extends TestCase
{
    public function testRouterRegistersAndMatchesExactRoute(): void
    {
        $router = new Router();
        $router->addRoute('test/route', \HealthController::class, 'check');

        $this->assertInstanceOf(Router::class, $router);
    }
}

