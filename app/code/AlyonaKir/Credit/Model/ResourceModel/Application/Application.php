<?php
declare(strict_types=1);
namespace AlyonaKir\Credit\Model\ResourceModel\Application;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Application extends AbstractDb
{
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    protected function _construct():void
    {
        $this->_init('credit_application', 'application_id');
    }
}
