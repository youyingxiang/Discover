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

/**
 * App\Models\DemandModel
 *
 * @property int $id
 * @property string|null $content 需求描述
 * @property int $type 需求类型
 * @property int $status 状态
 * @property string|null $reply 开发回复
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|DemandModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DemandModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DemandModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|DemandModel whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DemandModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DemandModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DemandModel whereReply($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DemandModel whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DemandModel whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DemandModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DemandModel extends BaseModel
{
    protected $table = 'demand';

    const STATUS_PENDING = 0;
    const STATUS_PROCESSING = 1;
    const STATUS_PROCESSED = 2;
    const STATUS_REJECTED = 3;

    const STATUS = [
        self::STATUS_PENDING    => '待处理',
        self::STATUS_PROCESSING => '处理中',
        self::STATUS_PROCESSED  => '已处理',
        self::STATUS_REJECTED   => '已拒绝',
    ];

    const STATUS_COLOR = [
        self::STATUS_PENDING    => 'gray',
        self::STATUS_PROCESSING => 'primary',
        self::STATUS_PROCESSED  => 'success',
        self::STATUS_REJECTED   => 'red',
    ];

    const TYPE_BUG = 0;
    const TYPE_DEMAND = 1;
    const TYPE_PROPOSE = 2;

    const TYPE = [
        self::TYPE_BUG     => 'Bug',
        self::TYPE_DEMAND  => '需求',
        self::TYPE_PROPOSE => '优化建议',
    ];

    const TYPE_COLOR = [
        self::TYPE_BUG     => 'red',
        self::TYPE_DEMAND  => 'green',
        self::TYPE_PROPOSE => 'yellow',
    ];
}
