<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%usuarios}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'nombres' => $this->string()->notNull(),
            'apellidos' => $this->string()->notNull(),
            'sexo' => $this->string()->notNull(),
            'fecha_nacimiento' => $this->date()->notNull(),
            'contacto_telefonico' => $this->string()->notNull(),
            'domicilio' => $this->string()->notNull(),
            'cuenta_bancaria' => $this->bigInteger()->notNull(),
            'balance' => $this->decimal(10,2)->defaultValue(0),

            'fecha_creado' => $this->dateTime()->defaultValue(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%usuarios}}');
    }
}
