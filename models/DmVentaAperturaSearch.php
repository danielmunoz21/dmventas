<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DmVentaApertura;

/**
 * DmVentaAperturaSearch represents the model behind the search form about `app\models\DmVentaApertura`.
 */
class DmVentaAperturaSearch extends DmVentaApertura
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dm_apert_id', 'dm_apert_monto', 'dm_usuario_id'], 'integer'],
            [['dm_apert_fecha'], 'safe'],
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
        $query = DmVentaApertura::find();

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
            'dm_apert_id' => $this->dm_apert_id,
            'dm_apert_monto' => $this->dm_apert_monto,
            'dm_apert_fecha' => $this->dm_apert_fecha,
            'dm_usuario_id' => $this->dm_usuario_id,
        ]);

        return $dataProvider;
    }
}
