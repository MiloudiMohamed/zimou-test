<?php

use App\Exports\PackagesExport;
use App\Livewire\ListPackages;
use App\Models\Package;
use Database\Seeders\PackageStatusSeeder;
use Livewire\Livewire;
use Maatwebsite\Excel\Facades\Excel;

it('exports packages', function () {
    $this->seed(PackageStatusSeeder::class);

    Excel::fake();

    Package::factory(5)->create();

    Livewire::test(ListPackages::class)
        ->call('export')
        ->assertHasNoErrors();

    $filename = 'packages-'.now()->format('Y-m-d hi').'.csv';

    Excel::assertDownloaded($filename, function (PackagesExport $export) {
        expect($export->collection()->count())->toEqual(5);

        $excelHeadings = $export->headings();

        expect($excelHeadings)->toEqual([
            'Tracking Code', 'Store', 'Package name',
            'Status', 'Client', 'Phone', 'Wilaya',
            'Commune', 'Delivery Type',
        ]);

        $packageColumns = array_keys($export->collection()->first()->toArray());

        expect($packageColumns)->toEqual([
            'tracking_code', 'name', 'client_first_name', 'client_last_name',
            'client_phone', 'store_id', 'status_id', 'delivery_type_id', 'commune_id',
            'store', 'status', 'delivery_type', 'commune',
        ]);

        return true;
    });
});
