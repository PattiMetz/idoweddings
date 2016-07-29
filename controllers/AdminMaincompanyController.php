<?php

namespace app\controllers;

use app\models\Country;
use app\models\MainCompanyAddress;
use app\models\MainCompanyContact;
//use app\models\MainCompanyPhone;
use Yii;
use app\models\MainCompany;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdminMaincompanyController implements the CRUD actions for MainCompany model.
 */
class AdminMaincompanyController extends Controller
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
     * Updates an existing MainCompany model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        //$userId = Yii::$app->user->id;
        $userId = 1;//todo get current user
        $model = MainCompany::find()->where(['user_id' => $userId])->one();
        if($model === null){
            $model = new MainCompany();
            $address = new MainCompanyAddress();
            $contacts = null;
            //$phone = new MainCompanyPhone();
        } else {
            $address = $model->mainCompanyAddresses;
            $contacts = MainCompanyContact::find()->where(['company_id' => $model->id])->all();//todo +all
            //$phone = MainCompanyPhone::find()->where(['contact_id' => $contact->id])->one();//todo +all
        }

        if ($model->load(Yii::$app->request->post()) &&
            $address->load(Yii::$app->request->post()))
        {
            $isValid = $model->validate() && $address->validate();

            if ($isValid) {
                $model->user_id = $userId;
                $model->save(false);
                $mid = $model->getPrimaryKey();

                if($mid){
                    $address->company_id = $mid;
                    $address->save(false);
                }
                else {
                    throw new NotFoundHttpException("MainCompany wasn't saved");
                }
            } else {
                throw new NotFoundHttpException("Model is not valid");
            }
        }

        return $this->render('update', [
            'model' => $model,
            'address' => $address,
            'contacts' => $contacts,
            'phone' => null,//$phone,//todo
            'country' => new Country()
        ]);
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
                $count = MainCompanyContact::find()->where(['company_id' => $post['comp_id']])->count();
                if($count > 1)
                    $status = MainCompanyContact::findOne($id)->delete();
                else
                    $msg = 'You can not delete the last contact';
            }
        }
        elseif(Yii::$app->request->isPut){
            $model = new MainCompanyContact();

            if(!empty($post['comp_id'])) {
                $model->company_id = (int)$post['comp_id'];
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
                $model = MainCompanyContact::find()->where(['id' => $id])->one();

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
     * Deletes an existing MainCompany model.
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
     * Finds the MainCompany model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MainCompany the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MainCompany::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
