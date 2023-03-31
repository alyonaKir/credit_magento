<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Api\Data;

interface CreditInterface
{
    const TABLE = 'credit';
    const CREDIT_ID = 'credit_id';
    const CREDIT_LIMIT = 'credit_limit';
    const LOCK_CREDIT_LIMIT = 'lock_credit_limit';
    const CREDIT_AVAILABLE = 'credit_available';
    const PURCHASE_STATUS = 'purchase_status';
    const FILE = 'file';
    const DATE_OF_RESPONSE = 'date_of_response';
    const ALLOWABLE_PURCHASE_TIME = 'allowable_purchase_time';
    const REASON = 'reason';
    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';

    const APPLICATION_ID = 'application_id';
    public function getCreditId(): int;

    public function setCreditId(int $creditId): void;

    public function getApplicationId(): int;

    public function setApplicationId(int $applicationId): void;

    public function getCreditLimit(): int;

    public function setCreditLimit(int $creditLimit): void;

    public function getLockCreditLimit(): int;

    public function setLockCreditLimit(int $lockCreditLimit): void;

    public function getCreditAvailable(): int;

    public function setCreditAvailable(int $creditAvailable): void;

    public function getPurchaseStatus(): int;

    public function setPurchaseStatus(int $purchaseStatus): void;

    public function getFile(): string;

    public function setFile(string $file): void;

    public function getDateOfResponse(): string;

    public function setDateOfResponse(string $dateOfResponse): void;

    public function getAllowablePurchaseTime(): string;

    public function setAllowablePurchaseTime(string $allowablePurchaseTime): void;

    public function getReason(): string;

    public function setReason(string $reason): void;

    public function getUpdatedAt(): string;

    public function setUpdatedAt(string $updatedAt): void;

    public function getCreatedAt(): string;

    public function setCreatedAt(string $createdAt): void;
}
