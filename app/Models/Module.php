<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'module',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

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

}

