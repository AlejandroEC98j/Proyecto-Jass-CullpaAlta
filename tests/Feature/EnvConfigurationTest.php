<?php

namespace Tests\Feature;

use Tests\TestCase;

class EnvConfigurationTest extends TestCase
{
    public function test_env_configuracion_correcta()
    {
        $this->assertEquals(env('DB_DATABASE'), config('database.connections.mysql.database'));
        $this->assertEquals(env('APP_ENV'), config('app.env'));
        $this->assertNotEmpty(config('app.key'));
    }

}
