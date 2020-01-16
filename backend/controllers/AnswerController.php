<?php

namespace backend\controllers;

use backend\models\TemplateAnswer;
use Yii;
use backend\models\Answer;
use backend\models\AnswerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use backend\models\Template;

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
        $template_id = Yii::$app->request->get('template_id');
        $model = new Answer();
        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->save()) {
            return $this->redirect(Url::to(['create', 'template_id' => $model->template_id]));
        }
        return $this->render('create', [
            'model' => $model,
            'template_id' => $template_id,
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
            if ($model->load($request) && $model->save()) {
                return $this->redirect(Url::to(['template/index']));
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        //获取模板id
        return $this->render('create', [
            'model' => $model,
            'template_id' => Yii::$app->request->get("template_id"),
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
                return $this->redirect(Url::to(['answer', 'object_id' => $request['object_id']]));
            }
            $object_id = $request['object_id'];
        }
        $object_id = Yii::$app->request->get('object_id');
        return $this->render('answer',
            [
                'model' => $model,
                'object_id' => $object_id,
            ]
        );
    }

}
