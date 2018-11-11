<?php

use yii\db\Migration;

/**
 * Class m181106_095103_logs
 */
class m181106_095103_logs extends Migration
{
    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
		$this->createTable('logs', [
			'id' => $this->primaryKey(),
			'time' => $this->integer(),
			'key' => $this->char(8),
		]);
    }

    public function down()
    {
        $this->dropTable('logs');
    }
    
}
