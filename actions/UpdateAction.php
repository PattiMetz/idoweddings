<?php

namespace app\actions;

use Yii;
use yii\base;
use yii\web\Response;
use yii\bootstrap\ActiveForm;

class UpdateAction extends base\Action
{

    public $view = '@app/views/actions/update';

    public $modelClass;

    public $exampleName;

    public function run($id='')
    {
        $alert = '';
       
        if ($id) {
          
           $prev = new $this->modelClass;
           
           $model = $prev::find()->where(['id' => $id])->one();

            if (!$model) {

                $alert = ucfirst($this->exampleName).' not found.';

            }

        } else {

            $model = new $this->modelClass;

        }

        $model_name = \yii\helpers\StringHelper::basename(get_class($model));
        if ($model->load(Yii::$app->request->post())) {
            
            $errors = ActiveForm::validate($model);
            
            if (!count($errors)) {

                if (!$model->save()) {
                    $alert = ucfirst($this->exampleName).' not saved.';

                    $errors = $model->getErrors();
                }

            }

            $pjax_reload = '#main';

            Yii::$app->response->format = Response::FORMAT_JSON;

            return compact(
                'errors',
                'alert',
                'pjax_reload'
            );

        }else {
            
        }
        return $this->controller->renderAjax($this->view ?: $this->id, [
                'model' => $model,
                'exampleName' => $this->exampleName,
                'alert' => $alert
            ]);
            

    }

}