<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Test\Unit\Model;

use PHPUnit\Framework\TestCase;
use AlyonaKir\Credit\Model\Application\Application;

/**
 * @covers Application
 */
class TestApplicationModel extends TestCase
{
    protected $_model;
    protected $_objectManager;

    protected function setUp(): void
    {
        $this->_objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->_model = $this->_objectManager->getObject(Application::class);
    }

    /** @test */
    public function testGetApplicationId()
    {
        $this->_model->setApplicationId(1);
        $this->assertEquals(1, $this->_model->getApplicationId());
    }

    /** @test */
    public function testGetCreditAmount()
    {
        $this->_model->setCreditAmount(1);
        $this->assertEquals(1, $this->_model->getCreditAmount());
    }

    /** @test */
    public function testGetCustomerId()
    {
        $this->_model->setCustomerId(1);
        $this->assertEquals(1, $this->_model->getCustomerId());
    }

    /** @test */
    public function testGetFile()
    {
        $this->_model->setFile("/pub/upload");
        $this->assertEquals("/pub/upload", $this->_model->getFile());
    }

    /** @test */
    public function testGetSentAt()
    {
        $this->_model->setSentAt("2020-10-21");
        $this->assertEquals("2020-10-21", $this->_model->getSentAt());
    }

    /** @test */
    public function testGetFirstName()
    {
        $this->_model->setFirstName("John");
        $this->assertEquals("John", $this->_model->getFirstName());
    }

    /** @test */
    public function testGetLastName()
    {
        $this->_model->setLastName("Smith");
        $this->assertEquals("Smith", $this->_model->getLastName());
    }

    /** @test */
    public function testGetEmail()
    {
        $this->_model->setEmail("example@mail.com");
        $this->assertEquals("example@mail.com", $this->_model->getEmail());
    }

    /** @test */
    public function testGetPhone()
    {
        $this->_model->setPhone("8029-456-35-62");
        $this->assertEquals("8029-456-35-62", $this->_model->getPhone());
    }


    /** @test */
    public function testSetApplicationId()
    {
        $this->_model->setApplicationId(1);
        $result = $this->_model->getApplicationId();
        $this->_model->setApplicationId(2);
        $this->assertNotEquals($result, $this->_model->getApplicationId());
    }

    /** @test */
    public function testSetCustomerId()
    {
        $this->_model->setCustomerId(1);
        $result = $this->_model->getCustomerId();
        $this->_model->setCustomerId(2);
        $this->assertNotEquals($result, $this->_model->getCustomerId());
    }

    /** @test */
    public function testSetFile()
    {
        $this->_model->setFile("/pub/upload");
        $result = $this->_model->getFile();
        $this->_model->setFile("/pub/news");
        $this->assertNotEquals($result, $this->_model->getFile());
    }

    /** @test */
    public function testSetSentAt()
    {
        $this->_model->setSentAt("2020-10-21");
        $result = $this->_model->getSentAt();
        $this->_model->setSentAt("2020-10-22");
        $this->assertNotEquals($result, $this->_model->getSentAt());
    }

    /** @test */
    public function testSetCreditAmount()
    {
        $this->_model->setCreditAmount(30);
        $result = $this->_model->getCreditAmount();
        $this->_model->setCreditAmount(20);
        $this->assertNotEquals($result, $this->_model->getCreditAmount());
    }

    /** @test */
    public function testSetFirstName()
    {
        $this->_model->setFirstName("John");
        $result = $this->_model->getFirstName();
        $this->_model->setFirstName("Matt");
        $this->assertNotEquals($result, $this->_model->getFirstName());
    }

    /** @test */
    public function testSetLastName()
    {
        $this->_model->setLastName("Smith");
        $result = $this->_model->getLastName();
        $this->_model->setLastName("Brown");
        $this->assertNotEquals($result, $this->_model->getLastName());
    }

    /** @test */
    public function testSetEmail()
    {
        $this->_model->setEmail("example@mail.com");
        $result = $this->_model->getEmail();
        $this->_model->setEmail("john@mail.com");
        $this->assertNotEquals($result, $this->_model->getEmail());
    }

    /** @test */
    public function testSetPhone()
    {
        $this->_model->setPhone("8029-456-58-69");
        $result = $this->_model->getPhone();
        $this->_model->setPhone("8044-456-58-69");
        $this->assertNotEquals($result, $this->_model->getPhone());
    }
}
