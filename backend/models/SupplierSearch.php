<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Supplier;

/**
 * SuppliersSearch represents the model behind the search form of `backend\models\Suppliers`.
 */
class SupplierSearch extends Supplier
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at','trade'], 'integer'],
            [['name','business_contact','business_email','cate_id1','filter_cate_id1','cate_id2','cate_id3','level','public_flag'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Supplier::find();

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
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'business_contact', $this->business_contact]);
        //$query->andFilterWhere(['not in','cate_id1',$this->filter_cate_id1]);
        $query->andFilterWhere([
            'id' => $this->id,
            //'name' => $this->name,
            'level'=> $this->level,
            'cate_id1'=> $this->cate_id1,
            'cate_id2'=> $this->cate_id2,
            'cate_id3'=> $this->cate_id3,
            'public_flag' => $this->public_flag,
            'business_email'=> $this->business_email,
            'trade'=> $this->trade,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        
        return $dataProvider;
    }
}
