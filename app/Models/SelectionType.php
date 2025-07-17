<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SelectionType extends Model
{

    public function selection(): HasMany
    {
        return $this->hasMany (Selections::class, 'type_test_id');
    }
}
