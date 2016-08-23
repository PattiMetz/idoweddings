<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\vendor\VendorSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vendor-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'slug') ?>

    <?= $form->field($model, 'tax_rate') ?>

    <?= $form->field($model, 'tax_service_rate') ?>

    <?php // echo $form->field($model, 'comm_prices') ?>

    <?php // echo $form->field($model, 'comm_rate') ?>

    <?php // echo $form->field($model, 'comm_note') ?>

    <?php // echo $form->field($model, 'admin_notes') ?>

    <?php // echo $form->field($model, 'payment_notes') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
