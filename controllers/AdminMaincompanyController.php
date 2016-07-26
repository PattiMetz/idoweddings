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
            $contact = new MainCompanyContact();
            //$phone = new MainCompanyPhone();
        } else {
            $address = $model->mainCompanyAddresses;
            $contact = MainCompanyContact::find()->where(['company_id' => $model->id])->one();//todo +all
            //$phone = MainCompanyPhone::find()->where(['contact_id' => $contact->id])->one();//todo +all
        }

        if ($model->load(Yii::$app->request->post()) &&
            $address->load(Yii::$app->request->post()) &&
            $contact->load(Yii::$app->request->post()))
        {
            $isValid = $model->validate() && $address->validate() && $contact->validate();

            if ($isValid) {
                $model->user_id = $userId;
                $model->save(false);
                $mid = $model->getPrimaryKey();

                if($mid){
                    $address->company_id = $mid;
                    $contact->company_id = $mid;
                    $address->save(false);
                    $contact->save(false);
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
            'contact' => $contact,
            'phone' => null,//$phone,//todo
            'country' => new Country()
        ]);
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
