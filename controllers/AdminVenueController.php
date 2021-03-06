<?php

namespace app\controllers;

use Yii;
use app\models\Organization;
use app\models\venue\Venue;
use app\models\venue\VenueTax;
use app\models\Contact;
use app\models\venue\VenueDoc;
use app\models\venue\VenuePage;
use app\models\search\VenueSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\actions\UpdateAction;
use app\actions\DeleteAction;
use yii\base\Model;
use yii\web\UploadedFile;
use app\models\venue\VenueWebsite;
use yii\web\Response;
/**
 * VenueController implements the CRUD actions for Venue model.
 */
class AdminVenueController extends Controller
{
    public $layout = 'admin';

    public function actions()
    {
        return [
            
            'delete' => [
                'class'       => DeleteAction::className(),
                'modelClass'  => 'app\models\venue\Venue',
                'exampleName' => 'venue'
            ],
            'delete-doc' => [
                'class'       => DeleteAction::className(),
                'modelClass'  => 'app\models\venue\VenueDoc',
                'exampleName' => 'doc'
            ],
            'page-update' => [
                'class'       => UpdateAction::className(),
                'modelClass'  => 'app\models\venue\VenuePage',
                'exampleName' => 'venuepage',
                'view' => '@app/views/admin-venue/website/page'
            ],
            'page-delete' => [
                'class'       => DeleteAction::className(),
                'modelClass'  => 'app\models\venue\VenuePage',
                'exampleName' => 'venuepage'
            ],
        ];
    }

    public function beforeAction($action) {

        $this->view->params['section_title'] = 'Venues';
        return parent::beforeAction($action);

    }

    public function behaviors() {

        return [
            'access' => [
                'class' => AccessControl::className(),
//              'ruleConfig' => [
//                  'class' => AccessRule::className(),
//              ],
                'rules' => [
                    [
                        
                        'allow' => true,
                    ],
                ],
            ],
        ];

    }

