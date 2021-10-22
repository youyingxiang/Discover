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

namespace App\Admin\Extensions\Form\Order;

use App\Admin\Actions\Grid\BatchCreatePro;
use App\Admin\Actions\Grid\OrderDelete;
use App\Admin\Actions\Grid\OrderPrint;
use App\Admin\Actions\Grid\OrderReview;
use App\Models\PurchaseBaseModel;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Exception;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

abstract class OrderController extends AdminController
{
    /**
     * @var PurchaseBaseModel
     */
    public $oredr_model;

    /**
     * @var Repository
     */
    public $order_repository;
    /**
     * @var array
     */
    public $order_relations = ['items'];

    /**
     * @var Model
     */
    public $item_model;

    /**
     * @var Repository
     */
    public $item_repository;
    /**
     * @var array
     */
    public $item_relations = ['sku', 'sku.product'];

    /**
     * @var string
     */
    public $item_name;

    /**
     * @var
     */
    protected $order;

    public function __construct()
    {
        if (\PHP_SAPI !== 'cli') {
            $this->style();
            $this->item_name        = $this->getItemName();
            $this->oredr_model      = $this->getOrderModel();
            $this->order_repository = $this->getOrderRepository();
            $this->item_model       = $this->getItemModel();
            $this->item_repository  = $this->getItemRepository();
        }
    }

    public function style(): void
    {
        Admin::style(
            <<<'CSS'
        body {
            overflow-x:hidden
        }
        #app > .content:last-child > .row:last-child{
            padding-left: 0.7rem;
            padding-right: 0.7rem;
        }
CSS
        );
    }

    /**
     * @throws Exception
     * @return string
     */
    public function getOrderModel(): string
    {
        return $this->getClassNameByType('model');
    }

    /**
     * @throws Exception
     * @return Repository
     */
    public function getOrderRepository(): Repository
    {
        $className = $this->getClassNameByType('repository');
        return (new $className($this->order_relations));
    }

    /**
     * @throws Exception
     * @return string
     */
    public function getItemModel(): string
    {
        return $this->getClassNameByType('model', false);
    }

    /**
     * @throws Exception
     * @return Repository
     */
    public function getItemRepository(): Repository
    {
        $className = $this->getClassNameByType('repository', false);
        return (new $className($this->item_relations));
    }

    /**
     * @param string $type
     * @param bool $is_oredr
     * @throws Exception
     * @return string
     */
    protected function getClassNameByType(string $type, bool $is_oredr = true): string
    {
        switch ($type) {
            case 'model':
                $subject = "\\App\\Models\\?Model";
                break;
            case 'repository':
                $subject = "\\App\\Admin\\Repositories\\?";
                break;
            default:
                throw new Exception('参数错误');
        }

        $controller = $is_oredr ? admin_controller_name() : $this->item_name;

        $className = Str::replaceFirst('?', $controller, $subject);
        if (! class_exists($className)) {
            throw new Exception(Str::replaceFirst('?', $className, "? 不存在！"));
        }
        return $className;
    }

    protected function getItemName(): string
    {
        return Str::replaceFirst("Order", "Item", admin_controller_name());
    }

    /**
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        $this->order = $this->oredr_model::findOrFail($id);
        return $content
            ->title($this->title())
            ->description($this->description()['edit'] ?? trans('admin.edit'))
            ->body($this->form()->edit($id))
            ->body($this->items($id))->full();
    }

    /**
     * @throws \Throwable
     * @return mixed
     */
    public function store()
    {
        return DB::transaction(function () {
            return $this->form()->store();
        });
    }

    /**
     * @param int $id
     * @throws \Throwable
     * @return \Illuminate\Http\Response|mixed
     */
    public function update($id)
    {
        return DB::transaction(function () use ($id) {
            return $this->form()->update($id);
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form(): Form
    {
        return Form::make($this->order_repository, function (Form $form) {
            $this->setForm($form);
            if ($form->isCreating()) {
                $this->creating($form);
            } elseif ($form->isEditing()) {
                $this->editing($form);
            }
        });
    }

    /**
     * @param Form $form
     */
    protected function editing(Form &$form): void
    {
        $form->row(function (Form\Row $row) {
            $row->reviewicon('review_status', '审核状态');
        });
        $form->disableFooter();
        $form->disableHeader();
        $form->disableAjaxSubmit();
    }

    /**
     * @param Form $form
     */
    abstract protected function creating(Form &$form): void;

    /**
     * @param Form $form
     */
    abstract protected function setForm(Form &$form): void;

    /**
     * @param Grid $grid
     */
    abstract protected function setItems(Grid &$grid): void;

    /**
     * @param int $id
     * @return Grid
     */
    public function items(int $id): Grid
    {
        return Grid::make($this->item_repository, function (Grid $grid) use ($id) {
            $grid->setName(Str::random(16));
            $grid->model()->resetOrderBy();
            $grid->model()->where('order_id', $id);
            $this->setItems($grid);
            $this->setItemsCommon($grid);
        })->resource(Str::of($this->item_name)->kebab()->plural());
    }

    /**
     * @param Grid $grid
     */
    public function setItemsCommon(Grid &$grid): void
    {
        $grid->tools(OrderPrint::make());
        if ($this->order && $this->order->review_status !== $this->oredr_model::REVIEW_STATUS_OK) {
            $grid->tools(OrderReview::make(show_order_review($this->order->review_status)));
            $grid->tools(OrderDelete::make());
            $grid->tools(BatchCreatePro::make());
        }
        $grid->disableActions();
        $grid->disablePagination();
        $grid->disableCreateButton();
        $grid->disableBatchDelete();
    }
}
