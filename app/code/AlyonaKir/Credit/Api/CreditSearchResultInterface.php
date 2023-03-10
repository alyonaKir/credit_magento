<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Api;

use AlyonaKir\Credit\Api\Data\CreditInterface;
use AlyonaKir\Credit\Model\Credit\CreditSearchResult;
use Magento\Framework\Api\SearchResultsInterface;

interface CreditSearchResultInterface extends SearchResultsInterface
{

    /**
     * @return CreditInterface[]
     */
    public function getItems():array;

    /**
     * @param array $items
     * @return CreditSearchResultInterface
     */
    public function setItems(array $items): CreditSearchResultInterface;
}
