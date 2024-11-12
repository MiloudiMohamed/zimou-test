<?php

namespace App\Jobs;

use App\Models\Package;
use App\Models\User;
use App\Notifications\ExportReadyNotification;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ExportPackages implements ShouldBeUnique, ShouldQueue
{
    use Queueable;

    public $tries = 5;

    public $timeout = 600;

    public function __construct(public User $user)
    {
        //
    }

    public function handle(): void
    {
        $filename = storage_path('app/exports/packages '.now()->format('Y-m-d hi').'-'.Str::random(10).'.csv');

        $handle = fopen($filename, 'w');

        $headers = [
            'Tracking Code', 'Store', 'Package name', 'Status',
            'Client', 'Phone', 'Wilaya', 'Commune', 'Delivery Type',
        ];

        fputcsv($handle, $headers);

        $this->buildQuery()
            ->chunk(50_000, (function (Collection $packages) use ($handle) {
                foreach ($packages as $package) {
                    fputcsv($handle, [
                        $package['tracking_code'],
                        $package['store'],
                        $package['name'],
                        $package['status'],
                        $package['client_last_name'].' '.$package['client_first_name'],
                        $package['client_phone'],
                        $package['wilaya'],
                        $package['commune'],
                        $package['delivery_type'],
                    ]);
                }
            }));

        fclose($handle);

        $this->user->notify(new ExportReadyNotification($filename));
    }

    protected function buildQuery(): Builder
    {
        return Package::query()
            ->join('stores', 'packages.store_id', 'stores.id')
            ->join('package_statuses', 'packages.status_id', 'package_statuses.id')
            ->join('delivery_types', 'packages.delivery_type_id', 'delivery_types.id')
            ->join('communes', 'packages.commune_id', 'communes.id')
            ->join('wilayas', 'communes.wilaya_id', 'wilayas.id')
            ->select([
                'packages.id', 'packages.tracking_code', 'packages.name', 'packages.client_phone',
                'packages.client_last_name', 'packages.client_first_name',
                'stores.name as store',
                'package_statuses.name as status',
                'delivery_types.name as delivery_type',
                'communes.name as commune',
                'wilayas.name as wilaya',
            ]);
    }

    public function uniqueId(): string
    {
        return 'export-packages:'.$this->user->id;
    }
}
