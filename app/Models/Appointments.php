<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Appointments extends Model
{
    protected $with = ['vacancy', 'applicant'];
    protected $guarded = [
        'id'
    ];

    public function vacancy(): BelongsTo
    {
        return $this->belongsTo(Vacancy::class, 'vac_id', 'id');
    }


    public function applicant(): BelongsTo
    {
        return $this->belongsTo (User::class, 'applicant_id', 'id');
    }
}
