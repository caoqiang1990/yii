<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\models\PasswordResetRequestForm;
use backend\models\ResetPasswordForm;
use common\models\AdminLog;
use backend\models\Department;
use backend\models\Supplier;
use backend\models\SupplierType;
use backend\models\SupplierLevel;
use backend\models\SupplierNature;
use backend\models\SupplierFunds;
use backend\models\SupplierCategory;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','reset','reset-password'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index','reset','reset-password'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $departmentNameArr = '';
        $departmentValueArr = [];
        $typeNameArr = '';
        $typeValueArr = [];

        $deparmentArr = Department::getDepartment();
        $departmentNameStr = "'" . join("','", array_values($deparmentArr) ) . "'";  // 使用需要的符号拼接

        foreach ($deparmentArr as $department_id => $deparment_name) {
            $departmentValueArr[] = Supplier::getCountByParams('department',$department_id);
        }
        $totalCount = Supplier::getTotalCount();

        //供应商业务类型
        $typeArr = SupplierType::getTypes();
        $typeNameStr = "'" . join("','", array_values($typeArr) ) . "'";  // 使用需要的符号拼接
        foreach ($typeArr as $type_id => $type_name) {
            $typeValueArr[] = Supplier::getCountByParams('business_type',$type_id);
        }

        //供应商等级
        $levelArr = SupplierLevel::getLevels();
        $levelNameStr = "'" . join("','", array_values($levelArr) ) . "'";  // 使用需要的符号拼接
        foreach ($levelArr as $level_id => $level_name) {
            $levelValueArr[] = Supplier::getCountByParams('level',$level_id);
        }

        //供应商企业性质
        $natureArr = SupplierNature::getNature();
        $natureNameStr = "'" . join("','", array_values($natureArr) ) . "'";  // 使用需要的符号拼接
        $key = 0;
        foreach ($natureArr as $nature_id => $nature_name) {
            $natureValueArr[$key]['value'] = Supplier::getCountByParams('firm_nature',$nature_id);
            $natureValueArr[$key]['name'] = $nature_name;
            $key++;
        }

        //供应商分类一级
        $categoryArr = SupplierCategory::getCategorys();
        $categoryNameStr = "'" . join("','", array_values($categoryArr) ) . "'";  // 使用需要的符号拼接
        $k = 0;
        foreach ($categoryArr as $category_id => $category_name) {
            $categoryValueArr[$k]['value'] = Supplier::getCountByParams('cate_id1',$category_id);
            $categoryValueArr[$k]['name'] = $category_name;
            $categorySelectedArr[$category_name] = $k < 6;
            $k++;
        }
        //供应商交易金额
        $yearArr[] = date('Y') - 4;
        $yearArr[] = date('Y') - 3;
        $yearArr[] = date('Y') - 2;
        $yearArr[] = date('Y') - 1;
        $yearStr = "'" . join("','", array_values($yearArr) ) . "'";  // 使用需要的符号拼接
        foreach ($yearArr as $year) {
            //交易金额
            $tradeFundArr['trade'][] = SupplierFunds::getTotalTradeFundsByYear($year) / 10000;
            //当年供应商数量
            $tradeFundArr['count'][] = SupplierFunds::getTotalCountByYear($year);
        }
        return $this->render('index',
            [
                'nameStr' => $departmentNameStr,
                'valueStr' => implode(',',$departmentValueArr),
                'totalCount' => $totalCount,
                'typeNameStr' => $typeNameStr,
                'typeValueStr' => implode(',',$typeValueArr),
                'levelNameStr' => $levelNameStr,
                'levelValueStr' => implode(',',$levelValueArr),
                'natureNameStr' => $natureNameStr,
                'natureValueStr' => json_encode($natureValueArr),
                'categoryNameStr' => $categoryNameStr,
                'categoryValueStr' => json_encode($categoryValueArr),
                'categorySelectedStr' => json_encode($categorySelectedArr),
                'yearStr' => $yearStr,
                'totalSupplierCount' => implode(',',$tradeFundArr['count']),
                'totalTradeFund' => implode(',',$tradeFundArr['trade']),
            ]
        );
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            AdminLog::saveLog('user', 'login', json_encode($model->user->toArray()), $model->user->id);
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * 重
     * @return [type] [description]
     */
    public function actionReset()
    {
        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }
        
        return $this->render('reset', [
            'model' => $model,
        ]);
    }
    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
