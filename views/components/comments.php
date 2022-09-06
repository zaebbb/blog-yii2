<div class="bottom-comment"><!--bottom comment-->
    <h4><?= count($comments) ?> comments</h4>
    <?php use yii\bootstrap5\ActiveForm;
    use yii\bootstrap5\Html;

    ?>
    <?php if(!empty($comments)): ?>

        <?php foreach($comments as $comment): ?>

            <div class="bottom-comment" style="margin: 10px 0 !important;padding:0 !important">
                <div class="comment-img">
                    <img class="img-circle" style="width: 50px;height:50px; object-fit: cover;" src="<?= $comment->user->getImage() ?>" alt="">
                </div>

                <div class="comment-text">
                    <a href="#" class="replay btn pull-right"> Replay</a>
                    <h5><?= $comment->user->name ?></h5>

                    <p class="comment-date">
                        <?= $comment->getFormatterDate() ?>
                    </p>

                    <p class="para"><?= $comment->text ?></p>
                </div>
            </div>

        <?php endforeach; ?>

    <?php endif; ?>
</div>
<!-- end bottom comment-->

<?php if(!Yii::$app->user->isGuest): ?>

    <?php if(Yii::$app->session->getFlash("comment")): ?>
        <div class="alert alert-success" role="alert">
            <?= Yii::$app->session->getFlash("comment") ?>
        </div>
    <?php endif; ?>
    <div class="leave-comment"><!--leave comment-->
        <h4>Leave a reply</h4>

        <?php
        $form = ActiveForm::begin(
             [
                 "id" => "add-comment",
                 "action" => ["site/comment", "id" => $article->id],
                 "options" => ["class" => "form-horizontal contact-form", 'role' => "form"],
                 'fieldConfig' => ['template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}"]
             ]
        );
        ?>
        <div class="form-group">
            <div class="col-md-12">
                <?= $form
                    ->field($commentForm, 'comment')
                    ->textarea(["class" => "form-control", "placeholder" => "Write Massage"])
                ?>
            </div>
        </div>
        <?= Html::submitButton('Post Comment', ['class' => 'btn send-btn']) ?>
        <?php ActiveForm::end(); ?>
    </div>
<?php endif; ?>
</div>