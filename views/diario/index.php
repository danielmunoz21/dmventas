<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DmVentaDSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dm Venta Diarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dm-venta-diario-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dm Venta Diario', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'dm_venta_diario_id',
            'dm_venta_total',
            'dm_venta_datetime',
            'dm_usuario_dm_usuario_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
