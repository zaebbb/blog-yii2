<?php

use app\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if(!empty($comments)): ?>

        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Author</th>
                <th scope="col">Comment</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach($comments as $comment): ?>

                <tr>
                    <th scope="row"><?= $comment->id ?></th>
                    <td><?= $comment->user->name ?></td>
                    <td><?= $comment->text ?></td>
                    <td>
                        <?php if($comment->isAllowed()): ?>
                            <a class="btn btn-warning" href="<?= Url::toRoute(['comment/disallow', "id" => $comment->id]) ?>">Disallow</a>
                        <?php else: ?>
                            <a class="btn btn-success" href="<?= Url::toRoute(['comment/allow', "id" => $comment->id]) ?>">Allow</a>
                        <?php endif; ?>

                        <a class="btn btn-danger" href="<?= Url::toRoute(['comment/delete', "id" => $comment->id]) ?>">Delete</a>
                    </td>
                </tr>

            <?php endforeach; ?>

            </tbody>
        </table>

    <?php endif; ?>

</div>
