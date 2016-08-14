<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\VendorType;
use yii\helpers\ArrayHelper;
use app\models\Country;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\vendor\Vendor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vendor-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal',
        'options' => ['class' => 'clearfix '],
        'fieldConfig' => [
            'horizontalCssClasses' => [
                'label' => 'col-md-4',
                'wrapper' => 'col-md-8',
                'error' => '',
                'hint' => '',
            ]
        ],]); ?>

    <div class="border-block">
        <div class="col-md-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="panel-group" id="vendor-accordion" role="tablist">
        <div class="panel panel-default">
            <div class="panel-heading" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                <h4 class="panel-title">
                    <a>
                        Vendor type
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <div class="col-md-4 col-md-offset-4 collapse_form">
                        <div class="checkbox">
                            <label>
                                <?= Html::checkbox('all_type', null, ['class' => 'all_types']) ?> Select All
                            </label>
                        </div>
                        <div class="types-group">
                            <?= Html::checkboxList('types', ArrayHelper::getColumn($model->vendorHasTypes, 'type_id'), VendorType::typeLists()) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" >
                <h4 class="panel-title">
                    <a>
                        Address details
                    </a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                <div class="panel-body">
                    <?= 
                        $form->field($model->organization, 'address')->textInput() .
                        $form->field($model->organization, 'city')->textInput() .
                        $form->field($model->organization, 'state')->textInput().
                        $form->field($model->organization, 'zip')->textInput() .
                        $form->field($model->organization, 'country_id')->dropDownList(Country::getCountryList(),['class'  => 'form-control chosen-style']) .
                        $form->field($model->organization, 'timezone')->dropDownList(Yii::$app->params['timezones'],['class'  => 'form-control chosen-style']) .
                        $form->field($model->organization, 'email')->textInput() .
                        $form->field($model->organization, 'site')->textInput()
                    ?>    
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading collapsed" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" >
                <h4 class="panel-title">
                    <a>
                        Contact details
                    </a>
                </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                <div class="panel-body">
<!--                    contacts block-->
                    <div class="cont_wrap"  data-comp_id="<?= $model->organization_id ?>" data-action="<?= \yii\helpers\Url::to(['admin-vendor/contacts']) ?>">
                        <?php $c=0; foreach ($model->organization->contacts as $contact){ $c++; ?>
                            <div id="c_<?= $contact->id?>" class="contact-group col-md-9" data-cid="<?= $contact->id?>">
                                <div class="cont-fields">
                                    <?= $form->field($contact, 'first_name')->textInput(['data-name' => 'first_name']) ?>
                                    <?= $form->field($contact, 'email')->textInput(['data-name' => 'email']) ?>
                                    <?= $form->field($contact, 'skype')->textInput(['data-name' => 'skype']) ?>
                                </div>
                                <div class="phones-wrap">
                                    <?php $p=0; foreach ($contact->contactPhones as $phone){ $p++; ?>
                                        <div class="phone_row rec_<?= $c.$p ?>"
                                             data-pid="<?= $phone->id ?>"
                                             data-action="<?= \yii\helpers\Url::to(['admin-vendor/delete_phone']) ?>">
                                            <div class="col-md-5">
                                                <?= $form->field($phone, 'type')->dropDownList($phone->phone_types, [
                                                    'class' => 'form-control update_on_field',
                                                    'data-field' => 'type',
                                                    'data-id' => $phone->id,
                                                    'data-action' => \yii\helpers\Url::to(['admin-vendor/update_phone'])
                                                ]) ?>
                                            </div>
                                            <div class="col-md-6">
                                                <?= $form->field($phone, 'phone')->textInput([
                                                    'class' => 'form-control update_on_field',
                                                    'data-field' => 'phone',
                                                    'data-id' => $phone->id,
                                                    'data-action' => \yii\helpers\Url::to(['admin-vendor/update_phone'])
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
                                        'data-action' => \yii\helpers\Url::to(['admin-vendor/add_phone_field']),
                                    ]) ?>
                                </div>
                                <div class="form-group">
                                    <?= Html::button('Delete contact', ['class' => 'del_contact btn btn-warning pull-right']) ?>
                                </div>
                            </div>
                            <br>
                        <?php } ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group"><?= Html::button('Add contact', ['class' => 'add_contact btn btn-success pull-right']) ?></div>
                    </div>
<!--                    end contacts block-->
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading collapsed" role="tab" id="headingFour" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" >
                <h4 class="panel-title">
                    <a>
                        Destination
                    </a>
                </h4>
            </div>
            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                <div class="panel-body">
                    <?
                    $destinationHtml = '';
                    foreach($model->vendorDestinations as $dest){
                        $destinationHtml .= '<div class="col-md-4">';
                        $destinationHtml .= $form->field($dest, 'region')
                            ->dropDownList(\app\models\Region::getStatList(),[
                                'class'  => 'form-control chosen-style update_on_field',
                                'data-id' => $dest->id,
                                'data-action' => Url::to(['admin-vendor/update_destination']),
                                'data-field' => 'region'
                        ]);
                        $destinationHtml .= $form->field($dest, 'destination')
                            ->dropDownList(\app\models\Destination::getStatList(6),[//todo change dynamic depend on region
                            'class'  => 'form-control chosen-style update_on_field',
                            'data-id' => $dest->id,
                            'data-action' => Url::to(['admin-vendor/update_destination']),
                            'data-field' => 'destination'
                        ]);
                        $destinationHtml .= $form->field($dest, 'location')
                            ->dropDownList(\app\models\Location::getStatList(80),[//todo change dynamic depend on region
                            'class'  => 'form-control chosen-style update_on_field',
                            'data-id' => $dest->id,
                            'data-action' => Url::to(['admin-vendor/update_destination']),
                            'data-field' => 'location'
                        ]);
                        $destinationHtml .= '</div>';
                    };
                    echo $destinationHtml ?>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading collapsed" role="tab" id="headingFive" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" >
                <h4 class="panel-title">
                    <a>
                        Vendor tax
                    </a>
                </h4>
            </div>
            <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                <div class="panel-body">
                    <div class="col-md-4">
                        <?=
                            $form->field($model, 'tax_rate')->textInput() .
                            $form->field($model, 'tax_service_rate')->textInput()
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading collapsed" role="tab" id="headingSix" data-toggle="collapse" data-parent="#accordion" href="#collapseSix">
                <h4 class="panel-title">
                    <a>
                        Vendor commission
                    </a>
                </h4>
            </div>
            <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <?= $form->field($model, 'comm_prices')->radioList(['1' => 'Prices are Net', '2' =>'Prices are Commissionable']) ?>
                        </div>
                        <div class="col-md-3">
                            <?=  $form->field($model, 'comm_rate')->textInput() ?>
                        </div>
                        <div class="col-md-5">
                            <?= $form->field($model, 'comm_note')->textInput() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading collapsed" role="tab" id="headingSeven" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                <h4 class="panel-title">
                    <a>
                        Documents
                    </a>
                </h4>
            </div>
            <div id="collapseSeven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSeven">
                <div class="panel-body">
                    ...
                </div>
            </div>
        </div>
    </div>

    <?//= $form->field($model, 'admin_notes')->textInput(['maxlength' => true]) ?>
    <?//= $form->field($model, 'payment_notes')->textInput(['maxlength' => true]) ?>
    <?//= $form->field($model, 'status')->textInput() ?>

    <div class="col-md-12 text-center">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
