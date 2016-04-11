<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        //Opciones para la creación de tablas
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        ##################
        ################## Creación de tablas
        ##################

        //Crear tabla de acciones
        $this->createTable('{{%acciones}}',[
        ], $tableOptions);

        //Crear tabla de bancos
        $this->createTable('{{%bancos}}',[
        ], $tableOptions);

        //Crear tabla de flores
        $this->createTable('{{%flores}}',[
        ], $tableOptions);

        //Crear tabla de comisiones
        $this->createTable('{{%comisiones}}',[
        ], $tableOptions);

        //Crear tabla de solicitudes_depositos
        $this->createTable('{{%solicitudes_depositos}}',[
        ], $tableOptions);

        //Crear tabla de modulos
        $this->createTable('{{%modulos}}',[
        ], $tableOptions);

        //Crear tabla de notificaciones
        $this->createTable('{{%notificaciones}}',[
        ], $tableOptions);

        //Crear tabla de invitaciones
        $this->createTable('{{%invitaciones}}',[
        ], $tableOptions);

        //Crear tabla de ordenes_pagos
        $this->createTable('{{%ordenes_pagos}}',[
        ], $tableOptions);

        //Crear tabla de permisos
        $this->createTable('{{%permisos}}',[
        ], $tableOptions);

        //Crear tabla de planes
        $this->createTable('{{%planes}}',[
        ], $tableOptions);

        //Crear tabla de roles
        $this->createTable('{{%roles}}',[
        ], $tableOptions);

        //Crear tabla de ubicaciones
        $this->createTable('{{%ubicaciones}}',[
        ], $tableOptions);

        //Crear tabla de usuarios
        $this->createTable('{{%usuarios}}', [
            'id' => $this->primaryKey(), //Llave primaria
            'email' => $this->string()->notNull()->unique(), //email unico para acceso
            'auth_key' => $this->string(32)->notNull(), //
            'password_hash' => $this->string()->notNull(), //Contraseña encriptada 
            'password_reset_token' => $this->string()->unique(),
            'nombres' => $this->string()->notNull(),
            'apellidos' => $this->string()->notNull(),
            'sexo' => $this->string()->notNull(),
            'fecha_nacimiento' => $this->date()->notNull(),
            'contacto_telefonico' => $this->string()->notNull(),
            'domicilio' => $this->string()->notNull(),
            'cuenta_bancaria' => $this->bigInteger()->notNull(),
            'balance' => $this->decimal(10,2)->defaultValue(0),
            'id_banco' => $this->integer()->notNull(), //Llave FORANEA de la tabla de bancos
            'id_ubicacion' => $this->integer()->notNull(), //Llave FORANEA de la tabla de ubicaciones
            'token' => $this->string()->unique(), //token para la validación de información por email
            
            'fecha_creado' => $this->dateTime()->defaultValue('NOW()'),
            'fecha_modificado' => $this->dateTime(),
            'fecha_eliminado' => $this->dateTime(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        //Crear tabla de usuarios_accesos
        $this->createTable('{{%usuarios_accesos}}',[
        ], $tableOptions);

        ##################
        ################## Creación de indices
        ##################

        ##################
        ################## Creación de llaves foraneas
        ##################

        //Agregar llave foranea
        $this->addForeignKey(
            'fk-post-author_id',    //Nombre de la llave foranea
            'post',                 //Nombre de la tabla destino
            'author_id',            //Nombre del campo destino
            'user',                 //Nombre de la tabla origen
            'id',                   //Nombre del campo origen
            'CASCADE'
        );
    }

    public function down()
    {
        ##################
        ################## Eliminación de tablas
        ##################
        $this->dropTable('{{%acciones}}');
        $this->dropTable('{{%bancos}}');
        $this->dropTable('{{%flores}}');
        $this->dropTable('{{%comisiones}}');
        $this->dropTable('{{%solicitudes_depositos}}');
        $this->dropTable('{{%modulos}}');
        $this->dropTable('{{%notificaciones}}');
        $this->dropTable('{{%invitaciones}}');
        $this->dropTable('{{%ordenes_pagos}}');
        $this->dropTable('{{%permisos}}');
        $this->dropTable('{{%planes}}');
        $this->dropTable('{{%roles}}');
        $this->dropTable('{{%ubicaciones}}');
        $this->dropTable('{{%usuarios}}');
        $this->dropTable('{{%usuarios_accesos}}');
    }
}
