<?php

namespace console\controllers;
use yii;
use yii\console\Controller;
use backend\models\Question;
use backend\models\SupplierLevel;
use backend\models\TemplateRecord;

class QuestionController extends Controller {

  public function actionSync()
  {
    //获取所有评价
    $count = 0;
    $lists = Question::find()->select('id,template_id,sid,status')->asArray()->all();
    foreach ($lists as $list) {
      $data = array();
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

        $client = new \swoole_client(SWOOLE_SOCK_TCP);
        if (!$client->connect('127.0.0.1', 9503)) {
          exit("connect failed. Error: {$client->errCode}\n");
        }
        $data['id'] = $list['sid'];
        $data['level'] = $level_id;
        $data = serialize($data);
        $client->send($data);
        $client->close();
        sleep(1);
        echo "评价id{$list['id']}-成功".PHP_EOL;
      }
    }
    echo "总数为{$count}".PHP_EOL;
  }
}