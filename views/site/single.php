<?php

/** @var yii\web\View $this */


use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

$this->title = 'Пост';
?>

<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <article class="post">
                    <div class="post-thumb">
                        <a href="blog.html"><img src="<?= $article->getImage() ?>" alt=""></a>
                    </div>
                    <div class="post-content">
                        <header class="entry-header text-center text-uppercase">
                            <h6><a href="#"> <?= !empty($article->category->title) ? $article->category->title : "" ?></a></h6>

                            <h1 class="entry-title"><a href="blog.html"><?= $article->title ?></a></h1>


                        </header>
                        <div class="entry-content">
                            <p>
                                <?= $article->description ?>
                            </p>
                            <p>
                                <?= $article->content ?>
                            </p>
                        </div>

                        <div class="decoration">
                            <?php foreach($article->tags as $tag): ?>
                                <a href="#" class="btn btn-default"><?=$tag->title?></a>
                            <?php endforeach; ?>
                        </div>

                        <div class="social-share">
							<span
                                    class="social-share-title pull-left text-capitalize">By <?= $article->author->name ?> On <?= $article->getFormatterDate() ?></span>
                            <ul class="text-center pull-right">
                                <li><a class="s-facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a class="s-twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a class="s-google-plus" href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li><a class="s-linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a class="s-instagram" href="#"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </article>

            <?= $this->render("/components/comments", [
                "commentForm" => $commentForm,
                "comments" => $comments,
                "article" => $article
            ]) ?>
            <?= $this->render("/components/sidebar", [
                "popularArticles" => $popularArticles,
                "recentArticles" => $recentArticles,
                "categories" => $categories
            ]) ?>
        </div>
    </div>
</div>
