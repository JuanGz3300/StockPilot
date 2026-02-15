<?php require_once __DIR__ . '/../controllers/cubi.php'; ?>
<div class="conte">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><i class="fa-solid fa-location-dot"></i> Ubicaciones</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="home.php">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ubicaciones</li>
            </ol>
        </nav>
    </div>

    <!-- Formulario -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fa-solid fa-pen-to-square"></i> <?= isset($datOne[0]) ? 'Editar Ubicación' : 'Nueva Ubicación' ?></h5>
        </div>
        <div class="card-body">
            <form method="post" action="home.php?pg=1017" class="row g-3">
                <input type="hidden" name="idubi" value="<?= isset($datOne[0]['idubi']) ? $datOne[0]['idubi'] : '' ?>">
                
                <div class="col-md-3">
                    <label class="form-label"><i class="fa-solid fa-tag"></i> Nombre <span class="text-danger">*</span></label>
                    <input type="text" name="nomubi" class="form-control" required value="<?= isset($datOne[0]['nomubi']) ? $datOne[0]['nomubi'] : '' ?>" placeholder="Ej. Almacén Principal">
                </div>
                <div class="col-md-2">
                    <label class="form-label"><i class="fa-solid fa-barcode"></i> Código <span class="text-danger">*</span></label>
                    <input type="text" name="codubi" class="form-control" required value="<?= isset($datOne[0]['codubi']) ? $datOne[0]['codubi'] : '' ?>" placeholder="Ej. ALM-01">
                </div>
                <div class="col-md-3">
                    <label class="form-label"><i class="fa-solid fa-map-location-dot"></i> Dirección</label>
                    <input type="text" name="dirubi" class="form-control" value="<?= isset($datOne[0]['dirubi']) ? $datOne[0]['dirubi'] : '' ?>" placeholder="Calle 123...">
                </div>
                <div class="col-md-2">
                    <label class="form-label"><i class="fa-solid fa-map"></i> Departamento</label>
                    <input type="text" name="depubi" class="form-control" value="<?= isset($datOne[0]['depubi']) ? $datOne[0]['depubi'] : '' ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label"><i class="fa-solid fa-city"></i> Ciudad</label>
                    <input type="text" name="ciuubi" class="form-control" value="<?= isset($datOne[0]['ciuubi']) ? $datOne[0]['ciuubi'] : '' ?>">
                </div>
                
                <div class="col-md-4">
                    <label class="form-label"><i class="fa-solid fa-building"></i> Empresa</label>
                    <select name="idemp" class="form-select bg-light" disabled>
                        <?php foreach($empresas as $emp): ?>
                            <option value="<?= $emp['idemp'] ?>" <?= ($_SESSION['idemp']==$emp['idemp']) ? 'selected' : '' ?>>
                                <?= $emp['nomemp'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="form-text text-muted"><i class="fa-solid fa-lock"></i> Asignado a su empresa</div>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label"><i class="fa-solid fa-user-tie"></i> Responsable</label>
                    <select name="idresp" class="form-select">
                        <option value="">Seleccione...</option>
                        <?php foreach($responsables as $resp): ?>
                            <option value="<?= $resp['idusu'] ?>" <?= (isset($datOne[0]['idresp']) && $datOne[0]['idresp']==$resp['idusu']) ? 'selected' : '' ?>>
                                <?= $resp['nomusu'] . ' ' . $resp['apeusu'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label class="form-label"><i class="fa-solid fa-toggle-on"></i> Estado</label>
                    <select name="act" class="form-select">
                        <option value="1" <?= (isset($datOne[0]['act']) && $datOne[0]['act']==1) ? 'selected' : '' ?>>Activo</option>
                        <option value="0" <?= (isset($datOne[0]['act']) && $datOne[0]['act']==0) ? 'selected' : '' ?>>Inactivo</option>
                    </select>
                </div>
                
                <div class="col-md-2 align-self-end d-grid gap-2">
                    <button type="submit" name="ope" value="save" class="btn btn-success">
                        <i class="fa fa-save"></i> <?= isset($datOne[0]) ? 'Guardar' : 'Agregar' ?>
                    </button>
                    <?php if(isset($datOne[0])): ?>
                        <a href="home.php?pg=1017" class="btn btn-secondary">
                            <i class="fa fa-times"></i> Cancelar
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-secondary"><i class="fa-solid fa-list"></i> Listado de Ubicaciones</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tableUbicaciones">
                    <thead class="table-light">
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Ubicación</th>
                            <th>Empresa</th>
                            <th>Responsable</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($datAll) {
                            foreach ($datAll as $row) { ?>
                                <tr>
                                    <td><span class="badge bg-light text-dark border"><?= $row['codubi']; ?></span></td>
                                    <td class="fw-bold"><?= $row['nomubi']; ?></td>
                                    <td><small><?= $row['dirubi']; ?></small></td>
                                    <td><small><?= $row['ciuubi']; ?> - <?= $row['depubi']; ?></small></td>
                                    <td>
                                        <?php 
                                        $emp = array_filter($empresas, function($e) use ($row) { return $e['idemp'] == $row['idemp']; });
                                        echo $emp ? '<i class="fa-solid fa-building text-muted"></i> ' . reset($emp)['nomemp'] : $row['idemp']; 
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                        $resp = array_filter($responsables, function($r) use ($row) { return $r['idusu'] == $row['idresp']; });
                                        echo $resp ? '<i class="fa-solid fa-user text-muted"></i> ' . reset($resp)['nomusu'] . ' ' . reset($resp)['apeusu'] : '-'; 
                                        ?>
                                    </td>
                                    <td>
                                        <?php if($row['act']): ?>
                                            <span class="badge bg-success-subtle text-success border border-success"><i class="fa fa-check"></i> Activo</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger-subtle text-danger border border-danger"><i class="fa fa-times"></i> Inactivo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="home.php?pg=1017&ope=edi&idubi=<?= $row['idubi']; ?>" class="btn btn-outline-warning btn-sm" title="Editar">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="home.php?pg=1017&ope=eli&idubi=<?= $row['idubi']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar esta ubicación?');" title="Eliminar">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                        <?php }} else { ?>
                            <tr><td colspan="8" class="text-center py-4 text-muted"><i class="fa-solid fa-inbox fa-2x mb-2"></i><br>No hay ubicaciones registradas.</td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    if($('#tableUbicaciones').length) {
        $('#tableUbicaciones').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            },
            order: [[0, 'asc']],
            pageLength: 10,
            responsive: true
        });
    }
});
</script>
