<?php

namespace app\controllers;

use Yii;
use app\models\venue\Venue;
use app\models\venue\VenueAddress;
use app\models\venue\VenueTax;
use app\models\venue\VenueContact;
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
        $errors = [];
        $post = Yii::$app->request->post();
        
        if(isset($post['validate']) && $post['validate']==1) {
            
            $res = $model->checkurl($post['VenueWebsite']['url']);

            if(!$model->checkurl($post['VenueWebsite']['url'])) {
                $alert = 'Url already exists';
            }else
                $alert = 'Url is available';
        }elseif(isset($post['validate']) && $post['validate']==0) {
            if(!$model->checkurl($post['VenueWebsite']['url'])) {
                $alert = 'Url already exists';
            }else {
                $model->url = $post['VenueWebsite']['url'];
                $model->save();
            }
            
        }
        if($alert!='') {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $pjax_reload = '#main';
            return compact(
                'alert',
                'pjax_reload'
            );
        }
        return $this->renderAjax('website/url', [
                'model' => $model,
                'alert' =>$alert
                ]
                );
    }

    public function actionSettings($id)
    {
        $model = VenueWebsite::find()->where(['venue_id' => $id])->one();
     
        $venue = Venue::findOne($id);
        
        if(Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $model->load($post);
            $model->font_settings = serialize($post['settings']);
            $model->save();

            foreach($post['VenuePage'] as $page_id=>$page) {
                $obj = VenuePage::findOne($page_id);
                $obj->active = $page['active'];
                $obj->save();
               
            }
            $alert = 'Succesfully saved';
        }
        if(!$model) {
            $model = new VenueWebsite();
            $model->url = $model->generateUrl($venue->name);
            $model->venue_id = $id;
            $model->save();
        }

        $pages = VenuePage::findAll(['venue_id'=>$id]);
        if(!$pages) {
            $this->setDefaultPages($id);
            $pages = VenuePage::findAll(['venue_id'=>$id]);
        }
        $fonts = ['Times New Roman', 'Arial'];
        $sizes = array();
        for($i=10;$i<40;$i++) {
            $sizes[] = $i;
            $i++;
        }

        return $this->render('website/settings', [
                'model' => $model,
                'fonts' => $fonts,
                'sizes' => $sizes,
                'pages' => $pages
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

    /**
     * Creates a new Venue model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Venue();
        $address = new VenueAddress;
        $tax = new VenueTax;
        $contacts = [new VenueContact];
        $post = Yii::$app->request->post();
        if($post) {

             if($model->load($post)) {
            
                $address->load($post);
                $tax->load($post);
                
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if (!$model->save()) {
                            $transaction->rollback();
                            
                    }else {
                        $address->venue_id = $model->id;
                        $tax->venue_id = $model->id;
                        Model::loadMultiple($contacts, $post);
                        if($address->save() && $tax->save()) {
                            $this->saveContacts($contacts, $model);
                            
                            $transaction->commit();
                            return $this->redirect(['update', 'id' => $model->id]);
                        } else {
                             $transaction->rollback();
                        }
                        
                    }
                   
                }catch (Exception $ex) {
                    $transaction->rollback();
                }
            }
            
        }
        return $this->render('create', [
                'model'   => $model,
                'address' => $address,
                'tax'     => $tax,
                'contacts'=> $contacts,
                'docs'    => [],
                'doc'     => ''
        ]);
       
    }

    /**
     * Updates an existing Venue model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $post = Yii::$app->request->post();
        if($post) {

             if($model->load($post)) {
            
                $model->address->load($post);
                $model->tax->load($post);
                
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if (!$model->save()) {
                        //echo '<pre>';print_r($model);
                            $transaction->rollback();
                            
                    }else {
                        $contacts = $model->getContacts()->all();
                        foreach (array_diff_key($post['VenueContact'], $contacts) as $new) {
                            $contacts[] = new VenueContact(['venue_id' => $model->id]);
                        }
                        Model::loadMultiple($contacts, $post);
                        if($model->address->save() && $model->tax->save()) {
                            $this->saveContacts($contacts, $model);
                            $doc = new VenueDoc();
                            $doc->venue_id = $model->id;
                            $doc->doc='';
                            $files = UploadedFile::getInstances($doc, 'files');
                            @mkdir('uploads/venue/'.$model->id);
                            foreach($files as $file) {
                                $baseName = str_replace(' ', '_', $file->basename);
                                $file->saveAs('uploads/venue/'.$model->id.'/' . $baseName . '.' . $file->extension);
                                $upload = new VenueDoc();
                                $upload->venue_id = $model->id;
                                $upload->doc = $baseName. '.' . $file->extension;
                                $upload->save();
                               
                            }
                            
                            
                            $transaction->commit();
                           return $this->redirect(['update', 'id' => $model->id]);
                        } else {
                             $transaction->rollback();
                        }
                        
                    }
                   
                }catch (Exception $ex) {
                    $transaction->rollback();
                }
            }
            
        }

        return $this->render('update', [
            'model' => $model,
            'address' => $model->address,
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


    public function saveContacts($contacts, Venue $model) {
         foreach ($contacts as $contact) {
            $contact->venue_id = $model->id;
            if ($contact->validate()) {
                if (!empty($contact->name) || !empty($contact->phone)) {
                   
                    $contact->save();
                } else {
                    $contact->delete();
                }
            }
        }
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
}