    public function actionEditurl($id){
        $model = VenueWebsite::findOne($id);
        $alert = '';
        $message = '';
        $errors = [];
        $pjax_reload = false;
        $post = Yii::$app->request->post();
        
        if( isset($post['VenueWebsite']['url'])) {
            if(isset($post['validate']) && $post['validate']==1) {
                
                $res = $model->checkurl($post['VenueWebsite']['url']);

                if(!$model->checkurl($post['VenueWebsite']['url'])) {
                    $alert = 'Url already exists';
                }else
                    $message = 'Url is available';
            }elseif(isset($post['validate']) && $post['validate']==0) {
                if(!$model->checkurl($post['VenueWebsite']['url'])) {
                    $alert = 'Url already exists';
                }else {
                    $model->url = $post['VenueWebsite']['url'];
                    $model->save();
                }
                
            }
            if($alert == '' && $message == '') {
               $pjax_reload = '#main';
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return compact(
                'alert',
                'message',
                'pjax_reload'
                
            );
        }
        return $this->renderAjax('website/url', [
                'model'   => $model,
                'message' => $message,
                'alert'   => $alert
                ]
        );
    }

    public function actionSettings($id)
    {
        $alert = $message = '';

        $model = VenueWebsite::find()->where(['venue_id' => $id])->one();
     
        $venue = Venue::findOne($id);
        
        if(Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $model->load($post);
            $model->font_settings = serialize($post['settings']);
            if ($model->save()) {
                foreach($post['VenuePage'] as $page_id=>$page) {
                    $obj = VenuePage::findOne($page_id);
                    $obj->active = $page['active'];
                    if(!$obj->save())
                        $alert = 'Venue page error';
                   
                }
                $message = 'Succesfully saved';
            }else {
                $alert = 'Error. Not saved';
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            $pjax_reload = '#main';
            return compact(
                'alert',
                'message'
            );
            
        }
        if(!$model) {
            $model = new VenueWebsite();
            $model->url = $model->generateUrl($venue->name);
            $model->venue_id = $id;
            $model->logo_type = '0';
            $model->navigation_pos = '0';
            $model->save();
        }

        $pages = $venue->pages;
        if(!$pages) {
            $this->setDefaultPages($id);
            return $this->redirect(['settings', 'id' => $venue->id]);
            //$pages = $venue->pages;
        }
        $fonts = Yii::$app->params['fonts'];
        $sizes = array();
        for($i=10;$i<80;$i++) {
            $sizes[$i] = $i;
            $i++;
        }

        return $this->render('website/settings', [
                'model' => $model,
                'fonts' => $fonts,
                'sizes' => $sizes,
                'pages' => $pages,
                'alert' => $alert,
                'message' => $message
            ]);
        
    }



    /**
     * Lists all Venue models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VenueSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function setDefaultPages($venue_id){
        
        $obj = new VenuePage(['name'=>'Main','type'=>'main','active'=>1,'venue_id'=>$venue_id]);$obj->save();
        $obj = new VenuePage(['name'=>'Locations','type'=>'locations','active'=>1,'venue_id'=>$venue_id]);$obj->save();
        $obj = new VenuePage(['name'=>'Availability','type'=>'availability','active'=>1,'venue_id'=>$venue_id]);$obj->save();
        $obj = new VenuePage(['name'=>'Wedding packages','type'=>'packages','active'=>1,'venue_id'=>$venue_id]);$obj->save();
        $obj = new VenuePage(['name'=>'Wedding items','type'=>'items','active'=>1,'venue_id'=>$venue_id]);$obj->save();
        $obj = new VenuePage(['name'=>'Food&Beverages','type'=>'food','active'=>1,'venue_id'=>$venue_id]);$obj->save();
    }
    /**
     * Displays a single Venue model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionMenu() {
        $id = Yii::$app->request->post('id');
        $model = $this->findModel($id);
        return $this->renderAjax('menu', [
            'model' => $model
        ]);
    }

    function actionFilesUpload($venue_id) {

        $alert = '';
        $errors = [];
        $list = [];
        $files = UploadedFile::getInstancesByName('files');
        if (Yii::$app->request->isPost) {
            if (!count($files)) {
                if ($_SERVER['CONTENT_LENGTH']) {
                    $alert = 'Content-Length exceeds the limit';
                }

            } else {

                foreach ($files as $file) {
                    $model = new VenueDoc;
                    $model->venue_id = $venue_id;
                    $model->doc = $file->name;
                    $model->file = $file;

                    $transaction = Yii::$app->db->beginTransaction();
                    if ($model->save() && $model->fileSaved) {
                            $list[$model->id] = $file->name;
                        $transaction->commit();
                    } else {
                       
                        $errors = $model->getErrors();
                        
                        $transaction->rollBack();
                    }
        
                }

            }

            Yii::$app->response->format = Response::FORMAT_JSON;

            return compact(
                'alert',
                'errors',
                'list'
            );

        }
    }

    function actionLogoUpload($venue_id) {

        $alert = '';
        $errors = [];
        $list = [];
        $files = UploadedFile::getInstancesByName('files');
        $model = VenueWebsite::find()->where(['venue_id' => $venue_id])->one();
        if (Yii::$app->request->isPost) {
            if (!count($files)) {
                if ($_SERVER['CONTENT_LENGTH']) {
                    $alert = 'Content-Length exceeds the limit';
                }

            } else {
                foreach ($files as $file) {
                    $model->logo_file = $file;

                    $transaction = Yii::$app->db->beginTransaction();
                    if ($model->save() && $model->file_saved) {
                            $list[$model->id] = $model->logo;
                        $transaction->commit();
                    } else {
                        $errors = $model->getErrors();
                        
                        $transaction->rollBack();
                    }
        
                }

            }

            Yii::$app->response->format = Response::FORMAT_JSON;

            return compact(
                'alert',
                'errors',
                'list'
            );

        }
    }

    /**
     * Updates an existing or create new Venue model.
     * If create is successful, the browser will be redirected to the 'update' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id ='')
    {
        if($id!='') {
            $model = $this->findModel($id);
            if(!$model->tax) {
                $model->tax = new VenueTax(['organization_id' => $model->organization_id]);
            }

        }
        else {
            $model = new Venue;
            $model->tax = new VenueTax();
        }

        $alert  = $message = '';

        $errors = [];

        $post = Yii::$app->request->post();
        if($post) {

            if($model->load($post) && $model->tax->load($post) && $model->organization->load($post)) {
                //echo '<pre>';print_r($model->contacts);die();
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if (!$model->save()) {
                        $transaction->rollback();
                        $alert = 'Info not saved. Venue error';
                        $errors = $model->getErrors();
                            
                    }else {

                        //$contacts = $model->getContacts()->all();
                       // $model->address->link('venue', $model);
                        //$model->tax->link('venue', $model);

                        
                        Model::loadMultiple($model->contacts, $post);
                        if($model->organization->save() && $model->tax->save()) {
                            if(count($model->contacts)>0) {
                                foreach($model->contacts as $contact) {
                                    if(!$contact->save()) {
                                        $alert = 'Info not saved. Contacts error ';
                                        $transaction->rollback();
                                    }
                                }
                            }
                            $transaction->commit();
                            if($id == '') {
                                return $this->redirect(['update','id' => $model->id]);
                            }
                            $message = 'Succesfully saved';
                        } else {
                            $alert = 'Info not saved. Address/tax error';
                            $transaction->rollback();
                        }
                        
                    }
                   
                }catch (Exception $ex) {
                    $transaction->rollback();
                    $alert = 'Info not saved';
                }
                    Yii::$app->response->format = Response::FORMAT_JSON;    
                    return compact(
                    'alert',
                    'message',
                    'errors'
                );
            }
            
        }
        return $this->render('form', [
            'model'   => $model,
            'alert'   => $alert,
            'message'   => $message,
            'tax'     => $model->tax,
            'contacts'=> $model->contacts,
            'docs'    => $model->docs,
            'doc'     => new VenueDoc
        ]);
    }


    /**
     * Deletes an existing Venue model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Venue model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Venue the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Venue::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionImport(){
        $addresses = VenueAddress::find()->all();
        foreach($addresses as $address) {
            $venue = Venue::findOne($address->venue_id);
            $organization = Organization::findOne($venue->organization_id);
            //$organization->attributes = $address->attributes;
            $organization->setAttributes($address->attributes, false);
            $organization->save();
        }
    }


}
