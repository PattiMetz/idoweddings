<?php

namespace app\actions;

use Yii;
use yii\base;
use yii\web\Response;
use yii\bootstrap\ActiveForm;

class DeleteAction extends base\Action
{

    public $view = '@app/views/actions/delete';

    public $modelClass;

    public $exampleName;

    public function run($id='')
    {
        $alert = '';

        $prev = new $this->modelClass;

        $model = $prev::findOne($id);

        if (!$model) {

            $alert = $this->exampleName.' not found.';

        }

        if (Yii::$app->request->isPost) {

            $errors = [];

            if (!$model->delete()) {

                $alert = $this->exampleName.' not deleted.';

            }

            $pjax_reload = '#main';

            Yii::$app->response->format = Response::FORMAT_JSON;

            return compact(
                'errors',
                'alert',
                'pjax_reload'
            );

        }
        return $this->controller->renderAjax($this->view, [
            'model' => $model,
            'alert' => $alert,
            'exampleName' => $this->exampleName
        ]);



    }

}