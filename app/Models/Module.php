<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Module extends Model
{
  use HasFactory;

  protected $fillable = [
    'module',
    'active',
    'teacher_id',
    'teacher_name',
    'slug'
  ];

  protected $casts = [
    'active' => 'boolean',
  ];


  //relationships
  public function teacher()
  {
    return $this->belongsTo(User::class, 'teacher_id');
  }

  public function enrollments()
  {
    return $this->hasMany(Enrollment::class);
  }

  public function activeStudents()
  {
    return $this->enrollments()->whereNull('completed_at');
  }

  public function isFull()
  {
    return $this->activeStudents()->count() >= 10;
  }

  //automatically generate the slug
  protected static function booted()
  {
    static::creating(function ($module) {
      $module->slug = \Illuminate\Support\Str::slug($module->module);
    });
  }
}
