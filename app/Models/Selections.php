<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Selections extends Model
{

    protected $with = ['vacancy', 'applicant', 'type', 'approve_by'];
    protected $guarded = [
        'id'
    ];
    public function vacancy(): BelongsTo
    {
        return $this->belongsTo(Vacancy::class, 'vac_id', 'id');
    }

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'applicant_id', 'id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(SelectionType::class, 'type_test_id', 'id');
    }

    public function approve_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'app_by', 'id');
    }

}
