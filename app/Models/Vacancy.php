<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vacancy extends Model
{
    public $timestamps = true;
    protected $with = ['staff_request'];
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

    public function selection(): HasMany
    {
        return $this->hasMany (Selections::class, 'vac_id', 'id');
    }

    public function countApplicantsByType($type): int
    {
        return $this->selection()->where('type_test_id', $type)->count('applicant_id');
    }


}
