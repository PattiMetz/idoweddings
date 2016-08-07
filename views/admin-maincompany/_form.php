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
    <?php $ajax_form = !$model->isNewRecord ? 'ajax-form' :'' ?>
    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'options' => ['class' => 'clearfix ' . $ajax_form ],
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
        <div class="cont_wrap"  data-comp_id="<?= $model->id ?>" data-action="<?= \yii\helpers\Url::to(['admin-maincompany/contacts']) ?>">
            <?php $c=0; foreach ($contacts as $contact){ $c++; ?>
                <div id="c_<?= $contact->id?>" class="contact-group" data-cid="<?= $contact->id?>">
                    <div class="cont-fields">
                        <?= $form->field($contact, 'name')->textInput(['data-name' => 'name']) ?>
                        <?= $form->field($contact, 'email')->textInput(['data-name' => 'email']) ?>
                        <?= $form->field($contact, 'skype')->textInput(['data-name' => 'skype']) ?>
                    </div>
                    <div class="phones-wrap">
                        <?php $p=0; foreach ($contact->mainCompanyPhones as $phone){ $p++; ?>
                            <div class="phone_row rec_<?= $c.$p ?>"
                                 data-pid="<?= $phone->id ?>"
                                 data-action="<?= \yii\helpers\Url::to(['admin-maincompany/delete_phone']) ?>">
                                <div class="col-md-5">
                                    <?= $form->field($phone, 'type')->dropDownList($phone->phone_types, [
                                        'class' => 'form-control update_on_field',
                                        'data-field' => 'type',
                                        'data-id' => $phone->id,
                                        'data-action' => \yii\helpers\Url::to(['admin-maincompany/update_phone'])
                                    ]) ?>
                                </div>
                                <div class="col-md-6">
                                    <?= $form->field($phone, 'phone')->textInput([
                                        'class' => 'form-control update_on_field',
                                        'data-field' => 'phone',
                                        'data-id' => $phone->id,
                                        'data-action' => \yii\helpers\Url::to(['admin-maincompany/update_phone'])
                                        ]) ?>
                                </div>
                                <div class="col-md-1" style="color: red; padding-top: 10px; cursor: pointer">
                                    <span class="delete_phone glyphicon glyphicon-remove" aria-hidden="true"></span>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <?= Html::button('Add phone', [
                            'class' => 'add_phone btn btn-success pull-right',
                            'data-action' => \yii\helpers\Url::to(['admin-maincompany/add_phone_field']),
                        ]) ?>
                    </div>
                    <div class="form-group">
                        <?= Html::button('Delete contact', ['class' => 'del_contact btn btn-warning pull-right']) ?>
                    </div>
                </div>
                <br>
            <?php } ?>
        </div>
        <div class="form-group"><?= Html::button('Add contact', ['class' => 'add_contact btn btn-success pull-right']) ?></div>
    </div>

    <div class="col-md-12 text-center">
        <div class="form-group"><?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?></div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
