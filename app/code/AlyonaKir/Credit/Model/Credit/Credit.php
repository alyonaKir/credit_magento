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

    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues(): array
    {
        $values = [];

        return $values;
    }

    public function getCreditId(): int
    {
        return $this->getData(CreditInterface::CREDIT_ID);
    }

    public function setCreditId(int $creditId): void
    {
        $this->setData(CreditInterface::CREDIT_ID, $creditId);
    }

    public function getCreditLimit(): int
    {
        return $this->getData(CreditInterface::CREDIT_LIMIT);
    }

    public function setCreditLimit(int $creditLimit): void
    {
        $this->setData(CreditInterface::CREDIT_LIMIT, $creditLimit);
    }

    public function getLockCreditLimit(): int
    {
        return $this->getData(CreditInterface::LOCK_CREDIT_LIMIT);
    }

    public function setLockCreditLimit(int $lockCreditLimit): void
    {
        $this->setData(CreditInterface::LOCK_CREDIT_LIMIT, $lockCreditLimit);
    }

    public function getCreditAvailable(): int
    {
        return $this->getData(CreditInterface::CREDIT_AVAILABLE);
    }

    public function setCreditAvailable(int $creditAvailable): void
    {
        $this->setData(CreditInterface::CREDIT_AVAILABLE, $creditAvailable);
    }

    public function getPurchaseStatus(): int
    {
        return $this->getData(CreditInterface::PURCHASE_STATUS);
    }

    public function setPurchaseStatus(int $purchaseStatus): void
    {
        $this->setData(CreditInterface::PURCHASE_STATUS, $purchaseStatus);
    }

    public function getFile(): string
    {
        return $this->getData(CreditInterface::FILE);
    }

    public function setFile(string $file): void
    {
        $this->setData(CreditInterface::FILE, $file);
    }

    public function getDateOfResponse(): string
    {
        return $this->getData(CreditInterface::DATE_OF_RESPONSE);
    }

    public function setDateOfResponse(string $dateOfResponse): void
    {
        $this->setData(CreditInterface::DATE_OF_RESPONSE, $dateOfResponse);
    }

    public function getAllowablePurchaseTime(): string
    {
        return $this->getData(CreditInterface::ALLOWABLE_PURCHASE_TIME);
    }

    public function setAllowablePurchaseTime(string $allowablePurchaseTime): void
    {
        $this->setData(CreditInterface::ALLOWABLE_PURCHASE_TIME, $allowablePurchaseTime);
    }

    public function getReason(): string
    {
        return $this->getData(CreditInterface::REASON);
    }

    public function setReason(string $reason): void
    {
        $this->setData(CreditInterface::REASON, $reason);
    }

    public function getUpdatedAt(): string
    {
        return $this->getData(CreditInterface::UPDATED_AT);
    }

    public function setUpdatedAt(string $updatedAt): void
    {
        $this->setData(CreditInterface::UPDATED_AT, $updatedAt);
    }

    public function getCreatedAt(): string
    {
        return $this->getData(CreditInterface::CREATED_AT);
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->setData(CreditInterface::CREATED_AT, $createdAt);
    }
}
