<?php

namespace backend\controllers;

use Yii;
use backend\models\Template;
use backend\models\TemplateSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\TemplateRecord;
use backend\models\Question;
use yii\helpers\Url;

/**
 * TemplateController implements the CRUD actions for Template model.
 */
class TemplateController extends Controller
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
     * Lists all Template models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TemplateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Template model.
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
     * Creates a new Template model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Template();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Template model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Template model.
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
     * Finds the Template model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Template the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Template::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('template', 'The requested page does not exist.'));
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
        $template_id = Yii::$app->request->get('template_id');
        $model = $this->findModel($template_id);
        $answers = $model->answers;
        return $this->render('preview', [
            'model' => $model,
            'answers' => $answers,
            'template_id' => $template_id,
        ]);
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
        $template_id = Yii::$app->request->get('template_id');
        $question_id = Yii::$app->request->get('question_id');
        $model = $this->findModel($template_id);

        $questionModel = Question::findOne($question_id);
        $answers = $model->answers;
        $templateRecordModel = new TemplateRecord();
        $user_id = Yii::$app->user->identity->id;
        $hasFinished = $templateRecordModel->hasTemplateRecord($template_id, $question_id, $user_id);

        if ($hasFinished) {
            Yii::$app->session->setFlash('error', '您已完成作答，请勿重新作答!');
            return Yii::$app->getResponse()->redirect(Url::to('/question/my'));
        }

        $status = $questionModel->status;
        if ($status == 1) {
            Yii::$app->session->setFlash('error', '评价还未开始!');
            return Yii::$app->getResponse()->redirect(Url::to('/question/my'));
        }
        if ($status == 3) {
            Yii::$app->session->setFlash('error', '评价已经结束!');
            return Yii::$app->getResponse()->redirect(Url::to('/question/my'));
        }

        if (Yii::$app->request->isPost) {
            $result = [];
            //保存对应的提交结果
            $post = Yii::$app->request->post();
            if ($templateRecordModel->load(Yii::$app->request->post()) && $templateRecordModel->save()) {
                Yii::$app->session->setFlash('success', '已完成作答!');
                return Yii::$app->getResponse()->redirect(Url::to('/question/my'));
            }
        }
        return $this->render('survey', [
            'model' => $model,
            'templaterecordmodel' => $templateRecordModel,
            'answers' => $answers,
            'template_id' => $template_id,
            'question_id' => $question_id,
            'sid' => $questionModel->sid,
        ]);
    }


    /**
     * Name: actionPreview 调查问卷预览
     * User: aimer
     * Date: 2019/5/6
     * Time: 上午9:13
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionResult()
    {
        $template_id = Yii::$app->request->get('template_id');
        $question_id = Yii::$app->request->get('question_id');
        $model = $this->findModel($template_id);
        $templateRecordModel = TemplateRecord::getByTemplateId($template_id);
        $answers = $model->answers;
        return $this->render('result', [
            'model' => $model,
            'answers' => $answers,
            'template_id' => $template_id,
            'templaterecordmodel' => $templateRecordModel,
            'question_id' => $question_id
        ]);
    }
}
