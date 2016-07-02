<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use app\models\venue\VenueLocationGroup;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\VenueLocation */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Venue Locations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="venue-location-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Group of Locations',Url::to(['/admin/venue-location/group','venue_id'=>$venue_id]),  ['class' => 'btn btn-success modal-ajax']) ?>
    </p>
 
    <?php
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'layout' => "{items}\n{summary}\n{pager}",
            'itemView' => '_group',
        ]);
    ?>
    <?php /*GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'group_id',
            'name',
            'description:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);*/ ?>
</div>
