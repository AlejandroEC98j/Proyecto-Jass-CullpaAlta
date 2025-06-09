<x-guest-layout>
    <!-- Contenedor principal -->
    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg">
        <!-- Mensaje inicial -->
        <p class="mb-4 text-sm text-gray-600 dark:text-gray-400 text-center">
            {{ __('¡Gracias por registrarte! Antes de comenzar, verifica tu dirección de correo electrónico haciendo clic en el enlace que te enviamos. Si no lo recibiste, podemos enviarlo nuevamente.') }}
        </p>

        <!-- Mensaje de estado (cuando se envía el enlace de verificación) -->
        @if (session('status') == 'verification-link-sent')
            <p class="mb-4 text-sm font-medium text-green-600 dark:text-green-400 text-center">
                {{ __('Hemos enviado un nuevo enlace de verificación a tu correo electrónico.') }}
            </p>
        @endif

        <!-- Formulario para reenviar el correo de verificación y cerrar sesión -->
        <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <!-- Botón para reenviar el enlace de verificación -->
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button class="bg-cyan-600 text-white py-2 px-4 rounded-md hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    {{ __('Reenviar correo de verificación') }}
                </x-primary-button>
            </form>

            <!-- Botón para cerrar sesión -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 font-medium underline focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 dark:focus:ring-offset-gray-800">
                    {{ __('Cerrar sesión') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
