

<!-- INFORMACION DE CONTENIDO DE REQUISITOS PARA PAGA -->
<meta name="keywords" content="Requisitos de paga, ascensos y misiones para los usuarios como tambien traslados">

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
                    <img src="/public/custom/custom_requisitos_rangos/image/agt.png" alt="Agente" class="tab-img">
                    <span class="tab-text"></span>
                </div>
            </button>
        </li>
        <li class="nav-item flex-grow-1 text-center" role="presentation">
            <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                <div class="tab-content-container">
                    <img src="/public/custom/custom_requisitos_rangos/image/supervisor.png" alt="Seguridad" class="tab-img">
                    <span class="tab-text"></span>
                </div>
            </button>
        </li>
        <li class="nav-item flex-grow-1 text-center" role="presentation">
            <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">
                <div class="tab-content-container">
                    <img src="/public/custom/custom_requisitos_rangos/image/tec.png" alt="Tecnico" class="tab-img">
                    <span class="tab-text"></span>
                </div>
            </button>
        </li>
        <li class="nav-item flex-grow-1 text-center" role="presentation">
            <button class="nav-link w-100" id="logistica-tab" data-bs-toggle="tab" data-bs-target="#logistica-tab-pane" type="button" role="tab" aria-controls="logistica-tab-pane" aria-selected="false">
                <div class="tab-content-container">
                    <img src="/public/custom/custom_requisitos_rangos/image/log.png" alt="Logistica" class="tab-img">
                    <span class="tab-text"></span>
                </div>
            </button>
        </li>
        <li class="nav-item flex-grow-1 text-center" role="presentation">
            <button class="nav-link w-100" id="supervisor-tab" data-bs-toggle="tab" data-bs-target="#supervisor-tab-pane" type="button" role="tab" aria-controls="supervisor-tab-pane" aria-selected="false">
                <div class="tab-content-container">
                    <img src="/public/custom/custom_requisitos_rangos/image/seg.png" alt="Supervisor" class="tab-img">
                    <span class="tab-text"></span>
                </div>
            </button>
        </li>
        <li class="nav-item flex-grow-1 text-center" role="presentation">
            <button class="nav-link w-100" id="director-tab" data-bs-toggle="tab" data-bs-target="#director-tab-pane" type="button" role="tab" aria-controls="director-tab-pane" aria-selected="false">
                <div class="tab-content-container">
                    <img src="/public/custom/custom_requisitos_rangos/image/director.png" alt="Director" class="tab-img">
                    <span class="tab-text"></span>
                </div>
            </button>
        </li>
        <li class="nav-item flex-grow-1 text-center" role="presentation">
            <button class="nav-link w-100" id="presidente-tab" data-bs-toggle="tab" data-bs-target="#presidente-tab-pane" type="button" role="tab" aria-controls="presidente-tab-pane" aria-selected="false">
                <div class="tab-content-container">
                    <img src="/public/custom/custom_requisitos_rangos/image/presidente.png" alt="Presidente" class="tab-img">
                    <span class="tab-text"></span>
                </div>
            </button>
        </li>
        <li class="nav-item flex-grow-1 text-center" role="presentation">
            <button class="nav-link w-100" id="op-tab" data-bs-toggle="tab" data-bs-target="#op-tab-pane" type="button" role="tab" aria-controls="op-tab-pane" aria-selected="false">
                <div class="tab-content-container">
                    <img src="/public/custom/custom_requisitos_rangos/image/op.png" alt="Operativo" class="tab-img">
                    <span class="tab-text"></span>
                </div>
            </button>
        </li>
        <li class="nav-item flex-grow-1 text-center" role="presentation">
            <button class="nav-link w-100" id="jtd-tab" data-bs-toggle="tab" data-bs-target="#jtd-tab-pane" type="button" role="tab" aria-controls="jtd-tab-pane" aria-selected="false">
                <div class="tab-content-container">
                    <img src="/public/custom/custom_requisitos_rangos/image/jd.png" alt="JTD" class="tab-img">
                    <span class="tab-text"></span>
                </div>
            </button>
        </li>
    </ul>

    <!-- TAB DE CONTENIDO -->

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
            <br>
            <section class="margenes">
                <ul class="nav nav-pills mb-3 justify-content-center flex-wrap" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="misiones-tab" data-bs-toggle="pill" data-bs-target="#misiones" type="button" role="tab" aria-controls="misiones" aria-selected="true">MISIONES</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="misiones" role="tabpanel" aria-labelledby="misiones-tab" tabindex="0">
                        <h4>Ascienden cada 30 minutos</h4>
                        <p>Misiones: 4</p>
                        <div class="table-responsive">
                            <table class="table table-striped text-center table-bordered table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">Numero de misiones</th>
                                        <th scope="col">Nombre de Misión</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>SNY- Aspirante</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>SNY- Agente -I</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>SNY- Agente -II</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">4</th>
                                        <td>SNY- Agente -III</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- TAB PARA SEGURIDAD -->

        <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
            <br>

            <!-- SECTION DE SEGURIDAD -->

            <section class="margenes">
                <ul class="nav nav-pills mb-3 justify-content-center flex-wrap" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="misionesSEG-tab" data-bs-toggle="pill" data-bs-target="#misionesSEG" type="button" role="tab" aria-controls="misiones" aria-selected="true">MISIONES</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="requisitosSEG-tab" data-bs-toggle="pill" data-bs-target="#requisitosSEG" type="button" role="tab" aria-controls="requisitos" aria-selected="false">REQUISITOS</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pagaSEG-tab" data-bs-toggle="pill" data-bs-target="#pagaSEG" type="button" role="tab" aria-controls="paga" aria-selected="false">PAGA</button>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="misionesSEG" role="tabpanel" aria-labelledby="misionesSEG-tab" tabindex="0">
                        <h4>Ascienden cada 2 horas</h4>
                        <h4>Misiones: 9</h4>
                        <h4>Costo de traslado: Gratis</h4>
                        <div class="table-responsive">
                            <table class="table table-striped text-center table-bordered table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">Numero de misiones</th>
                                        <th scope="col">Nombre de Misión</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>SNY - SEGURIDAD VIII</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>SNY - SEGURIDAD VII
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>SNY - SEGURIDAD VI
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">4</th>
                                        <td>SNY - SEGURIDAD V </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">5</th>
                                        <td>SNY - SEGURIDAD IV </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">6</th>
                                        <td>SNY - SEGURIDAD III </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">7</th>
                                        <td>SNY - SEGURIDAD II </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">8</th>
                                        <td>SNY - SEGURIDAD I </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">9</th>
                                        <td>SNY - JEFE DE SEGURIDAD </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="requisitosSEG" role="tabpanel" aria-labelledby="requisitosSEG-tab" tabindex="0">
                        <h4>Requisitos de Paga</h4>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Nómina</th>
                                        <th scope="col">Bonificación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h4>4 horas</h4> <img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>2 horas</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h4>Requisitos de Paga con Reducción (Diamante y Premium)</h4>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Nómina</th>
                                        <th scope="col">Bonificación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h4>2 horas</h4><img src="/public/custom/custom_requisitos_rangos/image/membresias/silver.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/membresias/gold.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>1 horas</h4><img src="/public/custom/custom_requisitos_rangos/image/membresias/silver.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/membresias/gold.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pagaSEG" role="tabpanel" aria-labelledby="pagaSEG-tab" tabindex="0">
                        <h4>PAGA SEGURIDAD</h4>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Nómina</th>
                                        <th scope="col">Bonificación</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h4>15 c</h4> <img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>5</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>20</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- TAB PARA TECNICOS -->

        <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">

            <section class="margenes">
                <ul class="nav nav-pills mb-3 justify-content-center flex-wrap" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="misionesTEC-tab" data-bs-toggle="pill" data-bs-target="#misionesTEC" type="button" role="tab" aria-controls="misiones" aria-selected="true">MISIONES</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="requisitosTEC-tab" data-bs-toggle="pill" data-bs-target="#requisitosTEC" type="button" role="tab" aria-controls="requisitos" aria-selected="false">REQUISITOS</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pagaTEC-tab" data-bs-toggle="pill" data-bs-target="#pagaTEC" type="button" role="tabTEC" aria-controls="paga" aria-selected="false">PAGA</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="misionesTEC" role="tabpanel" aria-labelledby="misionesTEC-tab" tabindex="0">
                        <h4>Ascienden cada 12 horas</h4>
                        <h4>Misiones: 9</h4>
                        <h4>Costo de traslado: gratis</h4>
                        <div class="table-responsive">
                            <table class="table table-striped text-center table-bordered table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">Numero de misiones</th>
                                        <th scope="col">Nombre de Misión</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>SNY - TECNICO VIII</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>SNY - TECNICO VII
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>SNY - TECNICO VI
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">4</th>
                                        <td>SNY - TECNICO V </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">5</th>
                                        <td>SNY - TECNICO IV </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">6</th>
                                        <td>SNY - TECNICO III </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">7</th>
                                        <td>SNY - TECNICO II </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">8</th>
                                        <td>SNY - TECNICO I </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">9</th>
                                        <td>SNY - INSPECTOR DE TECNICO </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="tab-pane fade" id="requisitosTEC" role="tabpanel" aria-labelledby="requisitosTEC-tab" tabindex="0">
                        <h4>Requisitos de Paga tecnicos</h4>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped text-center table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Nómina</th>
                                        <th scope="col">Bonificación</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h4> 6 horas</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>2 horas</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>7 horas</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h4>Requisitos de Paga con Reducción (Diamante y Premium)</h4>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped text-center table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Nómina</th>
                                        <th scope="col">Bonificación</th>
                                        <th scope="col">Total de horas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h4>3 horas</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/membresias/gold.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/membresias/silver.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>1 horas</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/membresias/silver.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/membresias/gold.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>4 horas</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/membresias/silver.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/membresias/gold.png" alt="Icono" width="40">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>



                    <div class="tab-pane fade" id="pagaTEC" role="tabpanel" aria-labelledby="pagaTEC-tab" tabindex="0">
                        <h4>PAGA TECNICOS</h4>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Nómina</th>
                                        <th scope="col">Bonificación</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h4>17 creditos</h4> <img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>8 creditos</h4> <img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>25 creditos</h4> <img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

        </div>

        <!-- LOGISTICA -->

        <div class="tab-pane fade" id="logistica-tab-pane" role="tabpanel" aria-labelledby="logistica-tab" tabindex="0">

            <section class="margenes">
                <ul class="nav nav-pills mb-3 justify-content-center flex-wrap flex-column flex-md-row" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="misionesLOG-tab" data-bs-toggle="pill" data-bs-target="#misionesLOG" type="button" role="tab" aria-controls="misiones" aria-selected="true">MISIONES</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="requisitosLOG-tab" data-bs-toggle="pill" data-bs-target="#requisitosLOG" type="button" role="tab" aria-controls="requisitos" aria-selected="false">REQUISITOS</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pagaLOG-tab" data-bs-toggle="pill" data-bs-target="#pagaLOG" type="button" role="tab" aria-controls="paga" aria-selected="false">PAGA</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="misionesLOG" role="tabpanel" aria-labelledby="misionesLOG-tab" tabindex="0">
                        <h4>Ascienden cada 24 horas</h4>
                        <h4>Misiones: 9</h4>
                        <h4>Costo de traslado: Gratis</h4>
                        <div class="table-responsive">
                            <table class="table table-striped text-center table-bordered table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">Numero de misiones</th>
                                        <th scope="col">Nombre de Misión</th>
                                        <th scope="col">Costo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>SNY - LOGISTICA VIII</td>
                                        <td>40</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>SNY - LOGISTICA VII
                                        </td>
                                        <td>47</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>SNY - LOGISTICA VI
                                        </td>
                                        <td>54</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">4</th>
                                        <td>SNY - LOGISTICA V </td>
                                        <td>61</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">5</th>
                                        <td>SNY - LOGISTICA IV </td>
                                        <td>68</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">6</th>
                                        <td>SNY - LOGISTICA III </td>
                                        <td>75</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">7</th>
                                        <td>SNY - LOGISTICA II </td>
                                        <td>82</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">8</th>
                                        <td>SNY - LOGISTICA I </td>
                                        <td>89</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">9</th>
                                        <td>SNY - ING. LOGISTICO </td>
                                        <td>95</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="requisitosLOG" role="tabpanel" aria-labelledby="requisitosLOG-tab" tabindex="0">
                        <h4>Requisitos de Paga</h4>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Nómina</th>
                                        <th scope="col">Bonificación</th>
                                        <th scope="col">Total horas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h4>6 horas</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>3 horas</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>9 horas</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h4>Requisitos de Paga con Reducción (Diamante y Premium)</h4>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Nómina</th>
                                        <th scope="col">Bonificación</th>
                                        <th scope="col">Total de horas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h4>3 horas</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/membresias/gold.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/membresias/silver.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>1 hora con 30 minutos</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/membresias/gold.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/membresias/silver.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>4 hora con 30 minutos</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/membresias/gold.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/membresias/silver.png" alt="Icono" width="40">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pagaLOG" role="tabpanel" aria-labelledby="pagaLOG-tab" tabindex="0">
                        <h4>PAGA</h4>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Nómina</th>
                                        <th scope="col">Bonificación</th>
                                        <th scope="col">Total de creditos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h4>22 creditos</h4> <img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>8 creditos</h4> <img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>30 creditos</h4> <img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

        </div>

        <!-- SUPERVISOR -->

        <div class="tab-pane fade" id="supervisor-tab-pane" role="tabpanel" aria-labelledby="supervisor-tab" tabindex="0">

            <section class="margenes">
                <ul class="nav nav-pills mb-3 justify-content-center flex-wrap" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="misionesSUP-tab" data-bs-toggle="pill" data-bs-target="#misionesSUP" type="button" role="tab" aria-controls="misiones" aria-selected="true">MISIONES</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="requisitosSUP-tab" data-bs-toggle="pill" data-bs-target="#requisitosSUP" type="button" role="tab" aria-controls="requisitos" aria-selected="false">REQUISITOS</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pagaSUP-tab" data-bs-toggle="pill" data-bs-target="#pagaSUP" type="button" role="tab" aria-controls="paga" aria-selected="false">PAGA</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="misionesSUP" role="tabpanel" aria-labelledby="misionesSUP-tab" tabindex="0">
                        <h4>Ascienden cada 48 horas</h4>
                        <h4>Misiones: 9</h4>
                        <h4>Costo de traslado: </h4>
                        <div class="table-responsive">
                            <table class="table table-striped text-center table-bordered table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">Numero de misiones</th>
                                        <th scope="col">Nombre de Misión</th>
                                        <th scope="col">Costo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>SNY - SUPERVISOR VIII</td>
                                        <td>100</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>SNY - SUPERVISOR VII
                                        </td>
                                        <td>110</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>SNY - SUPERVISOR VI
                                        </td>
                                        <td>120</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">4</th>
                                        <td>SNY - SUPERVISOR V </td>
                                        <td>130</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">5</th>
                                        <td>SNY - SUPERVISOR IV </td>
                                        <td>145</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">6</th>
                                        <td>SNY - SUPERVISOR III </td>
                                        <td>160</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">7</th>
                                        <td>SNY - SUPERVISOR II </td>
                                        <td>175</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">8</th>
                                        <td>SNY - SUPERVISOR I </td>
                                        <td>190</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">9</th>
                                        <td>SNY - SUP. EJECUTIVO </td>
                                        <td>205</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="requisitosSUP" role="tabpanel" aria-labelledby="requisitosSUP-tab" tabindex="0">
                        <h4>Requisitos de Paga</h4>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Nómina</th>
                                        <th scope="col">Bonificación</th>
                                        <th scope="col">Total horas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h4>4 horas</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>4 horas</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>8 horas</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h4>Requisitos de Paga con Reducción (Diamante y Premium)</h4>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Nómina</th>
                                        <th scope="col">Bonificación</th>
                                        <th scope="col">Total de horas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h4>4 horas</h4><img src="/public/custom/custom_requisitos_rangos/image/membresias/silver.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/membresias/gold.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>2 horas</h4><img src="/public/custom/custom_requisitos_rangos/image/membresias/silver.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/membresias/gold.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>7 horas</h4><img src="/public/custom/custom_requisitos_rangos/image/membresias/gold.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/membresias/silver.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pagaSUP" role="tabpanel" aria-labelledby="pagaSUP-tab" tabindex="0">
                        <h4>PAGA SUPERVISOR</h4>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Nómina</th>
                                        <th scope="col">Bonificación</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h4>25 creditos</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>5 creditos</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>30 creditos</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

        </div>

        <!-- DIRECTOR -->

        <div class="tab-pane fade" id="director-tab-pane" role="tabpanel" aria-labelledby="director-tab" tabindex="0">

            <section class="margenes">
                <ul class="nav nav-pills mb-3 justify-content-center flex-wrap" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="misionesDIR-tab" data-bs-toggle="pill" data-bs-target="#misionesDIR" type="button" role="tab" aria-controls="misiones" aria-selected="true">MISIONES</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="requisitosDIR-tab" data-bs-toggle="pill" data-bs-target="#requisitosDIR" type="button" role="tab" aria-controls="requisitos" aria-selected="false">REQUISITOS</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pagaDIR-tab" data-bs-toggle="pill" data-bs-target="#pagaDIR" type="button" role="tab" aria-controls="paga" aria-selected="false">PAGA</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="misionesDIR" role="tabpanel" aria-labelledby="misionesDIR-tab" tabindex="0">
                        <h4>Ascienden cada 5 dias</h4>
                        <h4>Misiones: 9</h4>
                        <h4>Costo de traslado: Gratis</h4>
                        <div class="table-responsive">
                            <table class="table table-striped text-center table-bordered table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">Numero de misiones</th>
                                        <th scope="col">Nombre de Misión</th>
                                        <th scope="col">Costo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>SNY - DIRECTOR VIII</td>
                                        <td>295</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>SNY - DIRECTOR VII
                                        </td>
                                        <td>310</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>SNY - DIRECTOR VI
                                        </td>
                                        <td>325</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">4</th>
                                        <td>SNY - DIRECTOR V </td>
                                        <td>340</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">5</th>
                                        <td>SNY - DIRECTOR IV </td>
                                        <td>360</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">6</th>
                                        <td>SNY - DIRECTOR III </td>
                                        <td>380</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">8</th>
                                        <td>SNY - DIRECTOR II </td>
                                        <td>400</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">9</th>
                                        <td>SNY - DIRECTOR I </td>
                                        <td>420</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">10</th>
                                        <td>SNY - DIRECTOR SUPREMO </td>
                                        <td>440</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="requisitosDIR" role="tabpanel" aria-labelledby="requisitosDIR-tab" tabindex="0">
                        <h4>Requisitos de Paga</h4>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Nómina</th>
                                        <th scope="col">Bonificación</th>
                                        <th scope="col">Total de ascenso</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h4>10 ascensos</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>5 acensos</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>15 ascensos</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h4>Requisitos de Paga con Reducción (Diamante y Premium)</h4>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Nómina</th>
                                        <th scope="col">Bonificación</th>
                                        <th scope="col">Total ascensos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h4>15 ascensos</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/membresias/silver.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/membresias/gold.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>10 ascensos</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/membresias/silver.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/membresias/gold.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>35 ascensos</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/membresias/silver.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/membresias/gold.png" alt="Icono" width="40">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pagaDIR" role="tabpanel" aria-labelledby="pagaDIR-tab" tabindex="0">
                        <h4>PAGA</h4>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Nómina</th>
                                        <th scope="col">Bonificación</th>
                                        <th scope="col">Total de creditos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h4>10 creditos</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>20 creditos</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>30 creditos</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

        </div>

        <!-- PRESIDENTE -->

        <div class="tab-pane fade" id="presidente-tab-pane" role="tabpanel" aria-labelledby="presidente-tab" tabindex="0">

            <section class="margenes">
                <ul class="nav nav-pills mb-3 justify-content-center flex-wrap" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="misionesPRE-tab" data-bs-toggle="pill" data-bs-target="#misionesPRE" type="button" role="tab" aria-controls="misiones" aria-selected="true">MISIONES</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="requisitosPRE-tab" data-bs-toggle="pill" data-bs-target="#requisitosPRE" type="button" role="tab" aria-controls="requisitos" aria-selected="false">REQUISITOS</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pagaPRE-tab" data-bs-toggle="pill" data-bs-target="#pagaPRE" type="button" role="tab" aria-controls="paga" aria-selected="false">PAGA</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="misionesPRE" role="tabpanel" aria-labelledby="misionesPRE-tab" tabindex="0">
                        <h4>Ascienden cada 10 dias</h4>
                        <h4>Misiones: 9</h4>
                        <h4>Costo de traslado: </h4>
                        <div class="table-responsive">
                            <table class="table table-striped text-center table-bordered table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">Numero de misiones</th>
                                        <th scope="col">Nombre de Misión</th>
                                        <th scope="col">Costo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>SNY - PRESIDENTE VIII</td>
                                        <td>540</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>SNY - PRESIDENTE VII
                                        </td>
                                        <td>580</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>SNY - PRESIDENTE VI
                                        </td>
                                        <td>620</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">4</th>
                                        <td>SNY - PRESIDENTE V </td>
                                        <td>660</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">5</th>
                                        <td>SNY - PRESIDENTE IV </td>
                                        <td>700</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">6</th>
                                        <td>SNY - PRESIDENTE III </td>
                                        <td>740</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">7</th>
                                        <td>SNY - PRESIDENTE II </td>
                                        <td>780</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">8</th>
                                        <td>SNY - PRESIDENTE I </td>
                                        <td>820</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">9</th>
                                        <td>SNY - PRESIDENTE MAYOR </td>
                                        <td>860</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="requisitosPRE" role="tabpanel" aria-labelledby="requisitosPRE-tab" tabindex="0">
                        <h4>Requisitos de Paga PRE</h4>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Nómina</th>
                                        <th scope="col">Bonificación</th>
                                        <th scope="col">Total de ascensos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h4>5 ascensos</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40"> 6 horas
                                        </td>
                                        <td>
                                            <h4>5 acesnsos</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>10 ascensos</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h4>Requisitos de Paga con Reducción (Diamante y Premium)</h4>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Nómina</th>
                                        <th scope="col">Bonificación</th>
                                        <th scope="col">Total de ascensos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h4>15 ascensos</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/membresias/silver.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/membresias/gold.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>10 ascensos</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/membresias/silver.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/membresias/gold.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>35 ascensos</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/membresias/silver.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/membresias/gold.png" alt="Icono" width="40">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pagaPRE" role="tabpanel" aria-labelledby="pagaPRE-tab" tabindex="0">
                        <h4>PAGA</h4>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Nómina</th>
                                        <th scope="col">Bonificación</th>
                                        <th scope="col">Total de creditos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h4>10 creditos</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>20 creditos</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40">
                                        </td>
                                        <td>
                                            <h4>30 creditos</h4><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40"><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

        </div>

        <!-- OPERATIVO -->

        <div class="tab-pane fade" id="op-tab-pane" role="tabpanel" aria-labelledby="op-tab" tabindex="0">

            <section class="margenes">
                <ul class="nav nav-pills mb-3 justify-content-center flex-wrap" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="misionesOP-tab" data-bs-toggle="pill" data-bs-target="#misionesOP" type="button" role="tab" aria-controls="misiones" aria-selected="true">MISIONES</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="requisitosOP-tab" data-bs-toggle="pill" data-bs-target="#requisitosOP" type="button" role="tab" aria-controls="requisitos" aria-selected="false">REQUISITOS</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pagaOP-tab" data-bs-toggle="pill" data-bs-target="#pagaOP" type="button" role="tab" aria-controls="paga" aria-selected="false">PAGA</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="misionesOP" role="tabpanel" aria-labelledby="misionesOP-tab" tabindex="0">
                        <h4>Ascienden cada 30 dias</h4>
                        <h4>Misiones: 9</h4>
                        <h4>Costo de traslado: </h4>
                        <div class="table-responsive">
                            <table class="table table-striped text-center table-bordered table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">Numero de misiones</th>
                                        <th scope="col">Nombre de Misión</th>
                                        <th scope="col">Costo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>SNY - OPERATIVO VIII</td>
                                        <td>1200</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>SNY - OPERATIVO VII
                                        </td>
                                        <td>1300</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>SNY - OPERATIVO VI
                                        </td>
                                        <td>1400</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">4</th>
                                        <td>SNY - OPERATIVO V </td>
                                        <td>1500</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">5</th>
                                        <td>SNY - OPERATIVO IV </td>
                                        <td>1600</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">6</th>
                                        <td>SNY - OPERATIVO III </td>
                                        <td>1700</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">8</th>
                                        <td>SNY - OPERATIVO II </td>
                                        <td>1800</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">9</th>
                                        <td>SNY - OPERATIVO I </td>
                                        <td>2000</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">10</th>
                                        <td>SNY - JEFE DPTO. OP </td>
                                        <td>2200</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="requisitosOP" role="tabpanel" aria-labelledby="requisitosOP-tab" tabindex="0">
                        <h4>Requisitos de Paga</h4>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Nómina</th>
                                        <th scope="col">Bonificación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40"> 6 horas
                                        </td>
                                        <td>
                                            <img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40"> 4 horas
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h4>Requisitos de Paga con Reducción (Diamante y Premium)</h4>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Nómina</th>
                                        <th scope="col">Bonificación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40">4 horas</td>
                                        <td><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40">2 horas</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pagaOP" role="tabpanel" aria-labelledby="pagaOP-tab" tabindex="0">
                        <h4>PAGA</h4>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Nómina</th>
                                        <th scope="col">Bonificación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>6 horas</td>
                                        <td>4 horas</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- JUNTA DIRECTIVA -->

        <div class="tab-pane fade" id="jtd-tab-pane" role="tabpanel" aria-labelledby="jtd-tab" tabindex="0">

            <section class="margenes">
                <ul class="nav nav-pills mb-3 justify-content-center flex-wrap" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="misionesJTD-tab" data-bs-toggle="pill" data-bs-target="#misionesJTD" type="button" role="tab" aria-controls="misiones" aria-selected="true">MISIONES</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="requisitosJTD-tab" data-bs-toggle="pill" data-bs-target="#requisitosJTD" type="button" role="tab" aria-controls="requisitos" aria-selected="false">REQUISITOS</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pagaJTD-tab" data-bs-toggle="pill" data-bs-target="#pagaJTD" type="button" role="tab" aria-controls="paga" aria-selected="false">PAGA</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="misionesJTD" role="tabpanel" aria-labelledby="misionesJTD-tab" tabindex="0">
                        <h4>Misiones: 9</h4>
                        <h4>Costo de traslado: </h4>
                        <div class="table-responsive">
                            <table class="table table-striped text-center table-bordered table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">Numero de misiones</th>
                                        <th scope="col">Nombre de Misión</th>
                                        <th scope="col">Costo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>SNY - JDT VIII</td>
                                        <td>3500</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>SNY - JDT VII
                                        </td>
                                        <td>3700</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>SNY - JDT VI
                                        </td>
                                        <td>3900</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">4</th>
                                        <td>SNY - JDT V </td>
                                        <td>4100</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">5</th>
                                        <td>SNY - JDT IV </td>
                                        <td>4300</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">6</th>
                                        <td>SNY - JDT III </td>
                                        <td>4500</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">7</th>
                                        <td>SNY - JDT II </td>
                                        <td>4900</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">8</th>
                                        <td>SNY - JDT I </td>
                                        <td>4900</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">9</th>
                                        <td>SNY - GERENTE JDT </td>
                                        <td>5100</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="requisitosJTD" role="tabpanel" aria-labelledby="requisitosJTD-tab" tabindex="0">
                        <h4>Requisitos de Paga</h4>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Nómina</th>
                                        <th scope="col">Bonificación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40"> 6 horas
                                        </td>
                                        <td>
                                            <img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40"> 4 horas
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h4>Requisitos de Paga con Reducción (Diamante y Premium)</h4>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Nómina</th>
                                        <th scope="col">Bonificación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><img src="/public/custom/custom_requisitos_rangos/image/paga/boni.png" alt="Icono" width="40">4 horas</td>
                                        <td><img src="/public/custom/custom_requisitos_rangos/image/paga/paga.png" alt="Icono" width="40">2 horas</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pagaJTD" role="tabpanel" aria-labelledby="pagaJTD-tab" tabindex="0">
                        <h4>PAGA</h4>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Nómina</th>
                                        <th scope="col">Bonificación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>6 horas</td>
                                        <td>4 horas</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
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