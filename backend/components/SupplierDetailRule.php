<?php
namespace backend\components;

use Yii;
use yii\rbac\Rule;
use mdm\admin\components\Helper;
use mdm\admin\components\Configs;

class SupplierDetailRule extends Rule
{
  /**
   * @inheritdoc
   */
  public $name = 'supplier_detail_rule';

  /**
   * @inheritdoc
   */
  public function execute($user, $item, $params)
  {
    $department = Yii::$app->user->identity->department;
    if (!$department) {
      return false;
    }
    return true;
  }
}




?>