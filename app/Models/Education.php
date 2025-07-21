<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Education extends Model
{

    public function vacancy(): HasMany
    {
        return $this->hasMany (Vacancy::class, 'min_edu');
    }

    public function applicant(): HasMany
    {
        return $this->hasMany (Applicant::class, 'last_edu');
    }
}
