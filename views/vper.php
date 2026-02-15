<?php
require_once('controllers/cper.php');
?>
<h2>Perfil</h2> <i class="fas fa-user-circle"></i>

<form action="home.php?pg=<?=$pg?>" method="POST">
    <div class="row">
        <div class="form-group col-md-4">
            <label for="codper">Código del Perfil</label>
            <input type="text" name="codper" id="codper" class="form-control" 
                   value="<?php if($datOne && isset($datOne[0]['codper'])) echo $datOne[0]['codper']; ?>">
        </div>

        <div class="form-group col-md-4">
            <label for="nomper">Nombre del Perfil</label>
            <input type="text" name="nomper" id="nomper" class="form-control" 
                   value="<?php if($datOne && isset($datOne[0]['nomper'])) echo $datOne[0]['nomper']; ?>">
        </div>

        <div class="form-group col-md-4">
            <label for="nivel">Nivel</label>
            <input type="text" name="nivel" id="nivel" class="form-control" 
                   value="<?php if($datOne && isset($datOne[0]['nivel'])) echo $datOne[0]['nivel']; ?>">
        </div>

        <div class="form-group col-md-6">
            <label for="fec_crea">Fecha de Creación</label>
            <input type="date" name="fec_crea" id="fec_crea" class="form-control" 
                   value="<?php if($datOne && isset($datOne[0]['fec_crea'])) echo $datOne[0]['fec_crea']; ?>">
        </div>

        <div class="form-group col-md-6">
            <label for="fec_actu">Fecha de Actualización</label>
            <input type="date" name="fec_actu" id="fec_actu" class="form-control" 
                   value="<?php if($datOne && isset($datOne[0]['fec_actu'])) echo $datOne[0]['fec_actu']; ?>">
        </div>

        <div class="form-group col-md-6">
            <label for="act">Activo</label>
            <select name="act" id="act" class="form-control">
                <option value="1" <?php if($datOne && $datOne[0]['act'] == 1) echo "selected"; ?>>Sí</option>
                <option value="0" <?php if($datOne && $datOne[0]['act'] == 0) echo "selected"; ?>>No</option>
            </select>
        </div>

        <div class="form-group col-md-12">
            <input type="hidden" name="idper" value="<?php if($datOne && isset($datOne[0]['idper'])) echo $datOne[0]['idper']; ?>">
            <input type="hidden" name="ope" value="save">
            <br>
            <input type="submit" class="form-control btn btn-dark" value="Guardar">
        </div>
    </div>
</form>

<hr>

<table id="table" class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Código</th>
            <th>Nombre</th>
            <th>Nivel</th>
            <th>Fecha Creación</th>
            <th>Fecha Actualización</th>
            <th>Activo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if($datAll){ foreach ($datAll as $dt){ ?>
        <tr>
            <td><?=$dt['idper'];?></td>
            <td><?=$dt['codper'];?></td>
            <td><?=$dt['nomper'];?></td>
            <td><?=$dt['nivel'];?></td>
            <td><?=$dt['fec_crea'];?></td>
            <td><?=$dt['fec_actu'];?></td>
            <td><?=$dt['act'] == 1 ? 'Sí' : 'No';?></td>
            <td>
                <a href="index.php?pg=<?=$pg;?>&idper=<?=$dt['idper'];?>&ope=edi" title="Editar">
                    <i class="fa-solid fa-pen-to-square fa-2x"></i>
                </a>
                <a href="index.php?pg=<?=$pg;?>&idper=<?=$dt['idper'];?>&ope=eli" title="Eliminar" onclick="return eliminar();">
                    <i class="fa-solid fa-trash-can fa-2x"></i>
                </a>
            </td>
        </tr>
        <?php }} ?>
    </tbody>
    <thead>
        <tr>
            <th>ID</th>
            <th>Código</th>
            <th>Nombre</th>
            <th>Nivel</th>
            <th>Fecha Creación</th>
            <th>Fecha Actualización</th>
            <th>Activo</th>
            <th>Acciones</th>
        </tr>
    </thead>
</table>
