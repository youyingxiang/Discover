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

namespace Dcat\Admin {
    use Illuminate\Support\Collection;

    /**
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection alias
     * @property Grid\Column|Collection authors
     * @property Grid\Column|Collection enable
     * @property Grid\Column|Collection imported
     * @property Grid\Column|Collection config
     * @property Grid\Column|Collection require
     * @property Grid\Column|Collection require_dev
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection day
     * @property Grid\Column|Collection day_type
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection year
     * @property Grid\Column|Collection accountant_date_id
     * @property Grid\Column|Collection end_at
     * @property Grid\Column|Collection month
     * @property Grid\Column|Collection start_at
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection input
     * @property Grid\Column|Collection ip
     * @property Grid\Column|Collection method
     * @property Grid\Column|Collection path
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection actual_num
     * @property Grid\Column|Collection item_id
     * @property Grid\Column|Collection percent
     * @property Grid\Column|Collection standard
     * @property Grid\Column|Collection stock_batch_id
     * @property Grid\Column|Collection cost_price
     * @property Grid\Column|Collection order_id
     * @property Grid\Column|Collection should_num
     * @property Grid\Column|Collection sku_id
     * @property Grid\Column|Collection apply_id
     * @property Grid\Column|Collection deleted_at
     * @property Grid\Column|Collection order_no
     * @property Grid\Column|Collection other
     * @property Grid\Column|Collection review_status
     * @property Grid\Column|Collection with_id
     * @property Grid\Column|Collection attr_id
     * @property Grid\Column|Collection blackhead
     * @property Grid\Column|Collection bulkiness
     * @property Grid\Column|Collection carbon_fiber
     * @property Grid\Column|Collection cleanliness
     * @property Grid\Column|Collection duck_ratio
     * @property Grid\Column|Collection feather_silk
     * @property Grid\Column|Collection flower_number
     * @property Grid\Column|Collection fluffy_silk
     * @property Grid\Column|Collection heterochromatic_hair
     * @property Grid\Column|Collection magazine
     * @property Grid\Column|Collection moisture
     * @property Grid\Column|Collection odor
     * @property Grid\Column|Collection prev_sku_stock_batch_id
     * @property Grid\Column|Collection raw_footage
     * @property Grid\Column|Collection sku_stock_batch_id
     * @property Grid\Column|Collection terrestrial_feather
     * @property Grid\Column|Collection velvet
     * @property Grid\Column|Collection actual_amount
     * @property Grid\Column|Collection cost_type
     * @property Grid\Column|Collection pay_type
     * @property Grid\Column|Collection should_amount
     * @property Grid\Column|Collection with_order_no
     * @property Grid\Column|Collection accountant_item_id
     * @property Grid\Column|Collection category
     * @property Grid\Column|Collection company_id
     * @property Grid\Column|Collection company_name
     * @property Grid\Column|Collection total_amount
     * @property Grid\Column|Collection link
     * @property Grid\Column|Collection pay_method
     * @property Grid\Column|Collection phone
     * @property Grid\Column|Collection address
     * @property Grid\Column|Collection customer_id
     * @property Grid\Column|Collection drawee_id
     * @property Grid\Column|Collection content
     * @property Grid\Column|Collection reply
     * @property Grid\Column|Collection status
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection batch_no
     * @property Grid\Column|Collection position_id
     * @property Grid\Column|Collection diff_num
     * @property Grid\Column|Collection happen_date
     * @property Grid\Column|Collection prefix
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection item_no
     * @property Grid\Column|Collection py_code
     * @property Grid\Column|Collection unit_id
     * @property Grid\Column|Collection attr_value_ids
     * @property Grid\Column|Collection product_id
     * @property Grid\Column|Collection check_order_id
     * @property Grid\Column|Collection purchase_order_id
     * @property Grid\Column|Collection price
     * @property Grid\Column|Collection apply_at
     * @property Grid\Column|Collection finished_at
     * @property Grid\Column|Collection supplier_id
     * @property Grid\Column|Collection check_status
     * @property Grid\Column|Collection accountant_id
     * @property Grid\Column|Collection settlement_at
     * @property Grid\Column|Collection return_num
     * @property Grid\Column|Collection address_id
     * @property Grid\Column|Collection num
     * @property Grid\Column|Collection discount_amount
     * @property Grid\Column|Collection order_amount
     * @property Grid\Column|Collection statement_order_id
     * @property Grid\Column|Collection balance_num
     * @property Grid\Column|Collection flag
     * @property Grid\Column|Collection in_num
     * @property Grid\Column|Collection in_position_id
     * @property Grid\Column|Collection in_price
     * @property Grid\Column|Collection init_num
     * @property Grid\Column|Collection inventory_diff_num
     * @property Grid\Column|Collection inventory_num
     * @property Grid\Column|Collection out_num
     * @property Grid\Column|Collection out_position_id
     * @property Grid\Column|Collection out_price
     * @property Grid\Column|Collection settlement_status
     * @property Grid\Column|Collection craft_id
     * @property Grid\Column|Collection finish_num
     * @property Grid\Column|Collection operator
     * @property Grid\Column|Collection plan_num
     * @property Grid\Column|Collection batch_id
     * @property Grid\Column|Collection family_hash
     * @property Grid\Column|Collection sequence
     * @property Grid\Column|Collection should_display_on_index
     * @property Grid\Column|Collection uuid
     * @property Grid\Column|Collection entry_uuid
     * @property Grid\Column|Collection tag
     * @property Grid\Column|Collection email_verified_at
     *
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection alias(string $label = null)
     * @method Grid\Column|Collection authors(string $label = null)
     * @method Grid\Column|Collection enable(string $label = null)
     * @method Grid\Column|Collection imported(string $label = null)
     * @method Grid\Column|Collection config(string $label = null)
     * @method Grid\Column|Collection require(string $label = null)
     * @method Grid\Column|Collection require_dev(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection day(string $label = null)
     * @method Grid\Column|Collection day_type(string $label = null)
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection year(string $label = null)
     * @method Grid\Column|Collection accountant_date_id(string $label = null)
     * @method Grid\Column|Collection end_at(string $label = null)
     * @method Grid\Column|Collection month(string $label = null)
     * @method Grid\Column|Collection start_at(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection input(string $label = null)
     * @method Grid\Column|Collection ip(string $label = null)
     * @method Grid\Column|Collection method(string $label = null)
     * @method Grid\Column|Collection path(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection actual_num(string $label = null)
     * @method Grid\Column|Collection item_id(string $label = null)
     * @method Grid\Column|Collection percent(string $label = null)
     * @method Grid\Column|Collection standard(string $label = null)
     * @method Grid\Column|Collection stock_batch_id(string $label = null)
     * @method Grid\Column|Collection cost_price(string $label = null)
     * @method Grid\Column|Collection order_id(string $label = null)
     * @method Grid\Column|Collection should_num(string $label = null)
     * @method Grid\Column|Collection sku_id(string $label = null)
     * @method Grid\Column|Collection apply_id(string $label = null)
     * @method Grid\Column|Collection deleted_at(string $label = null)
     * @method Grid\Column|Collection order_no(string $label = null)
     * @method Grid\Column|Collection other(string $label = null)
     * @method Grid\Column|Collection review_status(string $label = null)
     * @method Grid\Column|Collection with_id(string $label = null)
     * @method Grid\Column|Collection attr_id(string $label = null)
     * @method Grid\Column|Collection blackhead(string $label = null)
     * @method Grid\Column|Collection bulkiness(string $label = null)
     * @method Grid\Column|Collection carbon_fiber(string $label = null)
     * @method Grid\Column|Collection cleanliness(string $label = null)
     * @method Grid\Column|Collection duck_ratio(string $label = null)
     * @method Grid\Column|Collection feather_silk(string $label = null)
     * @method Grid\Column|Collection flower_number(string $label = null)
     * @method Grid\Column|Collection fluffy_silk(string $label = null)
     * @method Grid\Column|Collection heterochromatic_hair(string $label = null)
     * @method Grid\Column|Collection magazine(string $label = null)
     * @method Grid\Column|Collection moisture(string $label = null)
     * @method Grid\Column|Collection odor(string $label = null)
     * @method Grid\Column|Collection prev_sku_stock_batch_id(string $label = null)
     * @method Grid\Column|Collection raw_footage(string $label = null)
     * @method Grid\Column|Collection sku_stock_batch_id(string $label = null)
     * @method Grid\Column|Collection terrestrial_feather(string $label = null)
     * @method Grid\Column|Collection velvet(string $label = null)
     * @method Grid\Column|Collection actual_amount(string $label = null)
     * @method Grid\Column|Collection cost_type(string $label = null)
     * @method Grid\Column|Collection pay_type(string $label = null)
     * @method Grid\Column|Collection should_amount(string $label = null)
     * @method Grid\Column|Collection with_order_no(string $label = null)
     * @method Grid\Column|Collection accountant_item_id(string $label = null)
     * @method Grid\Column|Collection category(string $label = null)
     * @method Grid\Column|Collection company_id(string $label = null)
     * @method Grid\Column|Collection company_name(string $label = null)
     * @method Grid\Column|Collection total_amount(string $label = null)
     * @method Grid\Column|Collection link(string $label = null)
     * @method Grid\Column|Collection pay_method(string $label = null)
     * @method Grid\Column|Collection phone(string $label = null)
     * @method Grid\Column|Collection address(string $label = null)
     * @method Grid\Column|Collection customer_id(string $label = null)
     * @method Grid\Column|Collection drawee_id(string $label = null)
     * @method Grid\Column|Collection content(string $label = null)
     * @method Grid\Column|Collection reply(string $label = null)
     * @method Grid\Column|Collection status(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection batch_no(string $label = null)
     * @method Grid\Column|Collection position_id(string $label = null)
     * @method Grid\Column|Collection diff_num(string $label = null)
     * @method Grid\Column|Collection happen_date(string $label = null)
     * @method Grid\Column|Collection prefix(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection item_no(string $label = null)
     * @method Grid\Column|Collection py_code(string $label = null)
     * @method Grid\Column|Collection unit_id(string $label = null)
     * @method Grid\Column|Collection attr_value_ids(string $label = null)
     * @method Grid\Column|Collection product_id(string $label = null)
     * @method Grid\Column|Collection check_order_id(string $label = null)
     * @method Grid\Column|Collection purchase_order_id(string $label = null)
     * @method Grid\Column|Collection price(string $label = null)
     * @method Grid\Column|Collection apply_at(string $label = null)
     * @method Grid\Column|Collection finished_at(string $label = null)
     * @method Grid\Column|Collection supplier_id(string $label = null)
     * @method Grid\Column|Collection check_status(string $label = null)
     * @method Grid\Column|Collection accountant_id(string $label = null)
     * @method Grid\Column|Collection settlement_at(string $label = null)
     * @method Grid\Column|Collection return_num(string $label = null)
     * @method Grid\Column|Collection address_id(string $label = null)
     * @method Grid\Column|Collection num(string $label = null)
     * @method Grid\Column|Collection discount_amount(string $label = null)
     * @method Grid\Column|Collection order_amount(string $label = null)
     * @method Grid\Column|Collection statement_order_id(string $label = null)
     * @method Grid\Column|Collection balance_num(string $label = null)
     * @method Grid\Column|Collection flag(string $label = null)
     * @method Grid\Column|Collection in_num(string $label = null)
     * @method Grid\Column|Collection in_position_id(string $label = null)
     * @method Grid\Column|Collection in_price(string $label = null)
     * @method Grid\Column|Collection init_num(string $label = null)
     * @method Grid\Column|Collection inventory_diff_num(string $label = null)
     * @method Grid\Column|Collection inventory_num(string $label = null)
     * @method Grid\Column|Collection out_num(string $label = null)
     * @method Grid\Column|Collection out_position_id(string $label = null)
     * @method Grid\Column|Collection out_price(string $label = null)
     * @method Grid\Column|Collection settlement_status(string $label = null)
     * @method Grid\Column|Collection craft_id(string $label = null)
     * @method Grid\Column|Collection finish_num(string $label = null)
     * @method Grid\Column|Collection operator(string $label = null)
     * @method Grid\Column|Collection plan_num(string $label = null)
     * @method Grid\Column|Collection batch_id(string $label = null)
     * @method Grid\Column|Collection family_hash(string $label = null)
     * @method Grid\Column|Collection sequence(string $label = null)
     * @method Grid\Column|Collection should_display_on_index(string $label = null)
     * @method Grid\Column|Collection uuid(string $label = null)
     * @method Grid\Column|Collection entry_uuid(string $label = null)
     * @method Grid\Column|Collection tag(string $label = null)
     * @method Grid\Column|Collection email_verified_at(string $label = null)
     */
    class Grid
    {
    }

