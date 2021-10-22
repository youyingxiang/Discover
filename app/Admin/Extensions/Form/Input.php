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

namespace App\Admin\Extensions\Form;

use Dcat\Admin\Form\Field\Text;

class Input extends Text
{
    protected $rem;

    public function render()
    {
        $this->initPlainInput();
        $this->defaultAttribute('type', 'text')
            ->defaultAttribute('id', $this->id)
            ->defaultAttribute('name', $this->getElementName())
            ->defaultAttribute('value', old($this->column, $this->value()))
            ->defaultAttribute('class', 'form-control '.$this->getElementClassString())
            ->defaultAttribute('style', "width: {$this->rem}rem")
            ->defaultAttribute('placeholder', $this->placeholder());

        $this->addVariables([
            'append'  => $this->append,
        ]);

        return parent::render();
    }

    public function rem(int $rem):self
    {
        $this->rem = $rem;
        return $this;
    }
}
