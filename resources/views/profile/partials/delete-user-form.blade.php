<form method="post" action="{{ route('profile.destroy') }}" class="mt-4">
    @csrf
    @method('delete')
    <h4 class="mb-3" style="color:#FFA500;">Eliminar cuenta</h4>
    <hr>
    <div class="alert alert-danger" role="alert">
        <strong>¡Atención!</strong> Esta acción es <b>permanente</b> y no se puede deshacer. Todos tus datos serán eliminados definitivamente.
    </div>
    <div class="mb-3">
        <label for="password" class="form-label fw-bold">Contraseña</label>
        <input id="password" name="password" type="password" class="form-control" placeholder="Introduce tu contraseña para confirmar">
        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
    </div>
    <div class="mt-3">
        <button type="submit" class="btn btn-danger px-4 fw-bold rounded-3" style="color:#fff;">Borrar</button>
    </div>
</form>
