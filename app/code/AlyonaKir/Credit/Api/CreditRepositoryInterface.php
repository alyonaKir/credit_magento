<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Api;

use AlyonaKir\Credit\Api\CreditSearchResultInterface;
use AlyonaKir\Credit\Api\Data\CreditInterface;
use AlyonaKir\Credit\Model\Credit\CreditSearchResult;
use Magento\Framework\Api\SearchCriteriaInterface;

interface CreditRepositoryInterface
{

    /**
     * @param int $id
     * @return CreditInterface
     */
    public function getById(int $id): CreditInterface;


    /**
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return CreditInterface[]
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): array;

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

    /**
     * @param int $application_id
     * @return CreditInterface|null
     */
    public function getByApplicationId(int $application_id): ?CreditInterface;
}
