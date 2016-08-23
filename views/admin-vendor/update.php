<?php

use yii\helpers\Html;
use app\assets\VendorAsset;
//use app\assets\BootstrapMaterialAsset;
use app\assets\KendoAsset;

VendorAsset::register($this);
//BootstrapMaterialAsset::register($this);
KendoAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\vendor\Vendor */

$this->title = $model->name;
$this->params['section_title'] = 'Vendors';

$this->params['breadcrumbs'][] = ['label' => 'Vendors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->organization_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vendor-update">

    <div class="clearfix">
        <ol class="breadcrumb">
            <li><?php echo Html::a('Vendors',\yii\helpers\Url::to(['admin-vendor/index']),['class' => "return_link text-success",'data-pjax'=>'0'])?></li>
            <li><?php echo ($model->organization_id)?$model->name:'Create'?></li>
        </ol>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
