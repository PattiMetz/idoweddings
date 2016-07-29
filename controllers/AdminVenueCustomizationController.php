<?php

namespace app\controllers;

use app\models\venue\Venue;
use app\models\venue\VenuePage;
use app\models\venue\VenuePageSetting;
use app\models\venue\VenuePageImage;
use yii\web\Response;
use yii\helpers\ArrayHelper;

use yii\web\UploadedFile;
use yii\imagine\Image;
use Yii;
class AdminVenueCustomizationController extends \yii\web\Controller
{
    public $layout = 'full';

    public function beforeAction($action) {

        $this->view->params['section_title'] = 'Venues';
        return parent::beforeAction($action);

    }

    public function actionIndex($id, $page_id = '')
    {
        $alert = $message = '';
        $venue = Venue::findOne($id);

        $pages = ArrayHelper::map($venue->activepages, 'id', 'name');
        

       //getting current page (default - main page)

        if(!$page_id)
            $page = $venue->mainpage;
        else {
            $page = VenuePage::findOne($page_id);
          
        }

        $settings = $page->venuepagesetting;

        /*if ($page->type == 'locations') {
            $location_groups = ArrayHelper::map($venue->locationgroups, 'id', 'name');
        }*/

        $post = Yii::$app->request->post();
        if ($post) {
            if ($settings->load($post)){
                if ($settings->save()) {
                    if($page->type == 'locations') {

                        if( $page->load($post) && $page->save()) {
                        }else {
                             $alert = 'Error locations saving';
                        }
                    }
                    $message = 'Succesfully saved';
                }
                else {
                    $alert = 'Error';
                    $errors = $settings->getErrors();
                }
                Yii::$app->response->format = Response::FORMAT_JSON;

                return compact(
                    'message',
                    'alert',
                    'errors'
                );
            }
           

        }     
        return $this->render('/admin-venue/website/customization',[
            'pages'           => $pages,
            'page'            => $page,
            'venue'           => $venue,
            'images'          => $page->images,
           // 'location_groups' => $location_groups,
            'settings'        => $settings,
            'alert'           => $alert,
            'message'         => $message
        ]);
    }

    function actionUpdateSetting($page_id){
        $page = VenuePage::findOne($page_id);
        $post = Yii::$app->request->post();
        if ($post) {
            $page->venuepagesetting->default_slideshow = $post['default_slideshow'];
            $page->venuepagesetting->save();
        }  
    }

    function actionFilesUpload($page_id) {

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
                    $model = new VenuePageImage();
                    $model->page_id = $page_id;
                    $model->image = $file->name;
                    $model->file = $file;
                 
                    $transaction = Yii::$app->db->beginTransaction();
                    if ($model->save() && $model->fileSaved) {
                            $list[$model->id] = $model->id.'.'.$file->extension;
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

    public function actionPreviewTemplate($page_id, $top_type = '') {
        
        $model = VenuePage::findOne($page_id);
        $venue = Venue::findOne($model->venue_id);
        /*if($top_type!='')
            $model->venuepagesetting->top_type = $top_type;*/
        $venue = Venue::findOne($model->venue_id);
        return $this->renderAjax('/admin-venue/website/template-'.$model->type, [
            'model' => $model,
            'venue' => $venue
        ]);
    }

    public function actionDeleteImage($id='')
    {
        $alert = '';

        $model = VenuePageImage::findOne($id);

        if (!$model) {

            $alert = 'Image not found.';

        }

        if (Yii::$app->request->isPost) {

            $errors = [];

            if (!$model->delete()) {

                $alert = 'Image not deleted.';

            } else {
                @unlink('uploads/venue/'.$model->page->venue_id.'/website/'.$model->page->type.'/'.$model->image);
                @unlink('uploads/venue/'.$model->page->venue_id.'/website/'.$model->page->type.'/thumb/'.$model->image);
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
            'alert' => $alert,
            'exampleName'=>'VenuePageImage'
        ]);



    }


}
