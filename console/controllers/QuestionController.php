<?php

namespace console\controllers;
use yii;
use yii\console\Controller;
use backend\models\Question;
use backend\models\SupplierLevel;
use backend\models\TemplateRecord;
use console\models\Supplier;
use console\models\SupplierDetail;

class QuestionController extends Controller {

  public function actionSync()
  {
    //获取所有评价
    $count = 0;
    $lists = Question::find()->select('id,template_id,sid,status')->where(['template_id' => [7,8,9,10]])->andWhere(['>','start_date','2021-01-01 00:00'])->asArray()->all();
    foreach ($lists as $list) {
      $data = array();
      $supplierModel = '';
      $count++;
      if ($list['status'] != 3) {
        echo "评价id为{$list['id']}-失败".PHP_EOL;
      } else {
        //收集答案，评测
        $level = SupplierLevel::getLevels();
        $levelFlip = array_flip($level);
        $total = 0;
        $result = 0;
        $num = 0;
        $templateRecordModel = new TemplateRecord();
        $where['template_id'] = $list['template_id'];
        $where['question_id'] = $list['id'];
        $records = $templateRecordModel->getTemplateRecordByParams($where);
        if (!$records) {
          echo "评价为空，id为{$list['id']}".PHP_EOL;
          continue;
        }
        //总分
        $num = count($records);
        foreach ($records as $record) {
          $total += $record['total'];
        }
        $result = $total / $num;
        if ($result <= 0 || ($result > 0 && $result < 60)) {
          $level = '不合格';
        }
        if ($result >= 60 && $result < 90) {
          $level = '合格';
        }
        if ($result >= 90 && $result <= 100) {
          $level = '优秀';
        }
        if ($result > 100) {
          $level = '优秀';
        }
        $level_id = $levelFlip["{$level}"];
        //修改供应商评价等级
        //调用swoole客户端

        $sql = "SELECT * FROM supplier WHERE status='10' AND cooperate = 1 AND id={$list['sid']}";
        echo $sql.PHP_EOL;
        $supplier = Yii::$app->db->createCommand($sql)->queryAll();
        foreach ($supplier as $v) {
          $detail = SupplierDetail::getBySid($v['id']);

          if ($detail && ($detail['one_level_department'] == $v['department'])) {
            $supplierModel = Supplier::getByID($v['id']);
            $supplierModel->scenario = 'sync';
            if ($detail['cate_id1']) {
              //$supplierModel->cate_id1 = $detail['cate_id1'];
            }
            if ($detail['cate_id2']) {
              //$supplierModel->cate_id2 = $detail['cate_id2'];
            }
            if ($detail['cate_id3']) {
              //$supplierModel->cate_id3 = $detail['cate_id3'];
            }
            if ($level_id) {
              $supplierModel->level = $level_id;
            }
            $supplierModel->cooperate = 2;
            $supplierModel->save();
            echo "评价id{$list['id']}-成功".PHP_EOL;
          } else {
            echo "评价id{$list['id']}-不成功".PHP_EOL;
          }
        }
      }
    }
    echo "总数为{$count}".PHP_EOL;
  }

  /**
   * Name: actionSync2020
   * User: aimer
   * Date: 2021/4/1
   * Time: 下午2:19
   * @throws yii\web\NotFoundHttpException
   */
  public function actionSync2020()
  {
    //获取所有评价
    $count = 0;
    $lists = Question::find()->select('id,template_id,sid,status')->where(['template_id' => [7,8,9,10]])->andWhere(['>','start_date','2020-01-01 00:00'])->groupBy('sid')->asArray()->all();
    foreach ($lists as $list) {
      $data = array();
      $supplierModel = '';
      $count++;
      if ($list['status'] != 3) {
        echo "评价id为{$list['id']}-失败".PHP_EOL;
      } else {
        //收集答案，评测
        $level = SupplierLevel::getLevels();
        $levelFlip = array_flip($level);
        $total = 0;
        $result = 0;
        $num = 0;
        $templateRecordModel = new TemplateRecord();
        $where['sid'] = $list['sid'];
        $where['template_id'] = [7,8,9,10];
        $records = $templateRecordModel->getTemplateRecordByParams($where);
        if (!$records) {
          echo "评价为空，id为{$list['id']}".PHP_EOL;
          continue;
        }
        //总分
        $num = count($records);
        foreach ($records as $record) {
          $total += $record['total'];
        }
        $result = $total / $num;
        if ($result <= 0 || ($result > 0 && $result < 60)) {
          $level = '不合格';
        }
        if ($result >= 60 && $result < 90) {
          $level = '合格';
        }
        if ($result >= 90 && $result <= 100) {
          $level = '优秀';
        }
        if ($result > 100) {
          $level = '优秀';
        }
        $level_id = $levelFlip["{$level}"];
        //修改供应商评价等级
        $sql = "SELECT * FROM supplier WHERE status='10' AND id={$list['sid']}";
        $supplier = Yii::$app->db->createCommand($sql)->queryAll();
        foreach ($supplier as $v) {
          $detail = SupplierDetail::getBySid($v['id']);
          if ($detail && ($detail['one_level_department'] == $v['department'])) {
            $supplierModel = Supplier::getByID($v['id']);
            $supplierModel->scenario = 'sync';
            if ($detail['cate_id1']) {
              $supplierModel->cate_id1 = $detail['cate_id1'];
            }
            if ($detail['cate_id2']) {
              $supplierModel->cate_id2 = $detail['cate_id2'];
            }
            if ($detail['cate_id3']) {
              $supplierModel->cate_id3 = $detail['cate_id3'];
            }
            if ($level_id) {
              $supplierModel->level = $level_id;
            }
            $supplierModel->cooperate = 2;
            $supplierModel->save();
            echo "评价id{$list['id']}-成功".PHP_EOL;
          } else {
            echo "评价id{$list['id']}-不成功".PHP_EOL;
          }
        }
      }
    }
    echo "总数为{$count}".PHP_EOL;
  }

}