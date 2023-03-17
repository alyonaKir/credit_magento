<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Model\ResourceModel\Credit;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Credit extends AbstractDb
{
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    protected function _construct():void
    {
        $this->_init('credit', 'credit_id');
    }
}
