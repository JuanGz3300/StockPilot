<?php
// Incluye el controlador que obtiene los datos del menú
include("controllers/cmen.php"); 
?>

<?php if ($datm && count($datm) > 0) { ?>

<nav id="navbar">
    
    <div class="navbar-logo flexbox-left">
        <div class="navbar-item-inner flexbox-left"> 
            <div class="navbar-item-inner-icon-wrapper flexbox-col" style="padding-left: 0.5em;"> 
                <i class="fa-solid fa-house" title="Inicio"></i>
            </div>
            &nbsp;&nbsp;<span class="link-text">Inicio</span> 
        </div>
    </div>

    <div class="scrollable-menu-items">
        <ul class="navbar-top-items">
            <?php 
            foreach ($datm as $dm) { 
                $class_active = ($dm['idpag'] == $pg) ? 'active' : '';
            ?>
                <li class="navbar-item flexbox-left <?= $class_active; ?>">
                    <a class="navbar-item-inner flexbox-left" href="home.php?pg=<?= $dm['idpag']; ?>">
                        <div class="navbar-item-inner-icon-wrapper flexbox-col">
                            <i class="<?= $dm['icopag']; ?>"></i>
                        </div>
                        &nbsp;&nbsp;<span class="link-text"><?= $dm['nompag']; ?></span>
                    </a>
                </li>
            <?php 
            } 
            ?>
        </ul>
    </div>
    
    <ul class="navbar-bottom-items"> 
        
        <li class="navbar-item flexbox-left user-info-display">
            <div class="navbar-item-inner flexbox-left"> 
                <div class="navbar-item-inner-icon-wrapper flexbox-col">
                    <i class="fa-solid fa-user-tie"></i> 
                </div>
                
                <span class="link-text profile-text"> 
                    <span class="profile-name">
                        <?= htmlspecialchars($_SESSION['nomusu'] . " " . $_SESSION['apeusu']); ?>
                    </span>
                    <span class="profile-role">
                        <?= htmlspecialchars($_SESSION['nomper']); ?>
                    </span>
                </span>
            </div>
        </li>
        
        <li class="navbar-item flexbox-left">
            <a class="navbar-item-inner flexbox-left" href="views/vsal.php">
                <div class="navbar-item-inner-icon-wrapper flexbox-col">
                    <i class="fa-solid fa-power-off"></i>
                </div>
                <span class="link-text">Cerrar Sesión</span>
            </a>
        </li>
    </ul>
</nav>

<?php } ?>