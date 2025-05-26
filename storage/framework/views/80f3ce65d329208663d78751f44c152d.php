<?php
    use App\Models\User;
    $personal = User::whereNotNull('codigo_personal')->get();
?>

<?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<?php if(session('pw_real') && session('pw_user_id')): ?>
    <div class="alert alert-info">
        <strong>Contraseña real del usuario:</strong> <?php echo e(session('pw_real')); ?>

    </div>
<?php endif; ?>

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
        <?php $__currentLoopData = $personal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($p->name); ?></td>
                <td><?php echo e($p->puesto); ?></td>
                <td><?php echo e($p->codigo_personal); ?></td>
                <td><?php echo e($p->email); ?></td>
                <td>
                    <input type="password" value="********" id="pw-<?php echo e($p->id); ?>" class="form-control d-inline-block" style="width:120px;" readonly>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#verPwModal" onclick="setUserIdPw(<?php echo e($p->id); ?>)">👁️</button>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
      <form method="POST" action="<?php echo e(route('admin.usuarios.verpw')); ?>">
        <?php echo csrf_field(); ?>
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
</script> <?php /**PATH C:\xampp\htdocs\petsvet\resources\views/admin/usuarios/tabla-personal.blade.php ENDPATH**/ ?>