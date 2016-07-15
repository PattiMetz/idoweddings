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

    <h1><?php echo Html::encode($this->title) ?></h1>

    <p>
        <?php echo Html::a('Add Group of Locations',Url::to(['/admin/venue-location/group','venue_id'=>$venue_id]),  ['class' => 'btn btn-danger modal-ajax']) ?>
    </p>
    <?php
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'layout' => "{items}\n{summary}\n{pager}",
            'itemView' => '_group',
        ]);
    ?>
</div>
