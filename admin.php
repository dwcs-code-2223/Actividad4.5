<?php
ob_start();
require_once 'util.php';
$allowed_roles = [ADMIN_ROLE];



if (!isUserLoggedIn() || !isUserAllowedInPage($allowed_roles)) {
    //Podría cerrarse sesión o en el caso de que la sesión estuviese activa
    //, pero el rol no fuese el correcto, reenviar a una página de recurso no permitido
    cerrarSesion();
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Welcome page</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    </head>
    <body>
        <?php
        if (isset($_POST["btnCerrar"])) {
            cerrarSesion();
            header("Location: login.php");
            exit;
        }
        ?>
        <div class="container-fluid">
            <h1> Bienvenid@ ADMIN

            </h1>


            <div class="row justify-content-center">
                <div class="col-sm-12 col-md-6">
                    <form method="post">
                        <input type="submit" class="btn btn-primary btn-block mb-4" value="Cerrar sesión" name="btnCerrar"></button>

                    </form>


                </div>
            </div>   
        </div>
    </body>
</html>
<?php ob_end_flush() ?>