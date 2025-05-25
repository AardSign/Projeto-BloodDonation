<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            {{-- Nome --}}
            <div>
                <x-label for="name" value="{{ __('Nome') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            {{-- Email --}}
            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            {{-- Telefone --}}
            <div class="mt-4">
                <x-label for="phone" value="{{ __('Telefone') }}" />
                <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
            </div>

            {{-- Endereço --}}
            <div class="mt-4">
                <x-label for="address" value="{{ __('Endereço') }}" />
                <x-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required />
            </div>

            {{-- Data de Nascimento --}}
            <div class="mt-4">
                <x-label for="data_nascimento" value="{{ __('Data de Nascimento') }}" />
                <x-input id="data_nascimento" class="block mt-1 w-full" type="date" name="data_nascimento" :value="old('data_nascimento')" required />
            </div>

            {{-- Sexo --}}
            <div class="mt-4">
                <x-label for="sexo" value="{{ __('Sexo') }}" />
                <select id="sexo" name="sexo" required class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Selecione...</option>
                    <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                    <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Feminino</option>
                </select>
            </div>

            {{-- Tipo Sanguíneo --}}
            <div class="mt-4">
                <x-label for="blood_type" value="{{ __('Tipo Sanguíneo') }}" />
                <select id="blood_type" name="blood_type" required class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">Selecione...</option>
                    @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $tipo)
                        <option value="{{ $tipo }}" {{ old('blood_type') == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Senha --}}
            <div class="mt-4">
                <x-label for="password" value="{{ __('Senha') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            </div>

            {{-- Confirmar Senha --}}
            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirmar Senha') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
            </div>

            <div class="mt-4">
                <x-label for="image" value="{{ __('Foto de Perfil') }}" />
                <x-input id="image" class="block mt-1 w-full" type="file" name="image" accept="image/*" />
            </div>


            {{-- Termos de uso --}}
            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />
                            <div class="ml-2">
                                {!! __('Eu concordo com os :terms_of_service e :privacy_policy', [
                                    'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Termos de Serviço').'</a>',
                                    'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Política de Privacidade').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            {{-- Ação --}}
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Já tem uma conta?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Registrar-se') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

        <script>
        $(document).ready(function(){
            $('#phone').mask('(00) 00000-0000');
        });
        </script>

</x-guest-layout>
