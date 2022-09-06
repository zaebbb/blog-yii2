<?php

namespace app\controllers;

use app\models\Article;
use app\models\Category;
use app\models\RegisterForm;
use app\models\User;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class AuthController extends Controller
{
    public function actionLogin()
    {
        if(!Yii::$app->user->isGuest){
            return $this->goHome();
        }

        $model = new LoginForm();
        if($model->load(Yii::$app->request->post()) && $model->login()){
            return $this->goBack();
        }

        return $this->render('/auth/login', [
            "model" => $model
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionTest()
    {
        $user = User::findOne(1);
//        Yii::$app->user->login($user);
        Yii::$app->user->logout();

        echo "<pre>";
        print_r(Yii::$app->user->isGuest);
        echo "</pre>";
    }

    public function actionRegister()
    {
        $model = new RegisterForm();

        if(Yii::$app->request->isPost){
            $model->load(Yii::$app->request->post());

            if($model->register()){
                return $this->redirect(['auth/login']);
            }

        }

        return $this->render("/auth/register", [
            'model' => $model
        ]);
    }

    public function actionLoginVk($uid, $first_name, $photo)
    {
        $user = new User();

        if($user->saveFromVk($uid, $first_name, $photo)){
            return $this->redirect(["site/index"]);
        }
    }
}
