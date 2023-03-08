<?php

namespace AlyonaKir\Credit\Api;

use AlyonaKir\Credit\Api\Data\CreditInterface;
use Magento\Framework\Api\SearchResultsInterface;

interface CreditSearchResultInterface extends SearchResultsInterface
{

    /**
     * @return CreditInterface[]
     */
    public function getItems();

    /**
     * @param array $items
     * @return CreditSearchResultInterface
     */
    public function setItems(array $items);
}
