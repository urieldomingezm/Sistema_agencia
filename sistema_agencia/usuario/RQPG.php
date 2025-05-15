

<!-- INFORMACION DE CONTENIDO DE REQUISITOS PARA PAGA -->
<meta name="keywords" content="Requisitos de paga, ascensos y misiones para los usuarios como tambien traslados">

<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php'); ?>


<section class="margenes">
    <ul class="nav nav-pills justify-content-center flex-wrap gap-2" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active p-2" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab">
                <div class="card border-0 bg-transparent">
                    <div class="card-body p-2 text-center">
                        <img src="/usuario/rangos/image/agt.png" alt="Agente" class="img-fluid mb-2" style="width: 30px; height: 30px;">
                    </div>
                </div>
            </button>
        </li>
        <!-- Repite el mismo patrón para los demás tabs -->
        <li class="nav-item flex-grow-1 text-center" role="presentation">
            <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                <div class="tab-content-container">
                    <img src="/usuario/rangos/image/supervisor.png" alt="Seguridad" class="tab-img">
                    <span class="tab-text"></span>
                </div>
            </button>
        </li>
        <li class="nav-item flex-grow-1 text-center" role="presentation">
            <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">
                <div class="tab-content-container">
                    <img src="/usuario/rangos/image/tec.png" alt="Tecnico" class="tab-img">
                    <span class="tab-text"></span>
                </div>
            </button>
        </li>
        <li class="nav-item flex-grow-1 text-center" role="presentation">
            <button class="nav-link w-100" id="logistica-tab" data-bs-toggle="tab" data-bs-target="#logistica-tab-pane" type="button" role="tab" aria-controls="logistica-tab-pane" aria-selected="false">
                <div class="tab-content-container">
                    <img src="/usuario/rangos/image/log.png" alt="Logistica" class="tab-img">
                    <span class="tab-text"></span>
                </div>
            </button>
        </li>
        <li class="nav-item flex-grow-1 text-center" role="presentation">
            <button class="nav-link w-100" id="supervisor-tab" data-bs-toggle="tab" data-bs-target="#supervisor-tab-pane" type="button" role="tab" aria-controls="supervisor-tab-pane" aria-selected="false">
                <div class="tab-content-container">
                    <img src="/usuario/rangos/image/seg.png" alt="Supervisor" class="tab-img">
                    <span class="tab-text"></span>
                </div>
            </button>
        </li>
        <li class="nav-item flex-grow-1 text-center" role="presentation">
            <button class="nav-link w-100" id="director-tab" data-bs-toggle="tab" data-bs-target="#director-tab-pane" type="button" role="tab" aria-controls="director-tab-pane" aria-selected="false">
                <div class="tab-content-container">
                    <img src="/usuario/rangos/image/director.png" alt="Director" class="tab-img">
                    <span class="tab-text"></span>
                </div>
            </button>
        </li>
        <li class="nav-item flex-grow-1 text-center" role="presentation">
            <button class="nav-link w-100" id="presidente-tab" data-bs-toggle="tab" data-bs-target="#presidente-tab-pane" type="button" role="tab" aria-controls="presidente-tab-pane" aria-selected="false">
                <div class="tab-content-container">
                    <img src="/usuario/rangos/image/presidente.png" alt="Presidente" class="tab-img">
                    <span class="tab-text"></span>
                </div>
            </button>
        </li>
        <li class="nav-item flex-grow-1 text-center" role="presentation">
            <button class="nav-link w-100" id="op-tab" data-bs-toggle="tab" data-bs-target="#op-tab-pane" type="button" role="tab" aria-controls="op-tab-pane" aria-selected="false">
                <div class="tab-content-container">
                    <img src="/usuario/rangos/image/ceo.png" alt="Operativo" class="tab-img">
                    <span class="tab-text"></span>
                </div>
            </button>
        </li>
        <li class="nav-item flex-grow-1 text-center" role="presentation">
            <button class="nav-link w-100" id="jtd-tab" data-bs-toggle="tab" data-bs-target="#jtd-tab-pane" type="button" role="tab" aria-controls="jtd-tab-pane" aria-selected="false">
                <div class="tab-content-container">
                    <img src="/usuario/rangos/image/jd.png" alt="JTD" class="tab-img">
                    <span class="tab-text"></span>
                </div>
            </button>
        </li>
    </ul>

    <!-- TAB DE CONTENIDO -->

    <div class="tab-content mt-4" id="myTabContent">
        
        <!-- TAB PARA AGENTES -->

        <? require_once(RANGOS_PATH.'agente.php');?>

        <!-- TAB PARA SEGURIDAD -->

        <? require_once(RANGOS_PATH . 'seguridad.php'); ?>

        <!-- TAB PARA TECNICOS -->

        <? require_once(RANGOS_PATH . 'tecnico.php'); ?>

        <!-- LOGISTICA -->

        <? require_once(RANGOS_PATH. 'logistica.php');?>

        <!-- SUPERVISOR -->

        <? require_once(RANGOS_PATH. 'supervisor.php');?>

        <!-- DIRECTOR -->

        <? require_once(RANGOS_PATH.'director.php');?>

        <!-- PRESIDENTE -->

        <? require_once(RANGOS_PATH.'presidente.php');?>

        <!-- OPERATIVO -->

        <? require_once(RANGOS_PATH.'operativo.php');?>

        <!-- JUNTA DIRECTIVA -->

        <? require_once(RANGOS_PATH.'junta_directiva.php');?>
    </div>
