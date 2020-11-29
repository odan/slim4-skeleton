<?php

namespace App\Test\TestCase;

use Slim\App;

/**
 * App Test Trait.
 */
trait AppTestTrait
{
    use ContainerTestTrait;
    use HttpTestTrait;
    use MockTestTrait;
    use SessionTestTrait;

    /**
     * @var App
     */
    protected $app;

    /**
     * Before each test.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->app = require __DIR__ . '/../../config/bootstrap.php';
        $this->setUpContainer();

        if (method_exists($this, 'setUpDatabase')) {
            $this->setUpDatabase();
        }
    }

    /**
     * After each test.
     */
    public function tearDown(): void
    {
        $this->tearDownSession();
    }
}
