<?php

namespace AlyonaKir\Credit\Model\Application;

use AlyonaKir\Credit\Api\ApplicationRepositoryInterface;
use AlyonaKir\Credit\Api\Data\ApplicationInterface;
use AlyonaKir\Credit\Model\Application\ApplicationFactory;
use AlyonaKir\Credit\Model\Application\ApplicationSearchResultsFactory;
use AlyonaKir\Credit\Model\ResourceModel\Application\Application as ApplicationResource;
use AlyonaKir\Credit\Model\ResourceModel\Application\Application\CollectionFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;

class ApplicationRepository implements ApplicationRepositoryInterface
{

    private CollectionFactory $collectionFactory;
    private ApplicationResource $applicationResource;
    private ApplicationFactory $applicationFactory;
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    private ApplicationSearchResultsFactory $applicationSearchResultFactory;

    /**
     * @param CollectionFactory $collectionFactory
     * @param ApplicationResource $applicationResource
     * @param ApplicationFactory $applicationFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param ApplicationSearchResultsFactory $applicationSearchResultFactory
     */
    public function __construct(
        CollectionFactory              $collectionFactory,
        ApplicationResource            $applicationResource,
        ApplicationFactory             $applicationFactory,
        SearchCriteriaBuilder          $searchCriteriaBuilder,
        ApplicationSearchResultsFactory $applicationSearchResultFactory
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->applicationResource = $applicationResource;
        $this->applicationFactory = $applicationFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->applicationSearchResultFactory = $applicationSearchResultFactory;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getById(int $id): ApplicationInterface
    {
        $object = $this->applicationFactory->create();
        $this->applicationResource->load($object, $id);
        if (!$object->getId()) {
            throw new NoSuchEntityException(__('Unable to find entity with ID "%1"', $id));
        }
        return $object;
    }

    public function getList(SearchCriteriaInterface $searchCriteria = null): array
    {
        $collection = $this->collectionFactory->create();
        $searchCriteria = $this->searchCriteriaBuilder->create();

        if (null === $searchCriteria) {
            $searchCriteria = $this->searchCriteriaBuilder->create();
        } else {
            foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
                foreach ($filterGroup->getFilters() as $filter) {
                    $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
                    $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
                }
            }
        }

        $searchResult = $this->applicationSearchResultFactory->create();
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);
        return $searchResult->getItems();
    }

    /**
     * @throws AlreadyExistsException
     */
    public function save(ApplicationInterface $application): ApplicationInterface
    {
        $this->applicationResource->save($application);
        return $application;
    }

    /**
     * @throws StateException
     */
    public function delete(ApplicationInterface $application): bool
    {
        try {
            $this->applicationResource->delete($application);
        } catch (\Exception $e) {
            throw new StateException(__('Unable to remove entity #%1', $credit->getId()));
        }
        return true;
    }

    /**
     * @throws NoSuchEntityException
     * @throws StateException
     */
    public function deleteById(int $id): bool
    {
        return $this->delete($this->getById($id));
    }
}
