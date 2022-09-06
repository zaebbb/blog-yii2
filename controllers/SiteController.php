<?php

namespace app\controllers;

use app\models\Article;
use app\models\Category;
use app\models\CommentForm;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $data = Article::getAll(5);

        $popularArticles = Article::getPopular(3);

        $recentArticles = Article::getRecent(4);

        $categories = Category::find()->all();

        return $this->render('index', [
            "articles" => $data["articles"],
            "pagination" => $data["pagination"],
            "popularArticles" => $popularArticles,
            "recentArticles" => $recentArticles,
            "categories" => $categories
        ]);
    }


    public function actionView($id)
    {
        $article = Article::findOne($id);

        $popularArticles = Article::getPopular(3);

        $recentArticles = Article::getRecent(4);

        $categories = Category::find()->all();

        $comments = $article->getArticleComments();
        $commentForm = new CommentForm();

        $article->viewedCounter();

        return $this->render("single", [
            "article" => $article,
            "popularArticles" => $popularArticles,
            "recentArticles" => $recentArticles,
            "categories" => $categories,
            "comments" => $comments,
            "commentForm" => $commentForm
        ]);
    }

    public function actionCategory($id)
    {
        $data = Category::getAllArticles(4, $id);

        $popularArticles = Article::getPopular(3);

        $recentArticles = Article::getRecent(4);

        $categories = Category::find()->all();

        return $this->render("category", [
            "articles" => $data["articles"],
            "pagination" => $data["pagination"],
            "popularArticles" => $popularArticles,
            "recentArticles" => $recentArticles,
            "categories" => $categories
        ]);
    }

    public function actionComment($id)
    {
        $model = new CommentForm();

        if(Yii::$app->request->isPost){
            $model->load(Yii::$app->request->post());

            if($model->createComment($id)){
                Yii::$app->getSession()->setFlash('comment', 'Вы успешно добавили комментарий. После проверки администратора комментарий будет доступен к просмотру.');

                return $this->redirect(["site/view", "id" => $id]);
            }
        }
    }
}
