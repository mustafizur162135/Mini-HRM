<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\AdminLogin;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, AdminLogin;
}