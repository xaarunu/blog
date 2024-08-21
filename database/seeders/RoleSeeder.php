<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Limpiar tablas roles, perissions y role_has_permission
        Schema::disableForeignKeyConstraints();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        DB::table('role_has_permissions')->truncate();
        Schema::enableForeignKeyConstraints();

        $roleAdmin = Role::create(['name' => 'admin']);
        $roleUser = Role::create(['name' => 'usuario']);

        $roleJSub = Role::create(['name' => 'JefeSubarea']);
        $roleJArea = Role::create(['name' => 'JefeArea']);
        $roleJDivision = Role::create(['name' => 'JefeDivision']);
        $roleRH = Role::create(['name' => 'RecursosHumanos']);
        $roleRHDivision = Role::create(['name' => 'JefeRecursosHumanos']);
        $roleDoctora = Role::create(['name' => 'Doctora']);

        Permission::create(['name' => 'controlDivisional', 'description' => 'Acceso a todas las zonas/áreas de una división'])->syncRoles([$roleAdmin, $roleJDivision, $roleRHDivision, $roleDoctora]);

        Permission::create(['guard_name' => 'web','name' => 'roles.create', 'description' => 'Crear roles'])->syncRoles([$roleAdmin]);
        Permission::create(['guard_name' => 'web','name' => 'roles.store', 'description' => 'Guardar roles'])->syncRoles([$roleAdmin]);
        Permission::create(['guard_name' => 'web','name' => 'roles.index', 'description' => 'Ver roles'])->syncRoles([$roleAdmin]);
        Permission::create(['guard_name' => 'web','name' => 'roles.edit', 'description' => 'Editar roles'])->syncRoles([$roleAdmin]);
        Permission::create(['guard_name' => 'web','name' => 'roles.destroy', 'description' => 'Eliminar roles'])->syncRoles([$roleAdmin]);

        Permission::create(['name' => 'soportes.store', 'description' => 'Guardar soportes'])->assignRole([$roleAdmin, $roleUser, $roleJSub, $roleJArea, $roleJDivision, $roleRH, $roleRHDivision]);
        Permission::create(['name' => 'soportes.create', 'description' => 'Crear soportes'])->assignRole([$roleAdmin, $roleUser, $roleJSub, $roleJArea, $roleJDivision, $roleRH, $roleRHDivision]);

        Permission::create(['name' => 'users.datosPersonales'])->syncRoles([$roleAdmin, $roleUser, $roleJSub, $roleJArea, $roleJDivision, $roleRH, $roleRHDivision, $roleDoctora]);

        Permission::create(['name' => 'users.index', 'description' => 'Ver Usuarios'])->syncRoles([$roleAdmin, $roleJArea, $roleJDivision, $roleRH, $roleRHDivision, $roleDoctora]);
        Permission::create(['name' => 'users.create', 'description' => 'Crear Usuarios'])->syncRoles([$roleAdmin, $roleRH, $roleRHDivision]);
        Permission::create(['name' => 'users.autorizar', 'description' => 'Autorizar nuevos/cambios usuarios'])->syncRoles([$roleAdmin, $roleRHDivision]);
        Permission::create(['name' => 'users.edit', 'description' => 'Editar Usuarios'])->syncRoles([$roleAdmin, $roleRH, $roleRHDivision]);
        Permission::create(['name' => 'users.destroy', 'description' => 'Eliminar Usuarios'])->syncRoles([$roleAdmin, $roleRHDivision]);
        Permission::create(['name' => 'users.usuariosBaja'])->syncRoles([$roleAdmin, $roleRHDivision, $roleJSub]);

        Permission::create(['name' => 'reportes', 'description' => 'Reportes'])->syncRoles([$roleAdmin, $roleJSub, $roleJArea, $roleJDivision, $roleRH, $roleRHDivision]);
        Permission::create(['name' => 'calendar', 'description' => 'Calendarios'])->syncRoles([$roleAdmin, $roleJSub, $roleJArea, $roleJDivision, $roleRH, $roleRHDivision]);

        Permission::create(['name' => 'salud.index', 'description' => 'Ver salud'])->syncRoles([$roleAdmin]);
        Permission::create(['name' => 'expedientes.stats', 'description' => 'Estadística de expedientes general'])->syncRoles([$roleAdmin, $roleDoctora, $roleRH, $roleRHDivision]);

        Permission::create(['name' => 'antecedente.index', 'description' => 'Visualizar antecedentes'])->syncRoles([$roleAdmin, $roleDoctora]);
        Permission::create(['name' => 'antecedente.create', 'description' => 'Crear antecedentes'])->syncRoles([$roleAdmin, $roleDoctora]);
        Permission::create(['name' => 'antecedente.edit', 'description' => 'Editar registros de antecedentes'])->syncRoles([$roleAdmin, $roleDoctora]);
        Permission::create(['name' => 'antecedente.delete', 'description' => 'Eliminar registros de antecedentes'])->syncRoles([$roleAdmin, $roleDoctora]);
        Permission::create(['name' => 'antecedente.stats', 'description' => 'Visualizar Estadística de Antecedentes'])->syncRoles([$roleAdmin, $roleDoctora, $roleRH, $roleRHDivision]);

        Permission::create(['name' => 'notaMedica.index', 'description' => 'Visualizar notas médicas'])->syncRoles([$roleAdmin, $roleDoctora]);
        Permission::create(['name' => 'notaMedica.create', 'description' => 'Crear notas médicas'])->syncRoles([$roleAdmin, $roleDoctora]);
        Permission::create(['name' => 'notaMedica.edit', 'description' => 'Editar registros de notas médicas'])->syncRoles([$roleAdmin, $roleDoctora]);
        Permission::create(['name' => 'notaMedica.delete', 'description' => 'Eliminar registros de notas médicas'])->syncRoles([$roleAdmin, $roleDoctora]);
        Permission::create(['name' => 'notaMedica.stats', 'description' => 'Visualizar Estadística de Nota Médica'])->syncRoles([$roleAdmin, $roleDoctora, $roleRH, $roleRHDivision]);

        Permission::create(['name' => 'incapacidad.index', 'description' => 'Visualizar incapacidades'])->syncRoles([$roleAdmin, $roleDoctora, $roleRH, $roleRHDivision]);
        Permission::create(['name' => 'incapacidad.create', 'description' => 'Crear incapacidades'])->syncRoles([$roleAdmin, $roleDoctora, $roleRH, $roleRHDivision]);
        Permission::create(['name' => 'incapacidad.edit', 'description' => 'Editar registros de incapacidades'])->syncRoles([$roleAdmin, $roleDoctora, $roleRH, $roleRHDivision]);
        Permission::create(['name' => 'incapacidad.delete', 'description' => 'Eliminar registros de incapacidades'])->syncRoles([$roleAdmin, $roleDoctora]);
        Permission::create(['name' => 'incapacidad.autorizar', 'description' => 'Cambiar el estatus de la incapacidad'])->syncRoles([$roleAdmin, $roleDoctora]);
        Permission::create(['name' => 'incapacidad.stats', 'description' => 'Visualizar Estadística de Incapacidad'])->syncRoles([$roleAdmin, $roleDoctora, $roleRH, $roleRHDivision]);

        Permission::create(['name' => 'audiometria.index', 'description' => 'Visualizar audiometrías'])->syncRoles([$roleAdmin, $roleDoctora]);
        Permission::create(['name' => 'audiometria.create', 'description' => 'Crear audiometrías'])->syncRoles([$roleAdmin, $roleDoctora]);
        Permission::create(['name' => 'audiometria.edit', 'description' => 'Editar registros de audiometrías'])->syncRoles([$roleAdmin, $roleDoctora]);
        Permission::create(['name' => 'audiometria.delete', 'description' => 'Eliminar registros de audiometrías'])->syncRoles([$roleAdmin, $roleDoctora]);
        Permission::create(['name' => 'audiometria.stats', 'description' => 'Visualizar Estadística de Audiometrías'])->syncRoles([$roleAdmin, $roleDoctora]);

        Permission::create(['name' => 'prosalud.index', 'description' => 'Visualizar ProSalud'])->syncRoles([$roleAdmin, $roleDoctora]);
        Permission::create(['name' => 'prosalud.create', 'description' => 'Crear ProSalud'])->syncRoles([$roleAdmin, $roleDoctora]);
        Permission::create(['name' => 'prosalud.edit', 'description' => 'Editar registros de ProSalud'])->syncRoles([$roleAdmin, $roleDoctora]);
        Permission::create(['name' => 'prosalud.delete', 'description' => 'Eliminar registros de ProSalud'])->syncRoles([$roleAdmin, $roleDoctora]);
        Permission::create(['name' => 'prosalud.stats', 'description' => 'Visualizar Estadística de ProSalud'])->syncRoles([$roleAdmin, $roleDoctora, $roleRH, $roleRHDivision]);

        Permission::create(['name' => 'antidoping.index', 'description' => 'Visualizar antidoping'])->syncRoles([$roleAdmin, $roleDoctora]);
        Permission::create(['name' => 'antidoping.create', 'description' => 'Crear antidoping'])->syncRoles([$roleAdmin, $roleDoctora]);
        Permission::create(['name' => 'antidoping.edit', 'description' => 'Editar registros de antidoping'])->syncRoles([$roleAdmin, $roleDoctora]);
        Permission::create(['name' => 'antidoping.delete', 'description' => 'Eliminar registros de antidoping'])->syncRoles([$roleAdmin, $roleDoctora]);
        Permission::create(['name' => 'antidoping.stats', 'description' => 'Visualizar Estadística de antidoping'])->syncRoles([$roleAdmin, $roleDoctora, $roleRH, $roleRHDivision]);

        Permission::create(['name' => 'recepcion.index', 'description' => 'Visualizar entregas de recepción'])->syncRoles([$roleAdmin, $roleRHDivision, $roleRH]);
        Permission::create(['name' => 'recepcion.create', 'description' => 'Crear entregas de recepción'])->syncRoles([$roleAdmin, $roleRHDivision, $roleRH]);
        Permission::create(['name' => 'recepcion.edit', 'description' => 'Editar entregas de recepción'])->syncRoles([$roleAdmin, $roleRHDivision, $roleRH]);
        Permission::create(['name' => 'recepcion.delete', 'description' => 'Eliminar entregas de recepción'])->syncRoles([$roleAdmin, $roleRHDivision, $roleRH]);

        Permission::create(['name' => 'prestacion.index', 'description' => 'Visualizar prestaciones de usuarios.'])->syncRoles([$roleAdmin, $roleRHDivision, $roleRH]);
        Permission::create(['name' => 'prestacion.create', 'description' => 'Crear prestaciones para usuarios.'])->syncRoles([$roleAdmin, $roleRHDivision, $roleRH]);
        Permission::create(['name' => 'prestacion.edit', 'description' => 'Editar prestaciones de usuarios.'])->syncRoles([$roleAdmin, $roleRHDivision, $roleRH]);
        Permission::create(['name' => 'prestacion.delete', 'description' => 'Eliminar prestaciones de usuarios.'])->syncRoles([$roleAdmin, $roleRHDivision, $roleRH]);
    }
}
