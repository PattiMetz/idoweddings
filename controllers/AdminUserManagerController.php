<?php

namespace app\controllers;

use yii\web\Controller;

class AdminUserManagerController extends Controller
{
    public $layout = 'admin';

    public function actionIndex()
    {
        return $this->render('index');
    }
}