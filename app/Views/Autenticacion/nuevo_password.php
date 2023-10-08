<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
</head>

<body>
    <div class="d-flex justify-content-center">
        <div>
            <h1>Nueva contraseña</h1>

            <?= form_open("", ["class" => "rounded w-100 p-3 border"]) ?>
            <h4><?= esc($nombre)?></h4>
            <?php if (isset($estado)) : ?>
                <?php if (!$estado) : ?>
                    <?= view_cell("PruevaCells::Alert", ["type" => "danger", "msg" => "Las contraseñas no coinsiden", "error" => $error]) ?>
                <?php endif; ?>
            <?php endif ?>
            <div class="mb-3">
                <label class="form-label">Ingrese su nueva contraseña</label>
                <input name="nueva_password" class="form-control" type="password">
            </div>
            <div class="mb-3">
                <label class="form-label">Comprobar contraseña</label>
                <input name="confirmar_password" class="form-control" type="password">
            </div>
            <div class="mb-3 d-flex justify-content-between">
                <button type="reset" class="btn btn-primary">Cancelar</button>
                <button type="submit" class="btn btn-primary">Ok!</button>
            </div>
            </form>
        </div>
    </div>

    <!--Ejemplo con celdas-->
    <!--<?= view_cell("PruevaCells::Show", ["hola" => "'Hola mundo'"]) ?>-->
</body>

</html>