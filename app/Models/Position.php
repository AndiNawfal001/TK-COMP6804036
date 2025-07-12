<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    use HasFactory;
    public function staff_request(): HasMany
    {
        return $this->hasMany (StaffRequest::class, 'position_id');
    }
}
