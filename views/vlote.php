<?php
include("controllers/clote.php"); // controlador de lote
?>

<div class="container">
    <h2><?php echo $dtOne ? "Editar Lote" : "Nuevo Lote"; ?></h2>

    <form method="post" action="">
        <input type="hidden" name="idlote" value="<?php echo $dtOne[0]['idlote'] ?? ''; ?>">
        <input type="hidden" name="ope" value="SaVe">

        <div class="mb-3">
            <label>Producto</label>
            <input type="text" name="idprod" class="form-control" 
                value="<?php echo $dtOne[0]['idprod'] ?? ''; ?>" required>
        </div>

        <div class="mb-3">
            <label>Código de Lote</label>
            <input type="text" name="codlote" class="form-control" 
                value="<?php echo $dtOne[0]['codlote'] ?? ''; ?>" required>
        </div>

        <div class="mb-3">
            <label>Fecha de Vencimiento</label>
            <input type="date" name="fecven" class="form-control" 
                value="<?php echo $dtOne[0]['fecven'] ?? ''; ?>">
        </div>

        <div class="mb-3">
            <label>Cantidad</label>
            <input type="number" name="cant" class="form-control" 
                value="<?php echo $dtOne[0]['cant'] ?? ''; ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="vlote.php" class="btn btn-secondary">Nuevo</a>
    </form>

    <hr>

    <h3>Lista de Lotes</h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Código</th>
                <th>Fecha Vencimiento</th>
                <th>Cantidad</th>
                <th>Creado</th>
                <th>Actualizado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($dtAll): ?>
                <?php foreach ($dtAll as $d): ?>
                <tr>
                    <td><?php echo $d['idlote']; ?></td>
                    <td><?php echo $d['idprod']; ?></td>
                    <td><?php echo $d['codlote']; ?></td>
                    <td><?php echo $d['fecven']; ?></td>
                    <td><?php echo $d['cant']; ?></td>
                    <td><?php echo $d['fec_crea']; ?></td>
                    <td><?php echo $d['fec_actu']; ?></td>
                    <td>
                        <a href="?ope=eDi&idlote=<?php echo $d['idlote']; ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="?ope=eLi&idlote=<?php echo $d['idlote']; ?>" class="btn btn-danger btn-sm"
                           onclick="return confirm('¿Seguro que deseas eliminar este lote?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="8" class="text-center">No hay registros</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
