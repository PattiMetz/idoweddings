<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\vendor\VendorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vendors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vendor-index">
   <div class="top_panel">
       <p><?= Html::a('Create Vendor', ['update'], ['class' => 'btn btn-danger']) ?></p>
   </div>
    <div class="col-md-9 vend-table">
        <?php Pjax::begin(); ?>    <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => [
                    'class' => 'table table-bordered table-condensed'
                ],
                //'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'name',
                    'admin_notes',
                    //'status',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update} {delete}'
                    ],
                ],
            ]); ?>
        <?php Pjax::end(); ?>
    </div>
    <div class="col-md-3 vend-sidebar">
        <div class="list_wrap">
            <p>Vendor Customization </p>
            <ul>
                <li><?php echo Html::a('Vendor profile', [Url::to([Yii::$app->controller->id.'/update','id' => $model->organization_id])], ['data-pjax' => 0])?></li>
                <li><a>Wedding items</a></li>
                <li><a>Agreement</a></li>
            </ul>
        </div>
    </div>
</div>
