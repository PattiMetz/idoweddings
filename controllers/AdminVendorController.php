<?php

namespace app\controllers;

use app\models\Contact;
use app\models\ContactPhone;
use app\models\Destination;
use app\models\Organization;
use app\models\vendor\VendorDestination;
use app\models\vendor\VendorHasType;
use Yii;
use app\models\vendor\Vendor;
use app\models\vendor\VendorSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdminVendorController implements the CRUD actions for Vendor model.
 */
class AdminVendorController extends Controller
{
    public $layout = 'admin';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Vendor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VendorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Vendor model.
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
     * Creates a new Vendor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Vendor();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Vendor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id = null)
    {
        if($id){
            $model = Vendor::find()->where(['organization_id' => $id])->one();
        }
        else {
            //Create new organization
            $organization = new Organization();
            $organization->type_id = 4;
            $organization->save();

            if(!empty($organization->getErrors())){
                throw new NotFoundHttpException(json_encode($organization->getErrors()));
            }
            //Create new Vendor
            $oid = $organization->getPrimaryKey();
            $model = new Vendor();
            $model->organization_id = $oid;
            $model->name = 'Name';
            $model->save();

            if(!empty($model->getErrors())){
                Organization::findOne($organization->getPrimaryKey())->delete();
                throw new NotFoundHttpException(json_encode($model->getErrors()));
            }
            //Create new contact
            $contact = new Contact();
            $contact->organization_id = $oid;
            $contact->save();

            if(!empty($contact->getErrors())){
                throw new NotFoundHttpException(json_encode($contact->getErrors()));
            }

            //Create 3 new Vendor Destination todo change dynamic depend on region in view
            for ($i=0; $i<3;$i++){
                $destination = new VendorDestination();
                $destination->vendor_id = $oid;
                $destination->save();

                if(!empty($destination->getErrors())){
                    //todo handle error log;
                }
            }

            //redirect new created company to update page for next changing
            return $this->redirect('update?id=' . $oid);
        }

        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->organization->load($post)) {
            $model->save();
            $model->organization->save();

            $types = isset($post['types']) ? $post['types'] : [];
            VendorHasType::updateTypes($id, $types);
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    /**
     * Deletes an existing Vendor model.
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
     * Finds the Vendor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Vendor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Vendor::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param null $id
     * @throws \Exception
     * Ajax Contacts actions (update fields, add,delete additional contact forms)
     */
    public function actionContacts($id = null){
        $status = false;
        $msg = $cid = '';
        $post = Yii::$app->request->post();

        if(Yii::$app->request->isDelete){
            if(!empty($post['comp_id'])) {
                $count = Contact::find()->where(['organization_id' => $post['comp_id']])->count();
                if($count > 1)
                    $status = Contact::findOne($id)->delete();
                else
                    $msg = 'You can not delete the last contact';
            }
        }
        elseif(Yii::$app->request->isPut){
            $model = new Contact();

            if(!empty($post['comp_id'])) {
                $model->organization_id = (int)$post['comp_id'];
                $status = $model->save();
                if (!$status) {
                    $msg = json_encode($model->getFirstErrors());
                } else {
                    $cid = $model->getPrimaryKey();
                }
            }
        }
        elseif(Yii::$app->request->isPost){

            if(!empty($post['field'])){
                $field = $post['field'];
                $value = $post['value'];
                $model = Contact::find()->where(['id' => $id])->one();

                if($model){
                    $model->$field = $value;
                    $status = $model->save();
                    if (!$status){
                        $msg = json_encode($model->getFirstErrors());
                    }
                }
            }
        }

        echo json_encode(array(
            'status' => $status ? 'success' : 'error',
            'msg' => $msg,
            'cid' => $cid
        ));
    }

    /**
     * @param $cid
     * Add phone field ajax
     */
    public function actionAdd_phone_field($cid){

        if(Yii::$app->request->isPut){
            $phoneModel = new ContactPhone();
            $phoneModel->contact_id = $cid;
            $phoneModel->type = 'mobile';
            $phoneModel->phone = '';
            $status = $phoneModel->save();

            echo json_encode(array(
                'status' => $status ? 'success' : 'error',
                'pid' => $status ? $phoneModel->getPrimaryKey() : 0
            ));
        }
    }

    /**
     * @param $pid
     * @throws \Exception
     * Delete phone field ajax
     */
    public function actionDelete_phone($pid){

        if(Yii::$app->request->isDelete){
            $status = ContactPhone::findOne($pid)->delete();

            echo json_encode(array(
                'status' => $status ? 'success' : 'error',
            ));
        }
    }

    /**
     * @param $id
     * Ajax update phones fields
     */
    public function actionUpdate_phone($id){
        $status = false;
        $msg = '';
        $post = Yii::$app->request->post();

        if(Yii::$app->request->isPost){

            if(!empty($post['field'])){
                $field = $post['field'];
                $value = $post['value'];
                $model = ContactPhone::find()->where(['id' => $id])->one();

                if($model){
                    $model->$field = $value;
                    $status = $model->save();
                    if (!$status){
                        $msg = json_encode($model->getFirstErrors());
                    }
                }
            }
        }

        echo json_encode(array(
            'status' => $status ? 'success' : 'error',
            'msg' => $msg
        ));
    }

    /**
     * @param $id
     * Update destination field via ajax
     */
    public function actionUpdate_destination($id){
        $status = false;
        $msg = '';
        $post = Yii::$app->request->post();

        if(Yii::$app->request->isPost){

            if(!empty($post['field'])){
                $field = $post['field'];
                $value = $post['value'];
                $model = VendorDestination::find()->where(['id' => $id])->one();

                if($model){
                    $model->$field = $value;
                    $status = $model->save();
                    if (!$status){
                        $msg = json_encode($model->getFirstErrors());
                    }
                }
            }
        }

        echo json_encode(array(
            'status' => $status ? 'success' : 'error',
            'msg' => $msg
        ));
    }
}
