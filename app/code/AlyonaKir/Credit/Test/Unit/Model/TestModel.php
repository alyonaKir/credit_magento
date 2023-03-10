<?php

use AlyonaKir\Credit\Model\Credit;
use PHPUnit\Framework\TestCase;

/**
 * @covers \AlyonaKir\Credit\Model\Credit\Credit
 */
class TestModel extends TestCase
{
    protected $_model;
    protected $_objectManager;

    protected function setUp(): void
    {
        $this->_objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->_model = $this->_objectManager->getObject(AlyonaKir\Credit\Model\Credit\Credit::class);
    }

    /** @test */
    public function testGetCreditId()
    {
        $this->_model->setCreditId(1);
        $this->assertEquals(1, $this->_model->getCreditId());
    }

    /** @test */
    public function testGetCreditLimit()
    {
        $this->_model->setCreditLimit(1);
        $this->assertEquals(1, $this->_model->getCreditLimit());
    }

    /** @test */
    public function testGetLockCreditLimit()
    {
        $this->_model->setLockCreditLimit(1);
        $this->assertEquals(1, $this->_model->getLockCreditLimit());
    }

    /** @test */
    public function testGetCreditAvailable()
    {
        $this->_model->setCreditAvailable(1);
        $this->assertEquals(1, $this->_model->getCreditAvailable());
    }

    /** @test */
    public function testGetPurchaseStatus()
    {
        $this->_model->setPurchaseStatus(1);
        $this->assertEquals(1, $this->_model->getPurchaseStatus());
    }

    /** @test */
    public function testGetFile()
    {
        $this->_model->setFile("0010101010");
        $this->assertEquals("0010101010", $this->_model->getFile());
    }

    /** @test */
    public function testGetDateOfResponse()
    {
        $this->_model->setDateOfResponse("2020-10-21");
        $this->assertEquals("2020-10-21", $this->_model->getDateOfResponse());
    }

    /** @test */
    public function testGetAllowablePurchaseTime()
    {
        $this->_model->setAllowablePurchaseTime("2020-10-21");
        $this->assertEquals("2020-10-21", $this->_model->getAllowablePurchaseTime());
    }

    /** @test */
    public function testGetReason()
    {
        $this->_model->setReason("no reason");
        $this->assertEquals("no reason", $this->_model->getReason());
    }

    /** @test */
    public function testGetCreatedAt()
    {
        $this->_model->setCreatedAt("2020-10-21");
        $this->assertEquals("2020-10-21", $this->_model->getCreatedAt());
    }

    /** @test */
    public function testGetUpdatedAt()
    {
        $this->_model->setUpdatedAt("2020-10-21");
        $this->assertEquals("2020-10-21", $this->_model->getUpdatedAt());
    }

    /** @test */
    public function testSetCreditId()
    {
        $this->_model->setCreditId(1);
        $result =  $this->_model->getCreditId();
        $this->_model->setCreditId(2);
        $this->assertNotEquals($result, $this->_model->getCreditId());
    }

    /** @test */
    public function testSetCreditLimit()
    {
        $this->_model->setCreditLimit(1);
        $result =  $this->_model->getCreditLimit();
        $this->_model->setCreditLimit(2);
        $this->assertNotEquals($result, $this->_model->getCreditLimit());
    }

    public function testSetLockCreditLimit()
    {
        $this->_model->setLockCreditLimit(1);
        $result =  $this->_model->getLockCreditLimit();
        $this->_model->setLockCreditLimit(2);
        $this->assertNotEquals($result, $this->_model->getLockCreditLimit());
    }

    /** @test */
    public function testSetCreditAvailable()
    {
        $this->_model->setCreditAvailable(1);
        $result =  $this->_model->getCreditAvailable();
        $this->_model->setCreditAvailable(2);
        $this->assertNotEquals($result, $this->_model->getCreditAvailable());
    }

    /** @test */
    public function testSetPurchaseStatus()
    {
        $this->_model->setPurchaseStatus(1);
        $result =  $this->_model->getPurchaseStatus();
        $this->_model->setPurchaseStatus(2);
        $this->assertNotEquals($result, $this->_model->getPurchaseStatus());
    }

    /** @test */
    public function testSetFile()
    {
        $this->_model->setFile("file");
        $result =  $this->_model->getFile();
        $this->_model->setFile("new file");
        $this->assertNotEquals($result, $this->_model->getFile());
    }

    /** @test */
    public function testSetDateOfResponse()
    {
        $this->_model->setDateOfResponse("2020-10-21");
        $result =  $this->_model->getDateOfResponse();
        $this->_model->setDateOfResponse("2020-10-22");
        $this->assertNotEquals($result, $this->_model->getDateOfResponse());
    }

    /** @test */
    public function testSetAllowablePurchaseTime()
    {
        $this->_model->setAllowablePurchaseTime("2020-10-21");
        $result =  $this->_model->getAllowablePurchaseTime();
        $this->_model->setAllowablePurchaseTime("2020-10-22");
        $this->assertNotEquals($result, $this->_model->getAllowablePurchaseTime());
    }

    /** @test */
    public function testSetReason()
    {
        $this->_model->setReason("reason");
        $result =  $this->_model->getReason();
        $this->_model->setReason("new reason");
        $this->assertNotEquals($result, $this->_model->getReason());
    }

    /** @test */
    public function testSetCreatedAt()
    {
        $this->_model->setCreatedAt("2020-10-21");
        $result =  $this->_model->getCreatedAt();
        $this->_model->setCreatedAt("2020-10-22");
        $this->assertNotEquals($result, $this->_model->getCreatedAt());
    }

    /** @test */
    public function testSetUpdatedAt()
    {
        $this->_model->setUpdatedAt("2020-10-21");
        $result =  $this->_model->getUpdatedAt();
        $this->_model->setUpdatedAt("2020-10-22");
        $this->assertNotEquals($result, $this->_model->getUpdatedAt());
    }
}
