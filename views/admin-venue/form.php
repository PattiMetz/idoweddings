<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Region;
use app\models\Contact;
use app\models\Destination;
use app\models\Location;
use app\models\Country;
use app\models\Currency;
use app\models\VenueType;
use app\models\Vibe;
use app\models\VenueService;
use app\models\venue\VenueContact;
use yii\helpers\Url;
use yii\bootstrap\Alert;
/* @var $this yii\web\View */
/* @var $model app\models\venue\Venue */
/* @var $form yii\widgets\ActiveForm */

$this->title = $model->id?$model->name:'Create Venue';

$this->registerJs("
$('.add_contact').click(function(){
    $('.add_contact_form').each(function(){
    	if($(this).css('display')=='none') {
    		$(this).show();
    		exit;
    	}
    })
    //$(this).hide();
})
$('#venuetax-accommodation_commission_type input').change(function(){
    if($(this).val()=='0') {
        $('.field-venuetax-accommodation_commission').addClass('invisible');
        $('.field-venuetax-accommodation_note').addClass('invisible');
    }
    if($(this).val()=='1') {
        //$('.commissions').addClass('invisible');
        $('.field-venuetax-accommodation_commission').removeClass('invisible');
        $('.field-venuetax-accommodation_note').removeClass('invisible');
    }
})
$('#venuetax-commission_type input').change(function(){
    if($(this).val()=='0') {
        $('.commissions').addClass('invisible');
        
    }
    if($(this).val()=='1') {
        $('.commissions').addClass('invisible');
        $('.field-venuetax-commission').removeClass('invisible');
        $('.field-venuetax-commission_note').removeClass('invisible');
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
    else
        k--;

    html = html + '<div class=\"col-sm-6\">';
    html = html + '<select name=\"VenueContact[' + key + '][phones][' + k + '][type]\" class=\"form-control chosen-style\"><option value=\"0\">General</option><option value=\"1\">Mobile</option><option value=\"2\">Fax</option><option value=\"3\">What\'s App</option></select>';
     html = html + '</div>';  
    html = html + '<div class=\"col-sm-6\">';
    html = html + '<input type=\"text\" class=\"form-control\" name=\"VenueContact[' + key + '][phones][' + k + '][phone]\">';      
    html = html + '</div>';  
    $('.contact_' + key + ' .phones').append(html);        
    $(\".chosen-style\").chosen();   
}
",1);
?>
<div class="clearfix">
	<ol class="breadcrumb">
		<li><?php echo Html::a('Venues',Url::to(['admin-venue/index']),['class' => "return_link text-success",'data-pjax'=>'0'])?></li>
		<li><?php echo ($model->id)?$model->name:'Create'?></li>
	</ol>
</div>
<div class="venue-form clearfix">
    <?php $form = ActiveForm::begin([
            'layout' => 'horizontal',
            'options' => ['enctype' => 'multipart/form-data', 'class' => 'clearfix ajax-form'],
            'fieldConfig' => [
                'horizontalCssClasses' => [
                    'label' => 'col-md-4',
                    'wrapper' => 'col-md-8',
                    'error' => '',
                    'hint' => '',
                ]
            ],
        ]); ?>
    <?php
		echo Alert::widget([
			'options' => [
				'class' => 'alert-danger',
				'style' => ($alert == '') ? 'display: none' : ''
			],
			'body' => $alert,
			'closeButton' => false,
		]);

		?>
	<?php

		echo Alert::widget([
			'options' => [
				'class' => 'alert-success',
				'style' => ($message == '') ? 'display: none' : ''
			],
			'body' => $message,
			'closeButton' => false,
		]);

		?>	
	<?php

		echo Alert::widget([
			'options' => [
				'class' => 'alert-info',
				'style' => 'display: none'
			],
			'body' => '',
			'closeButton' => false,
		]);

		?>
	<?php echo $form->errorSummary($model); ?>
	<div class="border-block">
		<div class="col-md-10 col-md-offset-1 update_top_block clearfix">
			
			<div class="col-md-6">
				<?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

				<?php echo $form->field($model, 'featured_name')->textInput(['maxlength' => true]) ?>
				
				<div class="checkbox_group">
					<?php echo $form->field($model, 'active',  [
							'horizontalCssClasses' => [
								'offset' => 'col-md-offset-5',
								'wrapper' => '',
							]
						])->checkbox() ?>
					
					<?php echo $form->field($model, 'featured',  [
							'horizontalCssClasses' => [
								'offset' => 'col-md-offset-5',
								'wrapper' => '',
							]
						])->checkbox() ?>
				</div>
				<div class="form-group field-location-payment required">
					<label class="col-xs-4">Payment:</label>
					<p class="col-xs-8">05.01.2016</p>
				</div>
				<div class="form-group field-location-payment required">
					<label class="col-xs-4">Expiration Date:</label>
					<p class="col-xs-8">05.01.2017</p>
				</div>
				<div class="form-group field-location-payment required">
					<label class="col-xs-4">Number of users:</label>
					<p class="col-xs-8"><a href="#" class="text-success">10</a></p>
				</div>		
			</div>
			<div class="col-md-6">
			
				<?php 
					$region           = new Region();
					$location         = $model->location;
					$location_list    = ($location)?$location->getList($location->destination_id):array();
					$destination      = new Destination();
					$destination_list = ($location)?$destination->getList($location->destination->region_id):array();
					$region_id        = ($location)?$location->destination->region_id:'';
					$destination_id   = ($location)?$location->destination_id:'';
					$type             = new VenueType();
					$vibe             = new Vibe();
					$service          = new VenueService();
					$currency         = new Currency();
				?>

				<div class="form-group field-location-name required">
					<?php echo Html::label('Region','region_id',array('class'=>'control-label col-md-4'));?>
					<div class="col-md-8">
						<?php echo Html::dropDownList('region_id', $region_id, $region->getList(),
							[
								'class'  => 'form-control chosen-style',
								'prompt' => 'Choose from regions', 
								'onchange'=>'
									var id = $(this).val();

									$.ajax({
									url:"'.Yii::$app->urlManager->createUrl(["admin-mastertable/dynamicdestinations"]).'",
									method:"POST",
									data:{"region_id":id},
									success:function(data){
										$("#destination_id").chosen("destroy");
										$("#destination_id").html( data );
										$("#destination_id").chosen({disable_search_threshold: 10});
										$("#venue-location_id").chosen("destroy");
										$("#venue-location_id").html("<option value=\'\'>Choose from locations</option>");
										$("#venue-location_id").chosen({disable_search_threshold: 10});
									}
								})'
							]);
						?>
					</div>
				</div>
				<div class="form-group field-destination-name required">
					<?php echo Html::label('Destination','destination_id',array('class'=>'control-label col-md-4'));?>
					<div class="col-md-8">
						<?php echo Html::dropDownList('destination_id', $destination_id, $destination_list,
							[
								'id'=>'destination_id',
								'class'  => 'form-control chosen-style',
								'prompt' => 'Choose from destinations', 
								'onchange'=>'
									var id = $(this).val();
									$.ajax({
									url:"'.Yii::$app->urlManager->createUrl(["admin-mastertable/dynamiclocations"]).'",
									method:"POST",
									data:{"destination_id":id},
									success:function(data){
										$("#venue-location_id").chosen("destroy");
										$("#venue-location_id").html( data );
										$("#venue-location_id").chosen({disable_search_threshold: 10});
									}
								})'
							]);
						?>
					</div>
				</div>

				<?php echo $form->field($model, 'location_id')->dropDownList($location_list,['class'  => 'form-control chosen-style', 'prompt' => 'Choose from locations']) ?>
			
				<?php echo $form->field($model, 'comment')->textarea(['rows' => 3]) ?>

				<?php echo $form->field($model, 'guest_capacity')->textInput(['maxlength' => true]) ?>
			</div>
		</div>
	</div>
	<div class="panel-group" id="accordion">
		<div class="panel panel-default">
			<div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse1">
				<h4 class="panel-title">
					<a class="text-success">Address Details</a>
				</h4>
			</div>
			<div id="collapse1" class="panel-collapse collapse">
				<div class="panel-body">
					<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 collapse_form inner_col_box">
						<?php echo $form->field($model->tax, 'tax')->textInput()->label('Tax Rate',['class'=>'control-label']) ?>
						<?php echo $form->field($model->organization, 'address')->textArea(['rows' => 3]) ?>
						
						<?php echo $form->field($model->organization, 'city')->textInput(['maxlength' => true]) ?>
						
						<?php echo $form->field($model->organization, 'state')->textInput(['maxlength' => true]) ?>
						
						<?php echo $form->field($model->organization, 'zip')->textInput(['maxlength' => true]) ?>
						
						<?php $country = new Country();?>
						<?php echo $form->field($model->organization, 'country_id')->dropDownList($country->getList(),['class'  => 'form-control chosen-style']) ?>

						<?php echo $form->field($model->organization, 'timezone')->dropDownList(Yii::$app->params['timezones'],['class'  => 'form-control chosen-style']) ?>

						<?php echo $form->field($model->organization, 'email')->textInput(['maxlength' => true]) ?>

						<?php echo $form->field($model->organization, 'site')->textInput(['maxlength' => true]) ?>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse2">
				<h4 class="panel-title">
					<a class="text-success">Contact Details</a>
				</h4>
			</div>
			<div id="collapse2" class="panel-collapse collapse">
				<div class="panel-body">
					<div class="col-md-10 col-md-offset-1 collapse_form inner_col_box2">
						<?php $key=0;?>
						<?php if(isset($model->contacts) && count($model->contacts)>0) {?> 

							<?php foreach ($model->contacts as $key=>$contact) {?>

								<div class=" clearfix contact_<?php echo $key?>">
									<div class="col-md-6">
										<?php echo $form->field($contact, "[$key]type")->dropDownList(['Contact - for Events', 'Contact - Manager/Sales', 'Contact - Groups/Accommodation'], ['class'  => 'form-control chosen-style']) ?> 

										<?php echo $form->field($contact, "[$key]first_name")->textInput(['maxlength' => true]) ?>

										<?php echo $form->field($contact, "[$key]last_name")->textInput(['maxlength' => true]) ?>

										<?php echo $form->field($contact, "[$key]email")->textInput(['maxlength' => true]) ?>

										<?php echo $form->field($contact, "[$key]skype")->textInput(['maxlength' => true]) ?>
									</div>
									<div class="col-md-6 form-group required">
										
										<?php echo Html::label('Phone','',array('class'=>'control-label col-sm-3'));?>
										
										<div class="col-sm-9 phones">

											<?php  if(is_array($contact->contactPhones)) {
												
												foreach($contact->contactPhones as $k=>$phone) {?>

														<div class="col-sm-6">
															<?php echo Html::dropDownList('Contact['.$key.'][phones]['.$k.'][type]', $phone['type'], ['General', 'Mobile', 'Fax', 'What\'s App'], ['class'  => 'form-control chosen-style']);?>
														</div>
														<div class="col-sm-6">
															<?php echo Html::textInput('ontact['.$key.'][phones]['.$k.'][phone]', $phone['phone'], ['class'  => 'form-control ']);?>
														</div>

												<?php }

											}?>
										</div>
										<div class="form_group clearfix">
										   <?php echo Html::Button('Add phone', ['class' => 'btn btn-danger add_phone','onclick'=>'add_phone('.$contact->id.','.$key.')']) ?>
										</div>
									</div>
								</div>

							<?php }?>
						
						<?php } ?>
						
						   
						<?php for($i=0;$i<5;$i++) {?>
							<?php $key++;?>

							<div class="add_contact_form contact_<?php echo $key?> clearfix" style="display:none">
								<div class="col-md-6">
							
									<?php $new_contact = new Contact();
										  $new_contact->organization_id = $model->organization_id; 
										  ?>

									<?php echo $form->field($new_contact, "[$key]organization_id")->hiddenInput()->label(false) ?>

									<?php echo $form->field($new_contact, "[$key]type")->dropDownList(['Contact - for Events', 'Contact - Manager/Sales', 'Contact - Groups/Accommodation'], ['class'  => 'form-control chosen-style']) ?> 

									<?php echo $form->field($new_contact, "[$key]first_name")->textInput(['maxlength' => true]) ?>

									<?php echo $form->field($new_contact, "[$key]last_name")->textInput(['maxlength' => true]) ?>

									<?php echo $form->field($new_contact, "[$key]email")->textInput(['maxlength' => true]) ?>

									<?php echo $form->field($new_contact, "[$key]skype")->textInput(['maxlength' => true]) ?>
								</div>
								<div class="col-md-6 form-group required">
									
									<?php echo Html::label('Phone','',array('class'=>'control-label col-sm-3'));?>
									
									<div class="col-sm-9 phones">
										<div class="col-sm-6">
											<?php echo Html::dropDownList('VenueContact['.$key.'][phones][0][type]', '', ['General', 'Mobile', 'Fax', 'What\'s App'], ['class'  => 'form-control chosen-style']);?>
										</div>
										<div class="col-sm-6">		 
											<?php echo Html::textInput('VenueContact['.$key.'][phones][0][phone]', '', ['class'  => 'form-control']);?>
										</div>
									</div>

									<div class="form_group clearfix">
										<?php echo Html::Button('Add phone', ['class' => 'btn btn-danger add_phone','onclick'=>'add_phone('.(isset($contact->id)?$contact->id:0).', '.$key.')']) ?>
									</div>
								</div>    
							</div>
						<?php }?>
						<div class="form_group clearfix">
						   <?php echo Html::Button('Add contact', ['class' => 'btn btn-primary add_contact']) ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse3">
				<h4 class="panel-title">
					<a class="text-success">Venue Type</a>
				</h4>
			</div>
			<div id="collapse3" class="panel-collapse collapse">
				<div class="panel-body">
					<div class="col-md-4 col-md-offset-4 collapse_form">
						<div class="form-group required">
							
							<?php echo Html::checkbox('select_type',false,['class'=>'select_all','id'=>'select_types']);?>
							
							<?php echo Html::label('Check all that apply','select_types',array('class'=>'checkbox-inline'));?>

						</div>

						<?php echo $form->field($model, 'types_array',['template'=>"{input}{hint}\n\t{error}"])->checkBoxList($type->getList(),['class'=>'checkBox_block', 'label'=>'']) ?>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse4">
				<h4 class="panel-title">
					<a class="text-success">Wedding Vibe</a>
				</h4>
			</div>
			<div id="collapse4" class="panel-collapse collapse">
				<div class="panel-body">
					<div class="col-md-4 col-md-offset-4 collapse_form">
						<div class="form-group required">
							
							<?php echo Html::checkbox('select_type',false,['class'=>'select_all','id'=>'select_vibes']);?>

							<?php echo Html::label('Check all that apply','select_vibes',array('class'=>'checkbox-inline'));?>

						</div>
							  
						<?php echo $form->field($model, 'vibes_array',['template'=>"{input}{hint}\n\t{error}"])->checkBoxList($vibe->getList(),['class'=>'checkBox_block']) ?>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse5">
				<h4 class="panel-title">
					<a class="text-success">Venue provides</a>
				</h4>
			</div>
			<div id="collapse5" class="panel-collapse collapse">
				<div class="panel-body">
					<div class="col-md-4 col-md-offset-4 collapse_form">
						<div class="form-group required">
		
							<?php echo Html::checkbox('select_type',false,['class'=>'select_all','id'=>'select_services']);?>

							<?php echo Html::label('Check all that apply','select_services',array('class'=>'checkbox-inline'));?>

						</div>
							  
						<?php echo $form->field($model, 'services_array',['template'=>"{input}{hint}\n\t{error}"])->checkBoxList($service->getList(),['class'=>'checkBox_block']) ?>
						
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse6">
				<h4 class="panel-title">
					<a class="text-success">Venue Tax</a>
				</h4>
			</div>
			<div id="collapse6" class="panel-collapse collapse">
				<div class="panel-body">
					<div class="col-md-10 col-md-offset-1 collapse_form clearfix">
						<div class="col-md-6 tax_box clearfix">
							<div class="col-sm-6">
								
								<?php echo $form->field($model->tax, 'tax')->textInput()->label('Tax Rate',['class'=>'control-label']) ?>
								
							</div>
							<div class="col-sm-6">

								<?php echo $form->field($model->tax, 'service_rate')->textInput()->label('Service Rate',['class'=>'control-label']) ?>
								
							</div>
							<div class="col-sm-6">

								<?php echo $form->field($model->tax, 'our_service_rate')->textInput()->label('I Do Service Fee',['class'=>'control-label no_padding']) ?>
								
							</div>
							<div class="col-sm-6">

								<?php echo $form->field($model->tax, 'agency_service_rate')->textInput()->label('Agency Service Fee',['class'=>'control-label no_padding']) ?>
								
							</div>
						</div>
						<div class="col-md-6">

							<?php echo $form->field($model->tax, 'comment')->textarea(['rows' => 1]) ?>
						
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse7">
				<h4 class="panel-title">
					<a class="text-success">Venue Commission</a>
				</h4>
			</div>
			<div id="collapse7" class="panel-collapse collapse">
				<div class="panel-body">
					<div class="col-md-10 col-md-offset-1 collapse_form radiolist clearfix">
					
					<?php echo $form->field($model->tax, 'commission_type',['template'=>"{input}{hint}\n\t{error}",'horizontalCssClasses' => [
					'wrapper' => 'required',
					]])->radioList(['Prices are Net','Prices are Commissionable','Negotiated Wholesale rates']) ?>
					
					<div class="clearfix">

						<?php echo $form->field($model->tax, 'commission', ['options' => ['class' => 'form-group invisible commissions']])->textInput(['class'=>'form-control small-input']) ?>
					
					</div>
					<div class="clearfix">

						<?php echo $form->field($model->tax, 'commission_note', ['options' => ['class' => 'form-group invisible commissions']])->textInput(['class'=>'form-control']) ?>
					
					</div>
					<div class="clearfix">
					
						<?php echo $form->field($model->tax, 'commission_package', ['options' => ['class' => 'form-group invisible commissions']])->textInput(['class'=>'form-control small-input']) ?>

						<?php echo $form->field($model->tax, 'commission_food', ['options' => ['class' => 'form-group invisible commissions']])->textInput(['class'=>'form-control small-input']) ?>

						<?php echo $form->field($model->tax, 'commission_items', ['options' => ['class' => 'form-group invisible commissions']])->textInput(['class'=>'form-control small-input']) ?>
						
					</div>
					
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse8">
				<h4 class="panel-title">
					<a class="text-success">Accommodation Details</a>
				</h4>
			</div>
			<div id="collapse8" class="panel-collapse collapse">
				<div class="panel-body">
					<div class="col-md-10 col-md-offset-1 collapse_form clearfix">
						<ul class="prices_list clearfix">
							<li>
								
								<?php echo $form->field($model->tax, 'accommodation_commission_type',['template'=>"{input}{hint}\n\t{error}"])->radioList(['Prices are Net','Prices are Commissionable']) ?>
								
								<?php echo $form->field($model->tax, 'accommodation_commission', ['options' => ['class'=>'invisible']])->textInput() ?>
													
							</li>
							<li>

								<?php echo $form->field($model->tax, 'accomodation_wholesale',['horizontalCssClasses' => ['offset' => 'col-sm-offset-0', 'wrapper' => ''], 'template'=>"{input}{hint}\n\t{error}"])->checkbox() ?>
								
							</li>
						</ul>
						<div class="clearfix">
							<?php echo $form->field($model->tax, 'accommodation_note', ['options' => ['class' => 'form-group invisible']])->textInput(['class'=>'form-control'])->label('Note',['class'=>'control-label col-md-4']) ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse9">
				<h4 class="panel-title">
					<a class="text-success">Event Deposit</a>
				</h4>
			</div>
			<div id="collapse9" class="panel-collapse collapse">
				<div class="panel-body">
					<div class="col-md-10 col-md-offset-1 collapse_form clearfix">
						
						
						<?php echo $form->field($model->tax, 'event_deposit')->textInput(['class'=>'form-control small_input']) ?>
						<?php echo $form->field($model->tax, 'deposit_currency')->dropDownList($currency->list, ['class'  => 'form-control chosen-style']) ?>
						<?php //Добавить проверку - показывать только Патти ?>
						<?php echo $form->field($model->tax, 'note')->textarea(['rows' => 3]) ?>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse10">
				<h4 class="panel-title">
					<a class="text-success">Venue Package Type</a>
				</h4>
			</div>
			<div id="collapse10" class="panel-collapse collapse">
				<div class="panel-body">
					<div class="col-md-10 col-md-offset-1 collapse_form clearfix">
						
						<?php echo $form->field($model, 'type',['template'=>"{input}{hint}\n\t{error}"])->radioList([
							'1' => 'Venue Package is optional; Site fee is given and WOMI can bring on their own professional Vendors. (Venue Package Type : 1)',
							'2' => 'Venue Package is required, but WOMI can bring on their own professional Vendors. (Venue Package Type : 2)',
							'3' => 'Venue Package is required and all Vendors must be arranged through Venue. (Venue Package Type : 3)',
							'5' => 'PACKAGES are optional, WOMI chooses to use Venue Package and WOMI can bring on their own professional Vendors.. (Venue Package Type : 5)'
						]) ?>
						<?php echo $form->field($model, 'nonguest')->checkBox()->label('Venue allows NON-GUESTS to marry on the property. (Venue Package Type : 4)') ?>
						
					</div>
				</div>
			</div>
		</div>
		<?php if($model->id) {?> 
			<div class="panel panel-default">
			<div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse11">
				<h4 class="panel-title">
					<a class="text-success">Documents</a>
				</h4>
			</div>
			<div id="collapse11" class="panel-collapse collapse">
				<div class="panel-body">
						
					<div class="attach_block">
						<span>Attachments:</span>
						<ul id="files" class="attach_list clearfix">
							<!--?php foreach ($model->docs as $file): ?>
								<li id="file_<php echo $file->id; ?>">
									<i><!--?php echo Html::a($file->doc,["/uploads/venue/".$model->id."/".$file->id . '.' . end(explode('.', $file->doc))],['target'=>'_blank','data-pjax'=>0])?></i>
									<button class="remove-file modal-ajax" type="button" data-id="16" title="Delete" value="<!--?php echo Url::to([Yii::$app->controller->id."/delete-doc", 'id'=>$file->id])?>"></button>
									
								</li>
							<!?php endforeach; ?-->
						</ul>
						<a class="btn btn-danger" href="#">Attach file</a>
						<input type="file" id="files-select" name="files[]" size="20" multiple />

					</div>
				</div>
			</div>
		</div>
		<?php }?>
	</div>
	<div class="form-group required">
		<label>Updated by </label> <?php echo $model->user?> <?php echo $model->updated_at?>
	</div>
    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

$upload_url = Url::to(['admin-venue/files-upload', 'venue_id' => $model->id]);

$js = <<<EOT
	var xhr;

	$('#files-select').on('change', function() {

		// Disable browse files button
		$('#files-select').attr('disabled', true);

		// Hide alert
		$('.alert-danger').hide();

		// Display uploading status
		$('.alert-info').html('Uploading... <a id="files-abort" href="#">Abort</a>').show();
		$('body,html').animate({scrollTop: 0}, 400);
		// Handle upload abort
		$('#files-abort').on('click', function(e) {
			// Prevent default action
			e.preventDefault();

			// Abort the request
			xhr.abort();
		});

		// Create a new FormData object
		var data = new FormData();

		// Loop through each of the selected files
		jQuery.each(jQuery('#files-select')[0].files, function(i, file) {
			// Add the file to the request
			data.append('files[]', file);
		});

		xhr = jQuery.ajax({
			url: '{$upload_url}',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			type: 'POST',
			complete: function() {
				// Hide uploading status
				$('.alert-info').hide();

				// Clear file input
				$('#files-select').val('');

				// Enable file browse button
				$('#files-select').attr('disabled', false);
			},
			error: function(jqXHR) {
				var message;
				if (jqXHR.status == 0) {
					message = 'The request is aborted';
				} else {
					message = jqXHR.responseText;
				}
				$('.alert-danger').html(message).show();
			},
			success: function(data) {
				if (data.list !== undefined && !$.isEmptyObject(data.list)) {
					$.each(data.list, function(key, val) {
						// Append uploaded file
						var li = '<li id="file_' + key + '">';
						li+= '<input type="hidden" name="file_ids[]" value="' + key + '">';
						li+= '<i>' + val + '</i>';
						li+= '<button class="remove-file" type="button" data-id="' + key + '" title="Delete"></button>';
						li+= '</li>';

						$('#files').append(li);

						// Handle remove file
						$('.remove-file').off();
						$('.remove-file').on('click', function() {
							var fileId = $(this).attr('data-id');
							$('#file_' + fileId).remove();
						});
					});
				}

				if (data.alert !== undefined && data.alert != '') {
					// Show alert
					$('.alert-danger').html(data.alert).show();
					$('body,html').animate({scrollTop: 0}, 400);
				}

				if (data.errors !== undefined && !$.isEmptyObject(data.errors)) {
					// Collect errors
					var html = '';
					$.each(data.errors, function(key, val) {
						html+= key + ': ' + val + '<br>';
					});
					$('body,html').animate({scrollTop: 0}, 400);
					// Show alert
					$('.alert-danger').html(html).show();
				}

			}
		});
	});

	// Handle remove file
	$('.remove-file').on('click', function() {
		var fileId = $(this).attr('data-id');
		$('#file_' + fileId).remove();
	});
EOT;

$this->registerJS($js);
