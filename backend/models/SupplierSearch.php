<?php
declare(strict_types=1);
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
  public $supplier_status;

  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
        [['created_at', 'trade'], 'integer'],
        [['id', 'name', 'business_contact', 'business_email', 'cate_id1', 'filter_cate_id1', 'cate_id2', 'cate_id3', 'level', 'public_flag', 'department', 'status', 'supplier_status', 'cooperate', 'action', 'updated_by'], 'safe'],
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
    if (is_array($this->id)) {
      $query->andFilterWhere(['in', 'id', $this->id]);
    } else {
      $query->andFilterWhere([
          'id' => $this->id,
      ]);
    }
    if (!$this->supplier_status) {
      $query->andFilterWhere(['in', 'status', $this->supplier_status]);
    } else {
      $query->andFilterWhere(['status' => $this->supplier_status]);
    }
    if ($this->department) {
      $query->andFilterWhere(['in', 'department', $this->department]);
    }
    $query->andFilterWhere([
      //'name' => $this->name,
        'level' => $this->level,
      //'department' => $this->department,
        'cate_id1' => $this->cate_id1,
        'cate_id2' => $this->cate_id2,
        'cate_id3' => $this->cate_id3,
        'cooperate' => $this->cooperate,
        'public_flag' => $this->public_flag,
        'business_email' => $this->business_email,
        'trade' => $this->trade,
        'action' => $this->action,
        'created_at' => $this->created_at,
      //'updated_at' => $this->updated_at,
        'updated_by' => $this->updated_by,
    ]);

    return $dataProvider;
  }
}
