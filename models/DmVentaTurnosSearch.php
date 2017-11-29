<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DmVentaTurnos;

/**
 * DmVentaTurnosSearch represents the model behind the search form about `app\models\DmVentaTurnos`.
 */
class DmVentaTurnosSearch extends DmVentaTurnos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dm_venta_turnos_id'], 'integer'],
            [['dm_nombre', 'dm_venta_hora_inicio', 'dm_venta_hora_termino'], 'safe'],
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
        $query = DmVentaTurnos::find();

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
            'dm_venta_turnos_id' => $this->dm_venta_turnos_id,
            'dm_venta_hora_inicio' => $this->dm_venta_hora_inicio,
            'dm_venta_hora_termino' => $this->dm_venta_hora_termino,
        ]);

        $query->andFilterWhere(['like', 'dm_nombre', $this->dm_nombre]);

        return $dataProvider;
    }
}
