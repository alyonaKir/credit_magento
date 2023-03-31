<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Block\Adminhtml\Buttons;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;

class Generic
{
    protected Context $context;


    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    public function getEntityId(): ?int
    {
        try {
            return $this->context->getRequest()->getParam('credit_id');
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    public function getUrl($route = '', $params = []): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }

}
