<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de productos</title>
    <style>
    body {
        font-family: sans-serif;
    }

    table.border {
        width: 100%;
        border-collapse: collapse;

    }

    table.border th,
    table.border td {
        border: 1px solid black;
        padding: 3px;
        /* font-size: 14px; */
    }

    h1,
    h2,
    h3,
    h4,
    h5 {
        padding: 0;
        margin: 0;
        margin-block-start: 0;
        margin-block-end: 0;
        margin-inline-start: 0;
        margin-inline-end: 0;
        font-weight: normal;
    }

    .text-left {
        text-align: left;
    }

    .text-right {
        text-align: right;
    }

    .text-center {
        text-align: center;
    }

    .w-100 {
        width: 100%;
    }

    .to-uppercase {
        text-transform: uppercase;
    }

    .bg-red {
        background-color: red;
    }

    @page {
        margin: 130px 50px 50px;
    }

    header {
        position: fixed;
        left: 0px;
        top: -90px;
        right: 0px
    }

    /* #footer { position: fixed; left: 0px; bottom: -50px; right: 0px} */
    #footer .page:after {
        content: counter(page, upper-roman);
    }
    </style>
</head>

<body>
    <header style="width:100%">
        <table style="width:100%; height: 60px;">
            <tr style="width:100%;">
                <td style="width:20%">
                    <img src="" width="100%">
                </td>
                <td style="width:80%">
                    <h3 style="width: 100%; text-align: left"> Reporte de productos <?= date("d-m-Y H:i:s") ?></h3>
                </td>
            </tr>
        </table>
    </header>
    <table class="border">
        <thead>
            <tr>
                <th>#</th>
                <th>CODIGO</th>
                <th>CATEGORIA</th>
                <th>NOMBRE</th>
                <th>DESCRIPCION</th>
                <th>STOCK</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $key => $producto) { ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= $producto["CODIGO"] ?></td>
                <td><?= $producto["CATEGORIA"] ?></td>
                <td><?= $producto["NOMBRE"] ?></td>
                <td><?= $producto["DESCRIPCION"] ?></td>
                <td><?= $producto["STOCK"] ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <div id="footer"></div>
</body>

</html>