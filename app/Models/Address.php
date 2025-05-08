<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
	protected $fillable = [
        'country',
        'city',
        'post_code',
        'street',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'address_id', 'id');
    }
}
