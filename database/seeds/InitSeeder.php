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
                'name'        => '权限管理',
                'slug'        => 'auth-management',
                'http_method' => '',
                'http_path'   => '',
                'parent_id'   => 0,
                'order'       => 1,
                'created_at'  => $createdAt,
            ],
            [
                'id'          => 2,
                'name'        => '管理员',
                'slug'        => 'users',
                'http_method' => '',
                'http_path'   => '/auth/users*',
                'parent_id'   => 1,
                'order'       => 2,
                'created_at'  => $createdAt,
            ],
            [
                'id'          => 3,
                'name'        => '角色',
                'slug'        => 'roles',
                'http_method' => '',
                'http_path'   => '/auth/roles*',
                'parent_id'   => 1,
                'order'       => 3,
                'created_at'  => $createdAt,
            ],
            [
                'id'          => 4,
                'name'        => '权限',
                'slug'        => 'permissions',
                'http_method' => '',
                'http_path'   => '/auth/permissions*',
                'parent_id'   => 1,
                'order'       => 4,
                'created_at'  => $createdAt,
            ],
            [
                'id'          => 5,
                'name'        => '菜单',
                'slug'        => 'menu',
                'http_method' => '',
                'http_path'   => '/auth/menu*',
                'parent_id'   => 1,
                'order'       => 5,
                'created_at'  => $createdAt,
            ],
            [
                'id'          => 6,
                'name'        => '日志',
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
                'title'         => '首页',
                'icon'          => 'feather icon-bar-chart-2',
                'uri'           => '/',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 0,
                'order'         => 2,
                'title'         => '权限管理',
                'icon'          => 'feather icon-settings',
                'uri'           => '',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 2,
                'order'         => 3,
                'title'         => '管理员',
                'icon'          => '',
                'uri'           => 'auth/users',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 2,
                'order'         => 4,
                'title'         => '角色',
                'icon'          => '',
                'uri'           => 'auth/roles',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 2,
                'order'         => 5,
                'title'         => '权限',
                'icon'          => '',
                'uri'           => 'auth/permissions',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 2,
                'order'         => 6,
                'title'         => '菜单',
                'icon'          => '',
                'uri'           => 'auth/menu',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 2,
                'order'         => 7,
                'title'         => '日志',
                'icon'          => '',
                'uri'           => 'auth/logs',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 0,
                'order'         => 8,
                'title'         => '产品管理',
                'icon'          => 'fa-product-hunt',
                'uri'           => '',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 8,
                'order'         => 9,
                'title'         => '产品档案',
                'icon'          => '',
                'uri'           => 'products',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 8,
                'order'         => 10,
                'title'         => '产品单位',
                'icon'          => '',
                'uri'           => 'units',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 8,
                'order'         => 11,
                'title'         => '产品属性',
                'icon'          => '',
                'uri'           => 'attrs',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 0,
                'order'         => 12,
                'title'         => '采购管理',
                'icon'          => 'fa-cart-plus',
                'uri'           => '',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 12,
                'order'         => 13,
                'title'         => '供应商档案',
                'icon'          => '',
                'uri'           => 'suppliers',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 12,
                'order'         => 14,
                'title'         => '采购订购单',
                'icon'          => '',
                'uri'           => 'purchase-orders',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 12,
                'order'         => 15,
                'title'         => '采购入库单',
                'icon'          => '',
                'uri'           => 'purchase-in-orders',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 0,
                'order'         => 16,
                'title'         => '库存管理',
                'icon'          => 'fa-ambulance',
                'uri'           => '',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 16,
                'order'         => 17,
                'title'         => '产品库存',
                'icon'          => '',
                'uri'           => 'sku-stocks',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 16,
                'order'         => 18,
                'title'         => '批次库存',
                'icon'          => '',
                'uri'           => 'sku-stock-batchs',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 16,
                'order'         => 19,
                'title'         => '仓库库位',
                'icon'          => '',
                'uri'           => 'positions',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 16,
                'order'         => 20,
                'title'         => '库存往来',
                'icon'          => '',
                'uri'           => 'stock-historys',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 16,
                'order'         => 21,
                'title'         => '期初建账',
                'icon'          => '',
                'uri'           => 'init-stock-orders',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 0,
                'order'         => 22,
                'title'         => '销售管理',
                'icon'          => 'fa-calendar-minus-o',
                'uri'           => '',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 22,
                'order'         => 23,
                'title'         => '客户档案',
                'icon'          => '',
                'uri'           => 'customers',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 22,
                'order'         => 24,
                'title'         => '付款人信息',
                'icon'          => '',
                'uri'           => 'drawees',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 22,
                'order'         => 25,
                'title'         => '客户要货单',
                'icon'          => '',
                'uri'           => 'sale-orders',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 22,
                'order'         => 26,
                'title'         => '客户出货单',
                'icon'          => '',
                'uri'           => 'sale-out-orders',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 22,
                'order'         => 27,
                'title'         => '客户退货单',
                'icon'          => '',
                'uri'           => 'sale-in-orders',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 0,
                'order'         => 28,
                'title'         => '生产加工',
                'icon'          => 'fa-wrench',
                'uri'           => '',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 28,
                'order'         => 29,
                'title'         => '生产任务',
                'icon'          => '',
                'uri'           => 'tasks',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 28,
                'order'         => 30,
                'title'         => '生产工艺',
                'icon'          => '',
                'uri'           => 'crafts',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 28,
                'order'         => 31,
                'title'         => '物料申领',
                'icon'          => '',
                'uri'           => 'apply-for-orders',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 28,
                'order'         => 32,
                'title'         => '生产入库',
                'icon'          => '',
                'uri'           => 'make-product-orders',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 0,
                'order'         => 33,
                'title'         => '盘点管理',
                'icon'          => 'fa-database',
                'uri'           => '',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 33,
                'order'         => 34,
                'title'         => '盘点任务',
                'icon'          => '',
                'uri'           => 'inventorys',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 33,
                'order'         => 35,
                'title'         => '盘点单据',
                'icon'          => '',
                'uri'           => 'inventory-orders',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 0,
                'order'         => 36,
                'title'         => '财务管理',
                'icon'          => 'fa-money',
                'uri'           => '',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 36,
                'order'         => 37,
                'title'         => '会计期',
                'icon'          => '',
                'uri'           => 'accountant-dates',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 36,
                'order'         => 38,
                'title'         => '月结',
                'icon'          => '',
                'uri'           => 'month-settlements/create',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 36,
                'order'         => 39,
                'title'         => '费用单',
                'icon'          => '',
                'uri'           => 'cost-orders',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 36,
                'order'         => 40,
                'title'         => '结算单',
                'icon'          => '',
                'uri'           => 'statement-orders',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 0,
                'order'         => 41,
                'title'         => '报表中心',
                'icon'          => 'fa-calendar',
                'uri'           => 'report-centers',
                'created_at'    => $createdAt,
            ],
            [
                'parent_id'     => 0,
                'order'         => 9999,
                'title'         => '需求反馈',
                'icon'          => 'fa-comment-o',
                'uri'           => 'demands',
                'created_at'    => $createdAt,
            ],
        ]);

        (new Menu())->flushCache();
    }
}
