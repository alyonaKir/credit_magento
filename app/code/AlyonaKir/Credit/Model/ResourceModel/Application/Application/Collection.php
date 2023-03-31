<?php

namespace AlyonaKir\Credit\Model\ResourceModel\Application\Application;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection  extends AbstractCollection
{
    protected $_idFieldName = 'application_id';
    protected $_eventPrefix = 'application_collection';
    protected $_eventObject = 'application_collection';

    protected function _construct(): void
    {
        $this->_init('AlyonaKir\Credit\Model\Application\Application', 'AlyonaKir\Credit\Model\ResourceModel\Application\Application');
    }
}
