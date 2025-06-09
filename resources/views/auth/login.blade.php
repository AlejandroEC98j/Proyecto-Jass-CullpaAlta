<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="max-w-md mx-auto bg-white p-10 rounded-xl shadow-sm border border-gray-100">
        <!-- Encabezado elegante -->
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">JASS Chambara</h1>
            <p class="text-gray-600">{{ __('Acceso al sistema') }}</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-5">
                <x-input-label for="email" :value="__('Correo Electrónico')" class="mb-1 block text-sm font-medium text-gray-700" />
                <x-text-input id="email" 
                    class="block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-cyan-300 focus:border-transparent transition"
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autofocus 
                    autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-600" />
            </div>

            <!-- Password -->
            <div class="mb-5">
                <x-input-label for="password" :value="__('Contraseña')" class="mb-1 block text-sm font-medium text-gray-700" />
                <x-text-input id="password" 
                    class="block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-cyan-300 focus:border-transparent transition"
                    type="password" 
                    name="password" 
                    required 
                    autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-red-600" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-cyan-600 focus:ring-cyan-500 border-gray-300 rounded">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                        {{ __('Recordar sesión') }}
                    </label>
                </div>
                
                @if (Route::has('password.request'))
                    <a class="text-sm text-cyan-600 hover:text-cyan-800" href="{{ route('password.request') }}">
                        {{ __('¿Olvidó su contraseña?') }}
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-cyan-600 hover:bg-cyan-700 text-white font-medium py-3 px-4 rounded-lg shadow transition duration-200 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2">
                {{ __('Iniciar Sesión') }}
            </button>
        </form>

        <!-- Registration Link -->
        <div class="mt-8 text-center pt-6 border-t border-gray-100">
            <p class="text-sm text-gray-600">
                {{ __('¿No tiene una cuenta?') }}
                <a href="{{ route('register') }}" class="font-medium text-cyan-600 hover:text-cyan-700">
                    {{ __('Regístrese aquí') }}
                </a>
            </p>
        </div>
    </div>
</x-guest-layout>