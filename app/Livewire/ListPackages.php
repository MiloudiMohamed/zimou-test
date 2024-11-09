<?php

namespace App\Livewire;

use App\Models\Package;
use App\Models\PackageStatus;
use Illuminate\Contracts\Database\Query\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ListPackages extends Component
{
    use WithPagination;

    public function render()
    {
        $pendingStatus = PackageStatus::where('name', 'pending')->first();

        $packages = Package::query()
            ->select([
                'tracking_code', 'name', 'client_first_name', 'client_last_name',
                'client_phone', 'store_id', 'status_id', 'delivery_type_id', 'commune_id',
            ])
            ->with([
                'store:id,name',
                'status:id,name',
                'deliveryType:id,name',
                'commune' => fn (Builder $query) => $query
                    ->select(['id', 'wilaya_id', 'name'])
                    ->with(['wilaya:id,name']),
            ])
            ->pendingFirst($pendingStatus)
            ->oldest()
            ->paginate(25);

        return view('livewire.packages.index', [
            'packages' => $packages,
        ]);
    }
}
