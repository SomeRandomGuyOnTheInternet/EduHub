<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $primaryKey = 'user_id';
    protected $fillable = ['first_name', 'last_name', 'email', 'date_of_birth', 'password', 'user_type', 'profile_picture'];

    protected $hidden = ['password', 'remember_token'];
    protected $appends = ['name'];

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public static function getUsersByType($type)
    {
        return self::where('user_type', $type)->get()->pluck('name', 'user_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'user_id');
    }
    
    public function teaches()
    {
        return $this->hasMany(Teaches::class, 'user_id');
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'enrollments', 'user_id', 'module_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'module_id', 'user_id');
    }

    public function isAdmin()
    {
        return $this->user_type === 'admin';
    }

    public function isProfessor()
    {
        return $this->user_type === 'professor';
    }

    public function isStudent()
    {
        return $this->user_type === 'student';
    }
}