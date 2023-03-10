<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Model\Credit;

use AlyonaKir\Credit\Api\CreditSearchResultInterface;
use AlyonaKir\Credit\Api\Data\CreditInterface;
use Magento\Framework\Api\SearchResults;

class CreditSearchResult extends SearchResults implements CreditSearchResultInterface
{
    /**
     * @return CreditInterface[]
     */
    public function getItems(): array
    {
       return parent::getItems();
    }

    /**
     * @param array $items
     * @return CreditSearchResultInterface
     */
    public function setItems(array $items): CreditSearchResultInterface
    {
        return parent::setItems($items);
    }
}
