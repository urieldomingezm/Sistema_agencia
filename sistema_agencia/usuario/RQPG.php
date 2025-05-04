

<!-- INFORMACION DE CONTENIDO DE REQUISITOS PARA PAGA -->
<meta name="keywords" content="Requisitos de paga, ascensos y misiones para los usuarios como tambien traslados">

<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php'); ?>

<style>
.rank-tabs {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 2rem 0;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

.nav-pills .nav-link {
    border-radius: 12px;
    padding: 1rem;
    margin: 0.5rem;
    transition: all 0.3s ease;
    background: white;
    color: #333;
    border: 1px solid #dee2e6;
}

.nav-pills .nav-link.active {
    background: linear-gradient(135deg, #00c6fb 0%, #005bea 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.2);
}

.tab-content-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.tab-img {
    width: 50px;
    height: 50px;
    transition: transform 0.3s ease;
}

.nav-link:hover .tab-img {
    transform: scale(1.1);
}

.table {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
}

.table thead th {
    background: linear-gradient(135deg, #00c6fb 0%, #005bea 100%);
    color: white;
    font-weight: 500;
    border: none;
    padding: 1rem;
}

.table tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
}

.table td, .table th {
    vertical-align: middle;
    padding: 1rem;
    border-color: #f0f0f0;
}

.requirement-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s ease;
}

.requirement-card:hover {
    transform: translateY(-3px);
}

.requirement-title {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 1rem;
    position: relative;
    padding-bottom: 0.5rem;
}

.requirement-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 50px;
    height: 3px;
    background: linear-gradient(90deg, #00c6fb, #005bea);
    border-radius: 2px;
}

.icon-container {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0.5rem;
}

.icon-container img {
    width: 30px;
    height: 30px;
    transition: transform 0.3s ease;
}

.icon-container:hover img {
    transform: scale(1.1);
}

@media (max-width: 768px) {
    .nav-pills {
        flex-direction: column;
    }
    
    .nav-pills .nav-link {
        margin: 0.25rem;
    }
    
    .table-responsive {
        margin: 0 -1rem;
    }
}

.section-header {
    text-align: center;
    margin-bottom: 2rem;
    color: #2c3e50;
}

.section-header h4 {
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.mission-info {
    background: linear-gradient(135deg, #00c6fb 0%, #005bea 100%);
    color: white;
    padding: 1rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    text-align: center;
}

.mission-info h4 {
    margin: 0.5rem 0;
    font-size: 1.1rem;
}
</style>

<section class="margenes">
    <ul class="nav nav-pills justify-content-center flex-wrap" id="myTab" role="tablist">
        <li class="nav-item flex-grow-1 text-center" role="presentation">
            <button class="nav-link active w-100" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">
                <div class="tab-content-container">
                    <img src="/public/assets/custom_general/custom_requisitos_rangos/image/agt.png" alt="Agente" class="tab-img">
                    <span class="tab-text"></span>
                </div>
            </button>
        </li>
        <li class="nav-item flex-grow-1 text-center" role="presentation">
            <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                <div class="tab-content-container">
                    <img src="/public/assets/custom_general/custom_requisitos_rangos/image/supervisor.png" alt="Seguridad" class="tab-img">
                    <span class="tab-text"></span>
                </div>
            </button>
        </li>
        <li class="nav-item flex-grow-1 text-center" role="presentation">
            <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">
                <div class="tab-content-container">
                    <img src="/public/assets/custom_general/custom_requisitos_rangos/image/tec.png" alt="Tecnico" class="tab-img">
                    <span class="tab-text"></span>
                </div>
            </button>
        </li>
        <li class="nav-item flex-grow-1 text-center" role="presentation">
            <button class="nav-link w-100" id="logistica-tab" data-bs-toggle="tab" data-bs-target="#logistica-tab-pane" type="button" role="tab" aria-controls="logistica-tab-pane" aria-selected="false">
                <div class="tab-content-container">
                    <img src="/public/assets/custom_general/custom_requisitos_rangos/image/log.png" alt="Logistica" class="tab-img">
                    <span class="tab-text"></span>
                </div>
            </button>
        </li>
        <li class="nav-item flex-grow-1 text-center" role="presentation">
            <button class="nav-link w-100" id="supervisor-tab" data-bs-toggle="tab" data-bs-target="#supervisor-tab-pane" type="button" role="tab" aria-controls="supervisor-tab-pane" aria-selected="false">
                <div class="tab-content-container">
                    <img src="/public/assets/custom_general/custom_requisitos_rangos/image/seg.png" alt="Supervisor" class="tab-img">
                    <span class="tab-text"></span>
                </div>
            </button>
        </li>
        <li class="nav-item flex-grow-1 text-center" role="presentation">
            <button class="nav-link w-100" id="director-tab" data-bs-toggle="tab" data-bs-target="#director-tab-pane" type="button" role="tab" aria-controls="director-tab-pane" aria-selected="false">
                <div class="tab-content-container">
                    <img src="/public/assets/custom_general/custom_requisitos_rangos/image/director.png" alt="Director" class="tab-img">
                    <span class="tab-text"></span>
                </div>
            </button>
        </li>
        <li class="nav-item flex-grow-1 text-center" role="presentation">
            <button class="nav-link w-100" id="presidente-tab" data-bs-toggle="tab" data-bs-target="#presidente-tab-pane" type="button" role="tab" aria-controls="presidente-tab-pane" aria-selected="false">
                <div class="tab-content-container">
                    <img src="/public/assets/custom_general/custom_requisitos_rangos/image/presidente.png" alt="Presidente" class="tab-img">
                    <span class="tab-text"></span>
                </div>
            </button>
        </li>
        <li class="nav-item flex-grow-1 text-center" role="presentation">
            <button class="nav-link w-100" id="op-tab" data-bs-toggle="tab" data-bs-target="#op-tab-pane" type="button" role="tab" aria-controls="op-tab-pane" aria-selected="false">
                <div class="tab-content-container">
                    <img src="/public/assets/custom_general/custom_requisitos_rangos/image/op.png" alt="Operativo" class="tab-img">
                    <span class="tab-text"></span>
                </div>
            </button>
        </li>
        <li class="nav-item flex-grow-1 text-center" role="presentation">
            <button class="nav-link w-100" id="jtd-tab" data-bs-toggle="tab" data-bs-target="#jtd-tab-pane" type="button" role="tab" aria-controls="jtd-tab-pane" aria-selected="false">
                <div class="tab-content-container">
                    <img src="/public/assets/custom_general/custom_requisitos_rangos/image/jd.png" alt="JTD" class="tab-img">
                    <span class="tab-text"></span>
                </div>
            </button>
        </li>
    </ul>

    <!-- TAB DE CONTENIDO -->

    <div class="tab-content" id="myTabContent">
        
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
    .margenes {
        margin: 10px 25px 18%;
    }

    .tab-content-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .tab-img {
        width: 40px;
        height: 40px;
    }

    .tab-text {
        margin-top: 5px;
        font-size: 14px;
    }

    @media (max-width: 768px) {
        .nav-pills .nav-item {
            flex: 1 0 20%;
            max-width: 20%;
            text-align: center;
            margin-bottom: 10px;
        }

        .tab-content-container {
            flex-direction: row;
            justify-content: flex-start;
        }

        .tab-img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .tab-text {
            font-size: 12px;
            text-align: center;
        }
    }

    @media (max-width: 480px) {
        .nav-pills .nav-item {
            flex: 1 0 50%;
            max-width: 50%;
            text-align: center;
            margin-bottom: 10px;
        }

        .tab-img {
            width: 35px;
            height: 35px;
        }

        .tab-text {
            font-size: 11px;
        }
    }

    .table-responsive {
        overflow-x: hidden;
        display: block;
        width: 100%;
    }

    h4 {
        font-size: 16px;
    }

    p {
        font-size: 14px;
    }

    table {
        width: 100%;
    }

    th,
    td {
        padding: 8px;
        font-size: 12px;
    }
</style>