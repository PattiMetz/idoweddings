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
        $venue = Venue::findOne($id);
        $pages = ArrayHelper::map($venue->activepages, 'id', 'name');
        $location_groups = array();
       //getting current page (default - main page)
        if(!$page_id)
            $page = $venue->mainpage;
        else {
            $page = VenuePage::findOne($page_id);
          
        }
        
        $image  = new VenuePageImage();
        $settings = $page->venuepagesetting;

        if ($page->type == 'locations') {
            $location_groups = $venue->locationgroups;
        }

        $post = Yii::$app->request->post();
        if ($post) {
            if ($settings->load($post)){
                $settings->save();
            }
            if ($files = UploadedFile::getInstances($image, 'file')) {
                foreach ($files as $file) {
                    @mkdir('uploads/venue/'.$venue->id.'/website/');
                    @mkdir('uploads/venue/'.$venue->id.'/website/'.$page->type.'/');
                    @mkdir('uploads/venue/'.$venue->id.'/website/'.$page->type.'/thumb');
                    $baseName = str_replace(' ', '_', $file->basename);
                    $file->saveAs('uploads/venue/'.$venue->id.'/website/'.$page->type.'/' . $baseName . '.' . $file->extension);
                    $upload = new VenuePageImage();
                    $upload->page_id = $page->id;
                    $upload->image = $baseName. '.' . $file->extension;
                    $upload->save();
                    Image::thumbnail('uploads/venue/'.$venue->id.'/website/'.$page->type.'/' . $baseName . '.' . $file->extension, 240, 105)
                    ->save(Yii::getAlias('uploads/venue/'.$venue->id.'/website/'.$page->type.'/thumb/' . $baseName . '.' . $file->extension), ['quality' => 80]);
                }
            } 
        }     
        return $this->render('/admin-venue/website/customization',[
            'pages'           => $pages,
            'page'            => $page,
            'venue'           => $venue,
            'images'          => $page->images,
            'image'           => $image,
            'location_groups' => $location_groups,
            'settings'        => $settings
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
