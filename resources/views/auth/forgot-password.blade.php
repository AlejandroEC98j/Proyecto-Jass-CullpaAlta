<x-guest-layout>
    <div class="text-center mb-6">
        <img src="{{ asset('jass-unas.jpg') }}" alt="Logo del JASS" class="h-24 mx-auto">
    </div>
    <!-- Mensaje informativo -->
    <div class="mb-6 text-center text-sm text-gray-600 dark:text-gray-400">
        {{ __('¿Olvidaste tu contraseña? No te preocupes. Ingresa tu correo electrónico y te enviaremos un enlace para restablecerla.') }}
    </div>

    <!-- Contenedor principal -->
    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg">
        <!-- Estado de la sesión -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Correo Electrónico -->
            <div>
                <x-input-label for="email" :value="__('Correo Electrónico')" />
                <x-text-input id="email" 
                              class="block mt-1 w-full p-3 border border-cyan-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500" 
                              type="email" name="email" :value="old('email')" required autofocus 
                              placeholder="ejemplo@correo.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Botones -->
            <div class="flex justify-between mt-6">
                @if (Route::has('login'))
                    <a class="text-sm text-cyan-600 hover:text-cyan-800" href="{{ route('login') }}">
                        {{ __('¿Recordaste tu contraseña?') }}
                    </a>
                @endif

                <x-primary-button class="bg-cyan-600 text-white py-2 px-4 rounded-md hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    {{ __('Enviar enlace') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
