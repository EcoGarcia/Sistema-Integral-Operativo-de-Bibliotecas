<div class="navbar navbar-inverse set-radius-zero">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand">
                <img src="assets/img/logo.png" height="70" width="225" />
            </a>
        </div>
        <?php if (isset($_SESSION['registrar']) && $_SESSION['registrar']) { ?>
            <div class="right-div">
                <a href="logout.php" class="btn btn-danger pull-right">Desconectame</a>
            </div>
        <?php } ?>
    </div>
</div>
<!-- LOGO HEADER END-->
<?php if (isset($_SESSION['registrar']) && $_SESSION['registrar'])  { ?>
    <section class="menu-section">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <li><a href="dashboardds.php" class="menu-top-active">TABLERO</a></li>
                            <li>
                                <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown"> Cuenta <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="my_perfil.php">Mi Perfil</a></li>
                                </ul>
                            </li>
                            <li><a href="issued-books-docente.php">Libros publicados</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } else { ?>
    <section class="menu-section">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <li><a href="adminlogin.php">Inicio de sesión de administrador</a></li>
                            <li><a href="index.php">Inicio de sesión de estudiante</a></li>
                            <li><a href="docente.php">Iniciar como docente</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
