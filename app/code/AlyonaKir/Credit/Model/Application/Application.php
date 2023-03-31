<?php

namespace AlyonaKir\Credit\Model\Application;

use AlyonaKir\Credit\Api\Data\ApplicationInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class Application extends AbstractModel implements ApplicationInterface
{

    const CACHE_TAG = 'credit_application';

    protected $_cacheTag = 'credit_application';

    protected $_eventPrefix = 'credit_application';

    protected CustomerRepositoryInterface $customerRepository;

    protected function _construct()
    {
        $this->_init('AlyonaKir\Credit\Model\ResourceModel\Application\Application');
    }


    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getApplicationId()];
    }

    public function getDefaultValues(): array
    {
        $values = [];

        return $values;
    }

    public function getApplicationId(): int
    {
        return (int)$this->getData(ApplicationInterface::APPLICATION_ID);
    }

    public function getCreditAmount(): int
    {
        return (int)$this->getData(ApplicationInterface::CREDIT_AMOUNT);
    }

    public function getFile(): string
    {
        return $this->getData(ApplicationInterface::FILE);
    }

    public function getCustomerId(): int
    {
        return (int)$this->getData(ApplicationInterface::CUSTOMER_ID);
    }

    public function getSentAt(): string
    {
        return $this->getData(ApplicationInterface::SENT_AT);
    }

    public function setApplicationId(int $applicationId): void
    {
        $this->setData(ApplicationInterface::APPLICATION_ID, $applicationId);
    }

    public function setCreditAmount(int $creditAmount): void
    {
        $this->setData(ApplicationInterface::CREDIT_AMOUNT, $creditAmount);
    }

    public function setFile(string $file): void
    {
        $this->setData(ApplicationInterface::FILE, $file);
    }

    public function setCustomerId(int $customerId): void
    {
        $this->setData(ApplicationInterface::CUSTOMER_ID, $customerId);
    }

    public function setSentAt(int $sentAt): void
    {
        $this->setData(ApplicationInterface::SENT_AT, $sentAt);
    }

    public function setFirstName(string $firstName): void
    {
        $this->setData(ApplicationInterface::FIRST_NAME, $firstName);
    }

    public function setLastName(string $lastName): void
    {
        $this->setData(ApplicationInterface::LAST_NAME, $lastName);
    }

    public function setEmail(string $email): void
    {
        $this->setData(ApplicationInterface::EMAIL, $email);
    }

    public function setPhone(string $phone): void
    {
        $this->setData(ApplicationInterface::PHONE, $phone);
    }
}
