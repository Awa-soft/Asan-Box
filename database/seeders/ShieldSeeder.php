<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_c::r::m::both","view_any_c::r::m::both","create_c::r::m::both","update_c::r::m::both","restore_c::r::m::both","restore_any_c::r::m::both","replicate_c::r::m::both","reorder_c::r::m::both","delete_c::r::m::both","delete_any_c::r::m::both","force_delete_c::r::m::both","force_delete_any_c::r::m::both","view_c::r::m::bourse","view_any_c::r::m::bourse","create_c::r::m::bourse","update_c::r::m::bourse","restore_c::r::m::bourse","restore_any_c::r::m::bourse","replicate_c::r::m::bourse","reorder_c::r::m::bourse","delete_c::r::m::bourse","delete_any_c::r::m::bourse","force_delete_c::r::m::bourse","force_delete_any_c::r::m::bourse","view_c::r::m::customer","view_any_c::r::m::customer","create_c::r::m::customer","update_c::r::m::customer","restore_c::r::m::customer","restore_any_c::r::m::customer","replicate_c::r::m::customer","reorder_c::r::m::customer","delete_c::r::m::customer","delete_any_c::r::m::customer","force_delete_c::r::m::customer","force_delete_any_c::r::m::customer","view_c::r::m::partner","view_any_c::r::m::partner","create_c::r::m::partner","update_c::r::m::partner","restore_c::r::m::partner","restore_any_c::r::m::partner","replicate_c::r::m::partner","reorder_c::r::m::partner","delete_c::r::m::partner","delete_any_c::r::m::partner","force_delete_c::r::m::partner","force_delete_any_c::r::m::partner","view_c::r::m::vendor","view_any_c::r::m::vendor","create_c::r::m::vendor","update_c::r::m::vendor","restore_c::r::m::vendor","restore_any_c::r::m::vendor","replicate_c::r::m::vendor","reorder_c::r::m::vendor","delete_c::r::m::vendor","delete_any_c::r::m::vendor","force_delete_c::r::m::vendor","force_delete_any_c::r::m::vendor","view_h::r::employee","view_any_h::r::employee","create_h::r::employee","update_h::r::employee","restore_h::r::employee","restore_any_h::r::employee","replicate_h::r::employee","reorder_h::r::employee","delete_h::r::employee","delete_any_h::r::employee","force_delete_h::r::employee","force_delete_any_h::r::employee","view_h::r::employee::activity","view_any_h::r::employee::activity","create_h::r::employee::activity","update_h::r::employee::activity","restore_h::r::employee::activity","restore_any_h::r::employee::activity","replicate_h::r::employee::activity","reorder_h::r::employee::activity","delete_h::r::employee::activity","delete_any_h::r::employee::activity","force_delete_h::r::employee::activity","force_delete_any_h::r::employee::activity","view_h::r::employee::leave","view_any_h::r::employee::leave","create_h::r::employee::leave","update_h::r::employee::leave","restore_h::r::employee::leave","restore_any_h::r::employee::leave","replicate_h::r::employee::leave","reorder_h::r::employee::leave","delete_h::r::employee::leave","delete_any_h::r::employee::leave","force_delete_h::r::employee::leave","force_delete_any_h::r::employee::leave","view_h::r::employee::note","view_any_h::r::employee::note","create_h::r::employee::note","update_h::r::employee::note","restore_h::r::employee::note","restore_any_h::r::employee::note","replicate_h::r::employee::note","reorder_h::r::employee::note","delete_h::r::employee::note","delete_any_h::r::employee::note","force_delete_h::r::employee::note","force_delete_any_h::r::employee::note","view_h::r::employee::salary","view_any_h::r::employee::salary","create_h::r::employee::salary","update_h::r::employee::salary","restore_h::r::employee::salary","restore_any_h::r::employee::salary","replicate_h::r::employee::salary","reorder_h::r::employee::salary","delete_h::r::employee::salary","delete_any_h::r::employee::salary","force_delete_h::r::employee::salary","force_delete_any_h::r::employee::salary","view_h::r::identity::type","view_any_h::r::identity::type","create_h::r::identity::type","update_h::r::identity::type","restore_h::r::identity::type","restore_any_h::r::identity::type","replicate_h::r::identity::type","reorder_h::r::identity::type","delete_h::r::identity::type","delete_any_h::r::identity::type","force_delete_h::r::identity::type","force_delete_any_h::r::identity::type","view_h::r::position","view_any_h::r::position","create_h::r::position","update_h::r::position","restore_h::r::position","restore_any_h::r::position","replicate_h::r::position","reorder_h::r::position","delete_h::r::position","delete_any_h::r::position","force_delete_h::r::position","force_delete_any_h::r::position","view_h::r::team","view_any_h::r::team","create_h::r::team","update_h::r::team","restore_h::r::team","restore_any_h::r::team","replicate_h::r::team","reorder_h::r::team","delete_h::r::team","delete_any_h::r::team","force_delete_h::r::team","force_delete_any_h::r::team","view_inventory::brand","view_any_inventory::brand","create_inventory::brand","update_inventory::brand","restore_inventory::brand","restore_any_inventory::brand","replicate_inventory::brand","reorder_inventory::brand","delete_inventory::brand","delete_any_inventory::brand","force_delete_inventory::brand","force_delete_any_inventory::brand","view_inventory::category","view_any_inventory::category","create_inventory::category","update_inventory::category","restore_inventory::category","restore_any_inventory::category","replicate_inventory::category","reorder_inventory::category","delete_inventory::category","delete_any_inventory::category","force_delete_inventory::category","force_delete_any_inventory::category","view_inventory::item","view_any_inventory::item","create_inventory::item","update_inventory::item","restore_inventory::item","restore_any_inventory::item","replicate_inventory::item","reorder_inventory::item","delete_inventory::item","delete_any_inventory::item","force_delete_inventory::item","force_delete_any_inventory::item","view_inventory::unit","view_any_inventory::unit","create_inventory::unit","update_inventory::unit","restore_inventory::unit","restore_any_inventory::unit","replicate_inventory::unit","reorder_inventory::unit","delete_inventory::unit","delete_any_inventory::unit","force_delete_inventory::unit","force_delete_any_inventory::unit","view_logistic::branch","view_any_logistic::branch","create_logistic::branch","update_logistic::branch","restore_logistic::branch","restore_any_logistic::branch","replicate_logistic::branch","reorder_logistic::branch","delete_logistic::branch","delete_any_logistic::branch","force_delete_logistic::branch","force_delete_any_logistic::branch","view_logistic::warehouse","view_any_logistic::warehouse","create_logistic::warehouse","update_logistic::warehouse","restore_logistic::warehouse","restore_any_logistic::warehouse","replicate_logistic::warehouse","reorder_logistic::warehouse","delete_logistic::warehouse","delete_any_logistic::warehouse","force_delete_logistic::warehouse","force_delete_any_logistic::warehouse","view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","view_settings::currency","view_any_settings::currency","create_settings::currency","update_settings::currency","restore_settings::currency","restore_any_settings::currency","replicate_settings::currency","reorder_settings::currency","delete_settings::currency","delete_any_settings::currency","force_delete_settings::currency","force_delete_any_settings::currency","view_user","view_any_user","create_user","update_user","restore_user","restore_any_user","replicate_user","reorder_user","delete_user","delete_any_user","force_delete_user","force_delete_any_user","page_PackagePage","page_ReportPage","page_PurchasePage","page_SafeReport","page_EmployeeActivityReport","page_EmployeeLeaveReport","page_EmployeeNoteReport","page_IdentityTypeReport","page_PositionReport","page_TeamReport"]}]';
        $directPermissions = '[]';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
