<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\venue\VenueLocation */

$this->title = 'Update Venue Location: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Venue Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="venue-location-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
