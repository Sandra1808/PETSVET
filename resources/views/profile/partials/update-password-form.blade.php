<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Cambiar contraseña') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Asegúrate de que tu cuenta esté usando una contraseña larga y aleatoria para mantenerla segura.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-4">
        @csrf
        @method('put')

        <h4 class="mb-3" style="color:#FFA500;">Cambiar contraseña</h4>
        <hr>

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label fw-bold">Contraseña actual</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label fw-bold">Nueva contraseña</label>
            <input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password">
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label fw-bold">Confirmar nueva contraseña</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-warning px-4 fw-bold" style="background:#FFA500; color:#fff;">Guardar contraseña</button>
        </div>
    </form>
</section>
