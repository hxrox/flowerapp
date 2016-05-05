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
        $this->crearTablas($tableOptions);

        ##################
        ################## Creación de indices
        ##################

        ##################
        ################## Creación de llaves foraneas
        ##################
        $this->crearLlavesForaneas();

        ##################
        ################## Creación de triggers
        ##################
        $this->crearTriggers();
        
        ##################
        ################## Creación de contenido para catálogos iniciales
        ##################
        $this->cargarCatalogosContenidoInicial();
        

    }

    public function down()
    {
        ##################
        ################## Eliminación de llaves foraneas
        ##################
        $this->eliminarLlavesForaneas();

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

    private function crearTablas($tableOptions){
        //Crear tabla de acciones
        $this->crearTablaAcciones($tableOptions);
        //Crear tabla de bancos
        $this->crearTablaBancos($tableOptions);
        //Crear tabla de flores
        $this->crearTablaFlores($tableOptions);
        //Crear tabla de comisiones
        $this->crearTablaComisiones($tableOptions);
        //Crear tabla de solicitudes_depositos
        $this->crearTablaSolicitudesDepositos($tableOptions);
        //Crear tabla de modulos
        $this->crearTablaModulos($tableOptions);
        //Crear tabla de notificaciones
        $this->crearTablaNotificaciones($tableOptions);
        //Crear tabla de invitaciones
        $this->crearTablaInvitaciones($tableOptions);
        //Crear tabla de ordenes_pagos
        $this->crearTablaOrdenesPagos($tableOptions);
        //Crear tabla de servicios_pagos
        $this->crearTablaServiciosPagos($tableOptions);
        //Crear tabla de permisos
        $this->crearTablaPermisos($tableOptions);
        //Crear tabla de planes
        $this->crearTablaPlanes($tableOptions);
        //Crear tabla de roles
        $this->crearTablaRoles($tableOptions);
        //Crear tabla de colonias
        $this->crearTablaColonias($tableOptions);
        //Crear tabla de ciudades
        $this->crearTablaCiudades($tableOptions);
        //Crear tabla de estados
        $this->crearTablaEstados($tableOptions);
        //Crear tabla de paises
        $this->crearTablaPaises($tableOptions);
        //Crear tabla de usuarios
        $this->crearTablaUsuarios($tableOptions);
        //Crear tabla de usuarios_accesos
        $this->crearTablaUsuariosAccesos($tableOptions);
        //Crear tabla de usuarios_roles
        $this->crearTablaUsuariosRoles($tableOptions);
        //Crear tabla de sexos
        $this->crearTablaSexos($tableOptions);
        //Crear tabla de tokens
        $this->crearTablaTokens($tableOptions);
    }

    private function crearLlavesForaneas(){
        $this->agregarLlaveForaneaUsuarios();
        $this->agregarLlaveForaneaUsuariosAccesos();
        $this->agregarLlaveForaneaAcciones();

        $this->agregarLlaveForaneaColonias();
        $this->agregarLlaveForaneaCiudades();
        $this->agregarLlaveForaneaEstados();

        $this->agregarLlaveForaneaFlores();
        $this->agregarLlaveForaneaComisiones();
        $this->agregarLlaveForaneaUsuariosRoles();

        $this->agregarLlaveForaneaInvitaciones();
        $this->agregarLlaveForaneaPermisos();
        $this->agregarLlaveForaneaTokens();

        $this->agregarLlaveForaneaNotificaciones();
        $this->agregarLlaveForaneaSolicitudesDepositos();
    }

    private function eliminarLlavesForaneas(){
        $this->eliminarLlaveForaneaUsuarios();
        $this->eliminarLlaveForaneaUsuariosAccesos();
        $this->eliminarLlaveForaneaAcciones();

        $this->eliminarLlaveForaneaColonias();
        $this->eliminarLlaveForaneaCiudades();
        $this->eliminarLlaveForaneaEstados();

        $this->eliminarLlaveForaneaFlores();
        $this->eliminarLlaveForaneaComisiones();
        $this->eliminarLlaveForaneaUsuariosRoles();

        $this->eliminarLlaveForaneaInvitaciones();
        $this->eliminarLlaveForaneaPermisos();
        $this->eliminarLlaveForaneaTokens();

        $this->eliminarLlaveForaneaNotificaciones();
        $this->eliminarLlaveForaneaSolicitudesDepositos();
    }

    private function crearTablaUsuarios($tableOptions){
        $this->createTable('{{%usuarios}}', [
            'id' => $this->primaryKey(), //Llave primaria
            'email' => $this->string(50)->notNull()->unique(),//Correo electrónico para la autenticación de credenciales
            'auth_key' => $this->string(32)->notNull(),//Llave dinámica "salt"
            'password_hash' => $this->string()->notNull(),//Hash de la contraseña encriptada con hash
            'password_reset_token' => $this->string()->unique(),//password para resetear contraseña
            'nombres' => $this->string(50)->notNull(), //Nombre del usuario
            'apellidos' => $this->string(50)->notNull(), //Apellidos del usuario
            'id_sexo' => $this->integer()->notNull(), //Llave foránea a la tabla {{%sexos}}
            'fecha_nacimiento' => $this->date()->notNull(),//Fecha de nacimiento del usuario
            'contacto_telefonico' => $this->string(10)->notNull(),//Número telefónico del usuario
            'domicilio' => $this->string(100)->notNull(), //Domiicilio del usuario
            'cuenta_bancaria' => $this->string(18)->notNull(),//Cuenta bancaria del usuario
            'balance' => $this->decimal(10,2)->defaultValue(0), // Balance de la cuenta del usuario (Ganado en la aplicación)
            'id_banco' => $this->integer()->notNull(), //Llave foránea a la tabla {{%bancos}}
            'id_colonia' => $this->bigInteger()->notNull(), //Llave foránea a la tabla {{%colonias}}
            
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),//Fecha de creación del registro en la tabla
            'fecha_modificado' => $this->dateTime(), //Fecha de modificación del registro en la tabla
            'fecha_eliminado' => $this->dateTime(), //Fecha eliminado el usuario.

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        //FALTA: Crear trigger para cuando fecha_eliminado reciva un dato, concatenar el email con ELIMINADO y el status en 20.
    }

    private function crearTablaUsuariosAccesos($tableOptions){
        $this->createTable('{{%usuarios_accesos}}',[
            'id' => $this->bigPrimaryKey(), //Llave primaria
            'id_usuario' => $this->integer()->notNull(),
            'user_agent' => $this->string(20)->notNull(), //Chrome
            'ip_address' => $this->string(15)->notNull(), //000.000.000.000
            'fecha' => $this->dateTime()->defaultExpression('NOW()'), //Fecha de creación del registro en la tabla
        ], $tableOptions);
    }

    private function crearTablaUsuariosRoles($tableOptions){
        $this->createTable('{{%usuarios_roles}}',[
            'id' => $this->bigPrimaryKey(), //Llave primaria
            'id_usuario' => $this->integer()->notNull(),
            'id_rol' => $this->integer()->notNull(),
            'fecha' => $this->dateTime()->defaultExpression('NOW()'), //Fecha de creación del registro en la tabla
        ], $tableOptions);
    }

    private function crearTablaModulos($tableOptions){
        $this->createTable('{{%modulos}}',[
            'id' => $this->primaryKey(), //Llave primaria
            'nombre' => $this->string(50)->notNull(), //Nombre del registro de la tabla
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),//Fecha de creación del registro en la tabla
            'fecha_modificado' => $this->dateTime(), //Fecha de modificación del registro en la tabla
        ], $tableOptions);
    }

    private function crearTablaAcciones($tableOptions){
        $this->createTable('{{%acciones}}',[
            'id' => $this->primaryKey(), //Llave primaria
            'nombre' => $this->string(50)->notNull(),
            'descripcion' => $this->string(100)->notNull(),
            'id_modulo' => $this->integer()->notNull(),
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),
            'fecha_modificado' => $this->dateTime(),
        ], $tableOptions);
    }

    private function crearTablaBancos($tableOptions){
        $this->createTable('{{%bancos}}',[
            'id' => $this->primaryKey(), //Llave primaria
            'nombre' => $this->string(50)->notNull(),
            'recomendado' => $this->boolean(),
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),
            'fecha_modificado' => $this->dateTime(),
        ], $tableOptions);
    }

    private function crearTablaFlores($tableOptions){
        $this->createTable('{{%flores}}',[
            'id' => $this->bigPrimaryKey(), //Llave primaria
            'id_usuario' => $this->integer()->notNull(), //Aquien pertenece esta flor
            'id_flor_dependiente' => $this->bigInteger(), //De que flor depende directamente
            'id_flor_padre' => $this->bigInteger(), //A que flor beneficia directamente
            'id_invitacion' => $this->bigInteger(), //De que invitacion se creó esta flor
            'clave' => $this->string(9), //Clave dinámica
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'), //Fecha de creación del registro en la tabla
            'fecha_terminado_dependencia' => $this->dateTime(), //Fecha en la que se completaron sus dependencias.
            'fecha_terminado' => $this->dateTime(), //Fecha en la que termino todas su flor.
        ], $tableOptions);

        /*
        FALTA: Crear trigger que cuando una flor tenga dos flores dependientes este llene el campo
        de fecha_terminado_dependencia por la fecha en la que se completaron sus dependencias.
        */
    }

    private function crearTablaRoles($tableOptions){
        $this->createTable('{{%roles}}',[
            'id' => $this->primaryKey(), //Llave primaria
            'nombre' => $this->string(50)->notNull(),
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),
            'fecha_modificado' => $this->dateTime(),
        ], $tableOptions);
    }

    private function crearTablaComisiones($tableOptions){
        $this->createTable('{{%comisiones}}',[
            'id' => $this->primaryKey(), //Llave primaria
            'id_servicio_pago' => $this->integer(),
            'comision_porcentaje' => $this->decimal(10,2)->notNull(),
            'comision_precio' => $this->decimal(10,2)->notNull(),
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),//Fecha de creación del registro en la tabla
            'fecha_modificado' => $this->dateTime(),
        ], $tableOptions);
    }

    private function crearTablaNotificaciones($tableOptions){
        $this->createTable('{{%notificaciones}}',[
            'id' => $this->bigPrimaryKey(), //Llave primaria
            'id_usuario' => $this->integer()->notNull(),
            'contenido' => $this->text()->notNull(),
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),//Fecha de creación del registro en la tabla
            'fecha_leido' => $this->dateTime(),
        ], $tableOptions);
    }

    private function crearTablaOrdenesPagos($tableOptions){
        /*  
            Esta tabla de ordenes de pagos identificarán que usuarios
            que crearón solicitudes de pagos en cuanto a los servicios
            de pago, esto para no duplicar ordenes de pago.
        */
        $this->createTable('{{%ordenes_pagos}}',[
            'id' => $this->bigPrimaryKey(), //Llave primaria
            'id_servicio_pago' => $this->integer()->notNull(),
            'url_servicio_pago' => $this->string()->notNull(),
            'estado' => $this->string(10),
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),//Fecha de creación del registro en la tabla
            'fecha_modificado' => $this->dateTime(),
        ], $tableOptions);
    }

    private function crearTablaServiciosPagos($tableOptions){
        $this->createTable('{{%servicios_pagos}}',[
            'id' => $this->primaryKey(), //Llave primaria
            'nombre' => $this->string(50)->notNull(),
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),//Fecha de creación del registro en la tabla
            'fecha_modificado' => $this->dateTime(),
        ], $tableOptions);
    }

    private function crearTablaPermisos($tableOptions){
        $this->createTable('{{%permisos}}',[
            'id' => $this->primaryKey(), //Llave primaria
            'id_rol' => $this->integer()->notNull(), //Llave foránea de la tabla de roles
            'id_accion' => $this->integer()->notNull(), //Llave foránea de la tabla de acciones
            'permitida' => $this->boolean(), //Saber si esta acción la tiene permitida dicho rol
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'), //Fecha de creación del registro en la tabla
            'fecha_modificado' => $this->dateTime(),
        ], $tableOptions);
    }

    private function crearTablaColonias($tableOptions){
        $this->createTable('{{%colonias}}',[
            'id' => $this->bigPrimaryKey(), //Llave primaria
            'nombre' => $this->string(50)->notNull(),
            'codigo_postal' => $this->integer()->notNull(),
            'id_ciudad' => $this->integer()->notNull(),
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),//Fecha de creación del registro en la tabla
            'fecha_modificado' => $this->dateTime(),
        ], $tableOptions);
    }

    private function crearTablaSolicitudesDepositos($tableOptions){
        /*
        Esta tabla tendrá la información de todos los usuarios que soliciten un depósito
        a su cuenta bancaria que tienen previamente ligado.
        */
        $this->createTable('{{%solicitudes_depositos}}',[
            'id' => $this->bigPrimaryKey(), //Llave primaria
            'id_usuario' => $this->integer()->notNull(),
            'monto' => $this->decimal(10,2)->notNull(),
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),//Fecha de creación del registro en la tabla
            'fecha_depositado' => $this->dateTime(),
        ], $tableOptions);
        /*
        Crear un trigger que al momento de el campo de fecha_depositado reciba un valor
        este en automático deposite en la cuenta de usuario y se refleje que ya se 
        realizo un depósito.
        FALTA: Creación del trigger
        */
    }

    private function crearTablaCiudades($tableOptions){
        $this->createTable('{{%ciudades}}',[
            'id' => $this->primaryKey(), //Llave primaria
            'nombre' => $this->string(50)->notNull(),
            'codigo' => $this->string(3)->notNull(),
            'id_estado' => $this->integer()->notNull(),
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),//Fecha de creación del registro en la tabla
            'fecha_modificado' => $this->dateTime(),
        ], $tableOptions);
    }

    private function crearTablaEstados($tableOptions){
        $this->createTable('{{%estados}}',[
            'id' => $this->primaryKey(), //Llave primaria
            'nombre' => $this->string(50)->notNull(),
            'codigo' => $this->string(3)->notNull(),
            'id_pais' => $this->integer()->notNull(),
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),//Fecha de creación del registro en la tabla
            'fecha_modificado' => $this->dateTime(),
        ], $tableOptions);
    }

    private function crearTablaPaises($tableOptions){
        $this->createTable('{{%paises}}',[
            'id' => $this->primaryKey(), //Llave primaria
            'nombre' => $this->string(25)->notNull(),
            'codigo' => $this->string(3)->notNull(),
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),//Fecha de creación del registro en la tabla
            'fecha_modificado' => $this->dateTime(),
        ], $tableOptions);
    }

    private function crearTablaPlanes($tableOptions){
        $this->createTable('{{%planes}}',[
            'id' => $this->primaryKey(), //Llave primaria
            'pago_flor' => $this->decimal(10,2)->defaultValue(0),
            'ganancia_flor' => $this->decimal(10,2)->defaultValue(0),
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),//Fecha de creación del registro en la tabla
            'fecha_modificado' => $this->dateTime(),
        ], $tableOptions);
    }

    private function crearTablaInvitaciones($tableOptions){
        $this->createTable('{{%invitaciones}}',[
            'id' => $this->bigPrimaryKey(), //Llave primaria
            'id_usuario' => $this->integer()->notNull(),
            'email_invitado' => $this->string()->notNull(),
            'id_plan' => $this->integer()->notNull(),
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),//Fecha de creación del registro en la tabla
            'fecha_aceptado' => $this->dateTime(),
            'fecha_rechazado' => $this->dateTime(),
        ], $tableOptions);
    }

    private function crearTablaSexos($tableOptions){
        $this->createTable('{{%sexos}}',[
            'id' => $this->primaryKey(), //Llave primaria
            'nombre' => $this->string(20)->notNull(),
            'descripcion' => $this->string(100)->notNull(),
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),//Fecha de creación del registro en la tabla
            'fecha_modificado' => $this->dateTime(),
        ], $tableOptions);
    }

    private function crearTablaTokens($tableOptions){
        $this->createTable('{{%tokens}}',[
            'id' => $this->primaryKey(), //Llave primaria
            'id_usuario' => $this->integer(),
            'token' => $this->string(32)->notNull(),
            'fecha_creacion' => $this->dateTime()->defaultExpression('NOW()'),//Fecha de creación del registro en la tabla
            'fecha_utilizado' => $this->dateTime(),
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
    }

    private function eliminarLlaveForaneaUsuarios(){
        $this->dropForeignKey('fk-usuarios-id_sexo-sexos-id','{{%usuarios}}');
        $this->dropForeignKey('fk-usuarios-id_banco-bancos-id','{{%usuarios}}');
        $this->dropForeignKey('fk-usuarios-id_colonia-colonias-id','{{%usuarios}}');
    }

    private function agregarLlaveForaneaUsuariosAccesos(){
        //Usuarios_Accesos<<<Usuarios
        $this->addForeignKey(
            'fk-usuarios_accesos-id_usuario-usuarios-id',
            '{{%usuarios_accesos}}',
            'id_usuario',
            '{{%usuarios}}',
            'id',
            'CASCADE'
        );
    }

    private function eliminarLlaveForaneaUsuariosAccesos(){
        $this->dropForeignKey('fk-usuarios_accesos-id_usuario-usuarios-id');
    }

    private function agregarLlaveForaneaUsuariosRoles(){
        //Usuarios_Roles<<<Usuarios
        $this->addForeignKey(
            'fk-usuarios_roles-id_usuario-usuarios-id',
            '{{%usuarios_roles}}',
            'id_usuario',
            '{{%usuarios}}',
            'id',
            'CASCADE'
        );
        //Usuarios_Roles<<<Roles
        $this->addForeignKey(
            'fk-usuarios_roles-id_rol-roles-id',
            '{{%usuarios_roles}}',
            'id_rol',
            '{{%roles}}',
            'id',
            'CASCADE'
        );
    }

    private function eliminarLlaveForaneaUsuariosRoles(){
        $this->dropForeignKey('fk-usuarios_roles-id_usuario-usuarios-id');
        $this->dropForeignKey('fk-usuarios_roles-id_rol-roles-id');
    }

    private function agregarLlaveForaneaAcciones(){
        //Acciones<<<Modulos
        $this->addForeignKey(
            'fk-acciones-id_modulo-modulos-id',
            '{{%acciones}}',
            'id_modulo',
            '{{%modulos}}',
            'id',
            'CASCADE'
        );
    }

    private function eliminarLlaveForaneaAcciones(){
        $this->dropForeignKey('fk-acciones-id_modulo-modulos-id');
    }


    private function agregarLlaveForaneaColonias(){
        //Colonias<<<Ciudades
        $this->addForeignKey(
            'fk-colonias-id_ciudad-ciudades-id',
            '{{%colonias}}',                    
            'id_ciudad',                          
            '{{%ciudades}}',                       
            'id',                               
            'CASCADE'
        );
    }

    private function eliminarLlaveForaneaColonias(){
        $this->dropForeignKey('fk-colonias-id_ciudad-ciudades-id','{{%colonias}}');
    }

    private function agregarLlaveForaneaCiudades(){
        //Ciudades<<<Estados
        $this->addForeignKey(
            'fk-ciudades-id_estado-estados-id',
            '{{%ciudades}}',                    
            'id_estado',                          
            '{{%estados}}',                       
            'id',                               
            'CASCADE'
        );
    }

    private function eliminarLlaveForaneaCiudades(){
        $this->dropForeignKey('fk-ciudades-id_estado-estados-id','{{%ciudades}}');
    }

    private function agregarLlaveForaneaEstados(){
        //Ciudades<<<Estados
        $this->addForeignKey(
            'fk-estados-id_pais-paises-id',
            '{{%estados}}',                    
            'id_pais',                          
            '{{%paises}}',                       
            'id',                               
            'CASCADE'
        );
    }

    private function eliminarLlaveForaneaEstados(){
        $this->dropForeignKey('fk-estados-id_pais-paises-id','{{%estados}}');
    }

    private function agregarLlaveForaneaFlores(){
        //Flores<<<Usuarios
        $this->addForeignKey(
            'fk-flores-id_usuario-usuarios-id',
            '{{%flores}}',                    
            'id_usuario',                          
            '{{%usuarios}}',                       
            'id',                               
            'CASCADE'
        );

        //Flores<<<Flores
        $this->addForeignKey(
            'fk-flores-id_flor_dependiente-flores-id',
            '{{%flores}}',                    
            'id_flor_dependiente',                          
            '{{%flores}}',                       
            'id',                               
            'CASCADE'
        );

        //Flores<<<Flores
        $this->addForeignKey(
            'fk-flores-id_flor_padre-flores-id',
            '{{%flores}}',                    
            'id_flor_padre',                          
            '{{%flores}}',                       
            'id',                               
            'CASCADE'
        );

        //Flores<<<Invitaciones
        $this->addForeignKey(
            'fk-flores-id_invitacion-invitaciones-id',
            '{{%flores}}',                    
            'id_invitacion',                          
            '{{%invitaciones}}',                       
            'id',                               
            'CASCADE'
        );
    }

    private function eliminarLlaveForaneaFlores(){
        $this->dropForeignKey('fk-flores-id_usuario-usuarios-id','{{%flores}}');
        $this->dropForeignKey('fk-flores-id_flor_dependiente-flores-id','{{%flores}}');
        $this->dropForeignKey('fk-flores-id_flor_padre-flores-id','{{%flores}}');
        $this->dropForeignKey('fk-flores-id_invitacion-invitaciones-id','{{%flores}}');
    }

    private function agregarLlaveForaneaComisiones(){
        //Comisiones<<<Servicio de pagos
        $this->addForeignKey(
            'fk-comisiones-id_servicio_pago-servicios_pagos-id',
            '{{%comisiones}}',                    
            'id_servicio_pago',                          
            '{{%servicios_pagos}}',                       
            'id',                               
            'CASCADE'
        );
    }

    private function eliminarLlaveForaneaComisiones(){
        $this->dropForeignKey('fk-comisiones-id_servicio_pago-servicios_pagos-id','{{%comisiones}}');
    }

    private function agregarLlaveForaneaInvitaciones(){
        //Invitaciones<<<Usuarios
        $this->addForeignKey(
            'fk-invitaciones-id_usuario-usuarios-id',
            '{{%invitaciones}}',                    
            'id_usuario',                          
            '{{%usuarios}}',                       
            'id',                               
            'CASCADE'
        );

        //Invitaciones<<<Planes
        $this->addForeignKey(
            'fk-invitaciones-id_plan-planes-id',
            '{{%invitaciones}}',                    
            'id_plan',                          
            '{{%planes}}',                       
            'id',                               
            'CASCADE'
        );
    }

    private function eliminarLlaveForaneaInvitaciones(){
        $this->dropForeignKey('fk-invitaciones-id_usuario-usuarios-id','{{%invitaciones}}');
        $this->dropForeignKey('fk-invitaciones-id_plan-planes-id','{{%invitaciones}}');
    }

    private function agregarLlaveForaneaPermisos(){
        //Permisos<<<Roles
        $this->addForeignKey(
            'fk-permisos-id_rol-roles-id',
            '{{%permisos}}',                    
            'id_rol',                          
            '{{%roles}}',                       
            'id',                               
            'CASCADE'
        );
        //Permisos<<<Acciones
        $this->addForeignKey(
            'fk-permisos-id_accion-acciones-id',
            '{{%permisos}}',                    
            'id_accion',                          
            '{{%acciones}}',                       
            'id',                               
            'CASCADE'
        );
    }

    private function eliminarLlaveForaneaPermisos(){
        $this->dropForeignKey('fk-permisos-id_rol-roles-id','{{%permisos}}');
        $this->dropForeignKey('fk-permisos-id_accion-accion-id','{{%permisos}}');
    }

    private function agregarLlaveForaneaTokens(){
        //Tokens<<<Usuarios
        $this->addForeignKey(
            'fk-tokens-id_usuario-usuarios-id',
            '{{%tokens}}',                    
            'id_usuario',                          
            '{{%usuarios}}',                       
            'id',                               
            'CASCADE'
        );
    }

    private function eliminarLlaveForaneaTokens(){
        $this->dropForeignKey('fk-tokens-id_usuario-usuarios-id','{{%tokens}}');
    }

    private function agregarLlaveForaneaNotificaciones(){
        //Notificaciones<<<Usuarios
        $this->addForeignKey(
            'fk-notificaciones-id_usuario-usuarios-id',
            '{{%notificaciones}}',                    
            'id_usuario',                          
            '{{%usuarios}}',                       
            'id',                               
            'CASCADE'
        );
    }

    private function eliminarLlaveForaneaNotificaciones(){
        $this->dropForeignKey('fk-notificaciones-id_usuario-usuarios-id','{{%notificaciones}}');
    }

    private function agregarLlaveForaneaSolicitudesDepositos(){
        //Notificaciones<<<Usuarios
        $this->addForeignKey(
            'fk-solicitudes_depositos-id_usuario-usuarios-id',
            '{{%solicitudes_depositos}}',                    
            'id_usuario',                          
            '{{%usuarios}}',                       
            'id',                               
            'CASCADE'
        );
    }

    private function eliminarLlaveForaneaSolicitudesDepositos(){
        $this->dropForeignKey('fk-solicitudes_depositos-id_usuario-usuarios-id','{{%solicitudes_depositos}}');
    }

    ##################################################################################
    ##################################################################################
    ##################################################################################
    ##################################################################################

    private function cargarCatalogosContenidoInicial(){
        //Catálogo para sexos
        $this->agregarCatalogoSexos();
        //Catálogo para bancos
        $this->agregarCatalogoBancosMexico();
        //Catálogo para paises
        $this->agregarCatalogoPaises();
        //Catálogo para estados
        $this->agregarCatalogoEstados();
        //Catálogo para ciudades
        $this->agregarCatalogoCiudades();
        //Catálogo para colonias
        $this->agregarCatalogoColonias();
        //Catálogo para usuarios iniciales
        $this->agregarCatalogoUsuarios();
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

    private function agregarCatalogoPaises(){
        $this->batchInsert('{{%paises}}',['nombre','codigo'],[
                ['México','MX'] //1
            ]);
    }

    private function agregarCatalogoEstados(){
        $this->batchInsert('{{%estados}}',['nombre','codigo','id_pais'],[
                ['Aguascalientes', '01',1], //1
                ['Baja California', '02',1], //2
                ['Baja California Sur', '03',1], //3
                ['Campeche', '04',1], //4
                ['Chiapas', '05',1], //5
                ['Chihuahua', '06',1], //6
                ['Coahuila de Zaragoza', '07',1], //7
                ['Colima', '08',1], //8
                ['Distrito Federal', '09',1], //9
                ['Durango', '10',1],
                ['Guanajuato', '11',1],
                ['Guerrero', '12',1],
                ['Hidalgo', '13',1],
                ['Jalisco', '14',1],
                ['Michoacán de Ocampo', '15',1],
                ['Morelos', '16',1],
                ['México', '17',1],
                ['Nayarit', '18',1],
                ['Nuevo León', '19',1],
                ['Oaxaca', '20',1],
                ['Puebla', '21',1],
                ['Querétaro', '22',1],
                ['Quintana Roo', '23',1],
                ['San Luis Potosí', '24',1],
                ['Sinaloa', '25',1],
                ['Sonora', '26',1],
                ['Tabasco', '27',1],
                ['Tamaulipas', '28',1],
                ['Tlaxcala', '29',1],
                ['Veracruz de Ignacio de la Llav', '30',1],
                ['Yucatán', '31',1],
                ['Zacatecas', '32',1]
            ]);
    }

    public function agregarCatalogoCiudades(){
        $this->batchInsert('{{%ciudades}}',['nombre','codigo','id_estado'],[
                //Aguascalientes
                ['Aguascalientes', '001',1],['Asientos', '002',1],['Calvillo', '003',1],['Cosío', '004',1],['Jesús María', '005',1],['Pabellón de Arteaga', '006',1],['Rincón de Romos', '007',1],['San José de Gracia', '008',1],['Tepezalá', '009',1],['El Llano', '010',1],
                ['San Francisco de los Romo', '011',1],
                //Baja California
                ['Ensenada','001',2],['Mexicali','002',2],['Tecate','003',2],['Tijuana','004',2],['Playas de Rosarito','005',2],
                //Baja California Sur
                ['Comondú', '001', 3],['Mulegé', '002', 3],['La Paz', '003', 3],['Los Cabos', '008', 3],['Loreto', '009', 3],
                //Campeche
                ['Calkiní','001', 4],['Campeche','002', 4],['Carmen','003', 4],['Champotón','004', 4],['Hecelchakán','005', 4],['Hopelchén','006', 4],['Palizada','007', 4],['Tenabo','008', 4],['Escárcega','009', 4],['Calakmul','010', 4],['Candelaria','011', 4],
                //Chiapas
                ['Acacoyagua','001', 5],['Acala','002', 5],['Acapetahua','003', 5],['Altamirano','004', 5],['Amatán','005', 5],['Amatenango de la Frontera','006', 5],['Amatenango del Valle','007', 5],['Angel Albino Corzo','008', 5],['Arriaga','009', 5],['Bejucal de Ocampo','010', 5],['Bella Vista','011', 5],['Berriozábal','012', 5],['Bochil','013', 5],['El Bosque','014', 5],['Cacahoatán','015', 5],['Catazajá','016', 5],['Cintalapa','017', 5],['Coapilla','018', 5],['Comitán de Domínguez','019', 5],['La Concordia','020', 5],['Copainalá','021', 5],['Chalchihuitán','022', 5],['Chamula','023', 5],['Chanal','024', 5],['Chapultenango','025', 5],['Chenalhó','026', 5],['Chiapa de Corzo','027', 5],['Chiapilla','028', 5],['Chicoasén','029', 5],['Chicomuselo','030', 5],['Chilón','031', 5],['Escuintla','032', 5],['Francisco León','033', 5],['Frontera Comalapa','034', 5],['Frontera Hidalgo','035', 5],['La Grandeza','036', 5],['Huehuetán','037', 5],['Huixtán','038', 5],['Huitiupán','039', 5],['Huixtla','040', 5],['La Independencia','041', 5],['Ixhuatán','042', 5],['Ixtacomitán','043', 5],['Ixtapa','044', 5],['Ixtapangajoya','045', 5],['Jiquipilas','046', 5],['Jitotol','047', 5],['Juárez','048', 5],['Larráinzar','049', 5],['La Libertad','050', 5],['Mapastepec','051', 5],['Las Margaritas','052', 5],['Mazapa de Madero','053', 5],['Mazatán','054', 5],['Metapa','055', 5],['Mitontic','056', 5],['Motozintla','057', 5],['Nicolás Ruíz','058', 5],['Ocosingo','059', 5],['Ocotepec','060', 5],['Ocozocoautla de Espinosa','061', 5],['Ostuacán','062', 5],['Osumacinta','063', 5],['Oxchuc','064', 5],['Palenque','065', 5],['Pantelhó','066', 5],['Pantepec','067', 5],['Pichucalco','068', 5],['Pijijiapan','069', 5],['El Porvenir','070', 5],['Villa Comaltitlán','071', 5],['Pueblo Nuevo Solistahuacán','072', 5],['Rayón','073', 5],['Reforma','074', 5],['Las Rosas','075', 5],['Sabanilla','076', 5],['Salto de Agua','077', 5],['San Cristóbal de las Casas','078', 5],['San Fernando','079', 5],['Siltepec','080', 5],['Simojovel','081', 5],['Sitalá','082', 5],['Socoltenango','083', 5],['Solosuchiapa','084', 5],['Soyaló','085', 5],['Suchiapa','086', 5],['Suchiate','087', 5],['Sunuapa','088', 5],['Tapachula','089', 5],['Tapalapa','090', 5],['Tapilula','091', 5],['Tecpatán','092', 5],['Tenejapa','093', 5],['Teopisca','094', 5],['Tila','096', 5],['Tonalá','097', 5],['Totolapa','098', 5],['La Trinitaria','099', 5],['Tumbalá','100', 5],['Tuxtla Gutiérrez','101', 5],['Tuxtla Chico','102', 5],['Tuzantán','103', 5],['Tzimol','104', 5],['Unión Juárez','105', 5],['Venustiano Carranza','106', 5],['Villa Corzo','107', 5],['Villaflores','108', 5],['Yajalón','109', 5],['San Lucas','110', 5],['Zinacantán','111', 5],['San Juan Cancuc','112', 5],['Aldama','113', 5],['Benemérito de las Américas','114', 5],['Maravilla Tenejapa','115', 5],['Marqués de Comillas','116', 5],['Montecristo de Guerrero','117', 5],['San Andrés Duraznal','118', 5],['Santiago el Pinar','119', 5],
            ]);
    }

    public function agregarCatalogoColonias(){
        $this->batchInsert('{{%colonias}}',['nombre','codigo_postal','id_ciudad'],[
            ['Tester',12345,1]
        ]);
    }

    private function agregarCatalogoUsuarios(){
        $this->batchInsert('{{%usuarios}}',['email','password_hash','auth_key','nombres','apellidos','id_sexo','fecha_nacimiento','contacto_telefonico','domicilio','cuenta_bancaria','id_banco','id_colonia','status','created_at','updated_at'],[
            ['admin@admin.com','$2y$13$W2eLUsjsPF87gRZkGz0voOuu4YJk9ovf3tOucHfayjhWl4apVclfS','99WNfnBPVRRJvPdXUrE6k2Za7hhD9-he','Administrador','FlowerApp',1,'1990-01-01','1234567890','Domicilio','0123456789',1,1,10,1461797582,1461797582],
            ]);
    }

    ##################################################################################
    #################################TRIGGERS#########################################
    ##################################################################################
    ##################################################################################

    private function crearTriggers(){
        $this->crearTriggerSolicitudDepostios();
    }

    private function crearTriggerSolicitudDepostios(){
        $sql = "CREATE TRIGGER tgr_solicitudes_depositos_fecha_depositado AFTER UPDATE ON {{%solicitudes_depositos}}
                FOR EACH ROW
                BEGIN

                    UPDATE {{%usuarios}} SET balance = balance + new.monto WHERE id= new.id_usuario;

                END;";
        $this->execute($sql);
    }
}
