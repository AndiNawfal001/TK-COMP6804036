<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StaffRequest extends Model
{

    use HasFactory;

    protected $with = ['user_request', 'position', 'app_by'];

    protected $guarded = [
        'id'
    ];

    public function scopeFilter(Builder $query): void
    {
        if (request('search')) {
            $query->where(function ($q) {
                $q->where('number', 'like', '%' . request('search') . '%')
                    ->orWhere('title', 'like', '%' . request('search') . '%');
            });
        }

        if (request('position')) {
            $query->where('position_id', '=', request('position'));
        }

        if (request('status')) {
            $query->where('app_status', '=', request('status'));
        }
    }

    public static function generateNumber()
    {
        $lastNumber = self::orderBy('id', 'desc')->first();

        if (!$lastNumber) {
            $number = 1;
        } else {
            $number = (int) substr($lastNumber->number, 4) + 1;
        }

        return 'STRQ' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }



    public function user_request(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'position_id', 'id');
    }

    public function app_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'app_by', 'id');
    }

    public function vacancy(): HasMany
    {
        return $this->hasMany(Vacancy::class, 'request_id', 'id');
    }
}
