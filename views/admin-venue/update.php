<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\venue\Venue */

$this->title = 'Update Venue: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Venues', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="venue-update">

    <!--h1><!--?= Html::encode($this->title) ?></h1-->

    <?= $this->render('_form', [
        'model' => $model,
        'address'=>$address,
        'tax' =>$tax,
        'contacts'=>$contacts,
        'docs'=>$docs,
        'doc'=>$doc
    ]) ?>

</div>
