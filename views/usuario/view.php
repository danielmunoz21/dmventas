<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\DmUsuario;

/* @var $this yii\web\View */
/* @var $model app\models\DmUsuario */

$this->title = $model->dm_usuario_nombre;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dm-usuario-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->dm_usuario_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->dm_usuario_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Está seguro de eliminar este usuario?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'dm_usuario_nombre',
            'dm_nom_login',
             [
                 'attribute' => 'dm_tipo',
                 'value' => DmUsuario::$aTipos[ $model->dm_tipo ]
              ],
        ],
    ]) ?>

</div>
