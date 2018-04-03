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
use app\models\DmVentaApertura;
use kartik\mpdf\Pdf;
use app\lib\LibreryFunction;
/**
 * VentasController implements the CRUD actions for DmVentas model.
 */
class VentasController extends Controller
{

		static public  $aCierreData = array();
		static public $iMontoApert = 0;

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
                'only' => ['venta', 'searchproducto', 'agregarproducto', 'registrarventa', 'pdfcierre'],
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
				try {
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
									$oModelProducto->dm_stock = $newStock;
									if ( $oModelProducto->save() ){
										$bOK = true;
										error_log( 'PRODUCTO ' . $oModelProducto->dm_codigo . ' NOMBRE '. $oModelProducto->dm_nom_producto .' CANTIDAD ' . $producto['cantidad'] );
									}
									else {
										$bOK = false;
										break;
										//anular compra
										error_log( 'DEBUG ANULAR COMPRA'  );
									}

								}
								else {
									$bOK = false;
									//anular toda la compra
									break;
									error_log( 'DEBUG ANULAR COMPRA COMPLETA '  );
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
				catch ( \Exception $e ) {
					error_log( 'DEBUG REGISTRAR VENTA ' . $e->getMessage() );
					throw new NotFoundHttpException('Error al guardar la venta.');
				}


    }


    public function actionCaja(){
				try {
					$user = Yii::$app->user->identity;

					$iIdTurno = $user->id_turno;

					$modelTurno = DmVentaTurnos::findOne( $iIdTurno );

					$oSession = Yii::$app->session;
					$oSession->open();
					$iIdApertura = $oSession->get( 'id_apertura' );
					$oSession->close();
					$oDTAC = new \DateTime( date( 'Y-m-d' ) );

					$oLibFunction = new LibreryFunction();
					$oLibFunction->prepareDataCierre( $user->getId(), $iIdTurno, $iIdApertura );

					$aCajas = DmCajas::find()->all();

          $aCierres = Cierre::getAllCierres( $iIdTurno, $oLibFunction->get_fecha_inicio(), $oLibFunction->get_fecha_termino(), $user->getId() );

					return $this->render( '_cierre',[
						'aCierres' => $aCierres,
						'aCajas' => $aCajas,
						'modelTurno' => $modelTurno,
						'iMontoApertura' => $oLibFunction->get_monto_apertura(),
						'user' => $user,
						'strFecha' => $oDTAC->format( 'Y-m-d' ),
					] );

				}
				catch (\Exception $e){
					error_log( 'DEBUG REGISTRAR CAJA ' . $e->getMessage() );
					throw new NotFoundHttpException('Error al generar el cierre.' . $e->getMessage());
				}

    }

    public function actionPdfcierre(){

			try {
				$user = Yii::$app->user->identity;

				$iIdTurno = $user->id_turno;

				$modelTurno = DmVentaTurnos::findOne( $iIdTurno );

				$oSession = Yii::$app->session;
				$oSession->open();
				$iIdApertura = $oSession->get( 'id_apertura' );
				$oSession->close();
				$oDTAC = new \DateTime( date( 'Y-m-d' ) );

				$oLibFunction = new LibreryFunction();
				$oLibFunction->prepareDataCierre( $user->getId(), $iIdTurno, $iIdApertura );

				$aCajas = DmCajas::find()->all();

				$aCierres = Cierre::getAllCierres( $iIdTurno, $oLibFunction->get_fecha_inicio(), $oLibFunction->get_fecha_termino(), $user->getId() );
				$content = $this->renderPartial('_pdf', [ 'aCierres' => $aCierres,
				                                          'aCajas' => $aCajas,
				                                          'modelTurno' => $modelTurno,
				                                          'iMontoApertura' => $oLibFunction->get_monto_apertura(),
				                                          'user' => $user,
				                                          'strFecha' => $oDTAC->format( 'Y-m-d' ),
				]);

				$pdf = new Pdf([
					'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts
					'format' => Pdf::FORMAT_LETTER,
					'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
					'content' => $content,
					'options' => [
						'title' => 'Listado de Productos',
						'subject' => 'Listado de productos con códigos de barra incluidos'
					],
					'methods' => [
						'SetHeader' => ['DmVentas: ' . date("d/m/Y")],
						'SetFooter' => ['|Página {PAGENO}|'],
					],
					'destination' => Pdf::DEST_BROWSER,
					'filename'=> 'CIERRE_TURNO_'. $modelTurno->dm_nombre .'_'.$user->username.'.pdf',
				]);

				// return the pdf output as per the destination setting
				$pdf->render();
			}
			catch (\Exception $e){
				error_log( 'DEBUG PDF Cierre ' . $e->getMessage() );
				throw new NotFoundHttpException('Error al generar el PDF.');
			}

    }



    
    protected function loadProducto( $p_strCodigoProd ){
        if (($model = DmProductos::find()->where( ['dm_codigo' => $p_strCodigoProd] )->one() ) !== null) {
            return $model;
        } else {
            return false;
        }
    }


}
