<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    
</head>

<body>
    <nav class="nav">
        <div class="container">
            <h2>CatCorp.com</h2>
        </div>

    </nav>
    <main class="container d-flex justify-content-center mt-3">
        <div class="card" style="width: 400rem;">
            <div class="card-body">
                <h5 class="card-title">Confirmar cuenta del usuario</h5>
                <h6 class="card-subtitle mb-2 text-body-secondary"><?=$usuario?></h6>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. A, laudantium sapiente sit mollitia rem harum, corporis expedita temporibus ipsam impedit ea illum unde fuga animi aliquid, culpa perferendis repellat ad.</p>
                <hr>
                <!--<form method="POST">-->
                <?php echo form_open($url)?>
                    <?php if(isset($danger)):?>
                        <?php if($danger===false):?>
                        <div class="alert alert-danger" role="alert">
                            Porfavor de aceptar terminos y condiciones dando clien en "Aceptar terminos y condiciones".
                        </div>
                        <?php endif?>
                    <?php endif?>
                    <div class="form-check">
                        <input name="aceptar" type="checkbox" class="form-check-input">
                        <label>Aceptar terminos y condiciones</label>
                    </div>
                    <div class="d-flex justify-content-center">
                        <input type="submit" class="btn btn-primary" value="Cofirmar registro">
                    </div>
                <!--</form>-->
                <?php echo form_close()?>

            </div>
        </div>
    </main>

</body>

</html>