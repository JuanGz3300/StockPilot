<?php 
require_once __DIR__ . '/../controllers/caud.php';

// Obtener todos los logins de la empresa
$datLogins = [];

if($idemp_sesion){
    // Obtener todos los logins (exitosos y fallidos)
    $datLogins = $maud->getLogins($idemp_sesion);
}

// Calcular estadísticas
$total_logins = count($datLogins);
$logins_exitosos = count(array_filter($datLogins, function($l){ 
    return isset($l['exitoso']) && $l['exitoso'] == 1; 
}));
$logins_fallidos = count(array_filter($datLogins, function($l){ 
    return isset($l['exitoso']) && $l['exitoso'] == 0; 
}));
?>

<style>
.audit-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}
.stat-card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-left: 4px solid #6c757d;
}
.stat-card.success { border-left-color: #28a745; }
.stat-card.danger { border-left-color: #dc3545; }
.stat-card.info { border-left-color: #17a2b8; }
.stat-card.warning { border-left-color: #ffc107; }
.stat-number {
    font-size: 2rem;
    font-weight: bold;
    margin: 10px 0;
}
.stat-label {
    font-size: 0.9rem;
    color: #666;
    text-transform: uppercase;
}
.table-container {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}
.table-container h4 {
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #dee2e6;
}
</style>

<div class="conte">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2 style="margin: 0;">
            <i class="fa fa-shield-alt"></i> 
            Auditoría del Sistema
        </h2>
        <button class="btn btn-primary" onclick="location.reload()">
            <i class="fa fa-sync-alt"></i> Actualizar
        </button>
    </div>

    <!-- Tarjetas de Estadísticas -->
    <div class="audit-stats">
        <div class="stat-card success">
            <i class="fa fa-check-circle" style="font-size: 2rem; opacity: 0.3; float: right;"></i>
            <div class="stat-label">Logins Exitosos</div>
            <div class="stat-number"><?= $logins_exitosos; ?></div>
        </div>
        <div class="stat-card danger">
            <i class="fa fa-times-circle" style="font-size: 2rem; opacity: 0.3; float: right;"></i>
            <div class="stat-label">Logins Fallidos</div>
            <div class="stat-number"><?= $logins_fallidos; ?></div>
        </div>
        <div class="stat-card info">
            <i class="fa fa-sign-in-alt" style="font-size: 2rem; opacity: 0.3; float: right;"></i>
            <div class="stat-label">Total Logins</div>
            <div class="stat-number"><?= $total_logins; ?></div>
        </div>
    </div>

    <!-- Sección de Logins -->
    <!-- Sección de Logins -->
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4><i class="fa fa-sign-in-alt"></i> Historial de Logins</h4>
           
                
        
        </div>
        <div class="table-responsive">
            <table class="table table-hover" id="tableLogins">
                <thead style="background: #6c757d; color: white;">
                    <tr>
                        <th>Fecha y Hora</th>
                        <th>Usuario</th>
                        <th>Tipo</th>
                        <th>Email</th>
                        <th>Estado</th>
                        <th>IP</th>
                        <th>Navegador</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($datLogins && count($datLogins) > 0) {
                        foreach ($datLogins as $login) { ?>
                            <tr>
                                <td>
                                    <i class="fa fa-clock text-muted"></i>
                                    <?= date('d/m/Y H:i:s', strtotime($login['fecha'])); ?>
                                </td>
                                <td>
                                    <i class="fa fa-user text-primary"></i>
                                    <?= $login['nomusu'] ? htmlspecialchars($login['nomusu'].' '.$login['apeusu']) : '<em class="text-muted">Desconocido</em>'; ?>
                                </td>
                                <td>
                                    <?php if(isset($login['accion']) && $login['accion'] == 6): ?>
                                        <span class="badge bg-secondary"><i class="fa fa-sign-out-alt"></i> Logout</span>
                                    <?php else: ?>
                                        <span class="badge bg-info text-dark"><i class="fa fa-sign-in-alt"></i> Login</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($login['email']); ?></td>
                                <td>
    <?php if (!empty($login['exitoso'])): ?>
        <span class="badge bg-success"><i class="fa fa-check"></i> Exitoso</span>
    <?php else: ?>
        <span class="badge bg-danger"><i class="fa fa-times"></i> Fallido</span>
    <?php endif; ?>
</td>
                                <td>
                                    <code style="background: #f4f4f4; padding: 4px 8px; border-radius: 4px;">
                                        <?= htmlspecialchars($login['ip']); ?>
                                    </code>
                                </td>
                                <td style="max-width: 300px; overflow: hidden; text-overflow: ellipsis;" 
                                    title="<?= htmlspecialchars($login['navegador']); ?>">
                                    <small class="text-muted">
                                        <?= htmlspecialchars(substr($login['navegador'], 0, 50)); ?><?= strlen($login['navegador']) > 50 ? '...' : ''; ?>
                                    </small>
                                </td>
                            </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Sección de Movimientos de Kardex -->
    <?php 
    // Obtener movimientos de kardex
    $datMovs = $maud->getMovimientos($idemp_sesion);
    ?>
    <div class="table-container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4><i class="fa fa-boxes-stacked"></i> Movimientos de Inventario</h4>
            <!-- Opcional: Botón para vaciar movimientos si se requiere -->
        </div>
        <div class="table-responsive">
            <table class="table table-hover" id="tableMovs">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Acción</th>
                        <th>Detalle</th>
                        <th>IP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($datMovs && count($datMovs) > 0) {
                        foreach ($datMovs as $mov) { 
                            // Decodificar JSON para mostrar info legible
                            $datos = json_decode($mov['datos_nue'], true);
                            ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($mov['fecha'])); ?></td>
                                <td>
                                    <i class="fa fa-user-circle"></i> 
                                    <?= $mov['nomusu'] ? htmlspecialchars($mov['nomusu'].' '.$mov['apeusu']) : 'Sistema'; ?>
                                </td>
                                <td>
                                    <?php 
                                    $accion_txt = '';
                                    $badge_cls = 'secondary';
                                    $icono = 'fa-circle';
                                    
                                    if($mov['accion'] == 1) { 
                                        $accion_txt = 'Creado'; 
                                        $badge_cls = 'success'; 
                                        $icono = 'fa-plus-circle';
                                    }
                                    elseif($mov['accion'] == 2) { 
                                        $accion_txt = 'Editado'; 
                                        $badge_cls = 'warning'; 
                                        $icono = 'fa-edit';
                                    }
                                    elseif($mov['accion'] == 3) { 
                                        $accion_txt = 'Eliminado'; 
                                        $badge_cls = 'danger'; 
                                        $icono = 'fa-trash';
                                    }
                                    else { $accion_txt = 'Otro'; }
                                    ?>
                                    <span class="badge bg-<?= $badge_cls; ?>">
                                        <i class="fa <?= $icono; ?>"></i> <?= $accion_txt; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php 
                                    // Mostrar información legible según la tabla
                                    if(isset($mov['tabla']) && $mov['tabla'] == 'movim' && $datos):
                                        $tipo_mov = isset($datos['tipmov']) && $datos['tipmov'] == 1 ? 'Entrada' : 'Salida';
                                        ?>
                                        <div>
                                            <strong><?= $tipo_mov; ?></strong> de inventario
                                            <?php if(isset($datos['cantmov'])): ?>
                                                <br><i class="fa fa-boxes"></i> Cantidad: <strong><?= $datos['cantmov']; ?></strong>
                                            <?php endif; ?>
                                            <?php if(isset($datos['valmov'])): ?>
                                                <br><i class="fa fa-dollar-sign"></i> Valor: <strong>$<?= number_format($datos['valmov'], 2); ?></strong>
                                            <?php endif; ?>
                                            <?php if(isset($datos['docref']) && !empty($datos['docref'])): ?>
                                                <br><i class="fa fa-file-alt"></i> Doc: <?= htmlspecialchars($datos['docref']); ?>
                                            <?php endif; ?>
                                        </div>
                                    <?php elseif(isset($mov['tabla']) && $mov['tabla'] == 'kardex' && $datos): ?>
                                        <div>
                                            <i class="fa fa-calendar"></i> Kardex 
                                            <?php if(isset($datos['anio']) && isset($datos['mes'])): ?>
                                                <strong><?= $datos['anio']; ?> - Mes <?= $datos['mes']; ?></strong>
                                            <?php endif; ?>
                                        </div>
                                    <?php elseif(isset($mov['tabla']) && $mov['tabla'] == 'ubicacion' && $datos): ?>
                                        <div>
                                            <i class="fa fa-map-marker-alt"></i> Ubicación
                                            <?php if(isset($datos['nomubi'])): ?>
                                                <strong><?= htmlspecialchars($datos['nomubi']); ?></strong>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <small class="text-muted">
                                            <i class="fa fa-info-circle"></i> 
                                            <?= isset($mov['tabla']) ? ucfirst($mov['tabla']) : 'Registro'; ?>
                                        </small>
                                    <?php endif; ?>
                                </td>
                                <td><code><?= $mov['ip']; ?></code></td>
                            </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    // Configuración de idioma en español
    const spanishLang = {
        "decimal": "",
        "emptyTable": "No hay datos disponibles",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
        "infoEmpty": "Mostrando 0 a 0 de 0 registros",
        "infoFiltered": "(filtrado de _MAX_ registros totales)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ registros",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "No se encontraron registros coincidentes",
        "paginate": {
            "first": "Primero",
            "last": "Último",
            "next": "Siguiente",
            "previous": "Anterior"
        }
    };

    // Inicializar DataTables para Logins
    if($('#tableLogins').length) {
        $('#tableLogins').DataTable({
            language: spanishLang,
            order: [[0, 'desc']], // Ordenar por fecha descendente
            pageLength: 6, // Mostrar 6 registros por página
            lengthMenu: [[6, 10, 25, 50, -1], [6, 10, 25, 50, "Todos"]],
            responsive: true
        });
    }

    // Inicializar DataTables para Movimientos
    if($('#tableMovs').length) {
        $('#tableMovs').DataTable({
            language: spanishLang,
            order: [[0, 'desc']], // Ordenar por fecha descendente
            pageLength: 6, // Mostrar 6 registros por página
            lengthMenu: [[6, 10, 25, 50, -1], [6, 10, 25, 50, "Todos"]],
            responsive: true
        });
    }
});
</script>
