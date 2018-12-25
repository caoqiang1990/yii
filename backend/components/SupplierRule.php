<?php
namespace backend\components;

use Yii;
use yii\rbac\Rule;
use mdm\admin\components\Helper;
use mdm\admin\components\Configs;

class SupplierRule extends Rule
{
  /**
   * @inheritdoc
   */
  public $name = 'supplier_rule';

  /**
   * @inheritdoc
   */
  public function execute($user, $item, $params)
  {
      //var_dump($item);
      //var_dump($item);die;
      return true;
  }
}




?>