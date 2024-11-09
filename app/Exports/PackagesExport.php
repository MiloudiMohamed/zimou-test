<?php

namespace App\Exports;

use App\Models\Package;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PackagesExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    public function collection(): Collection
    {
        return Package::query()
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
            ->get();
    }

    public function map($row): array
    {
        return [
            $row->tracking_code,
            $row->store->name,
            $row->name,
            $row->status->name,
            $row->clientName,
            $row->client_phone,
            $row->commune->wilaya->name,
            $row->commune->name,
            $row->deliveryType->name,
        ];
    }

    public function headings(): array
    {
        return [
            'Tracking Code',
            'Store',
            'Package name',
            'Status',
            'Client',
            'Phone',
            'Wilaya',
            'Commune',
            'Delivery Type',
        ];
    }
}
