<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\venue\Venue */

$this->title = 'Create Venue';
?>
<div class="venue-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'address'=>$address,
        'tax' =>$tax,
        'contacts'=>$contacts,
        'docs'=>$docs,
        'doc'=>$doc
    ]) ?>

</div>
