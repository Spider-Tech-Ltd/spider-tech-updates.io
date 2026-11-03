<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Env;

class EnvTest extends TestCase
{
    public function testGetReturnsFallbackDefaultWhenKeyMissing(): void
    {
        $randomKey = 'NON_EXISTENT_KEY_' . uniqid();
        $this->assertSame('default_val', Env::get($randomKey, 'default_val'));
    }

    public function testGetParsesSpecialBooleanAndNullStrings(): void
    {
        putenv('TEST_BOOL_TRUE=true');
        putenv('TEST_BOOL_FALSE=false');
        putenv('TEST_VAL_NULL=null');
        putenv('TEST_VAL_EMPTY=empty');

        $_ENV['TEST_BOOL_TRUE'] = 'true';
        $_ENV['TEST_BOOL_FALSE'] = 'false';
        $_ENV['TEST_VAL_NULL'] = 'null';
        $_ENV['TEST_VAL_EMPTY'] = 'empty';

        $this->assertTrue(Env::get('TEST_BOOL_TRUE'));
        $this->assertFalse(Env::get('TEST_BOOL_FALSE'));
        $this->assertNull(Env::get('TEST_VAL_NULL'));
        $this->assertSame('', Env::get('TEST_VAL_EMPTY'));
    }

    public function testEnvLoadsExampleConfig(): void
    {
        $exampleFile = ROOT_PATH . '/.env.example';
        if (file_exists($exampleFile)) {
            Env::load($exampleFile);
            $currency = Env::get('PAYSTACK_CURRENCY');
            $this->assertSame('NGN', $currency);
        } else {
            $this->markTestSkipped('.env.example not found');
        }
    }
}

