<?php

use yii\db\Migration;
use common\models\Apple;

/**
 * Handles the creation of table `{{%apple}}`.
 */
class m210315_160613_create_apple_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%apple}}', [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'color' => $this->string()->notNull()->comment('Цвет'),
            'appear_date' => $this->timestamp()->notNull()->comment('Дата появления'),
            'fall_date' => $this->timestamp()->defaultValue(Null)->comment('Дата падения'),
            'status' => $this->smallInteger()->notNull()->defaultValue(Apple::STATUS_HANGING)->comment('Статус'),
            'size' => $this->float()->notNull()->defaultValue(1)->comment('Целостность'),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%apple}}');
    }
}
