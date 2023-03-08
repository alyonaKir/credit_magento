<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Model;

use AlyonaKir\Credit\Api\CreditRepositoryInterface;
use AlyonaKir\Credit\Model\ResourceModel\Credit\CollectionFactory;
use AlyonaKir\Credit\Model\ResourceModel\Credit\Credit as CreditResource;
use AlyonaKir\Credit\Api\CreditSearchResultInterface;
use AlyonaKir\Credit\Api\Data\CreditInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;

class CreditRepository implements CreditRepositoryInterface
{
    private CollectionFactory $collectionFactory;
    private CreditResource $creditResource;
    private CreditFactory $creditFactory;
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    private CreditSearchResultFactory $searchResultFactory;

    /**
     * @param CollectionFactory $collectionFactory
     * @param CreditResource $creditResource
     * @param \AlyonaKir\Credit\Model\CreditFactory $creditFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \AlyonaKir\Credit\Model\CreditSearchResultFactory $searchResultFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        CreditResource $creditResource,
        CreditFactory $creditFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        CreditSearchResultFactory $searchResultFactory
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->creditResource = $creditResource;
        $this->creditFactory = $creditFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->searchResultFactory = $searchResultFactory;
    }

    /**
     * @param int $id
     * @return CreditInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): CreditInterface
    {
        $object = $this->creditFactory->create();
        $this->creditResource->load($object, $id);
        if (! $object->getId()) {
            throw new NoSuchEntityException(__('Unable to find entity with ID "%1"', $id));
        }
        return $object;
    }

    /**
     * @return CreditSearchResultInterface
     */
    public function get(): CreditSearchResultInterface
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();
        return $this->getList($searchCriteria);
    }

    /**
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return CreditSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): CreditSearchResultInterface
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

        $searchResult = $this->searchResultFactory->create();
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);
        return $searchResult;
    }

    /**
     * @param CreditInterface $credit
     * @return CreditInterface
     * @throws StateException
     */
    public function save(CreditInterface $credit): CreditInterface
    {
        try {
            $this->creditResource->save($credit);
        } catch (\Exception $e) {
            throw new StateException(__('Unable to save entity #%1', $credit->getId()));
        }
        return $credit;
    }

    /**
     * @param CreditInterface $credit
     * @return bool
     * @throws StateException
     */
    public function delete(CreditInterface $credit): bool
    {
        try {
            $this->creditResource->delete($credit);
        } catch (\Exception $e) {
            throw new StateException(__('Unable to remove entity #%1', $credit->getId()));
        }
        return true;
    }

    /**
     * @param int $id
     * @return bool
     * @throws NoSuchEntityException
     * @throws StateException
     */
    public function deleteById(int $id): bool
    {
        return $this->delete($this->getById($id));
    }
}
