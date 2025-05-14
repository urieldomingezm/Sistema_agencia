

<!-- INFORMACION DE CONTENIDO DE REQUISITOS PARA PAGA -->
<meta name="keywords" content="Requisitos de paga, ascensos y misiones para los usuarios como tambien traslados">

<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php'); ?>


<section class="margenes">
    <ul class="nav nav-pills justify-content-center flex-wrap gap-2" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active p-2" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab">
                <div class="card border-0 bg-transparent">
                    <div class="card-body p-2 text-center">
                        <img src="/public/assets/custom_general/custom_requisitos_rangos/image/agt.png" alt="Agente" class="img-fluid mb-2" style="width: 30px; height: 30px;">
                    </div>
                </div>
            </button>
        </li>
        <!-- Repite el mismo patrón para los demás tabs -->
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
                    <img src="/public/assets/custom_general/custom_requisitos_rangos/image/ceo.png" alt="Operativo" class="tab-img">
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

<link rel="stylesheet" href="/public/assets/custom_general/custom_requisitos_rangos/estilos_tabla.css">


