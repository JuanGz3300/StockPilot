<?php
require_once('controllers/cpag.php');
?>
<h2>Página</h2> <i class="fas fa-file"></i>
<form action="home.php?pg=<?=$pg?>" method="POST">
    <div class="row">
        <div class="form-group col-md-6">
        <label for="nompag">Nombre de la Página</label>
        <input type="text" name="nompag" id="nompag" class="form-control">
        </div>
        <div class="form-group col-md-6">
            <label for="despag">Descripción de la Página</label>
            <input type="text" name="despag" id="despag" class="form-control">
        </div>
                                <div class="form-group col-md-12">
                                <input type="hidden" name="idpag" value="<?php if($datOne &&$datOne[0]['idpag']) echo $datOne[0]['idpag']; ?>">
                                <input type="hidden" name="ope" value="save">
                                <br>
                                <input type="submit" class="form-control btn btn-dark" value="Enviar">
                            </div>
    </div>
</form>
<table id="table" class="table table-striped">
        <thead>
            <tr>
                <th>Nombre de la página</th>
                <th>Ruta Pagina</th>
                <th>Acciones</th>
                <th></th> 
            </tr>
        </thead>
        <tbody>
            <?php if($datAll){ foreach ($datAll AS $dt){ ?>
            <tr>
                <td><?=$dt['idpag']."-".$dt['nompag'];?></td>
                <td><?=$dt['ruta'];?></td>
                <td>
                    <a href="index.php?pg=<?=$pg;?>&idpag=<?=$dt['idpag'];?>&ope=edi" title="Editar">
                    <i class="fa-solid fa-pen-to-square fa-2x"></i>
                    </a>
                    <a href="index.php?pg=<?=$pg;?>&idpag=<?=$dt['idpag'];?>&ope=eli" title="Eliminar" onclick="return eliminar();">
                        <i class="fa-solid fa-trash-can fa-2x"></i>
                    </a>
                </td>
            </tr>
            <?php }}?>
        </tbody>
        <thead>
            <tr>
                <th>Nombre de la página</th>
                <th>Ruta Pagina</th>
                <th>Acciones</th>
                <th></th>
            </tr>
        </thead>
    </table>