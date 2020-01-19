<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TemplateRecord;

/**
 * TemplateRecordSearch represents the model behind the search form of `backend\models\TemplateRecord`.
 */
class TemplateRecordSearch extends TemplateRecord
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'template_id', 'total', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['department', 'result', 'reason', 'operator', 'sid', 'question_id'], 'safe'],
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
        $query = TemplateRecord::find();

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
            'template_id' => $this->template_id,
            //'question_id' => $this->question_id,
            'total' => $this->total,
            'sid' => $this->sid,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        if ($this->question_id) {
            $query->andFilterWhere(['in', 'question_id', $this->question_id]);
        }
        $query->andFilterWhere(['like', 'department', $this->department])
            ->andFilterWhere(['like', 'result', $this->result])
            ->andFilterWhere(['like', 'reason', $this->reason])
            ->andFilterWhere(['like', 'operator', $this->operator]);

        return $dataProvider;
    }
}
