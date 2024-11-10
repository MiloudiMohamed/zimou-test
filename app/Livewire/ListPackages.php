<?php

namespace App\Livewire;

use App\Exports\PackagesExport;
use App\Models\Package;
use App\Models\PackageStatus;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Renderless;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ListPackages extends Component
{
    use WithPagination;

    #[Renderless]
    public function export(): BinaryFileResponse
    {
        $filename = 'packages-'.now()->format('Y-m-d hi').'.csv';

        return (new PackagesExport)->download($filename, Excel::CSV, [
            'Content-Type' => 'text/csv',
        ]);
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
