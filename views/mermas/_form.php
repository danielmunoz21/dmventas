<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\DmMermas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dm-mermas-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?php echo yii\helpers\Html::activeHiddenInput( $model, 'merma_datetime' ); ?>

    <?= $form->field($model, 'dm_cajas_id')->dropDownList( 
            $aCajas, 
            [ 
                'prompt' => 'Seleccione Caja', 
                'onchange' => '$.post( "'.Yii::$app->urlManager->createUrl('mermas/findprod?id=').'"+$(this).val(), function( data ) {
                    $( "select#prod" ).html( data );
                });'
            ] 
    ) ?>

    <?= $form->field($model, 'dm_productos_id')->dropDownList(
            $aProductos, 
            [
                'id' => 'prod'  
            ]
        ) ?>

    <?= $form->field($model, 'merma_cantidad')->textInput() ?>

    <?= $form->field($model, 'merma_descripcion')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Guardar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
