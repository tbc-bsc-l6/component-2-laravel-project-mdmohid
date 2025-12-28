<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
  protected $fillable = [
    'user_id',
    'module_id',
    'enrolled_at',
    'completed_at',
    'pass',
  ];

  protected $casts = [
    'pass' => 'boolean',
    'enrolled_at' => 'datetime',
    'completed_at' => 'datetime',
  ];

  // public function user()
  // {
  //   return $this->belongsTo(User::class);
  // }
  public function student()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function module()
  {
    return $this->belongsTo(Module::class);
  }
}
