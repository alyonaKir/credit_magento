<?php
declare(strict_types=1);
namespace AlyonaKir\Credit\Api;

use AlyonaKir\Credit\Api\Data\ApplicationInterface;
use Magento\Framework\Api\SearchResultsInterface;

interface ApplicationSearchResultInterface  extends SearchResultsInterface
{
    /**
     * @return ApplicationInterface[]
     */
    public function getItems():array;

    /**
     * @param array $items
     * @return ApplicationSearchResultInterface
     */
    public function setItems(array $items): ApplicationSearchResultInterface;
}
