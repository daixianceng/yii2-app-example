<?php

use yii\db\Migration;
use common\models\Category;
use common\models\Post;
use common\models\User;

/**
 * Class m180521_151010_demo
 */
class m180521_151010_demo extends Migration
{
    public $startId = 1001;
    public $categoryNumber = 12;
    public $postNumber = 12;

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        // Initialize the demo model
        $demo = new User();
        $demo->id = $this->startId;
        $demo->username = 'demo';
        $demo->avatar = Yii::$app->params['user.defaultAvatar'];
        $demo->email = 'demo@example.com';
        $demo->setPassword($demo->username);
        $demo->generateAuthKey();
        $demo->generateAccessToken();
        $demo->enable();
        $demo->createdAt = $demo->updatedAt = time();

        // Insert the demo into the `{{%user}}` table
        $this->insert('{{%user}}', $demo->toArray([
            'id',
            'username',
            'avatar',
            'email',
            'status',
            'createdAt',
            'updatedAt',
        ], [
            'passwordHash',
            'authKey',
            'accessToken',
        ]));

        $categoryIndex = 0;
        $categoryIdInserted = [];
        while ($categoryIndex < $this->categoryNumber) {
            $category = new Category();
            $category->id = $this->startId + $categoryIndex;
            $category->key = 'category_' . $category->id;
            $category->name = 'Category_' . $category->id;
            $category->sequence = $category->id;

            // Insert the category into the `{{%category}}` table
            $this->insert('{{%category}}', $category->toArray([
                'id',
                'key',
                'name',
                'sequence',
            ]));

            $categoryIdInserted[] = $category->id;
            $categoryIndex ++;
        }

        $postIndex = 0;
        while ($postIndex < $this->postNumber) {
            $post = new Post();
            $post->id = $this->startId + $postIndex;
            $post->categoryId = $categoryIdInserted[array_rand($categoryIdInserted)];
            $post->title = 'title_' . $post->id;
            $post->key = 'title_' . $post->id;
            $post->tags = 'tag1,tag2,tag3';
            $post->intro = 'This is a post with ID ' . $post->id;
            $post->content = '<p>' . $post->intro . '</p>';
            $post->authorId = $demo->id;
            $post->enable();
            $post->sequence = $post->id;
            $post->createdAt = $post->updatedAt = time();

            // Insert the post into the `{{%post}}` table
            $this->insert('{{%post}}', $post->toArray([
                'id',
                'categoryId',
                'title',
                'key',
                'tags',
                'intro',
                'content',
                'authorId',
                'status',
                'sequence',
                'createdAt',
                'updatedAt',
            ]));

            $postIndex ++;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->delete('{{%user}}', ['id' => $this->startId]);

        $categoryIndex = 0;
        while ($categoryIndex < $this->categoryNumber) {
            $this->delete('{{%category}}', ['id' => $this->startId + $categoryIndex]);

            $categoryIndex ++;
        }

        $postIndex = 0;
        while ($postIndex < $this->postNumber) {
            $this->delete('{{%post}}', ['id' => $this->startId + $postIndex]);

            $postIndex ++;
        }

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180521_151010_demo cannot be reverted.\n";

        return false;
    }
    */
}
