<?php
declare(strict_types=1);
namespace AlyonaKir\Credit\Model\Application;

use AlyonaKir\Credit\Api\ApplicationSearchResultInterface;
use AlyonaKir\Credit\Api\Data\ApplicationInterface;
use Magento\Framework\Api\SearchResults;

class ApplicationSearchResults extends SearchResults implements ApplicationSearchResultInterface
{

    /**
     * @return ApplicationInterface[]
     */
    public function getItems(): array
    {
        return parent::getItems();
    }

    /**
     * @param array $items
     * @return ApplicationSearchResultInterface
     */
    public function setItems(array $items): ApplicationSearchResultInterface
    {
        return parent::setItems($items);
    }
}
