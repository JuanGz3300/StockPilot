<?php
require_once('controllers/cmovim.php');
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2><i class="fas fa-exchange-alt me-2"></i>Gestión de Movimientos de Inventario</h2>
        </div>
    </div>

    <?php 
    // Mostrar mensajes de éxito o error
    if(isset($_SESSION['success_msg'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= $_SESSION['success_msg']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php unset($_SESSION['success_msg']); endif; ?>

    <?php if(isset($_SESSION['error_msg'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?= $_SESSION['error_msg']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php unset($_SESSION['error_msg']); endif; ?>

    <!-- Formulario -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-<?= $datOne ? 'edit' : 'plus-circle' ?> me-2"></i>
                <?= $datOne ? 'Editar Movimiento' : 'Nuevo Movimiento' ?>
            </h5>
        </div>
        <div class="card-body">
            <form action="home.php?pg=<?=$pg?>" method="POST" id="formMovimiento">
                <input type="hidden" name="idmov" value="<?= $datOne['idmov'] ?? '' ?>">
                <input type="hidden" name="ope" value="save">
                <input type="hidden" name="idemp" value="<?= $idemp_session ?>">
                <input type="hidden" name="idusu" value="<?= $idusu_session ?>">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="idkar" class="form-label">Kardex (Período) <span class="text-danger">*</span></label>
                        <select name="idkar" id="idkar" class="form-select" required>
                            <option value="">-- Seleccione un período --</option>
                            <?php if($datKardex): foreach($datKardex as $kar): ?>
                                <option value="<?=$kar['idkar']?>" <?= (isset($datOne['idkar']) && $datOne['idkar']==$kar['idkar']) ? 'selected' : '' ?>>
                                    <?=$kar['anio']?> - Mes <?=$kar['mes']?>
                                </option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="idprod" class="form-label">Producto <span class="text-danger">*</span></label>
                        <select name="idprod" id="idprod" class="form-select" required>
                            <option value="">-- Seleccione un producto --</option>
                            <?php if($datProductos): foreach($datProductos as $prod): ?>
                                <option value="<?=$prod['idprod']?>" <?= (isset($datOne['idprod']) && $datOne['idprod']==$prod['idprod']) ? 'selected' : '' ?>>
                                    <?=$prod['nomprod']?> (<?=$prod['codprod']?>)
                                </option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="idubi" class="form-label">Ubicación <span class="text-danger">*</span></label>
                        <select name="idubi" id="idubi" class="form-select" required>
                            <option value="">-- Seleccione una ubicación --</option>
                            <?php if($datUbicaciones): foreach($datUbicaciones as $ubi): ?>
                                <option value="<?=$ubi['idubi']?>" <?= (isset($datOne['idubi']) && $datOne['idubi']==$ubi['idubi']) ? 'selected' : '' ?>>
                                    <?=$ubi['nomubi']?>
                                </option>
                            <?php endforeach; endif; ?>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="fecmov" class="form-label">Fecha <span class="text-danger">*</span></label>
                        <input type="date" name="fecmov" id="fecmov" class="form-control" 
                               value="<?= $datOne['fecmov'] ?? date('Y-m-d') ?>" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="tipmov" class="form-label">Tipo de Movimiento <span class="text-danger">*</span></label>
                        <select name="tipmov" id="tipmov" class="form-select" required>
                            <option value="">-- Seleccione --</option>
                            <option value="1" <?= (isset($datOne['tipmov']) && $datOne['tipmov']==1) ? 'selected' : '' ?>>
                                <i class="fas fa-arrow-down"></i> Entrada
                            </option>
                            <option value="2" <?= (isset($datOne['tipmov']) && $datOne['tipmov']==2) ? 'selected' : '' ?>>
                                <i class="fas fa-arrow-up"></i> Salida
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="cantmov" class="form-label">Cantidad <span class="text-danger">*</span></label>
                        <input type="number" name="cantmov" id="cantmov" class="form-control" 
                               value="<?= $datOne['cantmov'] ?? '' ?>" min="1" step="1" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="valmov" class="form-label">Valor Unitario <span class="text-danger">*</span></label>
                        <input type="number" name="valmov" id="valmov" class="form-control" 
                               value="<?= $datOne['valmov'] ?? '' ?>" min="0" step="0.01" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="costprom" class="form-label">Costo Promedio</label>
                        <input type="number" name="costprom" id="costprom" class="form-control" 
                               value="<?= $datOne['costprom'] ?? '' ?>" min="0" step="0.01">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="docref" class="form-label">Documento Referencia</label>
                        <input type="text" name="docref" id="docref" class="form-control" 
                               value="<?= $datOne['docref'] ?? '' ?>" placeholder="Ej: FAC-001">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="obs" class="form-label">Observaciones</label>
                        <textarea name="obs" id="obs" class="form-control" rows="3"><?= $datOne['obs'] ?? '' ?></textarea>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Guardar Movimiento
                        </button>
                        <?php if($datOne): ?>
                            <a href="home.php?pg=<?=$pg?>" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de Movimientos -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Listado de Movimientos</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tableMovimientos" class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Producto</th>
                            <th>Ubicación</th>
                            <th>Tipo</th>
                            <th>Cantidad</th>
                            <th>Valor Unit.</th>
                            <th>Total</th>
                            <th>Doc. Ref</th>
                            <th>Usuario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($datAll): foreach($datAll as $row): 
                            $total = $row['cantmov'] * $row['valmov'];
                        ?>
                        <tr>
                            <td><?=$row['idmov']?></td>
                            <td><?=date('d/m/Y', strtotime($row['fecmov']))?></td>
                            <td><?=$row['nomprod'] ?? 'N/A'?></td>
                            <td><?=$row['nomubi'] ?? 'N/A'?></td>
                            <td>
                                <?php if($row['tipmov']==1): ?>
                                    <span class="badge bg-success"><i class="fas fa-arrow-down"></i> Entrada</span>
                                <?php else: ?>
                                    <span class="badge bg-danger"><i class="fas fa-arrow-up"></i> Salida</span>
                                <?php endif; ?>
                            </td>
                            <td><?=number_format($row['cantmov'], 0)?></td>
                            <td>$<?=number_format($row['valmov'], 2)?></td>
                            <td><strong>$<?=number_format($total, 2)?></strong></td>
                            <td><?=$row['docref'] ?? '-'?></td>
                            <td><?=($row['nomusu'] ?? '').' '.($row['apeusu'] ?? '')?></td>
                            <td>
                                <a href="home.php?pg=<?=$pg?>&idmov=<?=$row['idmov']?>&ope=edi" 
                                   class="btn btn-sm btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="confirmarEliminar(<?=$row['idmov']?>)" 
                                        class="btn btn-sm btn-danger" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="11" class="text-center">No hay movimientos registrados</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// DataTable
$(document).ready(function() {
    // Solo inicializar DataTables si hay datos
    if ($('#tableMovimientos tbody tr').length > 0 && !$('#tableMovimientos tbody tr td[colspan]').length) {
        $('#tableMovimientos').DataTable({
            language: {
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
            },
            order: [[0, 'desc']]
        });
    }
});

// Confirmar eliminación
function confirmarEliminar(idmov) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'home.php?pg=<?=$pg?>&idmov=' + idmov + '&ope=eli';
        }
    });
}
</script>
