<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MainCompany */
/* @var $address app\models\MainCompanyAddress */
/* @var $phone app\models\MainCompanyPhone */
/* @var $contact app\models\MainCompanyContact */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="main-company-form">
    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'options' => ['class' => 'clearfix ajax-form'],
        'fieldConfig' => [
            'horizontalCssClasses' => [
                'label' => 'col-md-4',
                'wrapper' => 'col-md-8',
                'error' => '',
                'hint' => '',
            ]
        ],
    ]); ?>
    <div class="col-md-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <div class="title col-md-12">
            <h4>Address details</h4>
        </div>
        <?= $form->field($address, 'address')->textInput() ?>
        <?= $form->field($address, 'city')->textInput() ?>
        <?= $form->field($address, 'zip')->textInput() ?>
        <?= $form->field($address, 'state')->textInput() ?>
        <?= $form->field($address, 'country_id')->dropDownList($country->getList(),['class'  => 'form-control chosen-style']) ?>
        <?= $form->field($address, 'time_zone')->dropDownList(Yii::$app->params['timezones'],['class'  => 'form-control chosen-style']) ?>
        <?= $form->field($address, 'email')->textInput() ?>
        <?= $form->field($address, 'website')->textInput() ?>
    </div>
    <div class="col-md-6">
        <div class="col-md-12 num_users">
            Number of users: <a href="#" class="text-success">10</a>
        </div>
        <div class="col-md-12 title">
            <h4>Contact details</h4>
        </div>
        <?= $form->field($contact, 'name')->textInput() ?>
        <?= $form->field($contact, 'email')->textInput() ?>
        <?= $form->field($contact, 'skype')->textInput() ?>
        <?//= $form->field($phone, 'phone')->textInput() ?>
        <div class="form-group"><?= Html::button('Add phone', ['class' => 'btn btn-success pull-right']) ?></div>
        <div class="form-group"><?= Html::button('Add contact', ['class' => 'btn btn-success pull-right']) ?></div>
    </div>

    <div class="col-md-12 text-center">
        <div class="form-group"><?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?></div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
