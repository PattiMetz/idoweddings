<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\web\View;

$this->title = 'Entries';
?>

<div class="sett_panel form-inline clearfix">
	<div class="choose_base input-group">
		<span class="input-group-addon"></span>	
		<div class="input-group-btn">
			<button type="button" class="btn btn-default sel_btn">Admin Knowledgebase</button>
			<button aria-expanded="false" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
				<span class="caret"></span>
				<span class="sr-only">Toggle Dropdown</span>
			</button>											
			<ul class="dropdown-menu">
				<li><a href="#block_l1" name="Admin Knowledgebase">Admin Knowledgebase</a></li>
				<li><a href="#block_l2" name="General">General</a></li>
				<li><a href="#block_l3" name="Mexico Weddings">Mexico Weddings</a></li>
				<li><a href="#block_l4" name="Sayingido">Sayingido</a></li>
				<li><a href="#block_l5" name="Test">Test</a></li>
			</ul>
		</div>
	</div>
	<div class="choose_base_btn_box">
		<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal_2"><i class="glyphicon glyphicon-pencil"></i></a>
		<a href="#" class="btn btn-danger" title="Permissions"><i class="glyphicon glyphicon-mykey"></i></a>
	</div>
</div>
<div class="top_panel clearfix">
	<div class="col-md-9 col-sm-8 col-xs-7">
		<!--a href="#" class="btn btn-danger" data-toggle="modal" data-target="#myModal_7">Add Category</a>
		<a href="#" class="btn btn-danger" data-toggle="modal" data-target="#myModal_8">Add Article</a-->
		<?php echo Html::button('Add Category', ['value' => Url::to(['admin-knowledgebases/categories-update']), 'class' => 'btn btn-danger modal-ajax']); ?>
		<?php echo Html::button('Add Article', ['value' => Url::to(['admin-knowledgebases/articles-update']), 'class' => 'btn btn-danger modal-ajax']); ?>
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
		'tableOptions' => [
            'class' => 'table table-bordered doc_table'
        ],
		'columns' => [
			'order',
			'title',
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
						return Html::button('<i class="glyphicon glyphicon-pencil"></i> Rename', [
							'value' => $url,
							'class' => 'btn btn-primary modal-ajax',
						]);
					},
					'view' => function($url, $model) {
						return Html::button('<i class="glyphicon glyphicon-mykey"></i>', [
							'value' => $url,
							'class' => 'btn btn-danger modal-ajax',
							'title' => 'Permissoins',
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

<div class="table-responsive">
	<table class="table table-bordered doc_table">
		<thead>
			<tr>
				<th>Order</th>
				<th>Title</th>
				<th>Contains</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<a href="#" class="text-success" data-toggle="modal" data-target="#myModal_5">1</a>
					<div style="display: none;" class="arrows">
						<a class="arr_up" title="Up"></a>
						<a class="arr_down" title="Down"></a>
					</div>
				</td>
				<td><a href="#sub_1" class="item_doc category">Category name 1</a></td>
				<td>
					<div class="contain">
						<div class="item_doc subcategory" title="Subcategories">2</div>
					</div>
					<div class="contain">
						<div class="item_doc article" title="Articles">1</div>
					</div>
					<div class="contain">
						<div class="item_doc draft" title="Drafts">2</div>
					</div>
				</td>
				<td>
					<a href="#" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Rename</a>
					<a href="#" class="btn btn-danger" title="Permissions"><i class="glyphicon glyphicon-mykey"></i></a>
					<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal_3"><i class="glyphicon glyphicon-close"></i> Delete</a>
				</td>
			</tr>
			<tr>
				<td>
					<a href="#" class="text-success" data-toggle="modal" data-target="#myModal_5">2</a>
					<div style="display: none;" class="arrows">
						<a class="arr_up" title="Up"></a>
						<a class="arr_down" title="Down"></a>
					</div>
				</td>
				<td><a href="#sub_2" class="item_doc category">Category name 2</a></td>
				<td></td>
				<td>
					<a href="#" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Rename</a>
					<a href="#" class="btn btn-danger" title="Permissions"><i class="glyphicon glyphicon-mykey"></i></a>
					<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal_3"><i class="glyphicon glyphicon-close"></i> Delete</a>
				</td>
			</tr>
			<tr>
				<td>
					<a href="#" class="text-success" data-toggle="modal" data-target="#myModal_5">3</a>
					<div style="display: none;" class="arrows">
						<a class="arr_up" title="Up"></a>
						<a class="arr_down" title="Down"></a>
					</div>
				</td>
				<td><a href="#" class="item_doc article" data-toggle="modal" data-target="#myModal_9">Article name 1</a></td>
				<td></td>
				<td>
					<a href="#" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Rename</a>
					<a href="#" class="btn btn-danger" title="Permissions"><i class="glyphicon glyphicon-mykey"></i></a>
					<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal_4"><i class="glyphicon glyphicon-close"></i> Delete</a>
				</td>
			</tr>
			<tr>
				<td>
					<a href="#" class="text-success" data-toggle="modal" data-target="#myModal_5">4</a>
					<div style="display: none;" class="arrows">
						<a class="arr_up" title="Up"></a>
						<a class="arr_down" title="Down"></a>
					</div>
				</td>
				<td><a href="#" class="item_doc draft" data-toggle="modal" data-target="#myModal_9">Article name 2 (draft)</a></td>
				<td></td>
				<td>
					<a href="#" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Rename</a>
					<a href="#" class="btn btn-danger" title="Permissions"><i class="glyphicon glyphicon-mykey"></i></a>
					<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal_4"><i class="glyphicon glyphicon-close"></i> Delete</a>
				</td>
			</tr>
			<tr>
				<td>
					<a href="#" class="text-success" data-toggle="modal" data-target="#myModal_5">5</a>
					<div style="display: none;" class="arrows">
						<a class="arr_up" title="Up"></a>
						<a class="arr_down" title="Down"></a>
					</div>
				</td>
				<td><a href="#" class="item_doc article" data-toggle="modal" data-target="#myModal_9">Article name 3</a></td>
				<td></td>
				<td>
					<a href="#" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Rename</a>
					<a href="#" class="btn btn-danger" title="Permissions"><i class="glyphicon glyphicon-mykey"></i></a>
					<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal_4"><i class="glyphicon glyphicon-close"></i> Delete</a>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<div class="pagination_panel clearfix">
	<span>Showing 1-5 Records of 5</span>
	<ul class="pagination">
		<li><a href="#">«</a></li>
		<li class="active"><a href="#">1</a></li>
		<li><a href="#">»</a></li>
	</ul>
</div>
									