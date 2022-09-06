<?php

namespace app\models;

use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $content
 * @property string|null $date
 * @property string|null $image
 * @property int|null $viewed
 * @property int|null $user_id
 * @property int|null $status
 * @property int|null $category_id
 *
 * @property ArticleTag[] $articleTags
 * @property Comment[] $comments
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title', 'description', 'content'], 'string'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['date'], 'default', 'value' => date('Y-m-d')],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'content' => 'Content',
            'date' => 'Date',
            'image' => 'Image',
            'viewed' => 'Viewed',
            'user_id' => 'User ID',
            'status' => 'Status',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * Gets query for [[ArticleTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleTags()
    {
        return $this->hasMany(ArticleTag::className(), ['article_id' => 'id']);
    }

    public function saveImage($filename)
    {
        $this->image = $filename;
        return $this->save(false);
    }

    public function deleteImage()
    {
        $imageUploadModel = new ImageUpload();
        $imageUploadModel->deleteOldImage($this->image);
    }

    public function beforeDelete()
    {
        $this->deleteImage();

        return parent::beforeDelete();
    }

    public function getImage()
    {
        if ($this->image) {
            return "/uploads/" . $this->image;
        }

        return "/uploads/noimage.jpg";
    }

    public function getCategory()
    {
        return $this->hasOne(Category::className(), ["id" => "category_id"]);
    }

    public function saveCategory(int $category_id): bool
    {
        $category = Category::findOne($category_id);
        if(!is_null($category)){
            $this->link('category', $category);

        }

        return true;
    }

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ["id" => "tag_id"])
            ->viaTable("article_tag", ["article_id" => "id"]);
    }

    public function getSelectedTags(): array
    {
        return ArrayHelper::getColumn($this->getTags()->select("id")->asArray()->all(), "id");
    }

    public function saveTags(array $tags): bool
    {
        $this->clearActiveTags();

        foreach($tags as $tag_id){
            $tag = Tag::findOne($tag_id);
            $this->link('tags', $tag);
        }

        return true;
    }

    public function clearActiveTags(): bool
    {
        ArticleTag::deleteAll(["article_id" => $this->id]);

        return true;
    }

    public function getFormatterDate(){
        $date = $this->date;

        $formatter = Yii::$app->formatter;
        $formatter->locale = "ru-RU";

        return $formatter->asDate($date);
    }

    public static function getAll(int $pageSize): array
    {
        $query = Article::find();

        $count = $query->count();

        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);

        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return ["articles" => $articles, "pagination" => $pagination];
    }

    public static function getPopular(int $limit): array
    {
        return Article::find()->orderBy("viewed desc")->limit($limit)->all();
    }

    public static function getRecent(int $limit): array
    {
        return Article::find()->orderBy("date desc")->limit($limit)->all();
    }

    public function saveArticle()
    {
        $this->user_id = Yii::$app->user->identity->id;
        return $this->save();
    }

    public function getComments()
    {
        return $this->hasMany(Comment::className(), ["article_id" => "id"]);
    }

    public function getArticleComments()
    {
        return $this->getComments()->where(['status' => 1])->all();
    }

    public function getAuthor()
    {
        return $this->hasOne(User::className(), ["id" => "user_id"]);
    }

    public function viewedCounter()
    {
        ++$this->viewed;
        return $this->save(false);
    }
}
