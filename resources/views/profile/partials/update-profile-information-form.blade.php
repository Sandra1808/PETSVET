<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Información personal') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Actualiza tu información personal y tu dirección de correo electrónico.") }}
        </p>
    </header>

    {{--
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
    --}}

    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        <h4 class="mb-3" style="color:#FFA500;">Información personal</h4>
        <hr>

        <div class="mb-3">
            <label for="name" class="form-label fw-bold">Nombre</label>
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>
        <div class="mb-3">
            <label for="email" class="form-label fw-bold">Email</label>
            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Haz click aquí para reenviar el enlace de verificación.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Un nuevo enlace de verificación ha sido enviado a tu dirección de correo electrónico.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
        <div class="mb-3">
            <label for="dni" class="form-label fw-bold">DNI</label>
            <input id="dni" name="dni" type="text" class="form-control" value="{{ old('dni', $user->dni) }}" required autocomplete="dni">
            <x-input-error class="mt-2" :messages="$errors->get('dni')" />
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label fw-bold">Dirección</label>
            <input id="direccion" name="direccion" type="text" class="form-control" value="{{ old('direccion', $user->direccion) }}" required autocomplete="direccion">
            <x-input-error class="mt-2" :messages="$errors->get('direccion')" />
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-warning px-4 fw-bold" style="background:#FFA500; color:#fff;">Guardar cambios</button>
        </div>
    </form>
</section>
