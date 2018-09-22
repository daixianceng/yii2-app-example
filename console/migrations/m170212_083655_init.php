<?php

use yii\db\Migration;
use common\models\User;

/**
 * Class m170212_083655_init
 */
class m170212_083655_init extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        // Create the `{{%user}}` table
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey()->unsigned(),
            'username' => $this->string()->notNull()->comment('Userame'),
            'authKey' => $this->string(32)->notNull()->comment('Authentication Key'),
            'passwordHash' => $this->string()->notNull()->comment('Password Hashed'),
            'accessToken' => $this->string()->notNull()->comment('Access Token'),
            'avatar' => $this->string()->notNull()->comment('Avatar Name'),
            'email' => $this->string()->notNull()->comment('E-mail'),
            'status' => $this->smallInteger(1)->unsigned()->notNull()->comment('Status'),
            'createdAt' => $this->integer(10)->unsigned()->notNull()->comment('Create Time'),
            'updatedAt' => $this->integer(10)->unsigned()->notNull()->comment('Update Time'),
        ], $tableOptions);

        // Initialize the administrator model
        $admin = new User();
        $admin->username = Yii::$app->params['init.adminUsername'];
        $admin->avatar = Yii::$app->params['user.defaultAvatar'];
        $admin->email = Yii::$app->params['adminEmail'];
        $admin->setPassword($admin->username);
        $admin->generateAuthKey();
        $admin->generateAccessToken();
        $admin->enable();
        $admin->createdAt = $admin->updatedAt = time();

        // Insert the administrator into the `{{%user}}` table
        $this->insert('{{%user}}', $admin->toArray([
            'username',
            'avatar',
            'email',
            'status',
            'createdAt',
            'updatedAt',
        ], [
            'passwordHash',
            'authKey',
            'accessToken'
        ]));

        // Create the `{{%category}}` table
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey()->unsigned(),
            'key' => $this->string()->notNull()->comment('Key'),
            'name' => $this->string()->notNull()->comment('Name'),
            'sequence' => $this->integer(10)->unsigned()->notNull()->comment('Sequence'),
        ], $tableOptions);

        // Create the `{{%post}}` table
        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey()->unsigned(),
            'categoryId' => $this->integer(10)->unsigned()->notNull()->comment('Category ID'),
            'title' => $this->string()->notNull()->comment('Title'),
            'key' => $this->string()->notNull()->comment('Key'),
            'tags' => $this->string()->notNull()->comment('Tags'),
            'cover' => $this->string()->notNull()->comment('Cover')->defaultValue(''),
            'intro' => $this->text()->notNull()->comment('Introduction'),
            'content' => $this->text()->notNull()->comment('Content'),
            'authorId' => $this->integer(10)->unsigned()->notNull()->comment('Author ID'),
            'status' => $this->smallInteger(1)->unsigned()->notNull()->comment('Status'),
            'sequence' => $this->integer(10)->unsigned()->notNull()->comment('Sequence'),
            'createdAt' => $this->integer(10)->unsigned()->notNull()->comment('Create Time'),
            'updatedAt' => $this->integer(10)->unsigned()->notNull()->comment('Update Time'),
        ], $tableOptions);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->delete('{{%user}}', ['id' => 1]);
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%category}}');
        $this->dropTable('{{%post}}');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170212_083655_init cannot be reverted.\n";

        return false;
    }
    */
}
