<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
  use CreatesApplication;
  // protected function setup(): void
  // {
  //   $this->withHeaders([
  //     'X-Requested-With' => 'XMLHttpRequest'
  //   ]);
  // }
}
