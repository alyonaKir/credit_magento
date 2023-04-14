<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Api\Data;


interface ApplicationInterface
{
    const TABLE = 'credit_application';
    const APPLICATION_ID = 'application_id';

    const CREDIT_AMOUNT = 'credit_amount';
    const FILE = 'file';
    const CUSTOMER_ID = 'customer_id';
    const SENT_AT = 'sent_at';
    const FIRST_NAME = 'first_name';
    const LAST_NAME = 'last_name';
    const EMAIL = 'email';
    const PHONE = 'phone';


    public function getApplicationId():int;
    public function getCreditAmount():int;
    public function getFile():string;
    public function getCustomerId():int;
    public function getSentAt():string;
    public function getFirstName(): string;
    public function getLastName(): string;
    public function getEmail(): string;
    public function getPhone(): string;
    public function setApplicationId(int $applicationId):void;
    public function setCreditAmount(int $creditAmount):void;
    public function setFile(string $file):void;
    public function setCustomerId(int $customerId):void;
    public function setSentAt(string $sentAt):void;
    public function setFirstName(string $firstName): void;
    public function setLastName(string $lastName): void;
    public function setEmail(string $email): void;
    public function setPhone(string $phone): void;
}
