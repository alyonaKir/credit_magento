<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Model\ResourceModel\Credit\Credit;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'credit_id';
    protected $_eventPrefix = 'credit_collection';
    protected $_eventObject = 'credit_collection';

    protected function _construct(): void
    {
        $this->_init('AlyonaKir\Credit\Model\Credit\Credit', 'AlyonaKir\Credit\Model\ResourceModel\Credit\Credit');
    }
}
