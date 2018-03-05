
<h1>Cierre de Turno  <?=$modelTurno->dm_nombre?></h1>

<?php echo $this->render( '__datacierre', [ 'aCierres' => $aCierres,
                                            'aCajas' => $aCajas,
                                            'modelTurno' => $modelTurno,
                                            'iMontoApertura' => $iMontoApertura, ] ); ?>