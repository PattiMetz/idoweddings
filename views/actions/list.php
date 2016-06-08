<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

?>


<div class="clearfix">
    <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            
        ]);
    ?>
</div>

