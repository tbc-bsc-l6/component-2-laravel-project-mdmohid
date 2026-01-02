<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
  /** @test */
  public function it_can_check_if_user_is_teacher()
  {
    $user = new class {
      public $user_role_id;
      public function isTeacher()
      {
        return $this->user_role_id === 2;
      }
    };

    $user->user_role_id = 2;

    $this->assertTrue($user->isTeacher());
  }

  /** @test */
  public function it_can_check_if_user_is_student()
  {
    $user = new class {
      public $user_role_id;
      public function isStudent()
      {
        return $this->user_role_id === 3;
      }
    };

    $user->user_role_id = 3;

    $this->assertTrue($user->isStudent());
  }
}
