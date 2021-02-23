<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // prefix 'get' end with 'Attribut' turns it into an attribute with snake_case
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
