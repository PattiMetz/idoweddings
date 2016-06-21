<?php

namespace app\controllers;

use Yii;
use app\models\venue\Venue;
use app\models\venue\VenueAddress;
use app\models\venue\VenueTax;
use app\models\venue\VenueContact;
use app\models\venue\VenueDoc;
use app\models\search\VenueSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\actions\DeleteAction;
use yii\base\Model;
use yii\web\UploadedFile;

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
            ]
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
