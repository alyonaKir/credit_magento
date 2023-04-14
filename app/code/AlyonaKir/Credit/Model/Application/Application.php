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


    /**
     * @return string[]
     */
    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getApplicationId()];
    }

    /**
     * @return array
     */
    public function getDefaultValues(): array
    {
        $values = [];

        return $values;
    }

    /**
     * @return int
     */
    public function getApplicationId(): int
    {
        return (int)$this->getData(ApplicationInterface::APPLICATION_ID);
    }

    /**
     * @return int
     */
    public function getCreditAmount(): int
    {
        return (int)$this->getData(ApplicationInterface::CREDIT_AMOUNT);
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->getData(ApplicationInterface::FILE);
    }

    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return (int)$this->getData(ApplicationInterface::CUSTOMER_ID);
    }

    /**
     * @return string
     */
    public function getSentAt(): string
    {
        return $this->getData(ApplicationInterface::SENT_AT);
    }

    /**
     * @param int $applicationId
     * @return void
     */
    public function setApplicationId(int $applicationId): void
    {
        $this->setData(ApplicationInterface::APPLICATION_ID, $applicationId);
    }

    /**
     * @param int $creditAmount
     * @return void
     */
    public function setCreditAmount(int $creditAmount): void
    {
        $this->setData(ApplicationInterface::CREDIT_AMOUNT, $creditAmount);
    }

    /**
     * @param string $file
     * @return void
     */
    public function setFile(string $file): void
    {
        $this->setData(ApplicationInterface::FILE, $file);
    }

    /**
     * @param int $customerId
     * @return void
     */
    public function setCustomerId(int $customerId): void
    {
        $this->setData(ApplicationInterface::CUSTOMER_ID, $customerId);
    }

    /**
     * @param string $sentAt
     * @return void
     */
    public function setSentAt(string $sentAt): void
    {
        $this->setData(ApplicationInterface::SENT_AT, $sentAt);
    }

    /**
     * @param string $firstName
     * @return void
     */
    public function setFirstName(string $firstName): void
    {
        $this->setData(ApplicationInterface::FIRST_NAME, $firstName);
    }

    /**
     * @param string $lastName
     * @return void
     */
    public function setLastName(string $lastName): void
    {
        $this->setData(ApplicationInterface::LAST_NAME, $lastName);
    }

    /**
     * @param string $email
     * @return void
     */
    public function setEmail(string $email): void
    {
        $this->setData(ApplicationInterface::EMAIL, $email);
    }

    /**
     * @param string $phone
     * @return void
     */
    public function setPhone(string $phone): void
    {
        $this->setData(ApplicationInterface::PHONE, $phone);
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->getData(ApplicationInterface::FIRST_NAME);
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->getData(ApplicationInterface::LAST_NAME);
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->getData(ApplicationInterface::EMAIL);
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->getData(ApplicationInterface::PHONE);
    }
}
