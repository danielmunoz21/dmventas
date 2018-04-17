<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use kartik\nav\NavX;
use app\models\DmUsuario;
use app\models\DmVentaApertura;
use app\models\DmVentaTurnos;
use app\lib\LibreryFunction;

AppAsset::register($this);



?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php



    NavBar::begin();
      $menuItems = [
          ['label' => 'Home', 'url' => ['/site/index']],
      ];
      if (Yii::$app->user->isGuest) {
          $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
      } else {
	     $controller =  Yii::$app->controller->id;
	     $action =   Yii::$app->controller->action->id;
	     $url = $controller . '/' . $action;
        if ( !isset( $_SESSION['id_apertura'] ) && $url != 'apertura/create' ){
            $user = Yii::$app->user->identity;
            if ( $user->tipo != 1 ){
	            $oLibrery = new LibreryFunction();
	            $bValido = $oLibrery->ValidateApertTurn( $user->getId(), $user->id_turno );
	            if ( !$bValido ){
	                Yii::$app->response->redirect(['/apertura/create']);
                }
            }
        }

        if ( Yii::$app->user->identity->tipo == 1 ){  //usuario administrador
          $menuItems[] = [
            'label' => 'Administración',
            'items' => [
                [ 'label' => 'Usuarios', 'url' => ['/usuario'] ],
                [ 'label' => 'Cajas', 'url' => ['/cajas'] ],
                [ 'label' => 'Turnos', 'url' => ['/turnos'] ],
                [ 'label' => 'Retirnos ingresados en el sistema', 'url' => ['/retiros'] ],
                [
                    'label' => 'Informes',
                    'items' => [
                       [ 'label' => 'Inventario productos bajo stock', 'url' => [ '/informes/prodbajostock' ] ],
                       [ 'label' => 'Registro de ventas', 'url' => ['/informes/ventasreg'] ],
                       [ 'label' => 'Cierres de turno', 'url' => ['/informes/cierreturnos'] ],
                       //[ 'label' => 'Registro de ventas por producto', 'url' => ['/informes/ventaspprod'] ],
                    ],
                ],
            ],
            
          ];

        }
        
          $menuItems[] = [
            'label' => 'Productos',
            'items' => [
                //[ 'label' => 'Registrar producto', 'url' => [ '/productos/create' ] ],
                [ 'label' => 'Listado de productos', 'url' => [ '/productos' ] ],
            ]
          ];

          if ( Yii::$app->user->identity->tipo == 1 ) {
	          $menuItems[] = [
		          'label' => 'Registrar producto',
		          'url'   => [ '/productos/create' ]
	          ];
          }

          $menuItems[] = [
            'label' => 'Venta',
            'url' => [ '/ventas/venta' ]
          ];

          $menuItems[] = [
            'label' => 'Cierre de turno',
            'url' => [ '/ventas/caja' ]
          ];

          $menuItems[] = [
            'label' => 'Mermas',
            'url' => [ '/mermas/index' ]
          ];

	      $menuItems[] = [
		      'label' => 'Retiro',
		      'url' => [ '/retiros/create' ]
	      ];
           
          $menuItems[] = [
              'label' => 'Cerrar programa (' . Yii::$app->user->identity->nombre . ')',
              'url' => ['/site/logout'],
              'linkOptions' => ['data-method' => 'post']
          ];
      }


      echo NavX::widget([
        'options' => ['class' => 'nav navbar-nav'],
        'items' => $menuItems,
        'activateParents' => true,
        'encodeLabels' => false
      ]);
      NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Daniel Muñoz Herrera <br/>Técnico Universitario en Informática - USM <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
