<x-guest-layout>
    <!-- Contenedor principal con fondo blanco -->
    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg">
        <!-- Logo de JASS -->
        <div class="text-center mb-6">
            <img src="{{ asset('jass-unas.jpg') }}" alt="Logo del JASS" class="h-24 mx-auto">
        </div>

        <h2 class="text-2xl font-bold text-center mb-6 text-cyan-600">{{ __('Registrarse') }}</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nombre -->
            <div>
                <x-input-label for="name" :value="__('Nombre')" />
                <x-text-input id="name" class="block mt-1 w-full p-3 border border-cyan-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500"
                              type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Correo Electrónico -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Correo Electrónico')" />
                <x-text-input id="email" class="block mt-1 w-full p-3 border border-cyan-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500"
                              type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Contraseña -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Contraseña')" />
                <x-text-input id="password" class="block mt-1 w-full p-3 border border-cyan-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500"
                              type="password" name="password" required autocomplete="new-password"
                              pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$"
                              title="Debe tener al menos 8 caracteres, incluyendo una mayúscula, una minúscula, un número y un carácter especial." />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirmar Contraseña -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full p-3 border border-cyan-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500"
                              type="password" name="password_confirmation" required autocomplete="new-password"
                              pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$"
                              title="Debe tener al menos 8 caracteres, incluyendo una mayúscula, una minúscula, un número y un carácter especial." />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Enlace de inicio de sesión y botón de registro -->
            <div class="flex justify-between mt-4">
                <a class="text-sm text-cyan-600 hover:text-cyan-800" href="{{ route('login') }}">
                    {{ __('¿Ya tienes cuenta?') }}
                </a>

                <x-primary-button class="bg-cyan-600 text-white py-2 px-4 rounded-md hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    {{ __('Registrarse') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
