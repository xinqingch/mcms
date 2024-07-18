<?php

namespace app\modules\cms\controllers;

use app\models\Cmsnews;
use yii\web\Controller;

/**
 * Default controller for the `cms` module
 */
class NewsController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView($id){
        $model = Cmsnews::findOne($id);
        return $this->render('detail',['model'=>$model]);
    }
}
