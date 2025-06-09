<x-guest-layout>
    <!-- Contenedor principal -->
    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg">
        <!-- Título -->
        <h2 class="text-2xl font-bold text-center mb-6 text-cyan-600">
            {{ __('Restablecer Contraseña') }}
        </h2>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Token de restablecimiento de contraseña -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Correo Electrónico -->
            <div>
                <x-input-label for="email" :value="__('Correo Electrónico')" />
                <x-text-input id="email" 
                              class="block mt-1 w-full p-3 border border-cyan-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500" 
                              type="email" name="email" 
                              :value="old('email', $request->email)" 
                              required autofocus autocomplete="username" 
                              placeholder="ejemplo@correo.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Nueva Contraseña -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Nueva Contraseña')" />
                <x-text-input id="password" 
                              class="block mt-1 w-full p-3 border border-cyan-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500" 
                              type="password" name="password" 
                              required autocomplete="new-password" 
                              placeholder="Mínimo 8 caracteres con letras, números y símbolos" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirmar Contraseña -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                <x-text-input id="password_confirmation" 
                              class="block mt-1 w-full p-3 border border-cyan-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500" 
                              type="password" name="password_confirmation" 
                              required autocomplete="new-password" 
                              placeholder="Repite la nueva contraseña" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Botón de envío -->
            <div class="flex justify-between mt-6">
                <a href="{{ route('login') }}" class="text-sm text-cyan-600 hover:text-cyan-800 font-medium">
                    {{ __('Volver al inicio de sesión') }}
                </a>

                <x-primary-button class="bg-cyan-600 text-white py-2 px-4 rounded-md hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    {{ __('Restablecer') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
