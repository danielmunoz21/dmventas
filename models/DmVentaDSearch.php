<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DmVentaDiario;

/**
 * DmVentaDSearch represents the model behind the search form about `app\models\DmVentaDiario`.
 */
class DmVentaDSearch extends DmVentaDiario
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dm_venta_diario_id', 'dm_venta_total', 'dm_usuario_dm_usuario_id'], 'integer'],
            [['dm_venta_datetime'], 'safe'],
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
        $query = DmVentaDiario::find();

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
            'dm_venta_diario_id' => $this->dm_venta_diario_id,
            'dm_venta_total' => $this->dm_venta_total,
            'dm_venta_datetime' => $this->dm_venta_datetime,
            'dm_usuario_dm_usuario_id' => $this->dm_usuario_dm_usuario_id,
        ]);

        return $dataProvider;
    }
}