</section>

<style>
    .nav-pills {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 1rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .nav-pills .nav-item {
        flex: 0 0 auto;
        margin: 0.25rem;
    }

    .nav-pills .nav-link {
        border-radius: 12px;
        padding: 0.75rem;
        min-width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #6f42c1;  /* Fondo violeta */
        color: white;         /* Letras blancas */
        border: 1px solid #dee2e6;
        transition: all 0.3s ease;
    }

    .nav-pills .nav-link.active {
        background: rgba(0, 0, 0, 0.8);  /* Negro opaco para el tab activo */
        color: white;                   /* Letras blancas */
        transform: translateY(-2px);
    }

    .tab-content-container {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
    }

    .tab-img {
        width: 40px;
        height: 40px;
        object-fit: contain;
    }

    @media (max-width: 768px) {
        .nav-pills .nav-link {
            min-width: 70px;
            height: 70px;
            padding: 0.5rem;
        }

        .tab-img {
            width: 35px;
            height: 35px;
        }
    }

    @media (max-width: 576px) {
        .nav-pills .nav-link {
            min-width: 60px;
            height: 60px;
        }

        .tab-img {
            width: 30px;
            height: 30px;
        }
    }

    .nav-pills .nav-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .card {
        transition: all 0.3s ease;
    }

    @media (max-width: 768px) {
        .nav-pills {
            padding: 0.5rem;
        }

        .nav-pills .nav-item {
            width: auto;
        }

        .nav-pills .nav-link {
            padding: 0.5rem;
            min-width: 60px;
        }

        .card-body {
            padding: 0.5rem !important;
        }

        img {
            width: 30px !important;
            height: 30px !important;
        }
    }

    @media (max-width: 576px) {
        .nav-pills .nav-item {
            margin: 0.15rem;
        }

        .nav-pills .nav-link {
            min-width: 50px;
        }

        img {
            width: 25px !important;
            height: 25px !important;
        }
    }

    .margenes {
        margin: 10px 25px calc(18% + 20px);
    }

    /* Estilos para las tablas */
    .table {
        background-color: #ffffff;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
        border: none;
    }

    .table thead {
        background: linear-gradient(135deg, #4a6bff 0%, #2541b2 100%);
        color: white;
    }

    .table thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
        padding: 1.2rem 1rem;
        border: none;
        vertical-align: middle;
    }

    .table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f0f0f0;
    }

    .table tbody tr:hover {
        background-color: rgba(74, 107, 255, 0.05);
        transform: translateY(-2px);
    }

    .table tbody td {
        padding: 1rem;
        font-size: 0.95rem;
        color: #333;
        vertical-align: middle;
    }

    /* Estilos para texto dentro de las tablas */
    .table h4 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2541b2;
        margin-bottom: 0.5rem;
    }

    .table p {
        font-size: 0.95rem;
        color: #666;
        line-height: 1.5;
        margin-bottom: 0;
    }

    /* Estilos responsivos para las tablas */
    @media (max-width: 768px) {
        .table thead th {
            font-size: 0.8rem;
            padding: 1rem 0.8rem;
        }

        .table tbody td {
            font-size: 0.85rem;
            padding: 0.8rem;
        }

        .table h4 {
            font-size: 1rem;
        }

        .table p {
            font-size: 0.85rem;
        }
    }

    @media (max-width: 576px) {
        .table-responsive {
            margin: 0 -15px;
            width: calc(100% + 30px);
        }

        .table thead th {
            font-size: 0.75rem;
            padding: 0.8rem 0.6rem;
        }

        .table tbody td {
            font-size: 0.8rem;
            padding: 0.6rem;
        }
    }
</style>

