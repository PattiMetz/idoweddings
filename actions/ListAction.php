<?php

namespace app\actions;

use Yii;
use yii\base;
use yii\web\Response;
use app\components\FilterModelBase;
use yii\widgets\LinkPager;

class ListAction extends base\Action
{

    /**
     * @var ActiveRecord
     */
    protected $filterModel;

   
    /**
     * @var string
     */
    public $view = '@app/views/actions/list';

    /**
     * @var string
     */
    public $exampleName = '';

    public function run()
    {
        if (!$this->filterModel) {
            throw new base\ErrorException('Model not found');
        }

        $request = Yii::$app->request;

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
        }

        $data = ($request->isPost) ? $_POST : $_GET;
        $this->filterModel->load($data);


        if (!($dataProvider = $this->filterModel->search($data))) {
            throw new base\ErrorException('not initialized DataProvider');
        }
        if ($this->filterModel->hasErrors()) {

            if (empty($data)) {
                $this->filterModel->clearErrors();
            }

        }

        

        /*if ($request->isAjax) {
            return [
                'list' => $this->filterModel->buildModels(),
                'pagination' => ($this->paginationAsHTML)
                        ? LinkPager::widget([
                                'pagination' => $dataProvider->getPagination()
                            ])
                        : $dataProvider->getPagination()
            ];
        }*/
         /*$pjax_reload = '#main';

            Yii::$app->response->format = Response::FORMAT_JSON;

            return compact(
                'errors',
                'alert',
                'pjax_reload'
            );*/
        $this->controller->view->title = $this->exampleName;
        return $this->controller->render($this->view ?: $this->id, [
                'filterModel' => $this->filterModel,
                'dataProvider' => $dataProvider,
                'exampleName'=>$this->exampleName

            ]);

    }

    public function setFilterModel($model)
    {
        $this->filterModel = $model;
    }

  
}