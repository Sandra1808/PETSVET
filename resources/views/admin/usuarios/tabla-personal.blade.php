@php
    use App\Models\User;
    $personal = User::whereNotNull('codigo_personal')->get();
@endphp

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('pw_real') && session('pw_user_id'))
    <div class="alert alert-info">
        <strong>Contraseña real del usuario:</strong> {{ session('pw_real') }}
    </div>
@endif

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Puesto</th>
            <th>Usuario</th>
            <th>Email</th>
            <th>Contraseña</th>
        </tr>
    </thead>
    <tbody>
        @foreach($personal as $p)
            <tr>
                <td>{{ $p->name }}</td>
                <td>{{ $p->puesto }}</td>
                <td>{{ $p->codigo_personal }}</td>
                <td>{{ $p->email }}</td>
                <td>
                    <input type="password" value="********" id="pw-{{ $p->id }}" class="form-control d-inline-block" style="width:120px;" readonly>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#verPwModal" onclick="setUserIdPw({{ $p->id }})">👁️</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal para ver contraseña real -->
<div class="modal fade" id="verPwModal" tabindex="-1" aria-labelledby="verPwModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verPwModalLabel">Ver contraseña de usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <form method="POST" action="{{ route('admin.usuarios.verpw') }}">
        @csrf
        <input type="hidden" name="user_id" id="userIdPw">
        <div class="modal-body">
          <div class="mb-3">
            <label>Introduce tu contraseña de administrador para ver la contraseña real:</label>
            <input type="password" name="admin_password" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Ver contraseña</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function setUserIdPw(id) {
    document.getElementById('userIdPw').value = id;
}
</script> 