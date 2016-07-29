<?php

use app\assets\OwnCompanyAsset;

OwnCompanyAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\MainCompany */
/* @var $address app\models\MainCompanyAddress */
/* @var $phone app\models\MainCompanyPhone */
/* @var $contacts app\models\MainCompanyContact */

$this->title = 'Our Profile';
//$this->params['breadcrumbs'][] = ['label' => 'Main Companies', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Our Profile';

?>
<div class="main-company-update">

    <div class="clearfix">
        <ol class="breadcrumb">
            <li>Our Profile</li>
        </ol>
    </div>

    <div class="border-block">
        <?= $this->render('_form', [
            'model' => $model,
            'address' => $address,
            'contacts' => $contacts,
            'phone' => $phone,
            'country' => $country
        ]) ?>
    </div>

</div>
