<?php

namespace AlyonaKir\Credit\Model\Credit\Grid;

use AlyonaKir\Credit\Model\ResourceModel\Credit\Credit\CollectionFactory;

class CustomDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * Seller collection
     *
     * @var \AlyonaKir\Credit\Model\ResourceModel\Credit\Credit\Collection
     */
    protected $collection;

    /**
     * @var \Magento\Ui\DataProvider\AddFieldToCollectionInterface[]
     */
    protected $addFieldStrategies;

    /**
     * @var \Magento\Ui\DataProvider\AddFilterToCollectionInterface[]
     */
    protected $addFilterStrategies;

    protected $_customerRepositoryInterface;

    /**
     * Construct
     *
     * @param string                                                    $name                Component name
     * @param string                                                    $primaryFieldName    Primary field Name
     * @param string                                                    $requestFieldName    Request field name
     * @param CollectionFactory                                         $collectionFactory   The collection factory
     * @param \Magento\Ui\DataProvider\AddFieldToCollectionInterface[]  $addFieldStrategies  Add field Strategy
     * @param \Magento\Ui\DataProvider\AddFilterToCollectionInterface[] $addFilterStrategies Add filter Strategy
     * @param array                                                     $meta                Component Meta
     * @param array                                                     $data                Component extra data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        array $addFieldStrategies = [],
        array $addFilterStrategies = [],
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        $this->collection = $collectionFactory->create();

        $this->addFieldStrategies  = $addFieldStrategies;
        $this->addFilterStrategies = $addFilterStrategies;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (!$this->getCollection()->isLoaded()) {
            $this->getCollection()->load();
        }
        $items = $this->getCollection()->toArray();



        for($i=0; $i<$items['totalRecords']; $i++){
            $customer = $this->_customerRepositoryInterface->getById($items['items'][$i]['user_id']);
            $items['items'][$i]['userName'] = $customer->getFirstname()." ".$customer->getLastname();
            $items['items'][$i]['link'] = 'https://'.$_SERVER['HTTP_HOST'].'/backend/customer/index/edit/id/'.$items['items'][$i]['user_id'];
        }
        $buff = $items['items'];

        return [
            'totalRecords' => $this->getCollection()->getSize(),
            'items'        => $buff,
        ];
    }

    /**
     * Add field to select
     *
     * @param string|array $field The field
     * @param string|null  $alias Alias for the field
     *
     * @return void
     */
    public function addField($field, $alias = null)
    {
        if (isset($this->addFieldStrategies[$field])) {
            $this->addFieldStrategies[$field]->addField($this->getCollection(), $field, $alias);

            return ;
        }
        parent::addField($field, $alias);
    }

    /**
     * {@inheritdoc}
     */
    public function addFilter(\Magento\Framework\Api\Filter $filter)
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
