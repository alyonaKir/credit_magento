<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Model\Credit\Form;

use AllowDynamicProperties;
use AlyonaKir\Credit\Model\ResourceModel\Credit\Credit\CollectionFactory;

#[AllowDynamicProperties] class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData(): array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        $this->SloadedData = [];

        foreach ($items as $credit) {
            $this->loadedData[$credit->getCreditId()]['credit_fieldset'] = $credit->getData();
            $this->loadedData[$credit->getCreditId()]['credit_fieldset']['my_url'] = $credit->getFile();
        }

        return $this->loadedData;
    }
}
