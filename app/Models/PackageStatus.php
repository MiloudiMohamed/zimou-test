<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageStatus extends Model
{
    use HasFactory;

    public function scopePending(Builder $query): Builder
    {
        return $query->where('name', 'pending');
    }

    public function scopeAccepted(Builder $query): Builder
    {
        return $query->where('name', 'accepted');
    }

    public function scopeCanceled(Builder $query): Builder
    {
        return $query->where('name', 'cancelled');
    }

    public function getColor(): string
    {
        return match ($this->name) {
            'pending' => 'bg-yellow-200',
            'accepted' => 'bg-blue-200',
            'cancelled' => 'bg-rose-200',
            'shipped' => 'bg-sky-200',
            'delivered' => 'bg-green-200',
            'returned' => 'bg-zinc-200',
            'refunded' => 'bg-zinc-200',
            default => 'bg-gray-200'
        };
    }
}
