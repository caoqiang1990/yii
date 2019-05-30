<?php

namespace console\controllers;
use yii;
use yii\console\Controller;
use console\models\Supplier;
use console\models\SupplierDetail;

class TcpSwooleController extends Controller {

    private $_tcp;

    /**
     * Name: actionRun 控制台应用方法
     * User: aimer
     * Date: 2019/5/30
     * Time: 下午2:41
     */
    public function actionRun()
    {
        $this->_tcp = new \swoole_server('0.0.0.0', 9503);
        $this->_tcp->set([
            'worker_num' => 2,
            'task_worker_num' => 10,
            'log_file' => __DIR__.'/../log/error.log',
        ]);
        $this->_tcp->on('connect', [$this, 'onConnect']);
        $this->_tcp->on('receive', [$this, 'onReceive']);
        $this->_tcp->on('task',[$this,'onTask']);
        $this->_tcp->on('finish',[$this,'onFinish']);
        $this->_tcp->on('close', [$this, 'onClose']);
        $this->_tcp->start();
    }

    /**
     * Name: onConnect
     * User: aimer
     * Date: 2019/5/30
     * Time: 下午2:41
     * @param $server
     * @param $fd
     */
    public function onConnect($server, $fd)
    {
        echo "connection open: {$fd}\n";
    }

    /**
     * Name: onReceive
     * User: aimer
     * Date: 2019/5/30
     * Time: 下午2:41
     * @param $server
     * @param $fd
     * @param $from_id
     * @param $data
     */
    public function onReceive($server, $fd, $from_id, $data)
    {
        $server->task($data,$fd);
    }

    /**
     * Name: onClose 失败回调
     * User: aimer
     * Date: 2019/5/30
     * Time: 下午2:40
     * @param $server
     * @param $fd
     */
    public function onClose($server, $fd)
    {
        echo "connection close: {$fd}\n";
    }

    /**
     * Name: onTask
     * User: aimer
     * Date: 2019/5/30
     * Time: 下午2:40
     * @param $server
     * @param $fd
     * @param $from_id
     * @param $data
     * @return string
     */
    public function onTask($server,$fd,$from_id,$data)
    {
        // 向客户端发送数据
        $logFile = __DIR__.'/../log/data.log';
        $file = fopen($logFile,'a+');
        $date = date('Y-m-d H:i:s',time());
        fwrite($file,"{$date} : {$data}\r\n");
        fclose($file);
        $result = $this->sync($data);
        return 'finish';
    }

    /**
     * Name: onFinish
     * User: aimer
     * Date: 2019/5/30
     * Time: 下午2:40
     * @param $server
     * @param $fd
     * @param $data
     * @return string
     */
    public function onFinish($server,$fd,$data)
    {
        return 'finished';
    }

    /**
     * Name: sync
     * User: aimer
     * Date: 2019/5/30
     * Time: 下午2:40
     * @param $id
     * @return bool
     * @throws yii\web\NotFoundHttpException
     */
    public function sync($id)
    {
        if (!$id) {
            return false;
        }
        $sql = "SELECT * FROM supplier WHERE status='10' AND id={$id}";
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
                if ($detail['level']) {
                    $supplierModel->level = $detail['level'];
                }
                $supplierModel->save();
            }
        }
    }
}