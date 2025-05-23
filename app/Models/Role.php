<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
	use HasFactory;

    protected $fillable = ['role_name'];

    public function users() {
        return $this->belongsToMany(User::class);
    }

	public const ADMIN = 'ADMIN';
    public const USER = 'USER';
}
