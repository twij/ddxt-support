<?php

namespace Ddxt\Support\Tests;

use Ddxt\Support\SupportServiceProvider;
use Ddxt\Support\Tests\Examples\Repository\RepositoryServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
  public function setUp(): void
  {
    parent::setUp();
    // additional setup
  }

  protected function getPackageProviders($app)
  {
    return [
        SupportServiceProvider::class,
        RepositoryServiceProvider::class
    ];
  }

  protected function getEnvironmentSetUp($app)
  {
    // perform environment setup
  }
}
