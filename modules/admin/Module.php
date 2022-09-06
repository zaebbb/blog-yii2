<?php

namespace app\modules\admin;

use Yii;
use yii\filters\AccessControl;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $layout = "/admin";
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    public function behaviors()
    {
        return [
            "access" => [
                "class" => AccessControl::className(),
                "denyCallback" => function($rule, $action){
                    throw new \yii\web\NotFoundHttpException();
                },
                "rules" => [
                    [
                        "allow" => true,
                        "matchCallback" => function($rule, $action){
                            if(!empty(Yii::$app->user->identity->isAdmin)){
                                return Yii::$app->user->identity->isAdmin;
                            }
                        }
                    ]
                ]
            ]
        ];
    }
}
