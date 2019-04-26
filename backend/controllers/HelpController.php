<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * HistoryController implements the CRUD actions for History model.
 */
class HelpController extends Controller
{

    /**
     * Lists all History models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
        ]);
    }

}
