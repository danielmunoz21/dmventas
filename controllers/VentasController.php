<?php

namespace app\controllers;

use Yii;
use app\models\DmVentas;
use app\models\DmVentaSearch;
use app\models\DmProductos;
use app\models\DmVentaDiario;
use app\models\DmVentaTurnos;
use app\models\Cierre;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Session;
use yii\helpers\Html;
use app\models\DmCajas;
/**
 * VentasController implements the CRUD actions for DmVentas model.
 */
class VentasController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['venta', 'searchproducto', 'agregarproducto', 'registrarventa'],
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        
                    ],
                ],
            ],
        ];
    }


    public function actionVenta(){

        $modelSearch = new DmVentaSearch();
        return $this->render( 'venta', [
                'modelSearch' => $modelSearch,
            ]);
    }

    public function actionSearchproducto( $term ){

        
        if (Yii::$app->request->isAjax) {

                $results = [];

                $oDmVentasSearch = new DmVentaSearch();
                $dataProvider = $oDmVentasSearch->searchProducto( [ 'dm_nom_producto' => $term ] );    

                $models = $dataProvider->getModels();
           
                if( count( $models ) > 0 ){
                    foreach( $models as $model ){
                        $results[] = [
                            'id' => $model->dm_id_producto,
                            'label' => $model->dm_nom_producto,
                        ];
                    }    
                }
                else {
                    $results[] = [
                            'id' => 'test',
                            'label' => 'PRODUCTO SIN STOCK',
                        ];
                }

                
            echo Json::encode($results);
        }
    }

    public function actionAgregarproducto(){
        
        $response = '';
        if (Yii::$app->request->isAjax) {

            //cargar producto por codigo
            $strCodigoProd = $_POST['DmVentaSearch']['dm_codigo'];

            //cargo informacion del producto
            $modelProducto = $this->loadProducto( $strCodigoProd );
            if ( $modelProducto !== false ) {
                $indice = uniqid();
                $iIdProducto = $modelProducto->dm_id_producto;
                $response .= '<td>'.$modelProducto->dm_codigo.'</td>';
                $response .= '<td>'.$modelProducto->dm_nom_producto.'</td>';
                $response .= '<td>'.$modelProducto->dm_precio_venta.'</td>';
                $response .= '<td>';
                $response .= Html::input('text', 'venta['.$iIdProducto.']['.$indice.'][cantidad]', 1, [ 'class' => 'form-control', 'onblur' => 'javascript:calculartotal( this.value, "'.$iIdProducto.'" )' ]);
                $response .= Html::hiddenInput(
                    'valor['.$iIdProducto.']['.$indice.'][cantidad]',
                    $modelProducto->dm_precio_venta ,
                    [ 'id' => 'costo_'.$iIdProducto,  ] );
                $response .= '</td>';
                $response .= '<td>';
                $response .= Html::input('text', 'venta['.$iIdProducto.']['.$indice.'][total]', $modelProducto->dm_precio_venta ,[ 'readonly' => true, 'class' => 'ventas form-control', 'id' => 'total_prod_' . $iIdProducto ]);
                $response .= '</td>';
                $response .= '<td>';
                $response .= Html::button( '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>', [ 'class' =>'btn btn-info borrar',  ] );
                $response .= '</td>';
            }
            else{
                $response = '-1';
            }


        }
        echo $response;
        exit();
    }

    /**
     * Registra y guarda una venta
     * @return \yii\web\Response
     */
    public function actionRegistrarventa(){

        $user = Yii::$app->user->identity;
        $aVentas = $_POST['venta'];
        $aProductos = array();
        $iTotalVenta = 0;
        if ( count( $aVentas ) > 0 ){
            $i = 0;
            foreach( $aVentas as $iIdProducto => $aData ){
                $iCantidad = 0;
                foreach ( $aData as $indice => $data ){
                    $iTotalVenta += $data['total'];
                    $iCantidad += $data['cantidad'];
                    $aProductos[$i]['id'] = $iIdProducto;
                    $aProductos[$i]['cantidad'] = $iCantidad;
                }
                $i++;
            }

            //registro venta de productos
            $oDateTime = new \DateTime('now');
            $oModelVentaDiario = new DmVentaDiario();
            $oModelVentaDiario->attributes = [
                'dm_venta_total' => $iTotalVenta,
                'dm_venta_datetime' => $oDateTime->format( 'Y-m-d H:i:s' ),
                'dm_usuario_dm_usuario_id' => $user->id,
                'dm_venta_turno_id' => $user->id_turno,
            ];
            $bOK = true;
            if ( $oModelVentaDiario->save() ){
             
                //grabo productos
                foreach( $aProductos as $key => $producto ){
                    $oModelVenta = new DmVentas();
                    $oModelVenta->attributes = [
                        'dm_venta_cantidad' => $producto['cantidad'],
                        'dm_productos_dm_id_producto' => $producto['id'],
                        'dm_venta_diario_dm_venta_diario_id' => $oModelVentaDiario->dm_venta_diario_id,

                    ];
                    if ( $oModelVenta->save() ){
                        
                        //descontar stock del producto. 
                        $oModelProducto = DmProductos::findOne( $producto['id'] );
                        $iStockAnterior = $oModelProducto->dm_stock;
                        $newStock = $iStockAnterior - $producto['cantidad'];
                        if ( $newStock < 0 ){
                            //no deberian quedar ya productos
                        }
                        else {
                            $oModelProducto->dm_stock = $newStock;
                            $oModelProducto->save();
                        }

                        $bOK = true;
                    }
                    else {
                        $bOK = false;
                        break;
                    }
                }

                if ( $bOK ){
                    \Yii::$app->getSession()->setFlash('ok', 'Venta Registrada.');
                }
                else{
                    \Yii::$app->getSession()->setFlash('error', 'Error al registrar la venta.');
                }
            }
        }
        return $this->redirect( ['venta'] );

    }


    public function actionCaja(){
     
        $user = Yii::$app->user->identity;


        $iIdTurno = $user->id_turno;

        $modelTurno = DmVentaTurnos::findOne( $iIdTurno );

        $oDTdbi = new \DateTime( date( 'H:i:s', strtotime( $modelTurno->dm_venta_hora_inicio ) ) );
        $oDTdbEnd = new \DateTime( date( 'H:i:s', strtotime( $modelTurno->dm_venta_hora_termino ) ) );

        $oDtDateIn = new \DateTime( date( 'Y-m-d' ) );
        
        $intervalo = new \DateInterval( 'PT'.$oDTdbi->format('H').'H'.$oDTdbi->format('i').'M'.$oDTdbi->format('s').'S' );
        //añadir tiempo de turno
        $oDtDateIn->add( $intervalo );
    
        $oDtDateEnd = new \DateTime( date( 'Y-m-d' ) );
        //añadir tiempo de turno
        $intervalo = new \DateInterval( 'PT'.$oDTdbEnd->format('H').'H'.$oDTdbEnd->format('i').'M'.$oDTdbEnd->format('s').'S' );
        $oDtDateEnd->add( $intervalo );

        if ( $modelTurno->dm_venta_hora_inicio > $modelTurno->dm_venta_hora_termino ){
            $oDtDateEnd->modify( '+1 day' ); 
        }


        $aCajas = DmCajas::find()->all();
        
        $aCierres = Cierre::getAllCierres( $iIdTurno, $oDtDateIn->format( 'Y-m-d H:i:s' ), $oDtDateEnd->format( 'Y-m-d H:i:s' ) );
        return $this->render( '_cierre',[
                'aCierres' => $aCierres,
                'aCajas' => $aCajas,
                'modelTurno' => $modelTurno,
            ] );

    }


    
    protected function loadProducto( $p_strCodigoProd ){
        if (($model = DmProductos::find()->where( ['dm_codigo' => $p_strCodigoProd] )->one() ) !== null) {
            return $model;
        } else {
            return false;
        }
    }


}
