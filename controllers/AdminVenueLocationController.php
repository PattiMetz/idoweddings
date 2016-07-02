<?php

namespace app\controllers;

use Yii;
use app\models\venue\VenueLocation;
use app\models\venue\VenueLocationGroup;
use app\models\venue\VenueLocationTime;
use app\models\venue\VenueLocationImage;
use app\models\search\VenueLocationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use app\actions\DeleteAction;
use yii\web\UploadedFile;
use yii\imagine\Image;
/**
 * VenueLocationController implements the CRUD actions for VenueLocation model.
 */
class AdminVenueLocationController extends Controller
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

    public function actions()
    {
        return [
            
            'location-delete' => [
                'class'       => DeleteAction::className(),
                'modelClass'  => 'app\models\venue\VenueLocation',
                'exampleName' => 'location'
            ],
            'group-delete' => [
                'class'       => DeleteAction::className(),
                'modelClass'  => 'app\models\venue\VenueLocationGroup',
                'exampleName' => 'group'
            ],
        ];
    }

    /**
     * Lists all VenueLocation models.
     * @return mixed
     */
    public function actionIndex($venue_id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => VenueLocationGroup::find()->where(['venue_id'=>$venue_id]),
        ]);

        return $this->render('/admin-venue/location/index', [
            'venue_id'    => $venue_id,
            'dataProvider' => $dataProvider,
            
        ]);
    }

    /**
     * Displays a single VenueLocation model.
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
     * Displays a single VenueLocationGroup model.
     * @param integer $id
     * @return mixed
     */
    public function actionGroup($id = '', $venue_id = '')
    {
        $alert = '';
        if($id > 0)
            $model = VenueLocationGroup::find($id);
        else {
            $model = new VenueLocationGroup();
            $model->venue_id = $venue_id;
        }
        if(Yii::$app->request->post()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model->load(Yii::$app->request->post());
            if(!$model->save()) {
                $errors = $model->getErrors();
                $alert = 'Not saved';
                return compact(
                    'errors',
                    'alert'
                );
            }else {
                $pjax_reload = '#main';
                return compact('pjax_reload', 'alert');
            }
        }
        return $this->renderAjax('/admin-venue/location/group', [
            'model' => $model,
            'alert' => $alert
        ]);
    }

    /**
     * Creates a new VenueLocation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionLocation($id = '', $group_id = '')
    {
        if($id)
            $model = $this->findModel($id);
        else {
            $model = new VenueLocation();
            $model->group_id = $group_id;
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $post = Yii::$app->request->post();
            if($post['VenueLocationTime']['time_from']!='') {
                $new_time = $post['VenueLocationTime'];
                $time = new VenueLocationTime();
                $time->location_id = $model->id;
                $time->time_from = $new_time['time_from'];
                $time->time_to = $new_time['time_to'];
                $time->days = serialize($new_time['days']);
                $time->save();
            }

            //save files
            $files = UploadedFile::getInstances($model, 'files');
            @mkdir('uploads/venue/'.$model->group->venue_id.'/');
            @mkdir('uploads/venue/'.$model->group->venue_id.'/location/');
            @mkdir('uploads/venue/'.$model->group->venue_id.'/location/thumb/');


            foreach($files as $file) {
                //save files model
                $baseName = str_replace(' ', '_', $file->basename);
                $file->saveAs('uploads/venue/'.$model->group->venue_id.'/location/' . $baseName . '.' . $file->extension);
                $upload = new VenueLocationImage();
                $upload->location_id = $model->id;
                $upload->image = $baseName. '.' . $file->extension;
                $upload->save();
                //image thumb
                Image::thumbnail('uploads/venue/'.$model->group->venue_id.'/location/' . $baseName . '.' . $file->extension, 120, 120)
                ->save(Yii::getAlias('uploads/venue/'.$model->group->venue_id.'/location/thumb/' . $baseName . '.' . $file->extension), ['quality' => 80]);
            }                  

            return $this->redirect(['location', 'id' => $model->id]);
        } else {
            $time = new VenueLocationTime;
            $times = array();
            $days = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
            $halfs = array('AM', 'PM');
            foreach($halfs as $half) {
                for($i=0;$i<12;$i++) {
                    $times[$i.' '.$half] = $i.' '.$half;
                }
            }
            return $this->render('/admin-venue/location/location', [
                'model' => $model,
                'time'  => $time,
                'times' => $times,
                'days'  => $days,
                'images' => $model->images,
            ]);
        }
    }


    /**
     * Deletes an existing VenueLocation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteImage($id='')
    {
        $alert = '';

        $model = VenueLocationImage::findOne($id);

        if (!$model) {

            $alert = 'Image not found.';

        }

        if (Yii::$app->request->isPost) {

            $errors = [];

            if (!$model->delete()) {

                $alert = 'Image not deleted.';

            } else {
                $location = VenueLocation::findOne($model->location_id);
                @unlink('uploads/venue/'.$location->group->venue_id.'/location/'.$model->image);
                @unlink('uploads/venue/'.$location->group->venue_id.'/location/thumb/'.$model->image);
            }

            $pjax_reload = '#main';

            Yii::$app->response->format = Response::FORMAT_JSON;

            return compact(
                'errors',
                'alert',
                'pjax_reload'
            );

        }
        return $this->renderAjax('/actions/delete', [
            'model' => $model,
            'alert' => $alert
        ]);



    }

    /**
     * Finds the VenueLocation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VenueLocation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VenueLocation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
