<div class="mb-24">
    <x-slot:title>Create a new package</x-slot:title>

    <x-form wire:submit.prevent="store" class="grid grid-cols-3">
        <div class="col-span-2 space-y-4">
            <x-card title="Basic information" shadow>
                <div class="space-y-4">
                    <x-choices
                        wire:model="form.store_id"
                        :options="$stores"
                        search-function="searchStores"
                        placeholder="Select a store"
                        single
                        searchable
                    />

                    <x-input
                        wire:model="form.name"
                        label="Package name"
                        inline
                    />

                    <div class="grid grid-cols-2 gap-4">
                        <x-input
                            wire:model="form.weight"
                            label="Weight"
                            inline
                            type="number"
                        />

                        <x-input
                            wire:model="form.extra_weight_price"
                            label="Extra weight price"
                            inline
                            type="number"
                        />
                    </div>
                </div>
            </x-card>

            <x-card title="Shipping information" shadow>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <x-input
                            wire:model="form.client_first_name"
                            label="First name*"
                            inline
                        />
                        <x-input
                            wire:model="form.client_last_name"
                            label="Last name*"
                            inline
                        />
                        <x-input
                            wire:model="form.client_phone"
                            label="Phone*"
                            inline
                        />
                        <x-input
                            wire:model="form.client_phone2"
                            label="2nd phone"
                            inline
                        />
                        <x-select
                            wire:model.live="wilayaId"
                            label="Wilayas*"
                            inline
                            placeholder="Select a wilaya"
                            :options="$wilayas"
                        />
                        <x-select
                            wire:model="form.commune_id"
                            label="Commune*"
                            inline
                            placeholder="Select a commune"
                            :options="$this->communes"
                        />
                        <div class="col-span-2">
                            <x-input
                                wire:model="form.address"
                                label="Address*"
                                inline
                            />
                        </div>
                    </div>
                </div>

            </x-card>
        </div>
        <div class="space-y-4">
            <x-card
                title="Pricing"
                shadow
                class="col-span-1"
            >
                <div class="grid grid-cols-2 gap-2">
                    <div class="col-span-2">
                        <x-input
                            wire:model="form.price"
                            label="Price"
                            type="number"
                            min="0"
                            inline
                        />
                    </div>
                    <x-input
                        wire:model="form.delivery_price"
                        label="Delivery price"
                        type="number"
                        min="0"
                        inline
                    />
                    <x-input
                        wire:model="form.packaging_price"
                        label="Packaging price"
                        type="number"
                        min="0"
                        inline
                    />
                    <x-input
                        wire:model="form.partner_cod_price"
                        label="Partner cod price"
                        type="number"
                        min="0"
                        inline
                    />
                    <x-input
                        wire:model="form.partner_delivery_price"
                        label="Partner delivery price"
                        type="number"
                        min="0"
                        inline
                    />
                    <x-input
                        wire:model="form.return_price"
                        label="Return price"
                        type="number"
                        min="0"
                        inline
                    />
                    <x-input
                        wire:model="form.partner_return"
                        label="Partner return"
                        type="number"
                        min="0"
                        inline
                    />
                    <x-input
                        wire:model="form.cod_to_pay"
                        label="Cod to pay"
                        type="number"
                        min="0"
                        inline
                    />
                    <x-input
                        wire:model="form.commission"
                        label="Commission"
                        type="number"
                        min="0"
                        inline
                    />
                </div>
            </x-card>

            <x-card
                title="Delivery"
                shadow
                class="col-span-1"
            >
                <div class="space-y-4">
                    <x-radio
                        wire:model="form.delivery_type_id"
                        :options="$deliveryTypes"
                        class="text-sm"
                    />
                    <x-toggle wire:model="form.free_delivery" label="Free delivery" />
                    <x-toggle wire:model="form.can_be_opened" label="Can be opened" />
                </div>
            </x-card>
        </div>

        <x-slot:actions>
            <x-button
                type="submit"
                link="{{ route('packages.index') }}"
                class="btn-ghost"
            >
                Cancel
            </x-button>
            <x-button type="submit" class="btn-primary">
                Create
            </x-button>
        </x-slot:actions>
    </x-form>
</div>
