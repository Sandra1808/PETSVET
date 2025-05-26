<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pet's Vet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
            background: #A7D7C5 !important;
        }
        .custom-header {
            background: #FFE5D0;
            padding: 35px 0 20px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 12px #0001;
        }
        .logo {
            height: 90px;
            margin-left: 30px;
        }
        .header-buttons {
            display: flex;
            gap: 10px;
        }
        .btn-nav {
            background: #FFA500;
            color: #333;
            border: none;
            border-radius: 20px;
            padding: 8px 18px;
            margin: 0 5px;
            font-weight: bold;
        }
        .btn-welcome {
            background: #F7A6A6;
            color: #333;
            border: none;
            border-radius: 20px;
            padding: 10px 30px;
            font-weight: bold;
            margin-right: 30px;
        }
        .main-content {
            flex: 1 0 auto;
            background: #A7D7C5;
            padding: 0 0 30px 0;
        }
        
        .footer-contacto {
            background: #FFE5D0;
            border-top: 2px solid #FFA500;
            border-bottom: 2px solid #FFA500;
            box-shadow: 0 -2px 8px #0001;
            position: relative;
            width: 95%;
            flex-shrink: 0;
            border-radius: 24px;
            margin: 32px auto 16px auto;
        }
        .footer-links a {
            color: #FFA500;
            font-weight: bold;
            margin: 0 12px;
            text-decoration: none;
            transition: color 0.2s;
            font-size: 1.08em;
        }
        .footer-links a:hover {
            color: #F77F00;
            text-decoration: underline;
        }
        .footer-contacto-info {
            font-size: 1.1em;
            color: #333;
            text-align: center;
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <div class="custom-header">
        <img src="<?php echo e(asset('img/logo.png')); ?>" alt="Logo" class="logo">
        <?php if(!Auth::check()): ?>
        <div class="header-buttons">
            <a href="<?php echo e(url('/')); ?>" class="btn-nav">Inicio</a>
            <a href="<?php echo e(route('servicios')); ?>" class="btn-nav">Servicios</a>
            <a href="<?php echo e(route('contacto')); ?>" class="btn-nav">Contacto</a>
        </div>
        <?php endif; ?>
        <div class="d-flex align-items-center" style="margin-right: 30px;">
            <?php if(Auth::check()): ?>
                <div class="dropdown">
                    <button class="btn btn-welcome dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo e(Auth::user()->name); ?>

                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('profile.edit')); ?>">Mi perfil</a>
                        </li>
                        <li>
                            <a href="#" class="dropdown-item text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar sesión</a>
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                <?php echo csrf_field(); ?>
                            </form>
                        </li>
                    </ul>
                </div>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="btn btn-welcome">Inicia sesión / Registro</a>
            <?php endif; ?>
        </div>
    </div>

    <?php if(Auth::check()): ?>
        <?php if(Auth::user()->isAdmin()): ?>
            <?php echo $__env->make('components.admin-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php elseif(Auth::user()->isVeterinario()): ?>
            <?php echo $__env->make('components.veterinario-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php else: ?>
            <?php if(!request()->routeIs('home')): ?>
                <?php echo $__env->make('components.user-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>

    <div class="main-content  align-items-center justify-content-center">
        <div class="main-content-box w-100">
            
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById('verPwModal');
        if (modal) {
            modal.addEventListener('shown.bs.modal', function () {
                var input = modal.querySelector('input[name=\'admin_password\']');
                if(input) input.focus();
            });
        }
    });
    </script>
    <script>
    function activarPestanaAdmin(tab) {
        var tabTrigger = document.querySelector('button[data-bs-target="#' + tab + '"]');
        if(tabTrigger) {
            tabTrigger.click();
        } else {
            // Si no hay botón, activar la pestaña manualmente (Bootstrap 5)
            var tabLink = document.querySelector('a[href="#' + tab + '"]');
            if(tabLink) {
                var tabInstance = new bootstrap.Tab(tabLink);
                tabInstance.show();
            }
        }
    }
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>

    <?php if(Auth::check()): ?>
    <footer class="footer-contacto mt-5">
        <div class="container py-3">
            <div class="row align-items-center justify-content-center text-center">
                <div class="col-12 col-md-6 mb-2 mb-md-0 d-flex flex-column align-items-center">
                    <div class="footer-contacto-info">
                        <strong>Dirección:</strong> Calle Ejemplo, Nº 0, Ciudad Ficticia<br>
                        <strong>Teléfono:</strong> 999 999 999<br>
                        <strong>Correo Electrónico:</strong> contacto@petsvet.fake
                    </div>
                </div>
                <div class="col-12 col-md-6 d-flex flex-column align-items-center">
                    <div class="footer-contacto-info">
                        <strong>Horario de la Clínica:</strong><br>
                        Lunes a Viernes: 00:00 - 00:00<br>
                        Sábados: 00:00 - 00:00<br>
                        Domingos cerrado
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <?php endif; ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\petsvet\resources\views/layouts/app.blade.php ENDPATH**/ ?>