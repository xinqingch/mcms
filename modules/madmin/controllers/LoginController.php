<?php

namespace app\modules\madmin\controllers;

use yii;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\Adminer;
use app\models\Helper;

/**
 * Default controller for the `manage` module
 */
class LoginController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'main_login';
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack('/madmin/default');
        }

        $model->password = '';
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->admin->logout();

        return $this->goHome();
    }

    /**
     * Create init user
     */
    public function actionAdmin()
    {
        echo "创建一个新用户 ...\n";                  // 提示当前操作
        $data = [
            'username'=>'morven',
            'password'=>'066810.com',
            'roleId'=>1,
            'login_time'=>time(),
            'login_ip'=> ip2long(Helper::GetIP())
        ];

        $model = new Adminer();                            // 创建一个新用户
        $model->attributes = $data;
        $model->setPassword($data['password']);
        $model->generateAuthKey();
        $model->generatePasswordResetToken();
        var_dump($model);exit;
        if (!$model->save())                            // 保存新的用户
        {
            foreach ($model->getErrors() as $error)     // 如果保存失败，说明有错误，那就输出错误信息。
            {
                foreach ($error as $e)
                {
                    echo "$e\n";
                }
            }
            return 1;                                   // 命令行返回1表示有异常
        }
        return 0;                                       // 返回0表示一切OK
    }
}
