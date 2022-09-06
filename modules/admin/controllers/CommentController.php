<?php

namespace app\modules\admin\controllers;

use app\models\Article;
use app\models\ArtileSearch;
use app\models\Category;
use app\models\Comment;
use app\models\ImageUpload;
use app\models\Tag;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class CommentController extends Controller
{
    public function actionIndex()
    {
        $comments = Comment::find()->orderBy("id desc")->all();

        return $this->render("index", [
            "comments" => $comments
        ]);
    }

    public function actionDelete($id)
    {
        $comment = Comment::findOne($id);

        if($comment->delete()){
            return $this->redirect(["comment/index"]);
        }
    }

    public function actionAllow($id)
    {
        $comment = Comment::findOne($id);

        if($comment->allow()){
            return $this->redirect(["comment/index"]);
        }
    }

    public function actionDisallow($id)
    {
        $comment = Comment::findOne($id);

        if($comment->disallow()){
            return $this->redirect(["comment/index"]);
        }
    }
}
