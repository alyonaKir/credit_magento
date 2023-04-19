<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Model\Credit;

use AlyonaKir\Credit\Api\Data\CreditInterface;
use Magento\Framework\Model\AbstractModel;

class Credit extends AbstractModel implements CreditInterface
{

    const CACHE_TAG = 'credit';

    protected $_cacheTag = 'credit';

    protected $_eventPrefix = 'credit';

    protected function _construct()
    {
        $this->_init('AlyonaKir\Credit\Model\ResourceModel\Credit\Credit');
    }

    /**
     * @return string[]
     */
    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
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
    public function getCreditId(): int
    {
        return (int)$this->getData(CreditInterface::CREDIT_ID);
    }

    /**
     * @param int $creditId
     * @return void
     */
    public function setCreditId(int $creditId): void
    {
        $this->setData(CreditInterface::CREDIT_ID, $creditId);
    }

    /**
     * @return int
     */
    public function getCreditLimit(): int
    {
        return (int)$this->getData(CreditInterface::CREDIT_LIMIT);
    }

    /**
     * @param int $creditLimit
     * @return void
     */
    public function setCreditLimit(int $creditLimit): void
    {
        $this->setData(CreditInterface::CREDIT_LIMIT, $creditLimit);
    }

    /**
     * @return int
     */
    public function getLockCreditLimit(): int
    {
        return (int)$this->getData(CreditInterface::LOCK_CREDIT_LIMIT);
    }

    /**
     * @param int $lockCreditLimit
     * @return void
     */
    public function setLockCreditLimit(int $lockCreditLimit): void
    {
        $this->setData(CreditInterface::LOCK_CREDIT_LIMIT, $lockCreditLimit);
    }

    /**
     * @return float
     */
    public function getCreditAvailable(): float
    {
        return (float)$this->getData(CreditInterface::CREDIT_AVAILABLE);
    }

    /**
     * @param float $creditAvailable
     * @return void
     */
    public function setCreditAvailable(float $creditAvailable): void
    {
        $this->setData(CreditInterface::CREDIT_AVAILABLE, $creditAvailable);
    }

    /**
     * @return int
     */
    public function getPurchaseStatus(): int
    {
        return (int)$this->getData(CreditInterface::PURCHASE_STATUS);
    }

    /**
     * @param int $purchaseStatus
     * @return void
     */
    public function setPurchaseStatus(int $purchaseStatus): void
    {
        $this->setData(CreditInterface::PURCHASE_STATUS, $purchaseStatus);
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->getData(CreditInterface::FILE);
    }

    /**
     * @param string $file
     * @return void
     */
    public function setFile(string $file): void
    {
        $this->setData(CreditInterface::FILE, $file);
    }

    /**
     * @return string
     */
    public function getDateOfResponse(): string
    {
        return $this->getData(CreditInterface::DATE_OF_RESPONSE);
    }

    /**
     * @param string $dateOfResponse
     * @return void
     */
    public function setDateOfResponse(string $dateOfResponse): void
    {
        $this->setData(CreditInterface::DATE_OF_RESPONSE, $dateOfResponse);
    }

    /**
     * @return string
     */
    public function getAllowablePurchaseTime(): string
    {
        return $this->getData(CreditInterface::ALLOWABLE_PURCHASE_TIME);
    }

    /**
     * @param string $allowablePurchaseTime
     * @return void
     */
    public function setAllowablePurchaseTime(string $allowablePurchaseTime): void
    {
        $this->setData(CreditInterface::ALLOWABLE_PURCHASE_TIME, $allowablePurchaseTime);
    }

    /**
     * @return string
     */
    public function getReason(): string
    {
        return $this->getData(CreditInterface::REASON);
    }

    /**
     * @param string $reason
     * @return void
     */
    public function setReason(string $reason): void
    {
        $this->setData(CreditInterface::REASON, $reason);
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->getData(CreditInterface::UPDATED_AT);
    }

    /**
     * @param string $updatedAt
     * @return void
     */
    public function setUpdatedAt(string $updatedAt): void
    {
        $this->setData(CreditInterface::UPDATED_AT, $updatedAt);
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->getData(CreditInterface::CREATED_AT);
    }

    /**
     * @param string $createdAt
     * @return void
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->setData(CreditInterface::CREATED_AT, $createdAt);
    }


    /**
     * @return int
     */
    public function getApplicationId(): int
    {
        return (int)$this->getData(CreditInterface::APPLICATION_ID);
    }

    /**
     * @param int $applicationId
     * @return void
     */
    public function setApplicationId(int $applicationId): void
    {
        $this->setData(CreditInterface::APPLICATION_ID, $applicationId);
    }
}
