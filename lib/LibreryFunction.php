<?php


namespace app\lib;

use app\models\DmVentaTurnos;
use app\models\DmVentaApertura;

class LibreryFunction {

	/**
	 * @var string
	 */
	private $fecha_actual;

	//variables para cierre de turno
	/**
	 * @var integer
	 */
	private $iMontoApertura;
	/**
	 * @var datetime
	 */
	private $strFechaInicio;
	/**
	 * @var datetime
	 */
	private $strFechaTermino;

	/**
	 * Set fecha Y-m-d
	 * @param $p_strFecha
	 */
	public function set_fecha_actual( $p_strFecha ){
		$this->fecha_actual = $p_strFecha;

	}

	/**
	 * get Fecha Y-m-d
	 * @return mixed
	 */
	public function get_fecha_actual(){
		return $this->fecha_actual;
	}

	public function set_fecha_inicio( $p_strFechaInicio ){
		$this->strFechaInicio = $p_strFechaInicio;
	}

	public function set_fecha_termino( $p_strFechaTermino ){
		$this->strFechaTermino = $p_strFechaTermino;
	}

	public function set_monto_apertura( $p_iMontoApert ){
		$this->iMontoApertura = $p_iMontoApert;
	}

	public function get_fecha_inicio(){
		return $this->strFechaInicio;
	}

	public function get_fecha_termino(){
		return $this->strFechaTermino;
	}

	public function get_monto_apertura(){
		return $this->iMontoApertura;
	}



	/**
	 * Valido Apertura de turno
	 * @param $p_iUserid
	 * @param $p_iIdTurno
	 *
	 * @return bool
	 */
	public function ValidateApertTurn( $p_iUserid, $p_iIdTurno ){

		$oDtActual = new \DateTime( date('Y-m-d H:i:s' ) );
		$iIdLastAperUser = DmVentaApertura::getMaxApert( $p_iUserid );
		$modelTurno = DmVentaTurnos::findOne( $p_iIdTurno );
		$iLastApert = DmVentaApertura::getLastApert(); //cambiar a la nueva validacion en base si existe un nuevo turno
		if ( $iIdLastAperUser !== false ) {
			$modelLastApert = DmVentaApertura::findOne( $iIdLastAperUser );
			$oDtLastApert = new \DateTime( date( 'Y-m-d H:i:s', strtotime( $modelLastApert->dm_apert_fecha ) ) );
			$oMidthNight = new \DateTime( 'today midnight' );
			$oFechaMidAfter = $oMidthNight->modify('-1day');

			if ( $oDtLastApert->format('Y-m-d' ) == $oFechaMidAfter->format('Y-m-d' ) &&  $p_iIdTurno == $modelLastApert->dm_turnos_id && $modelTurno->dm_venta_cierre_sig_dia == 1
			    && $modelLastApert->dm_apert_id == $iLastApert ) {
				$oDtActual->modify('-1day');
			}
		}

		$this->set_fecha_actual( $oDtActual->format('Y-m-d') );
		return  DmVentaApertura::valCajaExist( $p_iUserid, $oDtActual->format( 'Y-m-d' ), $p_iIdTurno );

	}

	/**
	 * Prepara informacion para el cierre de turno
	 * @param $p_iUserId
	 * @param $p_iTurnoId
	 * @param $p_iIdApertura
	 *
	 * @throws \Exception
	 */
	public function prepareDataCierre( $p_iUserId, $p_iTurnoId, $p_iIdApertura ){

		$modelApertura = DmVentaApertura::findOne( $p_iIdApertura );
		$modelTurno = DmVentaTurnos::findOne( $p_iTurnoId );

		if ( $modelApertura != null ) {
			$oDtDateIn = $oDTdbi = new \DateTime( date( 'Y-m-d H:i:s', strtotime( $modelApertura->dm_apert_fecha ) ) );
		}
		else {
			$oDTdbi    = new \DateTime( date( 'H:i:s', strtotime( $modelTurno->dm_venta_hora_inicio ) ) );
			$oDtDateIn = new \DateTime( date( 'Y-m-d' ) );
			$intervalo = new \DateInterval( 'PT' . $oDTdbi->format( 'H' ) . 'H' . $oDTdbi->format( 'i' ) . 'M' . $oDTdbi->format( 's' ) . 'S' );
			//añadir tiempo de turno
			$oDtDateIn->add( $intervalo );

		}

		$oDTdbEnd = new \DateTime( date( 'H:i:s', strtotime( $modelTurno->dm_venta_hora_termino ) ) );
		//la hora debo considerar el inicio del siguiente turno

		$iIdLASTAPERT = DmVentaApertura::getLastApert();
		if ( $iIdLASTAPERT != false && $iIdLASTAPERT != $modelApertura->dm_apert_id ) {
			$oTemp = DmVentaApertura::findOne( $iIdLASTAPERT );
			$oDtDateEnd = new \DateTime( date( 'Y-m-d H:i:s', strtotime( $oTemp->dm_apert_fecha ) ) );
		}
		else {
			$oDtDateEnd = new \DateTime( date( 'Y-m-d' ) );
			//añadir tiempo de turno
			$intervalo = new \DateInterval( 'PT' . $oDTdbEnd->format( 'H' ) . 'H' . $oDTdbEnd->format( 'i' ) . 'M' . $oDTdbEnd->format( 's' ) . 'S' );
			$oDtDateEnd->add( $intervalo );
		}


		if ( $modelApertura != null ) { //modifico si existe apertura CUENTA SOLO PARA TURNO DE NOCHE

			$oDTApert = new \DateTime( date( 'Y-m-d H:i:s', strtotime( $modelApertura->dm_apert_fecha ) ) );
			$oMidthNight = new \DateTime( 'today midnight' ); //esto tengo que arreglarlo
			if ( $oDTApert->format( 'H:i:s' ) > $oDtDateEnd->format( 'H:i:s' ) && $modelTurno->dm_venta_cierre_sig_dia == 1 ) {
				$oDtDateEnd->modify( '+1day' );
			}
		}

		if ( $modelApertura !== null ) {
			$iMontoApertura = $modelApertura->dm_apert_monto;
		}
		else{
			$iMontoApertura = DmVentaApertura::getMontoApertura( $p_iUserId , $oDtDateIn->format( 'Y-m-d' ), $p_iTurnoId  );
		}


  	$this->set_monto_apertura( $iMontoApertura );
		$this->set_fecha_inicio( $oDtDateIn->format( 'Y-m-d H:i:s' ) );
		$this->set_fecha_termino( $oDtDateEnd->format( 'Y-m-d H:i:s' ) );




	}

}