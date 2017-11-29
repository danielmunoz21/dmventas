<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DmUsuario */

$this->title = 'Actualizar Usuario: ' . $model->dm_usuario_nombre;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->dm_usuario_nombre, 'url' => ['view', 'id' => $model->dm_usuario_id]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="dm-usuario-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
