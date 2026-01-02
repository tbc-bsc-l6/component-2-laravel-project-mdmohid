<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class EnrollmentTest extends TestCase
{
  /** @test */
  public function it_can_remove_student()
  {
    $enrollment = new class {
      public $deleted = false;
      public function remove()
      {
        $this->deleted = true;
      }
    };

    $enrollment->remove();

    $this->assertTrue($enrollment->deleted);
  }
}
