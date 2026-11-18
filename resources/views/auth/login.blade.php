<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-gray-800">Welcome Back!</h2>
        <p class="text-sm text-gray-500 mt-1">Please sign in to your account</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-medium" />
            <x-text-input id="email"
                class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                placeholder="Enter your email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="flex justify-between items-center">
                <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium" />
                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-emerald-600 hover:text-emerald-500 transition-colors"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password"
                class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-lg shadow-sm"
                type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between pt-2">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500 cursor-pointer"
                    name="remember">
                <span
                    class="ms-2 text-sm text-gray-600 group-hover:text-gray-900 transition-colors">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full flex justify-center items-center px-4 py-3 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md hover:shadow-lg">
                {{ __('Log in') }}
            </button>
        </div>

        <p class="text-center text-sm text-gray-600 mt-6">
            Don't have an account?
            <a href="{{ route('register') }}"
                class="font-medium text-emerald-600 hover:text-emerald-500 transition-colors">Sign up</a>
        </p>
    </form>
</x-guest-layout>