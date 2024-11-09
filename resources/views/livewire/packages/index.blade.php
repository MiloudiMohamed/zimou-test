<div>
    <x-header
        title="Packages list"
        separator
        progress-indicator
    >

        <x-slot:actions>
            <x-form wire:submit.prevent="export">
                <x-button
                    type="submit"
                    icon="o-arrow-down-tray"
                    class="btn-outline text-sm"
                >
                    Export Packages
                </x-button>
            </x-form>
        </x-slot:actions>
    </x-header>

    <x-card>
        <x-table
            :headers="[
                ['key' => 'tracking_code', 'label' => 'Tracking Code'],
                ['key' => 'store.name', 'label' => 'Store'],
                ['key' => 'name', 'label' => 'Package name'],
                ['key' => 'status.name', 'label' => 'Status'],
                ['key' => 'client_name', 'label' => 'Client'],
                ['key' => 'client_phone', 'label' => 'Phone'],
                ['key' => 'commune.wilaya.name', 'label' => 'Wilaya'],
                ['key' => 'commune.name', 'label' => 'Commune'],
                ['key' => 'deliveryType.name', 'label' => 'Delivery Type'],
            ]"
            :striped="true"
            :rows="$packages"
            :row-decoration="[
                'whitespace-nowrap' => fn() => true,
            ]"
            with-pagination
        >
            @scope('cell_status.name', $package)
                <x-badge :value="$package->status->name" class="text-xs {{ $package->status->getColor() }}" />
            @endscope
            @scope('cell_deliveryType.name', $package)
                <x-badge :value="$package->deliveryType->name" class="text-xs bg-gray-500/10" />
            @endscope

            <x-slot:empty>
                <x-icon name="o-cube" label="No packages." />
            </x-slot:empty>
        </x-table>
    </x-card>
</div>
