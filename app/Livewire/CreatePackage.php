<?php

namespace App\Livewire;

use App\Data\PackagePriceData;
use App\Models\Commune;
use App\Models\DeliveryType;
use App\Models\Package;
use App\Models\Store;
use App\Models\Wilaya;
use App\Support\PackagePriceCalculator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Mary\Traits\Toast;

class CreatePackage extends Component
{
    use Toast;

    public ?int $wilayaId = null;

    public Collection $stores;

    public array $form = [
        'store_id' => '',
        'name' => '',
        'client_first_name' => '',
        'client_last_name' => '',
        'client_phone' => '',
        'client_phone2' => '',
        'wilaya_id' => '',
        'commune_id' => '',
        'address' => '',
        'price' => '',
        'delivery_price' => '',
        'packaging_price' => 0,
        'partner_cod_price' => 0,
        'partner_delivery_price' => 0,
        'return_price' => 0,
        'price_to_pay' => '',
        'partner_return' => 0,
        'cod_to_pay' => 0,
        'commission' => 0,
        'weight' => 1000,
        'extra_weight_price' => '',
        'delivery_type_id' => '',
        'free_delivery' => false,
        'can_be_opened' => true,
    ];

    public function mount(): void
    {
        $this->searchStores();
    }

    public function store(): void
    {
        $validated = $this->validate();

        $data = new PackagePriceData(...[
            'price' => $this->form['price'],
            'delivery_price' => $this->form['delivery_price'],
            'packaging_price' => $this->form['packaging_price'],
            'partner_cod_price' => $this->form['partner_cod_price'],
            'partner_delivery_price' => $this->form['partner_delivery_price'],
            'return_price' => $this->form['return_price'],
            'partner_return' => $this->form['partner_return'],
            'cod_to_pay' => $this->form['cod_to_pay'],
            'commission' => $this->form['commission'],
            'extra_weight_price' => $this->form['extra_weight_price'],
            'free_delivery' => $this->form['free_delivery'],
        ]);

        $priceCalculator = new PackagePriceCalculator;

        $total = $priceCalculator->total($data);
        $subtotal = $priceCalculator->subtotal($data);

        Package::create(
            $validated['form'] + [
                'price_to_pay' => $subtotal,
                'total_price' => $total,
            ],
        );

        $this->success(
            title: 'Package created successfully',
            redirectTo: route('packages.index'),
        );
    }

    #[Computed()]
    public function communes(): Collection
    {
        return Commune::where('wilaya_id', $this->wilayaId)->get();
    }

    public function searchStores(string $search = ''): void
    {
        $this->stores = Store::query()
            ->select(columns: ['id', 'name'])
            ->where('name', 'like', "%{$search}%")
            ->orWhere('id', $this->form['store_id'])
            ->take(10)
            ->active()
            ->get();
    }

    public function render(): View
    {
        return view('livewire.packages.create', [
            'wilayas' => Wilaya::all(),
            'deliveryTypes' => DeliveryType::all(),
        ]);
    }

    protected function rules(): array
    {
        return [
            'form.store_id' => ['required', Rule::exists(Store::class, 'id')->where('status', true)],
            'form.name' => ['nullable', 'string', 'max:255'],
            'form.client_first_name' => ['required', 'string', 'max:255'],
            'form.client_last_name' => ['required', 'string', 'max:255'],
            'form.client_phone' => ['required', 'string', 'max:255'],
            'form.client_phone2' => ['nullable', 'string', 'max:255'],
            'form.wilaya_id' => ['exclude', 'required', Rule::exists(Wilaya::class, 'id')],
            'form.commune_id' => ['required', Rule::exists(Commune::class, 'id')],
            'form.address' => ['required', 'string', 'max:255'],
            'form.price' => ['required', 'numeric', 'min:0'],
            'form.delivery_price' => ['required', 'numeric', 'min:0'],
            'form.packaging_price' => ['required', 'numeric', 'min:0'],
            'form.partner_cod_price' => ['required', 'numeric', 'min:0'],
            'form.partner_delivery_price' => ['required', 'numeric', 'min:0'],
            'form.return_price' => ['required', 'numeric', 'min:0'],
            'form.partner_return' => ['required', 'numeric', 'min:0'],
            'form.cod_to_pay' => ['required', 'numeric', 'min:0'],
            'form.commission' => ['required', 'numeric', 'min:0'],
            'form.weight' => ['required', 'numeric', 'min:0'],
            'form.extra_weight_price' => ['required', 'numeric', 'min:0'],
            'form.delivery_type_id' => ['required', Rule::exists(DeliveryType::class, 'id')],
            'form.free_delivery' => ['required', 'boolean'],
            'form.can_be_opened' => ['required', 'boolean'],
        ];
    }

    protected function validationAttributes(): array
    {
        return [
            'form.store_id' => 'store',
            'form.name' => 'package name',
            'form.client_first_name' => 'first name',
            'form.client_last_name' => 'last name',
            'form.client_phone' => 'phone',
            'form.client_phone2' => '2nd phone',
            'form.wilaya_id' => 'wilaya',
            'form.commune_id' => 'commune',
            'form.address' => 'address',
            'form.price' => 'price',
            'form.delivery_price' => 'delivery price',
            'form.packaging_price' => 'packaging price',
            'form.partner_cod_price' => 'partner cod price',
            'form.partner_delivery_price' => 'partner delivery price',
            'form.return_price' => 'return price',
            'form.partner_return' => 'partner return price',
            'form.cod_to_pay' => 'cod to pay',
            'form.commission' => 'commission',
            'form.weight' => 'weight',
            'form.extra_weight_price' => 'extra weight price',
            'form.delivery_type_id' => 'delivery type',
            'form.free_delivery' => 'free delivery',
            'form.can_be_opened' => 'can be opened',
        ];
    }
}
