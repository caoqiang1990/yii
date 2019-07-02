<?php

namespace backend\controllers;

use Yii;
use backend\models\Question;
use backend\models\QuestionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use mdm\admin\models\User;
use backend\models\Supplier;
use backend\models\QuestionRecord;
use yii\web\Response;
use yii\helpers\Url;
use backend\models\Answer;
use backend\models\SupplierLevel;

/**
 * QuestionController implements the CRUD actions for Question model.
 */
class QuestionController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Question models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new QuestionSearch();

        $request = Yii::$app->request->queryParams;
        $is_administrator = Yii::$app->user->identity->is_administrator;
        //非管理员显示自己创建的
        if ($is_administrator == 2) {
            $uid = Yii::$app->user->identity->id;
            $request['QuestionSearch']['created_by'] = $uid;
        }
        $dataProvider = $searchModel->search($request);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Question model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Question model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Question();
        $model->scenario = 'add';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $users = User::getUsers();
        $suppliers = Supplier::getSuppliers();
        $start = date('Y-m-d H:i', time());
        return $this->render('create', [
            'model' => $model,
            'users' => $users,
            'suppliers' => $suppliers,
            'start' => $start,
        ]);
    }

    /**
     * Updates an existing Question model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->player = explode(',', $model->player);
        $model->scenario = 'edit';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $users = User::getUsers();
        $suppliers = Supplier::getSuppliers();
        $start = $model->start_date;
        $end = $model->end_date;
        return $this->render('update', [
            'model' => $model,
            'users' => $users,
            'suppliers' => $suppliers,
            'start' => $start,
            'end' => $end,
        ]);
    }

    /**
     * Deletes an existing Question model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Question model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Question the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Question::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     *
     * 添加问题
     *                                                                                                                      *
     */
    public function actionQuestion()
    {
        return $this->render('question');
    }

    /**
     * Name: actionPreview 调查问卷预览
     * User: aimer
     * Date: 2019/5/6
     * Time: 上午9:13
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionPreview()
    {
        $question_id = Yii::$app->request->get('question_id');
        $model = $this->findModel($question_id);
        $answers = $model->answers;
        return $this->render('preview', [
            'model' => $model,
            'answers' => $answers,
            'question_id' => $question_id,
        ]);
    }

    /**
     * Name: beforeAction 验证防止重复提交
     * User: aimer
     * Date: 2019/5/7
     * Time: 上午10:47
     * @param $action
     * @return bool
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if ($this->enableCsrfValidation) {
                Yii::$app->getRequest()->getCsrfToken(true);
            }
            return true;
        }

        return false;
    }

    /**
     * Name: actionSurvey 调查问卷
     * User: aimer
     * Date: 2019/5/6
     * Time: 上午9:15
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionSurvey()
    {
        $question_id = Yii::$app->request->get('question_id');
        $model = $this->findModel($question_id);
        $answers = $model->answers;

        $questionRecordModel = new QuestionRecord();
        $user_id = Yii::$app->user->identity->id;
        $hasFinished = $questionRecordModel->hasQuestionRecord($question_id, $user_id);

        if ($answers && count($answers) < 10) {
            Yii::$app->session->setFlash('error', '选项不满10条，请添加完整！');
            return Yii::$app->getResponse()->redirect(Url::to('my'));
        }

        if ($hasFinished) {
            //throw new NotFoundHttpException('您已完成作答，请勿重新作答!');
            //return $this->render('finish');
            Yii::$app->session->setFlash('error', '您已完成作答，请勿重新作答!');
            return Yii::$app->getResponse()->redirect(Url::to('my'));
        }

        $status = $model->status;
        if ($status == 1) {
            //throw new NotFoundHttpException('评价还未开始!');
            Yii::$app->session->setFlash('error', '评价还未开始!');
            return Yii::$app->getResponse()->redirect(Url::to('my'));
        }
        if ($status == 3) {
            //throw new NotFoundHttpException('评价已经结束!');
            Yii::$app->session->setFlash('error', '评价已经结束!');
            return Yii::$app->getResponse()->redirect(Url::to('my'));
        }

        if (Yii::$app->request->isPost) {
            $result = [];
            //保存对应的提交结果
            $post = Yii::$app->request->post();
            //获取所有选项，及其对应结果
            $k = 0;
            foreach ($post as $key => $answer) {
                if (strpos($key, 'option_') !== false) {
                    $answer_id = substr($key, 7);
                    $info = Answer::getById($answer_id);
                    $result[$k]['question_id'] = $question_id;
                    $result[$k]['answer_id'] = $answer_id;
                    $result[$k]['result'] = $answer;
                    $result[$k]['ratio'] = $info ? $info->ratio : 100;
                    $result[$k]['created_by'] = Yii::$app->user->identity->id;
                    $result[$k]['updated_by'] = Yii::$app->user->identity->id;
                    $result[$k]['created_at'] = time();
                    $result[$k]['updated_at'] = time();
                    $k++;
                }
            }
            $questionRecordModel = new QuestionRecord();
            $questionRecordModel->addQuestionRecord($result);
            //$this->redirect(['finish']);
            Yii::$app->session->setFlash('success', '已完成作答!');
            return Yii::$app->getResponse()->redirect(Url::to('my'));
        }
        return $this->render('survey', [
            'model' => $model,
            'answers' => $answers,
            'question_id' => $question_id,
        ]);
    }

    /**
     * Name: actionSubmit 提交评价
     * User: aimer
     * Date: 2019/5/6
     * Time: 上午9:46
     */
    public function actionFinish()
    {
        return $this->render('finish');
    }


    /**
     * Name: actionSync
     * User: aimer
     * Date: 2019/5/24
     * Time: 上午10:45
     */
    public function actionSync()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->get('id');
        if ($id) {
            $model = $this->findModel($id);
            if ($model->status != 3) {
                $response_data['status'] = 'fail';
                $response_data['msg'] = '项目还未结束！';
            } else {
                //同步
                //收集答案，评测
                $level = SupplierLevel::getLevels();
                $levelFlip = array_flip($level);
                $select = 0;
                $result = 0;
                $questionRecordModel = new QuestionRecord();
                $records = $questionRecordModel::getQuestionRecordById($id);
                $sum = 4 * count($records);//最大值是4 所以
                foreach ($records as $record) {
                    $select += $record['result'];
                }
                $result = $select / $sum;
                if ($result < 0) {
                    $level = '不合格';
                }
                if ($result > 0 && $result <= 0.8) {
                    $level = '合格';
                }
                if ($result > 0.8 && $result < 1) {
                    $level = '优秀';
                }
                $level_id = $levelFlip["{$level}"];

                //修改供应商评价等级
                //调用swoole客户端
                $client = new \swoole_client(SWOOLE_SOCK_TCP);
                if (!$client->connect('127.0.0.1', 9503)) {
                    exit("connect failed. Error: {$client->errCode}\n");
                }
                $data['id'] = $model->sid;
                $data['level'] = $level_id;
                $data = serialize($data);
                $client->send($data);
                $client->close();
                $response_data['status'] = 'success';
                $response_data['msg'] = '同步成功！';
            }
        } else {
            $response_data['status'] = 'fail';
            $response_data['msg'] = 'id不能为空！';
        }
        return $response_data;
    }

    /**
     * Name: actionMy
     * User: aimer
     * Date: 2019/6/3
     * Time: 上午9:17
     * @return string
     */
    public function actionMy()
    {
        $searchModel = new QuestionSearch();
        $uid = Yii::$app->user->identity->id;

        $request = Yii::$app->request->queryParams;
        $request['QuestionSearch']['player'] = $uid;
        $request['QuestionSearch']['status'] = 1;
        $dataProvider = $searchModel->search($request);

        return $this->render('my', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Name: actionStart
     * User: aimer
     * Date: 2019/6/3
     * Time: 下午2:22
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionStart()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        if ($id) {
            $model = $this->findModel($id);
            $answers = $model->answers;
            if (!$answers || count($answers) < 10) {
                $response_data['status'] = 'fail';
                $response_data['msg'] = '请添加选项！';
                return $response_data;
            }

            $now = date('Y-m-d H:i:s', time());
            if ($model->end_date < $now) {
                $response_data['status'] = 'fail';
                $response_data['msg'] = '项目时间设置不正确！';
            } else {
                $model->scenario = 'edit';
                $model->status = 2;
                if ($model->save()) {
                    $response_data['status'] = 'success';
                    $response_data['msg'] = '评价开始';
                } else {
                    $response_data['status'] = 'fail';
                    $response_data['msg'] = '';
                }
            }
        } else {
            $response_data['status'] = 'fail';
            $response_data['msg'] = 'id不能为空！';
        }
        return $response_data;
    }

    /**
     * Name: actionEnd
     * User: aimer
     * Date: 2019/6/3
     * Time: 下午2:30
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionEnd()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        if ($id) {
            $model = $this->findModel($id);
            $model->scenario = 'edit';
            $model->status = 3;
            if ($model->save()) {
                $response_data['status'] = 'success';
                $response_data['msg'] = '评价结束';
            } else {
                $response_data['status'] = 'fail';
                $response_data['msg'] = '';
            }
        } else {
            $response_data['status'] = 'fail';
            $response_data['msg'] = 'id不能为空！';
        }
        return $response_data;
    }
}
