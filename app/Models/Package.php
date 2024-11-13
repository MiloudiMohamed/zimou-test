<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Package extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            $model->tracking_code = 'ZE-'.Str::random(10);
            $model->uuid = (string) Str::uuid();
            $model->status_id = PackageStatus::pending()->first()->getKey();
        });
    }

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
}
