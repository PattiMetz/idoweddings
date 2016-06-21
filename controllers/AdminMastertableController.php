<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\Response;
use app\models\Location;
use app\models\Region;
use app\models\Destination;
use app\models\search\LocationSearch;
use app\models\search\CountrySearch;
use app\models\search\DestinationSearch;
use app\models\search\RegionSearch;
use app\models\search\CurrencySearch;
use app\models\search\VibeSearch;
use app\models\search\VenueTypeSearch;
use app\models\search\VendorTypeSearch;
use app\models\search\VenueServiceSearch;
use app\models\search\LanguageSearch;
use app\actions\ListAction;
use app\actions\UpdateAction;
use app\actions\DeleteAction;

class AdminMastertableController extends Controller {

	public $layout = 'admin';

	public function beforeAction($action) {

		$this->view->params['section_title'] = 'Master Table';
		return parent::beforeAction($action);

	}


	public function behaviors() {

		return [
			'access' => [
				'class' => AccessControl::className(),
//				'ruleConfig' => [
//					'class' => AccessRule::className(),
//				],
				'rules' => [
					[
						
						'allow' => true,
					],
				],
			],
		];

	}

	public function actions()
    {
        return [
            'location-list' => [
                'class' => ListAction::className(),
                'filterModel' => new LocationSearch(),
                'exampleName' => 'location',
                'view'=>'@app/views/admin-mastertable/locations'
            ],
            'location-update' => [
            	'class'       => UpdateAction::className(),
            	'modelClass'  => 'app\models\Location',
            	'exampleName' => 'location',
            	'view' => '@app/views/admin-mastertable/location'
            ],
            'location-delete' => [
            	'class'       => DeleteAction::className(),
            	'modelClass'  => 'app\models\Location',
            	'exampleName' => 'location'
            ],
            'country-list' => [
                'class' => ListAction::className(),
                'exampleName' => 'country',
                'filterModel' => new CountrySearch(),
                'view'=>'@app/views/admin-mastertable/baselist'
            ],
            'country-update' => [
            	'class'       => UpdateAction::className(),
            	'modelClass'  => 'app\models\Country',
            	'exampleName' => 'country',
            ],
            'country-delete' => [
            	'class'       => DeleteAction::className(),
            	'modelClass'  => 'app\models\Country',
            	'exampleName' => 'country'
            ],
            'region-list' => [
                'class' => ListAction::className(),
                'filterModel' => new RegionSearch(),
                'exampleName' => 'region',
                'view'=>'@app/views/admin-mastertable/regions'
            ],
            'region-update' => [
            	'class'       => UpdateAction::className(),
            	'modelClass'  => 'app\models\Region',
            	'exampleName' => 'region',
            	'view' => '@app/views/admin-mastertable/region'
            ],
            'region-delete' => [
            	'class'       => DeleteAction::className(),
            	'modelClass'  => 'app\models\Region',
            	'exampleName' => 'region'
            ],
            'destination-list' => [
                'class' => ListAction::className(),
                'filterModel' => new DestinationSearch(),
                'exampleName' => 'destination',
                'view'=>'@app/views/admin-mastertable/destinations'
            ],
            'destination-update' => [
            	'class'       => UpdateAction::className(),
            	'modelClass'  => 'app\models\Destination',
            	'exampleName' => 'destination',
            	'view' => '@app/views/admin-mastertable/destination'
            ],
            'destination-delete' => [
            	'class'       => DeleteAction::className(),
            	'modelClass'  => 'app\models\Destination',
            	'exampleName' => 'destination'
            ],
            'currency-list' => [
                'class' => ListAction::className(),
                'filterModel' => new CurrencySearch(),
                'exampleName' => 'currency',
                'view'=>'@app/views/admin-mastertable/currencies'
            ],
            'currency-update' => [
            	'class'       => UpdateAction::className(),
            	'modelClass'  => 'app\models\Currency',
            	'exampleName' => 'currency',
            	'view' => '@app/views/admin-mastertable/currency'
            ],
            'currency-delete' => [
            	'class'       => DeleteAction::className(),
            	'modelClass'  => 'app\models\Currency',
            	'exampleName' => 'currency'
            ],
            'vibe-list' => [
                'class' => ListAction::className(),
                'filterModel' => new VibeSearch(),
                'exampleName' => 'vibe',
                'view'=>'@app/views/admin-mastertable/baselist'
            ],
            'vibe-update' => [
            	'class'       => UpdateAction::className(),
            	'modelClass'  => 'app\models\Vibe',
            	'exampleName' => 'vibe',
            ],
            'vibe-delete' => [
            	'class'       => DeleteAction::className(),
            	'modelClass'  => 'app\models\Vibe',
            	'exampleName' => 'vibe'
            ],
            'language-list' => [
                'class' => ListAction::className(),
                'filterModel' => new LanguageSearch(),
                'exampleName' => 'language',
                'view'=>'@app/views/admin-mastertable/baselist'
            ],
            'language-update' => [
            	'class'       => UpdateAction::className(),
            	'modelClass'  => 'app\models\Language',
            	'exampleName' => 'language',
            ],
            'language-delete' => [
            	'class'       => DeleteAction::className(),
            	'modelClass'  => 'app\models\Language',
            	'exampleName' => 'language'
            ],
            'venuetype-list' => [
                'class' => ListAction::className(),
                'filterModel' => new VenuetypeSearch(),
                'exampleName' => 'venuetype',
                'view'=>'@app/views/admin-mastertable/baselist'
            ],
            'venuetype-update' => [
            	'class'       => UpdateAction::className(),
            	'modelClass'  => 'app\models\Venuetype',
            	'exampleName' => 'venuetype',
            ],
            'venuetype-delete' => [
            	'class'       => DeleteAction::className(),
            	'modelClass'  => 'app\models\VenueType',
            	'exampleName' => 'venuetype'
            ],
            'venueservice-list' => [
                'class' => ListAction::className(),
                'filterModel' => new VenueserviceSearch(),
                'exampleName' => 'venueservice',
                'view'=>'@app/views/admin-mastertable/baselist'
            ],
            'venueservice-update' => [
            	'class'       => UpdateAction::className(),
            	'modelClass'  => 'app\models\Venueservice',
            	'exampleName' => 'venueservice',
            ],
            'venueservice-delete' => [
            	'class'       => DeleteAction::className(),
            	'modelClass'  => 'app\models\VenueService',
            	'exampleName' => 'venueservice'
            ],
            'vendortype-list' => [
                'class' => ListAction::className(),
                'filterModel' => new VendortypeSearch(),
                'exampleName' => 'vendortype',
                'view'=>'@app/views/admin-mastertable/baselist'
            ],
            'vendortype-update' => [
                'class'       => UpdateAction::className(),
                'modelClass'  => 'app\models\Vendortype',
                'exampleName' => 'vendortype',
            ],
            'vendortype-delete' => [
                'class'       => DeleteAction::className(),
                'modelClass'  => 'app\models\VendorType',
                'exampleName' => 'vendortype'
            ],
            
            
        ];
    }

    
	public function actionDynamicdestinations() {

		$region_id = (int)Yii::$app->request->post('region_id');
		$destination = new Destination();
		$data = $destination->getList($region_id);
		$html = '';
		if($data) {
			foreach($data as $k=>$v) {
				$html .= "<option value='".$k."'>".$v."</option>";
			}
		}
		Yii::$app->response->format = Response::FORMAT_HTML;
		return $html;
	}

    public function actionDynamiclocations() {

        $destination_id = (int)Yii::$app->request->post('destination_id');
        $location = new Location();
        $data = $location->getList($destination_id);
        $html = '';
        if($data) {
            foreach($data as $k=>$v) {
                $html .= "<option value='".$k."'>".$v."</option>";
            }
        }
        Yii::$app->response->format = Response::FORMAT_HTML;
        return $html;
    }

	public function actionIndex() {

		$this->view->title = 'Overview'; 
		return $this->render('index');

	}

	
}
