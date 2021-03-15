<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m210127_182939_add_user_row
 */
class m210127_182939_add_user_row extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('user', [
            'username' => 'default',
            'auth_key' => 'pEYGxfq6sEcStprT4YA2qSvU5Cg7Yr',
            'password_hash' => '$2y$13$KL75DU3RjO30HbhJ4HQrJO3JCng8B7RSmOoL8RvkeRbUU3AOsa6tO',
            'email' => '',
            'status' => User::STATUS_ACTIVE,
            'created_at' => 1611773279,
            'updated_at' => 1611773279,
        ]);
    }
}
