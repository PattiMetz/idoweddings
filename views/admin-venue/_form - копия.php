<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Region;
use app\models\Destination;
use app\models\Location;
use app\models\Country;
use app\models\VenueType;
use app\models\Vibe;
use app\models\VenueService;
use app\models\venue\VenueContact;

/* @var $this yii\web\View */
/* @var $model app\models\venue\Venue */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs("
$('.add_contact').click(function(){
    $('.add_contact_form').show();
    $(this).hide();
})
$('#venuetax-commission_type input').change(function(){
    if($(this).val()=='0') {
        $('.commissions').addClass('invisible');
        
    }
    if($(this).val()=='1') {
        $('.commissions').addClass('invisible');
        $('.field-venuetax-commission').removeClass('invisible');
    }
    if($(this).val()=='2') {
        $('.commissions').addClass('invisible');
        $('.field-venuetax-commission_package').removeClass('invisible');
        $('.field-venuetax-commission_food').removeClass('invisible');
        $('.field-venuetax-commission_items').removeClass('invisible');
    }
})
",4);

$this->registerJs("
function add_phone(contact_id, key){
    
    var html = '';
    var k = $('.phones').find('select').length;
    if(!k)
        k=0;
    html = html + '<p>';
    html = html + '<select name=\"contact[' + contact_id + '][phones][' + k + '][type]\"><option value=\"0\">General</option><option value=\"1\">Mobile</option><option value=\"2\">Fax</option></select>';
    html = html + '<input type=\"text\" name=\"contact[' + contact_id + '][phones][' + k + '][phone]\">';      
    html = html + '</p>';  
    $('.contact_' + key + ' .phones').append(html);           
}
",1);
?>

<div class="venue-form clearfix">
    <div class="col-sm-6">
        <?php $form = ActiveForm::begin([
            'layout' => 'horizontal',
            
            'fieldConfig' => [
                'horizontalCssClasses' => [
                    'label' => 'col-sm-4',
                    'wrapper' => 'col-sm-8',
                    'error' => '',
                    'hint' => '',
                ]
            ],
        ]); ?>
        <?php echo $form->errorSummary($model); ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'featured_name')->textInput(['maxlength' => true]) ?>

        <?php $region           = new Region();?>
        <?php $location         = $model->location;?>
        <?php $location_list    = ($location)?$location->getList($location->destination_id):array();?>
        <?php $destination      = new Destination();?>
        <?php $destination_list = ($location)?$destination->getList($location->destination->region_id):array();?>
        <?php $region_id        = ($location)?$location->destination->region_id:'';?>
        <?php $destination_id   = ($location)?$location->destination_id:'';?>
        <?php $type             = new VenueType();?>
        <?php $vibe             = new Vibe();?>
        <?php $service          = new VenueService();?>


        <div class="form-group field-location-name required">
            <?php echo Html::label('Region','region_id',array('class'=>'control-label col-sm-4'));?>
            <div class="col-sm-8">
                <?= Html::dropDownList('region_id', $region_id, $region->getList(),
                            [
                                'class'  => 'form-control',
                                'prompt' => 'Select a region', 
                                'onchange'=>'
                                    var id = $(this).val();
                                    $.ajax({
                                    url:"'.Yii::$app->urlManager->createUrl(["admin-mastertable/dynamicdestinations"]).'",
                                    method:"POST",
                                    data:{"region_id":id},
                                    success:function(data){
                                        $("#destination_id").html( data );
                                        $("#venue-location_id").html("");
                                    }
                                })'
                            ]);
                ?>
            </div>
        </div>
        <div class="form-group field-destination-name required">
            <?php echo Html::label('Destination','destination_id',array('class'=>'control-label col-sm-4'));?>
            <div class="col-sm-8">
                <?= Html::dropDownList('destination_id', $destination_id, $destination_list,
                    [
                        'id'=>'destination_id',
                        'class'  => 'form-control',
                        'prompt' => 'Select a region', 
                        'onchange'=>'
                            var id = $(this).val();
                            $.ajax({
                            url:"'.Yii::$app->urlManager->createUrl(["admin-mastertable/dynamiclocations"]).'",
                            method:"POST",
                            data:{"destination_id":id},
                            success:function(data){
                                $("#venue-location_id").html( data );
                            }
                        })'
                    ]);
                ?>
            </div>
        </div>

        <?= $form->field($model, 'location_id')->dropDownList($location_list,['prompt' => 'Select a location']) ?>

        

      <h2>Address details</h2>
        <?php $country = new Country();?>
        <?= $form->field($model->address, 'country_id')->dropDownList($country->getList()) ?>

        <?= $form->field($model->address, 'state')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model->address, 'zip')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model->address, 'city')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model->address, 'address')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model->address, 'timezone')->dropDownList(Yii::$app->params['timezones']) ?>

        <?= $form->field($model->address, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model->address, 'site')->textInput(['maxlength' => true]) ?>

        <h2>Contact Details</h2>
        <?php $key=0;?>
        <?php if(isset($model->contacts) && count($model->contacts)>0) {?> 

            <?php foreach ($model->contacts as $key=>$contact) {?>

                <div class="contact_<?=$key?>">
                    <?= $form->field($contact, "[$key]contact_type")->dropDownList(['Contact - for Events', 'Contact - Manager/Sales', 'Contact - Groups/Accommodation']) ?> 

                    <?= $form->field($contact, "[$key]name")->textInput(['maxlength' => true]) ?>

                    <?= $form->field($contact, "[$key]email")->textInput(['maxlength' => true]) ?>

                    <?= $form->field($contact, "[$key]skype")->textInput(['maxlength' => true]) ?>

                    <div class="form-group required">
                        
                        <?php echo Html::label('Phone','',array('class'=>'control-label col-sm-4'));?>
                        
                        <div class="col-sm-8 phones">

                            <?php if(is_array($contact->phones)) {
                                
                                foreach($contact->phones as $k=>$phone) {?>
                                    <p>
                                        <?= Html::dropDownList('contact['.$key.'][phones]['.$k.'][type]', $phone['type'], ['General','Mobile','Fax']);?>
                                     
                                        <?= Html::textInput('contact['.$key.'][phones]['.$k.'][phone]', $phone['phone']);?>
                                    </p>    
                                <?php }

                            }?>
                        </div>
                        <div class="form_group">
                           <?= Html::Button('Add phone', ['class' => 'btn btn-primary add_phone','onclick'=>'add_phone('.$contact->id.','.$key.')']) ?>
                        </div>
                    </div>  

                </div>

            <?php }?>
        
        <?php }?>    
        <div class="form_group">
           <?= Html::Button('Add contact', ['class' => 'btn btn-primary add_contact']) ?>
        </div>
        <?php $key++;?>
        <div class="add_contact_form contact_<?=$key?>" style="display:none">
            <?php $new_contact = new VenueContact();
                  $new_contact->venue_id = $model->id; 
                  ?>

            <?= $form->field($new_contact, "[$key]venue_id")->hiddenInput()->label(false) ?>

            <?= $form->field($new_contact, "[$key]contact_type")->dropDownList(['Contact - for Events', 'Contact - Manager/Sales', 'Contact - Groups/Accommodation']) ?> 

            <?= $form->field($new_contact, "[$key]name")->textInput(['maxlength' => true]) ?>

            <?= $form->field($new_contact, "[$key]email")->textInput(['maxlength' => true]) ?>

            <?= $form->field($new_contact, "[$key]skype")->textInput(['maxlength' => true]) ?>

            <div class="form-group required">
                
                <?php echo Html::label('Phone','',array('class'=>'control-label col-sm-4'));?>
                
                <div class="col-sm-8 phones">
                    <p>
                        <?= Html::dropDownList('contact['.$key.'][phones][0][type]', '', ['General','Mobile','Fax']);?>
                             
                        <?= Html::textInput('contact['.$key.'][phones][0][phone]', '');?>
                    </p>  

                </div>

                <div class="form_group">
                    <?= Html::Button('Add phone', ['class' => 'btn btn-primary add_phone','onclick'=>'add_phone('.(isset($contact->id)?$contact->id:0).', '.$key.')']) ?>
                </div>
            </div>    
        </div>
        <div class="form-group required">
            <label>Updated by </label> <?=$model->user?> <?=$model->updated_at?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="col-sm-12">
            <div class="col-sm-6">
                 <?= $form->field($model, 'active',  [
                        'horizontalCssClasses' => [
                            'offset' => 'col-sm-offset-0',
                            'wrapper' => '',
                        ]
                    ])->checkbox() ?>
                  <div class="form-group field-location-payment required">
                    <label>Payment:</label>
                    <span>05.01.2016</span>
                  </div>
                  <div class="form-group field-location-payment required">
                    <label>Number of users:</label>
                    <a href="#">10</a>
                  </div>
             </div>
            <div class="col-sm-6"> 
                <?= $form->field($model, 'featured',  [
                        'horizontalCssClasses' => [
                            'offset' => 'col-sm-offset-0',
                            'wrapper' => '',
                        ]
                    ])->checkbox() ?>
                <div class="form-group field-location-payment required">
                    <label>Expiration Date:</label>
                    <span>05.01.2017</span>
                  </div>
            </div>
        </div>    
        <?= $form->field($model, 'comment')->textarea(['rows' => 2]) ?>

        <?= $form->field($model, 'guest_capacity')->textInput(['maxlength' => true]) ?>
        
        <h2>Venue Type</h2>

        <div class="form-group required">
            
            <?= Html::checkbox('select_type',false,['class'=>'select_all','id'=>'select_types']);?>

            <?= Html::label('Check all that apply','select_types',array('class'=>'control-label col-sm-4'));?>

        </div>

        <?= $form->field($model, 'types_array',['template'=>"{input}{hint}\n\t{error}"])->checkBoxList($type->getList(),['class'=>'checkBox_block', 'label'=>'']) ?>
       
        <h2>Venue Vibe</h2>

        <div class="form-group required">
            
            <?= Html::checkbox('select_type',false,['class'=>'select_all','id'=>'select_vibes']);?>

            <?= Html::label('Check all that apply','select_vibes',array('class'=>'control-label col-sm-4'));?>

        </div>
              
        <?= $form->field($model, 'vibes_array',['template'=>"{input}{hint}\n\t{error}"])->checkBoxList($vibe->getList(),['class'=>'checkBox_block']) ?>

        <h2>Venue provides</h2>

        <div class="form-group required">
            
            <?= Html::checkbox('select_type',false,['class'=>'select_all','id'=>'select_services']);?>

            <?= Html::label('Check all that apply','select_services',array('class'=>'control-label col-sm-4'));?>

        </div>
              
        <?= $form->field($model, 'services_array',['template'=>"{input}{hint}\n\t{error}"])->checkBoxList($service->getList(),['class'=>'checkBox_block']) ?>
       
        <h2>Venue Tax type</h2>
        
        <?= $form->field($model->tax, 'tax')->textInput() ?>

        <?= $form->field($model->tax, 'service_rate')->textInput() ?>

        <?= $form->field($model->tax, 'our_service_rate')->textInput() ?>

        <?= $form->field($model->tax, 'agency_service_rate')->textInput() ?>

        <?= $form->field($model->tax, 'comment')->textarea(['rows' => 1]) ?>

        <h2>Venue Commission</h2>
        <?= $form->field($model->tax, 'commission_type',['template'=>"{input}{hint}\n\t{error}",'horizontalCssClasses' => [
                            'wrapper' => 'required',
                        ]])->radioList(['Prices are Net','Prices are Commissionable','Negotiated Wholesale rates']) ?>

        <?= $form->field($model->tax, 'commission', ['options' => ['class' => 'form-group invisible commissions']])->textInput(['class'=>'form-control small-input']) ?>

        <?= $form->field($model->tax, 'commission_package', ['options' => ['class' => 'form-group invisible commissions']])->textInput(['class'=>'form-control small-input']) ?>

        <?= $form->field($model->tax, 'commission_food', ['options' => ['class' => 'form-group invisible commissions']])->textInput(['class'=>'form-control small-input']) ?>

        <?= $form->field($model->tax, 'commission_items', ['options' => ['class' => 'form-group invisible commissions']])->textInput(['class'=>'form-control small-input']) ?>

        <h2>Accommodation Details</h2>

        <?= $form->field($model->tax, 'accommodation_commission_type',['template'=>"{input}{hint}\n\t{error}"])->radioList(['Prices are Net','Prices are Commissionable']) ?>

        <?= $form->field($model->tax, 'accommodation_commission', ['options' => ['class'=>'invisible']])->textInput() ?>

        <?= $form->field($model->tax, 'accomodation_wholesale',['horizontalCssClasses' => ['offset' => 'col-sm-offset-0'], 'template'=>"{input}{hint}\n\t{error}"])->checkbox() ?>

       
    </div>
    </div>    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
