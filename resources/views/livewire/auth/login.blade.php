<div class="max-w-lg mx-auto">
    <x-slot:title>Login</x-slot:title>

    <x-card
        shadow
        title="Login"
        subtitle="Welcome back!"
    >
        <x-form method="post" action="{{ route('login.store') }}">
            @csrf
            <x-input
                label="Email"
                name="email"
                type="email"
                wire:model="email"
                :value="old('email')"
                required
            />

            <x-input
                label="Password"
                name="password"
                type="password"
                required
            />

            <div class="mt-2">
                <x-checkbox label="Remember me" name="remember" />
            </div>

            <x-slot:actions>
                <div class="flex flex-col w-full">
                    <x-button
                        label="Login"
                        class="btn-primary"
                        type="submit"
                        spinner="submit"
                    />
                    <hr>
                    <div class="text-sm mt-2">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-primary">Register</a>
                    </div>
                </div>
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
