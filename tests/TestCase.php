<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected $user;

    /**
     * Game on!
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(\App\User::class)->create();
    }

    /**
     * Game over!
     *
     * @return void
     */
    public function tearDown(): void
    {
        $this->user->delete();
        $this->user = null;
        parent::tearDown();
    }
}
