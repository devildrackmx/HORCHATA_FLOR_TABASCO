<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $role1 = Role::create(['name' => 'Administrador']);
        $role2 = Role::create(['name' => 'Auxiliar']);

        Permission::create(['name' => 'admin.index', 'descripcion' => 'Ver el Panel Administrativo'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'admin.users.index', 'descripcion' => 'Ver Listado de Usuarios'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.users.edit', 'descripcion' => 'Editar un Usuario'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.users.update', 'descripcion' => 'Actualizar un Usuario'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.users.destroy', 'descripcion' => 'Eliminar un Usuario'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.roles.index', 'descripcion' => 'Ver Listado de Roles'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.roles.create', 'descripcion' => 'Crear un nuevo Rol'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.roles.edit', 'descripcion' => 'Editar un Rol'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.roles.destroy', 'descripcion' => 'Eliminar un Rol'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.horchatas.index', 'descripcion' => 'Ver Listado de Presentaciones de Horchatas'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.horchatas.create', 'descripcion' => 'Crear una Presentacion de Horchata'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.horchatas.edit', 'descripcion' => 'Editar una Presentacion de Horchata'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.horchatas.destroy', 'descripcion' => 'Eliminar una presentacion de Horchata'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.proveedores.index', 'descripcion' => 'Ver lista de Proveedores'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.proveedores.create', 'descripcion' => 'Crear un nuevo Proveedor'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.proveedores.edit', 'descripcion' => 'Editar un Proveedor'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.proveedores.destroy', 'descripcion' => 'Eliminar un Proveedor'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.insumos.index', 'descripcion' => 'Ver lista de Insumos'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.insumos.create', 'descripcion' => 'Crear un nuevo Insumo'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.insumos.edit', 'descripcion' => 'Editar un Insumo'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.insumos.destroy', 'descripcion' => 'Eliminar un insumo'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.compras.index', 'descripcion' => 'Ver lista de Compras'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.compras.create', 'descripcion' => 'Crear una nueva Compra'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.compras.edit', 'descripcion' => 'Editar una compra'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.compras.destroy', 'descripcion' => 'Eliminar una compra'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.devoluciones.index', 'descripcion' => 'Ver lista de Devoluciones'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.devoluciones.create', 'descripcion' => 'Crear una nueva Devolucion'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.devoluciones.edit', 'descripcion' => 'Editar una Devolucion'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.devoluciones.destroy', 'descripcion' => 'Eliminar una Devolucion'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.revolturas.index', 'descripcion' => 'Ver lista de Revolturas'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.revolturas.create', 'descripcion' => 'Crear una nueva Revoltura'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.revolturas.edit', 'descripcion' => 'Editar una Revoltura'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.revolturas.destroy', 'descripcion' => 'Eliminar una Revoltura'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.embasados.index', 'descripcion' => 'Ver lista de Embasados'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.embasados.create', 'descripcion' => 'Crear un nuevo Embasado'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.embasados.edit', 'descripcion' => 'Editar un Embasado'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.embasados.destroy', 'descripcion' => 'Eliminar un Embasado'])->syncRoles([$role1]);
    }
}
