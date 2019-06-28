<?php

namespace backend\controllers;

use Yii;
use backend\models\Answer;
use backend\models\AnswerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use backend\models\Question;

/**
 * AnswerController implements the CRUD actions for Answer model.
 */
class AnswerController extends Controller
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
     * Lists all Answer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AnswerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Answer model.
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
     * Creates a new Answer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $question_id = Yii::$app->request->get('question_id');
        $questionModel = Question::findOne($question_id);
        $list = $questionModel->answers;
        if ($list && count($list) >= 10) {
            Yii::$app->session->setFlash('error', "评价'{$questionModel->title}'的选项已经添加10条!");
            return Yii::$app->getResponse()->redirect(Url::to('/question/index'));
        }
        $model = new Answer();
        $model->count = count($list) + 1;
        if ($request = Yii::$app->request->post()) {
            $model->title = $request['question_title'];
            $model->desc = $request['question_desc'];
            $model->type = $request['question_type'];
            $model->answers = $request['answers'];
            $model->options = $request['options'];
            $model->question_id = $request['question_id'];
            $model->ratio = !empty($request['question_ratio']) ? $request['question_ratio']: '';
            if ($model->validate() && $model->save()) {
                return $this->redirect( Url::to(['create','question_id'=>$request['question_id']]));
            }
            $question_id = $request['question_id'];
        }
        return $this->render('create', [
            'model' => $model,
            'question_id' => $question_id,
        ]);
    }

    /**
     * Updates an existing Answer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($request = Yii::$app->request->post()) {
            $model->title = $request['question_title'];
            $model->desc = $request['question_desc'];
            $model->type = $request['question_type'];
            $model->answers = $request['answers'];
            $model->options = $request['options'];
            $model->question_id = $request['question_id'];
            $model->ratio = $request['question_ratio'];
            if ($model->validate() && $model->save()) {
                return $this->redirect( Url::to(['question/preview','question_id'=>$request['question_id']]));
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $question_id = Yii::$app->request->get('question_id');
        $options = json_decode($model->options,true);
        //var_dump($options);die;
        return $this->render('update', [
            'model' => $model,
            'question_id' => $question_id,
        ]);
    }

    /**
     * Deletes an existing Answer model.
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
     * Finds the Answer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Answer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Answer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('answer', 'The requested page does not exist.'));
    }

    /**
     *
     * 问答页
     *
     **/
    public function actionAnswer()
    {
        $model = new Answer();
        if ($request = Yii::$app->request->post()) {
            $model->title = $request['question_title'];
            $model->desc = $request['question_desc'];
            $model->type = $request['question_type'];
            $model->answers = $request['answers'];
            $model->options = $request['options'];
            $model->object_id = $request['object_id'];
            $model->ratio = $request['question_ratio'];
            if ($model->validate() && $model->save()) {
                return $this->redirect( Url::to(['answer','object_id'=>$request['object_id']]));
            }
            $object_id = $request['object_id'];
        }
        $object_id = Yii::$app->request->get('object_id');
        return $this->render('answer',
            [
                'model'=>$model,
                'object_id' => $object_id,
            ]
        );
    }

}
