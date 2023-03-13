<?php

namespace AlyonaKir\Credit\Block\Adminhtml\Buttons;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;

class Generic
{
    protected $context;
    protected $customform;

    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    public function getEntityId()
    {
        try {
            return $this->context->getRequest()->getParam('credit_id');
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }

}
