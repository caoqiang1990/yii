<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Answer;

/**
 * AnswerSearch represents the model behind the search form of `backend\models\Answer`.
 */
class AnswerSearch extends Answer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['title', 'desc', 'options_1', 'answers_1', 'options_2', 'answers_2', 'options_3', 'answers_3'], 'safe'],
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
        $query = Answer::find();

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
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'options', $this->options_1])
            ->andFilterWhere(['like', 'answers', $this->answers_1])
            ->andFilterWhere(['like', 'options', $this->options_2])
            ->andFilterWhere(['like', 'answers', $this->answers_2])
            ->andFilterWhere(['like', 'options', $this->options_3])
            ->andFilterWhere(['like', 'answers', $this->answers_3]);

        return $dataProvider;
    }
}
