<?php

namespace AlyonaKir\Credit\Model\ResourceModel\Credit;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Credit extends AbstractDb
{
    protected function __construct(Context $context)
    {
        parent::__construct($context);
    }
    protected function _construct()
    {
        $this->_init('credit', 'credit_id');
    }
}
