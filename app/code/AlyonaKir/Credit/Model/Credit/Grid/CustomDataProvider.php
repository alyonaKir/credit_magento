<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Model\Credit\Grid;

use AlyonaKir\Credit\Model\ResourceModel\Credit\Credit\CollectionFactory;
use AlyonaKir\Credit\Model\ResourceModel\Credit\Credit\Collection;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Ui\DataProvider\AddFilterToCollectionInterface;
use Magento\Ui\DataProvider\AddFieldToCollectionInterface;
use Magento\Framework\Api\Filter;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class CustomDataProvider extends AbstractDataProvider
{
    /**
     * @var Collection|null
     */
    protected $collection;

    /**
     * @var AddFieldToCollectionInterface[]
     */
    protected array $addFieldStrategies;

    /**
     * @var AddFilterToCollectionInterface[]
     */
    protected array $addFilterStrategies;

    protected CustomerRepositoryInterface $_customerRepositoryInterface;

    /**
     * Construct
     *
     * @param string $name Component name
     * @param string $primaryFieldName Primary field Name
     * @param string $requestFieldName Request field name
     * @param CollectionFactory $collectionFactory The collection factory
     * @param AddFieldToCollectionInterface[] $addFieldStrategies Add field Strategy
     * @param AddFilterToCollectionInterface[] $addFilterStrategies Add filter Strategy
     * @param array $meta Component Meta
     * @param array $data Component extra data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        CustomerRepositoryInterface $customerRepositoryInterface,
        array $addFieldStrategies = [],
        array $addFilterStrategies = [],
        array $meta = [],
        array $data = []
    )
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        $this->collection = $collectionFactory->create();

        $this->addFieldStrategies = $addFieldStrategies;
        $this->addFilterStrategies = $addFilterStrategies;
    }


    /**
     * @return array
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getData(): array
    {
        if (!$this->getCollection()->isLoaded()) {
            $this->getCollection()->load();
        }
        $items = $this->getCollection()->toArray();


        for ($i = 0; $i < $items['totalRecords']; $i++) {
            $customer = $this->_customerRepositoryInterface->getById($items['items'][$i]['user_id']);
            $items['items'][$i]['userName'] = $customer->getFirstname() . " " . $customer->getLastname();
            $items['items'][$i]['link'] = 'https://' . $_SERVER['HTTP_HOST'] . '/backend/customer/index/edit/id/' . $items['items'][$i]['user_id'];
        }
        $buff = $items['items'];

        return [
            'totalRecords' => $this->getCollection()->getSize(),
            'items' => $buff,
        ];
    }


    /**
     * @param $field
     * @param $alias
     * @return void
     */
    public function addField($field, $alias = null): void
    {
        if (isset($this->addFieldStrategies[$field])) {
            $this->addFieldStrategies[$field]->addField($this->getCollection(), $field, $alias);

            return;
        }
        parent::addField($field, $alias);
    }


    /**
     * @param Filter $filter
     * @return void
     */
    public function addFilter(Filter $filter): void
    {
        if (isset($this->addFilterStrategies[$filter->getField()])) {
            $this->addFilterStrategies[$filter->getField()]
                ->addFilter(
                    $this->getCollection(),
                    $filter->getField(),
                    [$filter->getConditionType() => $filter->getValue()]
                );

            return;
        }
        parent::addFilter($filter);
    }
}
