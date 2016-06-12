<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

//$this->title = 'Knowledge Bases';
?>

<div class="top_panel clearfix">
	<div class="col-md-9 col-sm-8 col-xs-7">
		<?php echo Html::button('Add Knowledge Base', ['value' => Url::to(['admin-knowledgebases/update']), 'class' => 'btn btn-danger modal-ajax']); ?>
		<!--a href="#" class="btn btn-danger" data-toggle="modal" data-target="#myModal">Add Knowledge Base</a-->

		<?php /* echo Html::button('Test confirm', [
			'value' => Url::to(['admin-knowledgebases/delete']),
			'class' => 'btn btn-danger modal-confirm',
			'data-message' => 'Are you sure you want to test confirm?',
			'data-button-primary-text' => 'Test confirm'
		]); */ ?>

		<?php /* echo Html::a('Test confirm!', Url::to(['admin-knowledgebases/delete']), [
			'title' => 'Delete',
			'class'=>'btn btn-primary',
			'data-confirm' => 'Are you sure you want to delete this item?',
			'data-method' => 'post',
			'data-pjax' => '0',
		]); */ ?>
	</div>
	<div class="col-md-3 col-sm-4 col-xs-5">
		<form name="search" class="input-group" method="get" action="">
			<input type="text" name="search" class="form-control" placeholder="Search" autocomplete="off" />
			<span class="input-group-btn">
				<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
			</span>
		</form>
	</div>
</div>

<?php #Pjax::begin(['id' => 'knowledgebases']) ?>

<div class="clearfix">
	<?php
		echo ListView::widget([
			'dataProvider' => $dataProvider,
			'layout' => "{items}\n{summary}\n{pager}",
			'itemView' => '_knowledgebase',
		]);
	?>
</div>

<?php #Pjax::end() ?>
