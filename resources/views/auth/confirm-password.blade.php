<x-guest-layout>
    <!-- Mensaje de seguridad -->
    <div class="mb-6 text-sm text-gray-600 dark:text-gray-400 text-center">
        {{ __('Esta es un área segura de la aplicación. Por favor, confirma tu contraseña antes de continuar.') }}
    </div>

    <!-- Contenedor principal -->
    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg">
        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Contraseña -->
            <div>
                <x-input-label for="password" :value="__('Contraseña')" />
                <x-text-input id="password" class="block mt-1 w-full p-3 border border-cyan-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500"
                              type="password" name="password" required autocomplete="current-password"
                              pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$"
                              title="Debe tener al menos 8 caracteres, incluyendo una mayúscula, una minúscula, un número y un carácter especial." />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Botón de confirmación -->
            <div class="flex justify-end mt-6">
                <x-primary-button class="bg-cyan-600 text-white py-2 px-4 rounded-md hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    {{ __('Confirmar') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
