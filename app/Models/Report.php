<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model
{
    protected $fillable = [
        'user_id',
        'area_id',
        'judul',
        'deskripsi',
        'latitude',
        'longitude',
        'waktu_kejadian',
        'bukti_path',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'waktu_kejadian' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ReportReview::class)->latest();
    }
}