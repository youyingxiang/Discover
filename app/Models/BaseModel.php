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

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BaseModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel query()
 * @mixin \Eloquent
 */
class BaseModel extends Model
{
    use HasDateTimeFormatter;

    protected $guarded = ['id'];

    const STATUS_NO = 0;
    const STATUS_OK = 1;

    const REVIEW_STATUS_WAIT = 0;
    const REVIEW_STATUS_OK = 1;
    const REVIEW_STATUS_REREVIEW = 2;

    const STANDARD_NO_CHOICE = 0;
    const STANDARD_CHINA = 1;
    const STANDARD_JAPAN = 2;
    const STANDARD_EUROPE = 3;

    const STANDARD = [
        self::STANDARD_NO_CHOICE => '暂无',
        self::STANDARD_CHINA => '国标',
        self::STANDARD_JAPAN => '日标',
        self::STANDARD_EUROPE => '欧标',
    ];

    const REVIEW_STATUS = [
        self::REVIEW_STATUS_WAIT     => "待审核",
        self::REVIEW_STATUS_OK       => "已审核",
        self::REVIEW_STATUS_REREVIEW => "反审核",
    ];

    const REVIEW_STATUS_COLOR = [
        self::REVIEW_STATUS_WAIT     => "gray",
        self::REVIEW_STATUS_OK       => "success",
        self::REVIEW_STATUS_REREVIEW => "red",
    ];
}
