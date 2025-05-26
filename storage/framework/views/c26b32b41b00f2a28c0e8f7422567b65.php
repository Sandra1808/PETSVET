<div class="container my-4">
    <div class="nav nav-tabs justify-content-center admin-tabs-float" id="adminTabNav" role="tablist">
        <button class="nav-link admin-btn-nav active" id="tab-citas" data-bs-toggle="tab" data-bs-target="#citas" type="button" role="tab" aria-controls="citas" aria-selected="true">Citas</button>
        <button class="nav-link admin-btn-nav" id="tab-personal" data-bs-toggle="tab" data-bs-target="#personal" type="button" role="tab" aria-controls="personal" aria-selected="false">Personal</button>
        <button class="nav-link admin-btn-nav" id="tab-mascotas" data-bs-toggle="tab" data-bs-target="#mascotas" type="button" role="tab" aria-controls="mascotas" aria-selected="false">Mascotas</button>
    </div>

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
</div> <?php /**PATH C:\xampp\htdocs\petsvet\resources\views/components/admin-nav.blade.php ENDPATH**/ ?>