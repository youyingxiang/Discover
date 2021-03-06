<?php

/*
 * // +----------------------------------------------------------------------
 * // | erp
 * // +----------------------------------------------------------------------
 * // | Copyright (c) 2006~2020 erp All rights reserved.
 * // +----------------------------------------------------------------------
 * // | Licensed ( LICENSE-1.0.0 )
 * // +----------------------------------------------------------------------
 * // | Author: yxx <1365831278@qq.com>
 * // +----------------------------------------------------------------------
 */

use Illuminate\Database\Seeder;
use Dcat\Admin\Models\Menu;
use Dcat\Admin\Models\Role;
use Dcat\Admin\Models\Permission;
use Dcat\Admin\Models\Administrator;
use Illuminate\Support\Facades\DB;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createdAt = date('Y-m-d H:i:s');

        // create a user.

        Role::truncate();
        Menu::truncate();
        Permission::truncate();
        Administrator::truncate();
        DB::table('admin_roles')->truncate();
        DB::table('admin_users')->truncate();
        DB::table('admin_permissions')->truncate();
        DB::table('admin_role_users')->truncate();
        DB::table('admin_role_permissions')->truncate();
        DB::table('admin_permission_menu')->truncate();
        DB::table('admin_role_menu')->truncate();

        Administrator::create([
            'username'   => 'admin',
            'password'   => bcrypt('admin'),
            'name'       => 'Administrator',
            'created_at' => $createdAt,
        ]);

        // create a role.

        Role::create([
            'name'       => 'Administrator',
            'slug'       => Role::ADMINISTRATOR,
            'created_at' => $createdAt,
        ]);

        // add role to user.
        Administrator::first()->roles()->save(Role::first());

        //create a permission

        Permission::insert([
            [
                'id'          => 1,
                'name'        => '????????????',
                'slug'        => 'auth-management',
                'http_method' => '',
                'http_path'   => '',
                'parent_id'   => 0,
                'order'       => 1,
                'created_at'  => $createdAt,
            ],
            [
                'id'          => 2,
                'name'        => '?????????',
                'slug'        => 'users',
                'http_method' => '',
                'http_path'   => '/auth/users*',
                'parent_id'   => 1,
                'order'       => 2,
                'created_at'  => $createdAt,
            ],
            [
                'id'          => 3,
                'name'        => '??????',
                'slug'        => 'roles',
                'http_method' => '',
                'http_path'   => '/auth/roles*',
                'parent_id'   => 1,
                'order'       => 3,
                'created_at'  => $createdAt,
            ],
            [
                'id'          => 4,
                'name'        => '??????',
                'slug'        => 'permissions',
                'http_method' => '',
                'http_path'   => '/auth/permissions*',
                'parent_id'   => 1,
                'order'       => 4,
                'created_at'  => $createdAt,
            ],
            [
                'id'          => 5,
                'name'        => '??????',
                'slug'        => 'menu',
                'http_method' => '',
                'http_path'   => '/auth/menu*',
                'parent_id'   => 1,
                'order'       => 5,
                'created_at'  => $createdAt,
            ],
            [
                'id'          => 6,
                'name'        => '??????',
                'slug'        => 'operation-log',
                'http_method' => '',
                'http_path'   => '/auth/logs*',
                'parent_id'   => 1,
                'order'       => 6,
                'created_at'  => $createdAt,
            ],
        ]);

