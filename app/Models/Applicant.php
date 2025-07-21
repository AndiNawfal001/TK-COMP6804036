<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Applicant extends Model
{

    protected $guarded = ['id'];

    public function last_edu(): BelongsTo
    {
        return $this->belongsTo(Education::class, 'last_edu', 'id');
    }

    public function religion(): BelongsTo
    {
        return $this->belongsTo(Religions::class, 'religion', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
