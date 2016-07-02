<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\venue\VenueLocation */

$this->title = 'Create Venue Location';
$this->params['breadcrumbs'][] = ['label' => 'Venue Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="venue-location-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
