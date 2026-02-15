<?php
include("controllers/cdetsal.php"); // controlador de detsalida
?>

<div class="container">
    <h2><?php echo !empty($dtOne) ? "Editar Detalle de Salida" : "Nuevo Detalle de Salida"; ?></h2>

    <form method="post" action="">
        <input type="hidden" name="iddet" value="<?= htmlspecialchars($dtOne['iddet'] ?? '') ?>">
        <input type="hidden" name="ope" value="save">

        <div class="mb-3">
            <label>Empresa</label>
            <input type="text" name="idemp" class="form-control" 
                value="<?= htmlspecialchars($dtOne['idemp'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label>Solicitud</label>
            <input type="text" name="idsol" class="form-control" 
                value="<?= htmlspecialchars($dtOne['idsol'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label>Producto</label>
            <input type="text" name="idprod" class="form-control" 
                value="<?= htmlspecialchars($dtOne['idprod'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label>Cantidad</label>
            <input type="number" name="cantdet" class="form-control" 
                value="<?= htmlspecialchars($dtOne['cantdet'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label>Valor Unitario</label>
            <input type="number" step="0.01" name="vundet" class="form-control" 
                value="<?= htmlspecialchars($dtOne['vundet'] ?? '') ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="vdetsalida.php" class="btn btn-secondary">Nuevo</a>
    </form>

    <hr>

    <h3>Lista de Detalles de Salida</h3>
    <table class="table table-bordered table-striped">
        <thead> ... </thead>
        <tbody>
            <?php if (!empty($dtAll)): ?>
                <?php foreach ($dtAll as $d): ?>
                <tr>
                    <td><?= htmlspecialchars($d['iddet']) ?></td>
                    <td><?= htmlspecialchars($d['idemp']) ?></td>
                    <td><?= htmlspecialchars($d['idsol']) ?></td>
                    <td><?= htmlspecialchars($d['idprod']) ?></td>
                    <td><?= htmlspecialchars($d['cantdet']) ?></td>
                    <td><?= htmlspecialchars($d['vundet']) ?></td>
                    <td><?= htmlspecialchars($d['totdet'] ?? '') ?></td>
                    <td><?= htmlspecialchars($d['fec_crea']) ?></td>
                    <td><?= htmlspecialchars($d['fec_actu']) ?></td>
                    <td>
                        <a href="?ope=eDi&iddet=<?= $d['iddet'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="?delete=<?= $d['iddet'] ?>" class="btn btn-danger btn-sm"
                        onclick="return confirm('¿Seguro que deseas eliminar este registro?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="10" class="text-center">No hay registros</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
