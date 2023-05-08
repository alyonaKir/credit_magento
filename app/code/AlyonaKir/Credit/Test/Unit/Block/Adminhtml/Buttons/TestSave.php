<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Test\Unit\Block\Adminhtml\Buttons;

use AlyonaKir\Credit\Block\Adminhtml\Buttons\Save;
use Magento\Backend\Block\Widget\Context;
use PHPUnit\Framework\TestCase;

class TestSave extends TestCase
{
    private $saveButton;
    private $context;

    protected function setUp(): void
    {
        $this->context = $this->createMock(Context::class);
        $this->saveButton = new Save($this->context);
    }

    public function testGetButtonData()
    {
        $buttonData = $this->saveButton->getButtonData();

        $this->assertIsArray($buttonData);
        $this->assertArrayHasKey('label', $buttonData);
        $this->assertArrayHasKey('class', $buttonData);
        $this->assertArrayHasKey('data_attribute', $buttonData);
        $this->assertArrayHasKey('mage-init', $buttonData['data_attribute']);
        $this->assertArrayHasKey('form-role', $buttonData['data_attribute']);
        $this->assertArrayHasKey('sort_order', $buttonData);
        $this->assertEquals(__('Save'), $buttonData['label']);
        $this->assertEquals('save primary', $buttonData['class']);
        $this->assertEquals(['button' => ['event' => 'save']], $buttonData['data_attribute']['mage-init']);
        $this->assertEquals('save', $buttonData['data_attribute']['form-role']);
        $this->assertEquals(90, $buttonData['sort_order']);
    }
}
