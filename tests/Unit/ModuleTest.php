<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Module;
//use Illuminate\Foundation\Testing\RefreshDatabase;

class ModuleTest extends TestCase
{
  //use RefreshDatabase;


  /** @test */
  public function it_toggles_active_flag()
  {
    $module = new class {
      public $active = true;
      public function toggleActive()
      {
        $this->active = !$this->active;
      }
    };

    $module->toggleActive();

    $this->assertFalse($module->active);
  }
}
