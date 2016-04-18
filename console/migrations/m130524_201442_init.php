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
            'id' => $this->primaryKey(), //Llave primaria
            'nombre' => $this->string(50)->notNull(),
            'descripcion' => $this->string(100)->notNull(),
            'id_modulo' => $this->integer()->notNull(),
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),
            'fecha_modificado' => $this->dateTime(),
        ], $tableOptions);

        //Crear tabla de bancos
        $this->createTable('{{%bancos}}',[
            'id' => $this->primaryKey(), //Llave primaria
            'nombre' => $this->string(50)->notNull(),
            'recomendado' => $this->boolean(),
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),
            'fecha_modificado' => $this->dateTime(),
        ], $tableOptions);

        //Crear tabla de flores
        $this->createTable('{{%flores}}',[
            'id' => $this->bigPrimaryKey(), //Llave primaria
            'id_usuario' => $this->integer()->notNull(),
            'id_flor_dependiente' => $this->bigInteger(),
            'id_flor_padre' => $this->bigInteger(),
            'id_invitacion' => $this->bigInteger(),
            'clave' => $this->string(9),
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),
            'fecha_terminado' => $this->dateTime(),
        ], $tableOptions);

        //Crear tabla de comisiones
        $this->createTable('{{%comisiones}}',[
            'id' => $this->primaryKey(), //Llave primaria
        ], $tableOptions);

        //Crear tabla de solicitudes_depositos
        $this->createTable('{{%solicitudes_depositos}}',[
            'id' => $this->bigPrimaryKey(), //Llave primaria
        ], $tableOptions);

        //Crear tabla de modulos
        $this->createTable('{{%modulos}}',[
            'id' => $this->primaryKey(), //Llave primaria
            'nombre' => $this->string(50)->notNull(),
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),
            'fecha_modificado' => $this->dateTime(),
        ], $tableOptions);

        //Crear tabla de notificaciones
        $this->createTable('{{%notificaciones}}',[
            'id' => $this->bigPrimaryKey(), //Llave primaria
            'id_usuario' => $this->integer()->notNull(),
            'contenido' => $this->text()->notNull(),
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),
            'fecha_leido' => $this->dateTime(),
        ], $tableOptions);

        //Crear tabla de invitaciones
        $this->createTable('{{%invitaciones}}',[
            'id' => $this->bigPrimaryKey(), //Llave primaria
            'id_usuario' => $this->integer(),
            'id_invitado' => $this->integer(),
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),
            'fecha_aceptado' => $this->dateTime(),
            'fecha_rechazado' => $this->dateTime(),
        ], $tableOptions);

        //Crear tabla de ordenes_pagos
        $this->createTable('{{%ordenes_pagos}}',[
            'id' => $this->bigPrimaryKey(), //Llave primaria
        ], $tableOptions);

        //Crear tabla de permisos
        $this->createTable('{{%permisos}}',[
            'id' => $this->primaryKey(), //Llave primaria
        ], $tableOptions);

        //Crear tabla de planes
        $this->createTable('{{%planes}}',[
            'id' => $this->primaryKey(), //Llave primaria
            'pago_flor' => $this->decimal(10,2)->defaultValue(0),
            'ganancia_flor' => $this->decimal(10,2)->defaultValue(0),
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),
            'fecha_modificado' => $this->dateTime(),
        ], $tableOptions);

        //Crear tabla de roles
        $this->createTable('{{%roles}}',[
            'id' => $this->primaryKey(), //Llave primaria
            'nombre' => $this->string(50)->notNull(),
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),
            'fecha_modificado' => $this->dateTime(),
        ], $tableOptions);

        //Crear tabla de colonias
        $this->crearTablaColonias();
        //Crear tabla de ciudades
        $this->crearTablaCiudades();

        //Crear tabla de estados
        $this->createTable('{{%estados}}',[
            'id' => $this->primaryKey(), //Llave primaria
        ], $tableOptions);

        //Crear tabla de paises
        $this->createTable('{{%paises}}',[
            'id' => $this->primaryKey(), //Llave primaria
        ], $tableOptions);

        $this->crearTablaUsuarios();

        //Crear tabla de usuarios_accesos
        $this->createTable('{{%usuarios_accesos}}',[
            'id' => $this->bigPrimaryKey(), //Llave primaria
        ], $tableOptions);

        //Crear tabla de sexos
        $this->createTable('{{%sexos}}',[
            'id' => $this->primaryKey(), //Llave primaria
            'nombre' => $this->string(20)->notNull(),
            'descripcion' => $this->string(100)->notNull(),
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),
            'fecha_modificado' => $this->dateTime(),
        ], $tableOptions);

        //Crear tabla de tokens
        $this->createTable('{{%tokens}}',[
            'id' => $this->primaryKey(), //Llave primaria
            'token' => $this->string(32)->notNull(),
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),
            'fecha_utilizado' => $this->dateTime(),
        ], $tableOptions);

        ##################
        ################## Creación de indices
        ##################

        ##################
        ################## Creación de llaves foraneas
        ##################

        $this->agregarLlaveForaneaUsuarios();
        $this->agregarLlaveForaneaColonias();

        ##################
        ################## Creación de contenido para catálogos iniciales
        ##################

        //USUARIOS
        //Catálogo para sexos
        $this->agregarCatalogoSexos();
        //Catálogo para bancos
        $this->agregarCatalogoBancosMexico();

    }

    public function down()
    {
        ##################
        ################## Eliminación de llaves foraneas
        ##################

        $this->eliminarLlaveForaneaUsuarios();
        $this->eliminarLlaveForaneaColonias();

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
        $this->dropTable('{{%colonias}}');
        $this->dropTable('{{%ciudades}}');
        $this->dropTable('{{%estados}}');
        $this->dropTable('{{%paises}}');
        $this->dropTable('{{%usuarios}}');
        $this->dropTable('{{%usuarios_accesos}}');
        $this->dropTable('{{%sexos}}');
        $this->dropTable('{{%tokens}}');
    }

    private function crearTablaUsuarios(){
        $this->createTable('{{%usuarios}}', [
            'id' => $this->primaryKey(), //Llave primaria
            'email' => $this->string(50)->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'nombres' => $this->string(50)->notNull(),
            'apellidos' => $this->string(50)->notNull(),
            'id_sexo' => $this->integer()->notNull(), //Llave foránea a la tabla {{%sexos}}
            'fecha_nacimiento' => $this->date()->notNull(),
            'contacto_telefonico' => $this->string()->notNull(),
            'domicilio' => $this->string()->notNull(),
            'cuenta_bancaria' => $this->bigInteger()->notNull(),
            'balance' => $this->decimal(10,2)->defaultValue(0),
            'id_banco' => $this->integer()->notNull(), //Llave foránea a la tabla {{%bancos}}
            'id_colonia' => $this->bigInteger()->notNull(), //Llave foránea a la tabla {{%colonia}}
            'id_token' => $this->integer(), //token para la validación de información por email
            
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),
            'fecha_modificado' => $this->dateTime(),
            'fecha_eliminado' => $this->dateTime(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    private function crearTablaColonias(){
        $this->createTable('{{%colonias}}',[
            'id' => $this->bigPrimaryKey(), //Llave primaria
            'nombre' => $this->string(50)->notNull(),
            'codigo_postal' => $this->integer()->notNull(),
            'id_ciudad' => $this->integer()->notNull(),
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),
            'fecha_modificado' => $this->dateTime(),
        ], $tableOptions);
    }

    private function crearTablaCiudades(){
        $this->createTable('{{%ciudades}}',[
            'id' => $this->primaryKey(), //Llave primaria
            'nombre' => $this->string(50)->notNull(),
            'id_estado' => $this->integer()->notNull(),
            'codigo' => $this->string(3)->notNull(),
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),
            'fecha_modificado' => $this->dateTime(),
        ], $tableOptions);
    }

    private function crearTablaEstados(){
        $this->createTable('{{%estados}}',[
            'id' => $this->primaryKey(), //Llave primaria
            'nombre' => $this->string(50)->notNull(),
            'id_pais' => $this->integer()->notNull(),
            'codigo' => $this->string(3)->notNull(),
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),
            'fecha_modificado' => $this->dateTime(),
        ], $tableOptions);
    }

    private function agregarLlaveForaneaUsuarios(){
        //Usuarios<<<Sexos
        $this->addForeignKey(
            'fk-usuarios-id_sexo-sexos-id',   //Nombre de la llave foranea
            '{{%usuarios}}',                    //Nombre de la tabla destino
            'id_sexo',                          //Nombre del campo destino
            '{{%sexos}}',                       //Nombre de la tabla origen
            'id',                               //Nombre del campo origen
            'CASCADE'
        );
        //Usuarios<<<Bancos
        $this->addForeignKey(
            'fk-usuarios-id_banco-bancos-id',
            '{{%usuarios}}',
            'id_banco',
            '{{%bancos}}',
            'id',
            'CASCADE'
        );
        //Usuarios<<<Colonias
        $this->addForeignKey(
            'fk-usuarios-id_colonia-colonias-id',
            '{{%usuarios}}',
            'id_colonia',
            '{{%colonias}}',
            'id',
            'CASCADE'
        );
        //Usuarios<<<Tokens
        $this->addForeignKey(
            'fk-usuarios-id_token-tokens-id',
            '{{%usuarios}}',
            'id_token',
            '{{%tokens}}',
            'id',
            'CASCADE'
        );
    }

    private function eliminarLlaveForaneaUsuarios(){
        $this->dropForeignKey('fk-usuarios-id_sexo-sexos-id','{{%usuarios}}');
        $this->dropForeignKey('fk-usuarios-id_banco-bancos-id','{{%usuarios}}');
        $this->dropForeignKey('fk-usuarios-id_colonia-colonias-id','{{%usuarios}}');
        $this->dropForeignKey('fk-usuarios-id_token-tokens-id','{{%usuarios}}');
    }

    private function agregarLlaveForaneaColonias(){
        //Colonias<<<Municipios
        $this->addForeignKey(
            'fk-colonias-id_ciudad-ciudades-id',   //Nombre de la llave foranea
            '{{%colonias}}',                    //Nombre de la tabla destino
            'id_ciudad',                          //Nombre del campo destino
            '{{%ciudades}}',                       //Nombre de la tabla origen
            'id',                               //Nombre del campo origen
            'CASCADE'
        );
    }

    private function eliminarLlaveForaneaColonias(){
        $this->dropForeignKey('fk-colonias-id_ciudad-ciudades-id','{{%colonias}}');
    }

    private function agregarCatalogoSexos()
    {
        $this->batchInsert('{{%sexos}}',['nombre','descripcion'],[
            ['Hombre','Clasificación para el género hombre'],
            ['Mujer','Clasificación para el género mujer']
        ]);
    }

    private function agregarCatalogoBancosMexico()
    {
        $this->batchInsert('{{%bancos}}',['nombre','recomendado'],[
            ['ABC Capital',false],
            ['American Express Bank (México)',false],
            ['Banca Afirme',false],
            ['Banca Mifel',false],
            ['Banco Actinver',false],
            ['Banco Ahorro Famsa',false],
            ['Banco Autofin México',false],
            ['Banco Azteca',false],
            ['Banco Base',false],
            ['Banco Compartamos',false],
            ['Banco Credit Suisse (México)',false],
            ['Banco del Bajío',false],
            ['Banco Finterra',false],
            ['Banco Forjadores',false],
            ['Banco Inbursa',false],
            ['Banco Inmobiliario Mexicano',false],
            ['Banco Interacciones',false],
            ['Banco Invex',false],
            ['Banco JP Morgan',false],
            ['Banco Mercantil del Norte',false],
            ['Banco Monex',false],
            ['Banco Multiva',false],
            ['Banamex',false],
            ['Banco PagaTodo',false],
            ['Banco Progreso Chihuahua',false],
            ['Banco Regional de Monterrey',false],
            ['Banco Sabadell',false],
            ['Banco Santander',false],
            ['Banco Ve por Más',false],
            ['BanCoppel',true],
            ['Banorte',true],
            ['Bancrea',false],
            ['Bank Of America Mexico',false],
            ['Bank Of Tokyo Mitsubishi UFJ (México)',false],
            ['Bankaool',false],
            ['Bansí',false],
            ['Barclays Bank México',false],
            ['BBVA Bancomer',false],
            ['CIBanco',false],
            ['Consubanco',false],
            ['Deutsche Bank México',false],
            ['Fundación Dondé Banco',false],
            ['HSBC México',false],
            ['Industrial and Commercial Bank of China',false],
            ['Intercam Banco',false],
            ['Investa Bank',false],
            ['Scotiabank',false],
            ['Shinhan Bank',false],
            ['UBS Bank México',false],
            ['Volkswagen Bank',false]
        ]);
        
    }
}
