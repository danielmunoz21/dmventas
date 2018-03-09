<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DmVentaRetiros;

/**
 * DmVentaRetirosSearch represents the model behind the search form of `app\models\DmVentaRetiros`.
 */
class DmVentaRetirosSearch extends DmVentaRetiros
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['retiro_id', 'retiro_monto', 'dm_cajas_dm_cajas_id', 'dm_usuario_dm_usuario_id', 'dm_venta_turnos_dm_venta_turnos_id'], 'integer'],
            [['retiro_datetime'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = DmVentaRetiros::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'retiro_id' => $this->retiro_id,
            'retiro_monto' => $this->retiro_monto,
            'retiro_datetime' => $this->retiro_datetime,
            'dm_cajas_dm_cajas_id' => $this->dm_cajas_dm_cajas_id,
            'dm_usuario_dm_usuario_id' => $this->dm_usuario_dm_usuario_id,
            'dm_venta_turnos_dm_venta_turnos_id' => $this->dm_venta_turnos_dm_venta_turnos_id,
        ]);

        return $dataProvider;
    }
}
