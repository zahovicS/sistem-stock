<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $ventaCabecera->serie . "-" . $ventaCabecera->num_comprobante ?></title>
    <style>
    @page {
        margin: 5px;
    }

    body {
        font-family: sans-serif;
        width: 100%;
        font-size: .8rem;
    }

    table {
        width: 100%;
    }

    table td,
    table th {
        font-size: .8rem;
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

    hr {
        border: 0;
        height: 2px;
        border-top: 1px dashed black;
        border-bottom: 1px dashed black;
    }

    .dash {
        width: 100%;
        height: 10px;
        border: 0;
        height: 1px;
        border-top: 1px dashed black;
        border-bottom: 1px dashed black;
        /*   text-align:center; */
        /*   position: relative; */
    }

    .dash span {
        position: absolute;
        top: 0px;
        background-color: #fff;
        left: 50%;
        transform: translate(-50%, 0);
    }

    .to-uppercase {
        text-transform: uppercase;
    }

    .bg-red {
        background-color: red;
    }
    </style>
</head>

<body>
    <?php $descuentos = 0; ?>
    <?php $subtotal = 0; ?>
    <div class="text-center w-100">
        <span><b><?= TIPO_DOCUMENTO_EMPRESA ?>: <?= DOCUMENTO_EMPRESA ?></b></span><br />
        <span><b><?= NOMBRE_EMPRESA ?></b></span><br />
        <span><?= NOMBRE_COMERCIAL_EMPRESA ?></span><br />
        <span><?= DIRECCION_EMPRESA ?></span><br />
        <span><?= TELEFONO_EMPRESA . " - " . CELULAR_EMPRESA ?></span><br />
    </div>
    <div class="text-center w-100">
        <span>=======================================</span>
    </div>
    <div class="text-center w-100">
        <span style="text-transform: uppercase;"><b><?= $ventaCabecera->tipo_comprobante ?></b></span>
        <br />
        <span><b><?= $ventaCabecera->serie . " - " . str_pad($ventaCabecera->num_comprobante, 7, 0, STR_PAD_LEFT) ?></b></span>
    </div>
    <div class="text-center w-100">
        <span>=======================================</span>
    </div>
    <div>
        <span>
            <b>Fecha de emisión: </b>
            <span><?= $ventaCabecera->fecha ?></span>
        </span>
        <br />
        <span>
            <b>Cajero(a): </b>
            <span class="to-uppercase"><?= $ventaCabecera->usuario ?></span>
        </span>
        <br />
    </div>
    <div class="text-center w-100">
        <span>=======================================</span>
    </div>
    <div>
        <span>
            <b><?= $ventaCabecera->tipo_documento ?>:</b>
            <span class="to-uppercase"><?= $ventaCabecera->num_documento ?></span>
        </span>
        <br />
        <span>
            <b>Nombre: </b>
            <span><?= $ventaCabecera->cliente ?></span>
        </span>
        <br />
        <span>
            <b>Dirección: </b>
            <span><?= $ventaCabecera->direccion ?></span>
        </span>
        <br />
    </div>
    <div class="text-center w-100">
        <span>=======================================</span>
    </div>
    <table>
        <thead>
            <tr>
                <th class="text-left">[Cant.] Producto</th>
                <th class="text-center">P/U</th>
                <th class="text-center">Desc.</th>
                <th class="text-center">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detalles as $detalle) {
                $descuentos += floatval($detalle["DSCTO"]);
                $subtotal += floatval($detalle["SUBTOTAL"]);
            ?>
            <tr>
                <td>
                    [<?= $detalle["CANTIDAD"] ?>] <?= $detalle["DESCRIPCION"] ?>
                </td>
                <td>
                    <?= SIMBOLO_MONEDA_EMPRESA . $detalle["PU"] ?>
                </td>
                <td>
                    <?= SIMBOLO_MONEDA_EMPRESA . $detalle["DSCTO"] ?>
                </td>
                <td class="text-right"><?= SIMBOLO_MONEDA_EMPRESA . $detalle["SUBTOTAL"] ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="text-center w-100">
        <span>=======================================</span>
    </div>
    <table>
        <?php
        $subtotal_v = floatval($ventaCabecera->total_venta) - floatval($descuentos);
        $m_pago = $ventaCabecera->m_pago == "C" ? "CONTADO" : "TARJETA";
        ?>
        <tbody>
            <tr>
                <th class="text-right" style="width: 70%"><b>SUBTOTAL: </b></th>
                <td class="text-right" style="width: 30%">
                    <?= SIMBOLO_MONEDA_EMPRESA . number_format($subtotal_v, 2, ".", ",") ?>
                </td>
            </tr>
            <tr>
                <th class="text-right" style="width: 70%"><b>DESCUENTOS: </b></th>
                <td class="text-right" style="width: 30%">
                    <?= SIMBOLO_MONEDA_EMPRESA . number_format($descuentos, 2, ".", ",") ?>
                </td>
            </tr>
            <tr>
                <th class="text-right" style="width: 70%"><b>TOTAL: </b></th>
                <td class="text-right" style="width: 30%"><?= SIMBOLO_MONEDA_EMPRESA . $ventaCabecera->total_venta ?>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="text-center w-100">
        <span>=======================================</span>
    </div>
    <div>
        <span>
            <b>SON:</b>
            <span class="to-uppercase"><?= $con_letra ?></span>
        </span>
        <br />
        <span>
            <b>Método de pago:</b>
            <span class="to-uppercase"><?= $m_pago ?></span>
        </span>
        <br />
    </div>
    <div class="text-center w-100">
        <span>=======================================</span>
    </div>
    <div class="text-center w-100">
        <span><?= MSG_EMPRESA ?></span><br>
    </div>
</body>

</html>