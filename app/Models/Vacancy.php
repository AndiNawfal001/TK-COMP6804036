<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vacancy extends Model
{
    public $timestamps = true;
    protected $with = ['staff_request', 'min_edu', 'sallary_id'];
    protected $guarded = [
        'id'
    ];

    public function staff_request(): BelongsTo
    {
        return $this->belongsTo(StaffRequest::class, 'request_id', 'id');
    }

    public function min_edu(): BelongsTo
    {
        return $this->belongsTo(Education::class, 'min_edu', 'id');
    }

    public function sallary_id(): BelongsTo
    {
        return $this->belongsTo(SallaryType::class, 'sallary_id', 'id');
    }


}
