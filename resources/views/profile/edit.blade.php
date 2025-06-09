@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-200 leading-tight">
        {{ __('Perfil') }}
    </h2>
@endsection

@section('content')
    <div class="space-y-6">

        {{-- Sección: Información de perfil --}}
        <div class="p-4 sm:p-6 bg-gray-800 shadow sm:rounded-lg text-gray-100">
            <div class="max-w-xl space-y-4">
                <h3 class="text-lg font-semibold">{{ __('Información del Perfil') }}</h3>
                <p class="text-sm text-gray-400">
                    {{ __("Actualiza la información de tu perfil y la dirección de correo electrónico.") }}
                </p>
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Sección: Actualizar contraseña --}}
        <div class="p-4 sm:p-6 bg-gray-800 shadow sm:rounded-lg text-gray-100">
            <div class="max-w-xl space-y-4">
                <h3 class="text-lg font-semibold">{{ __('Actualizar Contraseña') }}</h3>
                <p class="text-sm text-gray-400">
                    {{ __("Asegúrate de que tu cuenta utilice una contraseña larga y aleatoria para mantenerse segura.") }}
                </p>
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Sección: Eliminar cuenta --}}
        <div class="p-4 sm:p-6 bg-gray-800 shadow sm:rounded-lg text-gray-100">
            <div class="max-w-xl space-y-4">
                <h3 class="text-lg font-semibold">{{ __('Eliminar Cuenta') }}</h3>
                <p class="text-sm text-gray-400">
                    {{ __("Elimina tu cuenta de forma permanente.") }}
                </p>
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection
