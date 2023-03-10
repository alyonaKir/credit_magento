<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Api;

use AlyonaKir\Credit\Api\CreditSearchResultInterface;
use AlyonaKir\Credit\Api\Data\CreditInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface CreditRepositoryInterface
{

    /**
     * @param int $id
     * @return CreditInterface
     */
    public function getById(int $id): CreditInterface;

    /**
     * @return CreditSearchResultInterface
     */
    public function get(): CreditSearchResultInterface;

    /**
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return CreditSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): CreditSearchResultInterface;

    /**
     * @param CreditInterface $credit
     * @return CreditInterface
     */
    public function save(CreditInterface $credit): CreditInterface;

    /**
     * @param CreditInterface $credit
     * @return bool
     */
    public function delete(CreditInterface $credit): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;
}
