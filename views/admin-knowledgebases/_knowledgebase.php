<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\BaseHtml;
?>
<div class="knbase_box">
	<div class="knbase_top">
		<?php
			echo Html::button('&times;', [
						'value' => Url::to(['admin-knowledgebases/delete', 'id' => $model->id]),
						'class' => 'close modal-ajax'
			]);
		?>
		<!--a href="#" id="l1" name="<?php echo Html::encode($model->name); ?>"><?php echo Html::encode($model->name); ?></a-->
		<?php echo Html::a($model->name, Url::to(['admin-knowledgebases/entries', 'id' => $model->id])); ?>
	</div>
	<div class="knbase_cont clearfix">
		<div class="col-sm-8 col-xs-8">
			<div class="col-sm-12">
				<div class="col-sm-6 author">Author:</div>
				<div class="col-sm-6 block_2">Patti Metzger</div>
			</div>
			<div class="col-sm-12">
				<div class="col-sm-6 publish">Published:</div>
				<div class="col-sm-6 block_2">0</div>
			</div>
			<div class="col-sm-12">
				<div class="col-sm-6 drafts">Drafts:</div>
				<div class="col-sm-6 block_2">0</div>
			</div>
		</div>
		<div class="col-sm-4 col-xs-4 block_3 clearfix">
			<div class="icon_base"></div>
			<a class="permissions" title="Permissions" data-toggle="modal" data-target="#myModal_1"></a>
		</div>
	</div>
</div>
