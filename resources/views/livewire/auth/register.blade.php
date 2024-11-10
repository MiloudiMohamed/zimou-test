<div class="max-w-lg mx-auto">
    <x-slot:title>Registration</x-slot:title>
    <x-card
        shadow
        title="Registration"
        subtitle="Create an account to get started."
    >
        <x-form method="post" action="{{ route('register.store') }}">
            @csrf
            <x-input
                label="Name"
                name="name"
                type="text"
                wire:model="name"
                :value="old('name')"
                first-error-only
                required
            />

            <x-input
                label="Email"
                name="email"
                type="email"
                wire:model="email"
                :value="old('email')"
                first-error-only
                required
            />

            <x-input
                label="Password"
                name="password"
                type="password"
                wire:model="password"
                :value="old('password')"
                first-error-only
                required
            />

            <x-input
                label="Password Confirmation"
                name="password_confirmation"
                type="password"
                wire:model="password_confirmation"
                :value="old('password_confirmation')"
                first-error-only
                required
            />

            <x-slot:actions>
                <div class="flex flex-col w-full">
                    <x-button
                        label="Create an account"
                        class="btn-primary"
                        type="submit"
                        spinner="submit"
                    />

                    <div class="text-sm mt-2">
                        Already have an account?
                        <a href="{{ route('login') }}" class="text-primary">Login</a>
                    </div>
                </div>
            </x-slot:actions>

        </x-form>
    </x-card>
</div>
