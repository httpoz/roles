<?php

namespace HttpOz\Roles\Tests\Feature;


use HttpOz\Roles\Tests\TestCase;
use HttpOz\Roles\Traits\HasRole;

class CachingTest extends TestCase
{
    public function testDefaultCachingConfig()
    {
        $config = config('roles.cache');

        config(['roles.cache.enabled' => true]);
        $updatedConfig = config('roles.cache');

        $this->assertFalse($config['enabled']);
        $this->assertTrue($updatedConfig['enabled']);
        $this->assertEquals(20160, $config['expiry']);
    }
}