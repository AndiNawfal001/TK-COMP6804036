<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Religions extends Model
{
    public function applicant(): HasMany
    {
        return $this->hasMany (Applicant::class, 'religion');
    }
}