//        Role::first()->permissions()->save(Permission::first());

        // add default menus.

        Menu::insert([
            [
                'parent_id'     => 0,
                'order'         => 1,
                'title'         => '??????',
                'icon'          => 'feather icon-bar-chart-2',
                'uri'           => '/',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 0,
                'order'         => 2,
                'title'         => '????????????',
                'icon'          => 'feather icon-settings',
                'uri'           => '',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 2,
                'order'         => 3,
                'title'         => '?????????',
                'icon'          => '',
                'uri'           => 'auth/users',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 2,
                'order'         => 4,
                'title'         => '??????',
                'icon'          => '',
                'uri'           => 'auth/roles',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 2,
                'order'         => 5,
                'title'         => '??????',
                'icon'          => '',
                'uri'           => 'auth/permissions',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 2,
                'order'         => 6,
                'title'         => '??????',
                'icon'          => '',
                'uri'           => 'auth/menu',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 2,
                'order'         => 7,
                'title'         => '??????',
                'icon'          => '',
                'uri'           => 'auth/logs',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 0,
                'order'         => 8,
                'title'         => '????????????',
                'icon'          => 'fa-product-hunt',
                'uri'           => '',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 8,
                'order'         => 9,
                'title'         => '????????????',
                'icon'          => '',
                'uri'           => 'products',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 8,
                'order'         => 10,
                'title'         => '????????????',
                'icon'          => '',
                'uri'           => 'units',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 8,
                'order'         => 11,
                'title'         => '????????????',
                'icon'          => '',
                'uri'           => 'attrs',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 0,
                'order'         => 12,
                'title'         => '????????????',
                'icon'          => 'fa-cart-plus',
                'uri'           => '',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 12,
                'order'         => 13,
                'title'         => '???????????????',
                'icon'          => '',
                'uri'           => 'suppliers',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 12,
                'order'         => 14,
                'title'         => '???????????????',
                'icon'          => '',
                'uri'           => 'purchase-orders',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 12,
                'order'         => 15,
                'title'         => '???????????????',
                'icon'          => '',
                'uri'           => 'purchase-in-orders',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 0,
                'order'         => 16,
                'title'         => '????????????',
                'icon'          => 'fa-ambulance',
                'uri'           => '',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 16,
                'order'         => 17,
                'title'         => '????????????',
                'icon'          => '',
                'uri'           => 'sku-stocks',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 16,
                'order'         => 18,
                'title'         => '????????????',
                'icon'          => '',
                'uri'           => 'sku-stock-batchs',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 16,
                'order'         => 19,
                'title'         => '????????????',
                'icon'          => '',
                'uri'           => 'positions',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 16,
                'order'         => 20,
                'title'         => '????????????',
                'icon'          => '',
                'uri'           => 'stock-historys',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 16,
                'order'         => 21,
                'title'         => '????????????',
                'icon'          => '',
                'uri'           => 'init-stock-orders',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 0,
                'order'         => 22,
                'title'         => '????????????',
                'icon'          => 'fa-calendar-minus-o',
                'uri'           => '',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 22,
                'order'         => 23,
                'title'         => '????????????',
                'icon'          => '',
                'uri'           => 'customers',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 22,
                'order'         => 24,
                'title'         => '???????????????',
                'icon'          => '',
                'uri'           => 'drawees',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 22,
                'order'         => 25,
                'title'         => '???????????????',
                'icon'          => '',
                'uri'           => 'sale-orders',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 22,
                'order'         => 26,
                'title'         => '???????????????',
                'icon'          => '',
                'uri'           => 'sale-out-orders',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 22,
                'order'         => 27,
                'title'         => '???????????????',
                'icon'          => '',
                'uri'           => 'sale-in-orders',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 0,
                'order'         => 28,
                'title'         => '????????????',
                'icon'          => 'fa-wrench',
                'uri'           => '',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 28,
                'order'         => 29,
                'title'         => '????????????',
                'icon'          => '',
                'uri'           => 'tasks',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 28,
                'order'         => 30,
                'title'         => '????????????',
                'icon'          => '',
                'uri'           => 'crafts',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 28,
                'order'         => 31,
                'title'         => '????????????',
                'icon'          => '',
                'uri'           => 'apply-for-orders',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 28,
                'order'         => 32,
                'title'         => '????????????',
                'icon'          => '',
                'uri'           => 'make-product-orders',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 0,
                'order'         => 33,
                'title'         => '????????????',
                'icon'          => 'fa-database',
                'uri'           => '',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 33,
                'order'         => 34,
                'title'         => '????????????',
                'icon'          => '',
                'uri'           => 'inventorys',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 33,
                'order'         => 35,
                'title'         => '????????????',
                'icon'          => '',
                'uri'           => 'inventory-orders',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 0,
                'order'         => 36,
                'title'         => '????????????',
                'icon'          => 'fa-money',
                'uri'           => '',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 36,
                'order'         => 37,
                'title'         => '?????????',
                'icon'          => '',
                'uri'           => 'accountant-dates',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 36,
                'order'         => 38,
                'title'         => '??????',
                'icon'          => '',
                'uri'           => 'month-settlements/create',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 36,
                'order'         => 39,
                'title'         => '?????????',
                'icon'          => '',
                'uri'           => 'cost-orders',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 36,
                'order'         => 40,
                'title'         => '?????????',
                'icon'          => '',
                'uri'           => 'statement-orders',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 0,
                'order'         => 41,
                'title'         => '????????????',
                'icon'          => 'fa-calendar',
                'uri'           => 'report-centers',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 0,
                'order'         => 9999,
                'title'         => '????????????',
                'icon'          => 'fa-comment-o',
                'uri'           => 'demands',
                'created_at'    => $createdAt,
            ],
        ]);

        (new Menu())->flushCache();
    }
}
