<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DmVentaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dm Ventas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dm-ventas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dm Ventas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'dm_venta_id',
            'dm_cajas_dm_cajas_id',
            'dm_usuario_dm_usuario_id',
            'dm_venta_cantidad',
            'dm_venta_turnos_dm_venta_turnos_id',
            // 'dm_productos_dm_id_producto',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
