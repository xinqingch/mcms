<?php

namespace app\modules\madmin\controllers;

use yii;
use app\controllers\AdminController;
use app\models\LoginForm;

/**
 * Default controller for the `manage` module
 */
class DefaultController extends AdminController
{
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        return $this->render('index');
    }

    
}
