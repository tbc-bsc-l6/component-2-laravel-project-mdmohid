<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enrollment extends Model
{
  use HasFactory;

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

  public function student()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function module()
  {
    return $this->belongsTo(Module::class);
  }
}
