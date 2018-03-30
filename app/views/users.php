<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $pageTitle ?></title>

    <link rel="shortcut icon" href="<?= APPIMAGEPATH; ?>favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?= APPIMAGEPATH; ?>favicon.ico" type="image/x-icon">
    
    <link rel="apple-touch-icon" href="<?= APPIMAGEPATH; ?>apple-touch-icon.png">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
    <table class="table" border="1">

        <thead>
            <tr>
                <th>Id</th>
                <th>Saludo</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Genero</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Pwd</th>
                <th>Fecha Registro</th>
                <th>Empresa</th>
                <th>Dependencia</th>
                <th>Tipo usuario</th>
                <th>Celular</th>
                <th>Telf Casa</th>
                <th>Telf Trabajo</th>
                <th>Extension</th>
                <th>Activo/Inactivo</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php echo $user["id"] ?></td>
                <td><?php echo $user["saludo"] ?></td>
                <td><?php echo $user["nombre"] ?></td>
                <td><?php echo $user["apellido"] ?></td>
                <td><?php echo $user["gender"] ?></td>
                <td><?php echo $user["usuario"] ?></td>
                <td><?php echo $user["email"] ?></td>
                <td><?php echo $user["password"] ?></td>
                <td><?php echo $user["usuario"] ?></td>
                <td><?php echo $user["fecha_ingreso"] ?></td>
                <td><?php echo $user["empresa"] ?></td>
                <td><?php echo $user["dependencia"] ?></td>
                <td><?php echo $user["role"] ?></td>
                <td><?php echo $user["Celular"] ?></td>
                <td><?php echo $user["TelefonoCasa"] ?></td>
                <td><?php echo $user["TelefonoTrabajo"] ?></td>
                <td><?php echo $user["ExtensionTrabajo"] ?></td>
                <td><?php echo $user["activo"] ?></td>
                <td>
                    <button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-user"></span> Activar</button>
                    <button type="button" class="btn btn-warning"><span class="glyphicon glyphicon-minus-sign"></span> Desactivar</button>
                    <button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Eliminar</button>
                </td>
            </tr>
            <?php } ?>

        </tbody>
    </table>
</body>
</html>