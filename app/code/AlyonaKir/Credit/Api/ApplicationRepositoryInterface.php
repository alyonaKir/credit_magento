<?php
declare(strict_types=1);
namespace AlyonaKir\Credit\Api;

use AlyonaKir\Credit\Api\Data\ApplicationInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface ApplicationRepositoryInterface
{
    /**
     * @param int $id
     * @return ApplicationInterface
     */
    public function getById(int $id): ApplicationInterface;


    /**
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return ApplicationInterface[]
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): array;

    /**
     * @param ApplicationInterface $application
     * @return ApplicationInterface
     */
    public function save(ApplicationInterface $application): ApplicationInterface;

    /**
     * @param ApplicationInterface $application
     * @return bool
     */
    public function delete(ApplicationInterface $application): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;
}
