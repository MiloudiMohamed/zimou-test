<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Package extends Model
{
    use HasFactory;

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(PackageStatus::class);
    }

    public function deliveryType(): BelongsTo
    {
        return $this->belongsTo(DeliveryType::class);
    }

    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class);
    }

    public function clientName(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->client_last_name} {$this->client_first_name}",
        );
    }

    public function scopePendingFirst(Builder $query, PackageStatus $status): Builder
    {
        return $query->orderByRaw('CASE WHEN status_id = ? THEN 0 ELSE 1 END', [$status->id]);
    }
}
