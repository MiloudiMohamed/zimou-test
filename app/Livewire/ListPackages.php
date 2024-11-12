<?php

namespace App\Livewire;

use App\Jobs\ExportPackages;
use App\Models\Package;
use App\Models\PackageStatus;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ListPackages extends Component
{
    use Toast;
    use WithPagination;

    public function export()
    {
        ExportPackages::dispatch(Auth::user())->onQueue('exports');

        $this->success(
            title: 'Export has been started',
            description: 'Your export is being processed. we will email you when it is finished.',
            timeout: 10000,
        );
    }

    public function render(): View
    {
        $pendingStatus = PackageStatus::where('name', 'pending')->first();

        $packages = Package::query()
            ->select([
                'id', 'tracking_code', 'name', 'client_first_name', 'client_last_name',
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
