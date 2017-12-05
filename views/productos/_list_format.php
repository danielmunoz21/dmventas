<?php
use app\models\DmProductos;

?>


<body>

<h1>Listado de Productos</h1>

<?php

    if ( count( $aCajas ) > 0 ){
        foreach( $aCajas as $iIdCaja => $strNomCaja ){
            echo '<h3>' . $strNomCaja . '</h3>';
            //productos
            $aProductos = DmProductos::getProdByIdCaja( $iIdCaja );
            if ( count( $aProductos ) > 0 ) {
                ?>
                <table class="table">
                    <thead>
                        <tr>
                            <td>Producto</td>
                            <td>Valor</td>
                            <td>Código</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach( $aProductos as $key => $modelProducto ){

                            $generator = new Picqer\Barcode\BarcodeGeneratorPNG();

                            echo '<tr>';
                                echo '<td>' . $modelProducto->dm_nom_producto . '</td>';
                                echo '<td>$' . number_format($modelProducto->dm_precio_venta, 0, ',', '.') . '</td>';
                                echo '<td><img src="data:image/png;base64,' . base64_encode($generator->getBarcode($modelProducto->dm_codigo, $generator::TYPE_CODE_128)) . '"></td>';
                            echo '</tr>';
                        }
                    ?>
                    </tbody>
                </table>
                <?php
            }
        }
    }

?>


</body>
