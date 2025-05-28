<div class="container my-4">  
    <div class="nav nav-tabs justify-content-center admin-tabs-float" id="adminTabNav" role="tablist">  
        <a href="{{ url('/admin#citas') }}" class="nav-link admin-btn-nav" id="btn-citas" role="tab">Citas</a>  
        <a href="{{ url('/admin#personal') }}" class="nav-link admin-btn-nav" id="btn-personal" role="tab">Personal</a>  
        <a href="{{ url('/admin#mascotas') }}" class="nav-link admin-btn-nav" id="btn-mascotas" role="tab">Mascotas</a>  
    </div>  
    <script>  
    document.addEventListener('DOMContentLoaded', function() {  
        // Forzar hash a #citas si no es válido  
        var validHashes = ['#citas', '#personal', '#mascotas'];  
        if (!validHashes.includes(window.location.hash)) {  
            window.location.hash = '#citas';  
        }  
        function activarPestanaAdmin() {  
            var hash = window.location.hash || '#citas';  
            document.querySelectorAll('.admin-btn-nav').forEach(btn => btn.classList.remove('active'));  
            if(hash === '#personal') {  
                document.getElementById('btn-personal').classList.add('active');  
            } else if(hash === '#mascotas') {  
                document.getElementById('btn-mascotas').classList.add('active');  
            } else {  
                document.getElementById('btn-citas').classList.add('active');  
            }  
            // Mostrar/ocultar secciones  
            document.querySelectorAll('.admin-tab-section').forEach(sec => sec.style.display = 'none');  
            var sec = document.querySelector(hash + '-section');  
            if(sec) sec.style.display = 'block';  
            // Inicializar calendario si estamos en Citas  
            if(hash === '#citas') {  
                if(typeof inicializarCalendarioAdmin === 'function') {  
                    if(window.adminCalendar) {  
                        setTimeout(function(){ window.adminCalendar.updateSize(); }, 100);  
                    } else {  
                        setTimeout(function(){ inicializarCalendarioAdmin(); }, 100);  
                    }  
                }  
            }  
        }  
        activarPestanaAdmin();  
        window.addEventListener('hashchange', activarPestanaAdmin);  
    });  
    </script>  
    <style>
        .admin-tabs-float {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            margin-bottom: 0 !important;
            gap: 2px;
            padding: 0;
        }
        .admin-btn-nav {
            border: none;
            background: #fff;
            color: #FFA500;
            border-radius: 24px;
            padding: 10px 32px;
            font-weight: bold;
            font-size: 1.1em;
            transition: box-shadow 0.2s, background 0.2s, color 0.2s, transform 0.2s;
            text-decoration: none;
            margin: 0 8px;
            box-shadow: 0 4px 16px #0002;
            position: relative;
            z-index: 2;
            display: inline-block;
        }
        .admin-btn-nav.active, .admin-btn-nav:focus, .admin-btn-nav[aria-selected="true"] {
            background: #FFA500;
            color: #fff;
            box-shadow: 0 8px 24px #FFA50033;
            transform: translateY(-4px) scale(1.04);
            border-radius: 24px 24px 24px 24px;
            border: 3px solid #FFA500;
            border-bottom: 3px solid #FFA500;
        }
        .admin-btn-nav:hover:not(.active) {
            background: #FFE5D0;
            color: #FFA500;
            box-shadow: 0 6px 20px #FFA50022;
            transform: translateY(-2px) scale(1.02);
        }
        .admin-tabs-underline {
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #FFA500 0%, #FFD580 100%);
            border-radius: 2px;
            margin-top: -8px;
            margin-bottom: 18px;
            box-shadow: 0 2px 8px #FFA50022;
        }
    </style>
</div>