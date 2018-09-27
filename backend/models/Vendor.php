<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * User represents the model behind the search form about `mdm\admin\models\User`.
 */
class Vendor extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at'], 'integer'],
            [['vendorname'], 'safe'],
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

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('vendor','ID'),
            'vendorname' => Yii::t('vendor','Vendor Name'),
            'created_at' => Yii::t('vendor','Created At'),
            'updated_at' => Yii::t('vendor','Updated At'),

        ];
    }

    public function search($params)
    {
      $query = Vendor::find();

      $dataProvider = new ActiveDataProvider([
          'query' => $query,
          'pagination' => [
                'pageSize' => 1,
            ],
      ]);


      $this->load($params);
      if (!$this->validate()) {
          $query->where('1=0');
          return $dataProvider;
      }

      $query->andFilterWhere([
          'id' => $this->id,
          'created_at' => $this->created_at,
          'updated_at' => $this->updated_at,
      ]);

      $query->andFilterWhere(['like', 'vendorname', $this->vendorname]);

      return $dataProvider;
    }    
}