    class MiniGrid extends Grid
    {
    }

    /**
     * @property Show\Field|Collection name
     * @property Show\Field|Collection version
     * @property Show\Field|Collection alias
     * @property Show\Field|Collection authors
     * @property Show\Field|Collection enable
     * @property Show\Field|Collection imported
     * @property Show\Field|Collection config
     * @property Show\Field|Collection require
     * @property Show\Field|Collection require_dev
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection day
     * @property Show\Field|Collection day_type
     * @property Show\Field|Collection id
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection year
     * @property Show\Field|Collection accountant_date_id
     * @property Show\Field|Collection end_at
     * @property Show\Field|Collection month
     * @property Show\Field|Collection start_at
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection order
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection input
     * @property Show\Field|Collection ip
     * @property Show\Field|Collection method
     * @property Show\Field|Collection path
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection password
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection username
     * @property Show\Field|Collection actual_num
     * @property Show\Field|Collection item_id
     * @property Show\Field|Collection percent
     * @property Show\Field|Collection standard
     * @property Show\Field|Collection stock_batch_id
     * @property Show\Field|Collection cost_price
     * @property Show\Field|Collection order_id
     * @property Show\Field|Collection should_num
     * @property Show\Field|Collection sku_id
     * @property Show\Field|Collection apply_id
     * @property Show\Field|Collection deleted_at
     * @property Show\Field|Collection order_no
     * @property Show\Field|Collection other
     * @property Show\Field|Collection review_status
     * @property Show\Field|Collection with_id
     * @property Show\Field|Collection attr_id
     * @property Show\Field|Collection blackhead
     * @property Show\Field|Collection bulkiness
     * @property Show\Field|Collection carbon_fiber
     * @property Show\Field|Collection cleanliness
     * @property Show\Field|Collection duck_ratio
     * @property Show\Field|Collection feather_silk
     * @property Show\Field|Collection flower_number
     * @property Show\Field|Collection fluffy_silk
     * @property Show\Field|Collection heterochromatic_hair
     * @property Show\Field|Collection magazine
     * @property Show\Field|Collection moisture
     * @property Show\Field|Collection odor
     * @property Show\Field|Collection prev_sku_stock_batch_id
     * @property Show\Field|Collection raw_footage
     * @property Show\Field|Collection sku_stock_batch_id
     * @property Show\Field|Collection terrestrial_feather
     * @property Show\Field|Collection velvet
     * @property Show\Field|Collection actual_amount
     * @property Show\Field|Collection cost_type
     * @property Show\Field|Collection pay_type
     * @property Show\Field|Collection should_amount
     * @property Show\Field|Collection with_order_no
     * @property Show\Field|Collection accountant_item_id
     * @property Show\Field|Collection category
     * @property Show\Field|Collection company_id
     * @property Show\Field|Collection company_name
     * @property Show\Field|Collection total_amount
     * @property Show\Field|Collection link
     * @property Show\Field|Collection pay_method
     * @property Show\Field|Collection phone
     * @property Show\Field|Collection address
     * @property Show\Field|Collection customer_id
     * @property Show\Field|Collection drawee_id
     * @property Show\Field|Collection content
     * @property Show\Field|Collection reply
     * @property Show\Field|Collection status
     * @property Show\Field|Collection type
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection batch_no
     * @property Show\Field|Collection position_id
     * @property Show\Field|Collection diff_num
     * @property Show\Field|Collection happen_date
     * @property Show\Field|Collection prefix
     * @property Show\Field|Collection email
     * @property Show\Field|Collection token
     * @property Show\Field|Collection item_no
     * @property Show\Field|Collection py_code
     * @property Show\Field|Collection unit_id
     * @property Show\Field|Collection attr_value_ids
     * @property Show\Field|Collection product_id
     * @property Show\Field|Collection check_order_id
     * @property Show\Field|Collection purchase_order_id
     * @property Show\Field|Collection price
     * @property Show\Field|Collection apply_at
     * @property Show\Field|Collection finished_at
     * @property Show\Field|Collection supplier_id
     * @property Show\Field|Collection check_status
     * @property Show\Field|Collection accountant_id
     * @property Show\Field|Collection settlement_at
     * @property Show\Field|Collection return_num
     * @property Show\Field|Collection address_id
     * @property Show\Field|Collection num
     * @property Show\Field|Collection discount_amount
     * @property Show\Field|Collection order_amount
     * @property Show\Field|Collection statement_order_id
     * @property Show\Field|Collection balance_num
     * @property Show\Field|Collection flag
     * @property Show\Field|Collection in_num
     * @property Show\Field|Collection in_position_id
     * @property Show\Field|Collection in_price
     * @property Show\Field|Collection init_num
     * @property Show\Field|Collection inventory_diff_num
     * @property Show\Field|Collection inventory_num
     * @property Show\Field|Collection out_num
     * @property Show\Field|Collection out_position_id
     * @property Show\Field|Collection out_price
     * @property Show\Field|Collection settlement_status
     * @property Show\Field|Collection craft_id
     * @property Show\Field|Collection finish_num
     * @property Show\Field|Collection operator
     * @property Show\Field|Collection plan_num
     * @property Show\Field|Collection batch_id
     * @property Show\Field|Collection family_hash
     * @property Show\Field|Collection sequence
     * @property Show\Field|Collection should_display_on_index
     * @property Show\Field|Collection uuid
     * @property Show\Field|Collection entry_uuid
     * @property Show\Field|Collection tag
     * @property Show\Field|Collection email_verified_at
     *
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection alias(string $label = null)
     * @method Show\Field|Collection authors(string $label = null)
     * @method Show\Field|Collection enable(string $label = null)
     * @method Show\Field|Collection imported(string $label = null)
     * @method Show\Field|Collection config(string $label = null)
     * @method Show\Field|Collection require(string $label = null)
     * @method Show\Field|Collection require_dev(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection day(string $label = null)
     * @method Show\Field|Collection day_type(string $label = null)
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection year(string $label = null)
     * @method Show\Field|Collection accountant_date_id(string $label = null)
     * @method Show\Field|Collection end_at(string $label = null)
     * @method Show\Field|Collection month(string $label = null)
     * @method Show\Field|Collection start_at(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection input(string $label = null)
     * @method Show\Field|Collection ip(string $label = null)
     * @method Show\Field|Collection method(string $label = null)
     * @method Show\Field|Collection path(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection actual_num(string $label = null)
     * @method Show\Field|Collection item_id(string $label = null)
     * @method Show\Field|Collection percent(string $label = null)
     * @method Show\Field|Collection standard(string $label = null)
     * @method Show\Field|Collection stock_batch_id(string $label = null)
     * @method Show\Field|Collection cost_price(string $label = null)
     * @method Show\Field|Collection order_id(string $label = null)
     * @method Show\Field|Collection should_num(string $label = null)
     * @method Show\Field|Collection sku_id(string $label = null)
     * @method Show\Field|Collection apply_id(string $label = null)
     * @method Show\Field|Collection deleted_at(string $label = null)
     * @method Show\Field|Collection order_no(string $label = null)
     * @method Show\Field|Collection other(string $label = null)
     * @method Show\Field|Collection review_status(string $label = null)
     * @method Show\Field|Collection with_id(string $label = null)
     * @method Show\Field|Collection attr_id(string $label = null)
     * @method Show\Field|Collection blackhead(string $label = null)
     * @method Show\Field|Collection bulkiness(string $label = null)
     * @method Show\Field|Collection carbon_fiber(string $label = null)
     * @method Show\Field|Collection cleanliness(string $label = null)
     * @method Show\Field|Collection duck_ratio(string $label = null)
     * @method Show\Field|Collection feather_silk(string $label = null)
     * @method Show\Field|Collection flower_number(string $label = null)
     * @method Show\Field|Collection fluffy_silk(string $label = null)
     * @method Show\Field|Collection heterochromatic_hair(string $label = null)
     * @method Show\Field|Collection magazine(string $label = null)
     * @method Show\Field|Collection moisture(string $label = null)
     * @method Show\Field|Collection odor(string $label = null)
     * @method Show\Field|Collection prev_sku_stock_batch_id(string $label = null)
     * @method Show\Field|Collection raw_footage(string $label = null)
     * @method Show\Field|Collection sku_stock_batch_id(string $label = null)
     * @method Show\Field|Collection terrestrial_feather(string $label = null)
     * @method Show\Field|Collection velvet(string $label = null)
     * @method Show\Field|Collection actual_amount(string $label = null)
     * @method Show\Field|Collection cost_type(string $label = null)
     * @method Show\Field|Collection pay_type(string $label = null)
     * @method Show\Field|Collection should_amount(string $label = null)
     * @method Show\Field|Collection with_order_no(string $label = null)
     * @method Show\Field|Collection accountant_item_id(string $label = null)
     * @method Show\Field|Collection category(string $label = null)
     * @method Show\Field|Collection company_id(string $label = null)
     * @method Show\Field|Collection company_name(string $label = null)
     * @method Show\Field|Collection total_amount(string $label = null)
     * @method Show\Field|Collection link(string $label = null)
     * @method Show\Field|Collection pay_method(string $label = null)
     * @method Show\Field|Collection phone(string $label = null)
     * @method Show\Field|Collection address(string $label = null)
     * @method Show\Field|Collection customer_id(string $label = null)
     * @method Show\Field|Collection drawee_id(string $label = null)
     * @method Show\Field|Collection content(string $label = null)
     * @method Show\Field|Collection reply(string $label = null)
     * @method Show\Field|Collection status(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection batch_no(string $label = null)
     * @method Show\Field|Collection position_id(string $label = null)
     * @method Show\Field|Collection diff_num(string $label = null)
     * @method Show\Field|Collection happen_date(string $label = null)
     * @method Show\Field|Collection prefix(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection item_no(string $label = null)
     * @method Show\Field|Collection py_code(string $label = null)
     * @method Show\Field|Collection unit_id(string $label = null)
     * @method Show\Field|Collection attr_value_ids(string $label = null)
     * @method Show\Field|Collection product_id(string $label = null)
     * @method Show\Field|Collection check_order_id(string $label = null)
     * @method Show\Field|Collection purchase_order_id(string $label = null)
     * @method Show\Field|Collection price(string $label = null)
     * @method Show\Field|Collection apply_at(string $label = null)
     * @method Show\Field|Collection finished_at(string $label = null)
     * @method Show\Field|Collection supplier_id(string $label = null)
     * @method Show\Field|Collection check_status(string $label = null)
     * @method Show\Field|Collection accountant_id(string $label = null)
     * @method Show\Field|Collection settlement_at(string $label = null)
     * @method Show\Field|Collection return_num(string $label = null)
     * @method Show\Field|Collection address_id(string $label = null)
     * @method Show\Field|Collection num(string $label = null)
     * @method Show\Field|Collection discount_amount(string $label = null)
     * @method Show\Field|Collection order_amount(string $label = null)
     * @method Show\Field|Collection statement_order_id(string $label = null)
     * @method Show\Field|Collection balance_num(string $label = null)
     * @method Show\Field|Collection flag(string $label = null)
     * @method Show\Field|Collection in_num(string $label = null)
     * @method Show\Field|Collection in_position_id(string $label = null)
     * @method Show\Field|Collection in_price(string $label = null)
     * @method Show\Field|Collection init_num(string $label = null)
     * @method Show\Field|Collection inventory_diff_num(string $label = null)
     * @method Show\Field|Collection inventory_num(string $label = null)
     * @method Show\Field|Collection out_num(string $label = null)
     * @method Show\Field|Collection out_position_id(string $label = null)
     * @method Show\Field|Collection out_price(string $label = null)
     * @method Show\Field|Collection settlement_status(string $label = null)
     * @method Show\Field|Collection craft_id(string $label = null)
     * @method Show\Field|Collection finish_num(string $label = null)
     * @method Show\Field|Collection operator(string $label = null)
     * @method Show\Field|Collection plan_num(string $label = null)
     * @method Show\Field|Collection batch_id(string $label = null)
     * @method Show\Field|Collection family_hash(string $label = null)
     * @method Show\Field|Collection sequence(string $label = null)
     * @method Show\Field|Collection should_display_on_index(string $label = null)
     * @method Show\Field|Collection uuid(string $label = null)
     * @method Show\Field|Collection entry_uuid(string $label = null)
     * @method Show\Field|Collection tag(string $label = null)
     * @method Show\Field|Collection email_verified_at(string $label = null)
     */
    class Show
    {
    }

    /**
     * @method \App\Admin\Extensions\Form\Fee fee(...$params)
     * @method \App\Admin\Extensions\Form\Num num(...$params)
     * @method \App\Admin\Extensions\Form\TableDecimal tableDecimal(...$params)
     * @method \App\Admin\Extensions\Form\Input ipt(...$params)
     * @method \App\Admin\Extensions\Form\ReviewIcon reviewicon(...$params)
     */
    class Form
    {
    }
}

namespace Dcat\Admin\Grid {
    /**
     * @method $this emp(...$params)
     * @method $this fee(...$params)
     * @method $this edit(...$params)
     * @method $this selectplus(...$params)
     * @method $this batch_detail(...$params)
     */
    class Column
    {
    }

    class Filter
    {
    }
}

namespace Dcat\Admin\Show {
    class Field
    {
    }
}
