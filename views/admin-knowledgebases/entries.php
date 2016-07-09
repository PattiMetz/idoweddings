<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\web\View;
use yii\bootstrap\Alert;
?>

<?php

echo Alert::widget([
	'options' => [
		'class' => 'alert-danger',
		'style' => ($alert == '') ? 'display: none' : ''
	],
	'body' => $alert,
		'body' => $alert,
		'closeButton' => false
]);

?>

<?php if ($alert == ''): ?>

	<?php if ($current_category_id): ?>

		<div class="sett_panel form-inline clearfix">
			<ol class="breadcrumb">

				<!-- Knowledgebase -->
				<li><a href="<?php echo Url::to(['admin-knowledgebases/entries', 'knowledgebase_id' => $current_knowledgebase_id]); ?>" class="return_link text-success"><?php echo Html::encode($knowledgebases[$current_knowledgebase_id]); ?></a></li>

				<!-- Categories -->
				<?php foreach ($current_path as $category_id): ?>
					<?php $category_title = (isset($categories[$category_id])) ? Html::encode($categories[$category_id]['title']) : '<i>Undefined</i>'; ?>
					<?php if ($category_id == $current_category_id): ?>
						<li class="active"><?php echo $category_title; ?></li>
					<?php else: ?>
						<li><a href="<?php echo Url::to(['admin-knowledgebases/entries', 'knowledgebase_id' => $current_knowledgebase_id, 'category_id' => $category_id]); ?>" class="return_link text-success"><?php echo $category_title; ?></a></li>
					<?php endif; ?>
				<?php endforeach; ?>

			</ol>
		</div>

	<?php else: ?>

		<div class="sett_panel form-inline clearfix">
			<div class="choose_base input-group">
				<span class="input-group-addon"></span>	
				<?php echo Html::dropDownList('knowledgebase_id', $current_knowledgebase_id, $knowledgebases, ['id' => '_knowledgebase_id', 'class' => 'chosen-style']); ?>
			</div>
			<div class="choose_base_btn_box">
				<?php echo Html::button('<i class="glyphicon glyphicon-pencil"></i>', ['value' => Url::to(['admin-knowledgebases/update', 'id' => $current_knowledgebase_id]), 'class' => 'btn btn-primary modal-ajax']); ?>
				<a href="#" class="btn btn-danger" title="Permissions"><i class="glyphicon glyphicon-mykey"></i></a>
			</div>
		</div>

	<?php endif; ?>

	<div class="top_panel clearfix">
		<div class="col-md-9 col-sm-8 col-xs-7">
			<?php echo Html::button('Add Category', ['value' => Url::to(['admin-knowledgebases/categories-update', 'knowledgebase_id' => $current_knowledgebase_id, 'category_id' => $current_category_id]), 'class' => 'btn btn-danger modal-ajax']); ?>
			<?php echo Html::button('Add Article', ['value' => Url::to(['admin-knowledgebases/articles-update', 'knowledgebase_id' => $current_knowledgebase_id, 'category_id' => $current_category_id]), 'class' => 'btn btn-danger modal-ajax']); ?>
		</div>
		<div class="col-md-3 col-sm-4 col-xs-5">
			<form name="search" class="input-group" method="get" action="">
				<input name="search" class="form-control" placeholder="Search" autocomplete="off" type="text">
				<span class="input-group-btn">
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
				</span>
			</form>
		</div>
	</div>

	<div class="table-responsive">
	<?php
		echo GridView::widget([
			'dataProvider' => $dataProvider,
			'layout' => "{items}\n{summary}\n{pager}",
			'tableOptions' => [
				'class' => 'table table-bordered doc_table'
			],
			'columns' => [
				[
					'attribute' => 'order',
					'format' => 'raw',
					'value' => function ($model) {
						$url = Url::to(['admin-knowledgebases/entries-reorder', 'id' => $model->id]);
						$order = floor($model->order / 10);
						$output = <<<OUTPUT
							<a href="{$url}" class="text-success modal-ajax">{$order}</a>
							<div class="arrows">
								<a href="{$url}" class="arr_up reorder-knowledgebase-entry" data-move-type="up" title="Up"></a>
								<a href="{$url}" class="arr_down reorder-knowledgebase-entry" data-move-type="down" title="Down"></a>
							</div>
OUTPUT;
						return $output;
					}
				],
				[
					'attribute' => 'title',
					'format' => 'raw',
					'value' => function ($model) {
						if ($model->is_category) {
							return Html::a(
								$model->title,
								Url::to([
									'admin-knowledgebases/entries',
									'knowledgebase_id' => $model->knowledgebase_id,
									'category_id' => $model->id
								]),
								[
									'class' => 'item_doc category'
								]
							);
						} else {
							if ($model->status == 'draft') {
								$output = Html::a(
									$model->title . ' (draft)',
									Url::to([
										'admin-knowledgebases/articles-update',
										'id' => $model->id
									]),
									[
										'class' => 'item_doc draft line_norm modal-ajax'
									]
								);
							} else {
								$output = Html::a(
									$model->title,
									Url::to([
										'admin-knowledgebases/articles-update',
										'id' => $model->id
									]),
									[
										'class' => 'item_doc article line_norm modal-ajax'
									]
								);
							}
							if ($model->count_files) {
								$list_files = unserialize($model->list_files);
								$output.= '<small class="attach_doc">Attachments: ';
								foreach ($list_files as $name) {
									$output.= '<i>' . Html::encode($name) . '</i>' . "\n";
								}
								$output.= '</small>';
							}
							return $output;
						}
					}
				],
				[
					'label' => 'Contains',
					'format' => 'raw',
					'value' => function ($model) {
						if ($model->is_category) {
							$output = <<<OUTPUT
								<div class="contain">
									<div class="item_doc subcategory" title="Subcategories">{$model->count_categories}</div>
								</div>
								<div class="contain">
									<div class="item_doc article" title="Articles">{$model->count_articles_published}</div>
								</div>
								<div class="contain">
									<div class="item_doc draft" title="Drafts">{$model->count_articles_draft}</div>
								</div>
OUTPUT;
							return $output;
						} else {
							if ($model->count_files) {
								$output = <<<OUTPUT
									<div class="contain">
										<div title="Attachments" class="item_doc attach">{$model->count_files}</div>
									</div>
OUTPUT;
							} else {
								$output = '&nbsp';
							}
							return $output;
						}
					}
				],
				[  
					'class' => 'yii\grid\ActionColumn',
					'header' => 'Actions',
					'template' => '{update} {view} {delete}',
					'urlCreator' => function ($action, $model, $key, $index) {
						$type = ($model->is_category) ? 'categories' : 'articles';
						switch ($action) {
							case 'update':
								$url = Url::to(["admin-knowledgebases/{$type}-update", 'id' => $model->id]);
								break;
							case 'view':
								$url = Url::to(["admin-knowledgebases/{$type}-view", 'id' => $model->id]);
								break;
							case 'delete':
								$url = Url::to(["admin-knowledgebases/{$type}-delete", 'id' => $model->id]);
								break;
						}
						return $url;
					},
					'buttons' => [
						'update' => function($url, $model) {
							return Html::button('<i class="glyphicon glyphicon-pencil"></i> Edit', [
								'value' => $url,
								'class' => 'btn btn-primary modal-ajax',
							]);
						},
						'view' => function($url, $model) {
							return Html::button('<i class="glyphicon glyphicon-mykey"></i>', [
								'value' => $url,
								'class' => 'btn btn-danger modal-ajax',
								'title' => 'Permissins',
							]);
						},
						'delete' => function($url, $model) {
							return Html::button('<i class="glyphicon glyphicon-close"></i> Delete', [
								'value' => $url,
								'class' => 'btn btn-primary modal-ajax',
							]);
						}
					]
				]
			],
		]);
	?>
	</div>

<?php endif; ?>
