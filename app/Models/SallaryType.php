<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SallaryType extends Model
{
    public function vacancy(): HasMany
    {
        return $this->hasMany (Vacancy::class, 'sallary_id');
    }
}
