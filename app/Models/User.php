<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  /** @use HasFactory<\Database\Factories\UserFactory> */
  use HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var list<string>
   */
  protected $fillable = [
    'name',
    'email',
    'password',
    'user_role_id',
    'role' //user's role
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var list<string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }
  /**
   * Get the user role for the user.
   */
  public function userRole()
  {
    return $this->belongsTo(UserRole::class);
  }



  public function taughtModules()
  {
    return $this->hasMany(Module::class, 'teacher_id');
  }

  public function enrollments()
  {
    return $this->hasMany(Enrollment::class);
  }

  public function activeEnrollments()
  {
    return $this->enrollments()->whereNull('completed_at');
  }

  public function completedEnrollments()
  {
    return $this->enrollments()->whereNotNull('completed_at');
  }



  //Automatically set the 'role' column when 'user_role_id' is set.
  public static function boot()
  {
    parent::boot();

    static::saving(function ($user) {
      // If userRole relationship is loaded and role is not set
      if ($user->userRole && !$user->role) {
        $user->role = $user->userRole->role;
      }
    });
  }
}
