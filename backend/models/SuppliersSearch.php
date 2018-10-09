<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Suppliers;

/**
 * SuppliersSearch represents the model behind the search form of `backend\models\Suppliers`.
 */
class SuppliersSearch extends Suppliers
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'black_box', 'white_box', 'created_at', 'updated_at'], 'integer'],
            [['sname', 'legal_person', 'business_license', 'tax_registration_certificate', 'orcc', 'service_authorization_letter', 'certified_assets', 'effective_credentials', 'opening_bank', 'bank_no', 'account_name', 'account_no', 'registration_certificate', 'manufacturing_licence', 'business_certificate', 'credibility_certificate', 'headcount', 'address', 'telephone', 'mobile', 'fax', 'email', 'contact', 'url', 'remarks', 'update_date', 'operator'], 'safe'],
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
        $query = Suppliers::find();

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
            'id' => $this->id,
            'black_box' => $this->black_box,
            'white_box' => $this->white_box,
            'update_date' => $this->update_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'sname', $this->sname])
            ->andFilterWhere(['like', 'legal_person', $this->legal_person])
            ->andFilterWhere(['like', 'business_license', $this->business_license])
            ->andFilterWhere(['like', 'tax_registration_certificate', $this->tax_registration_certificate])
            ->andFilterWhere(['like', 'orcc', $this->orcc])
            ->andFilterWhere(['like', 'service_authorization_letter', $this->service_authorization_letter])
            ->andFilterWhere(['like', 'certified_assets', $this->certified_assets])
            ->andFilterWhere(['like', 'effective_credentials', $this->effective_credentials])
            ->andFilterWhere(['like', 'opening_bank', $this->opening_bank])
            ->andFilterWhere(['like', 'bank_no', $this->bank_no])
            ->andFilterWhere(['like', 'account_name', $this->account_name])
            ->andFilterWhere(['like', 'account_no', $this->account_no])
            ->andFilterWhere(['like', 'registration_certificate', $this->registration_certificate])
            ->andFilterWhere(['like', 'manufacturing_licence', $this->manufacturing_licence])
            ->andFilterWhere(['like', 'business_certificate', $this->business_certificate])
            ->andFilterWhere(['like', 'credibility_certificate', $this->credibility_certificate])
            ->andFilterWhere(['like', 'headcount', $this->headcount])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'telephone', $this->telephone])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'contact', $this->contact])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'operator', $this->operator]);

        return $dataProvider;
    }
}
