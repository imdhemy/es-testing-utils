<?php

namespace EsUtils\Tools;

use EsUtils\Ds\Queue;
use EsUtils\Tools\Contracts\MockAble;
use EsUtils\Tools\Contracts\TemplateAble;

class TemplateQueue implements MockAble
{
    /**
     * @var Queue
     */
    private $templates;

    /**
     * @param Queue|null $templates
     */
    public function __construct(?Queue $templates = null)
    {
        $this->templates = $templates ?: new Queue();
    }

    /**
     * @param TemplateAble $template
     */
    public function addTemplate(TemplateAble $template): void
    {
        $this->templates->push($template);
    }

    /**
     * @inheritDoc
     */
    public function getNext(): TemplateAble
    {
        return $this->templates->pop();
    }
}
