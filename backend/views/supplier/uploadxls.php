<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SuppliersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('suppliers', 'Suppliers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suppliers-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>

        <?php $form = ActiveForm::begin() ?>
            <?php
                echo $form->field($model, 'imageFile')->widget(FileInput::classname());
            ?>
            <button>Submit</button>
        <?php ActiveForm::end() ?>
    </p>

</div>
