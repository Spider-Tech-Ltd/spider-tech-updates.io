<?php

namespace Tests\Smoke;

use PHPUnit\Framework\TestCase;

class BootstrapSmokeTest extends TestCase
{
    public function testCoreConstantsAreDefined(): void
    {
        $this->assertTrue(defined('ROOT_PATH'), 'ROOT_PATH constant must be defined.');
        $this->assertTrue(defined('BASE_URL'), 'BASE_URL constant must be defined.');
    }

    public function testEssentialClassesCanBeInstantiated(): void
    {
        $classes = [
            \Router::class,
            \CSRF::class,
            \Utils::class,
            \HealthController::class,
        ];

        foreach ($classes as $class) {
            $this->assertTrue(class_exists($class), "Class {$class} must exist and be autoloadable.");
            $instance = new $class();
            $this->assertInstanceOf($class, $instance);
        }
    }

    public function testCriticalConfigAndUtilsFilesExist(): void
    {
        $files = [
            ROOT_PATH . '/config/config.php',
            ROOT_PATH . '/config/database.php',
            ROOT_PATH . '/utils/Env.php',
            ROOT_PATH . '/utils/Router.php',
            ROOT_PATH . '/utils/PaystackService.php',
            ROOT_PATH . '/controllers/HealthController.php',
            ROOT_PATH . '/index.php',
        ];

        foreach ($files as $file) {
            $this->assertFileExists($file, "Critical file {$file} must exist.");
        }
    }
}
