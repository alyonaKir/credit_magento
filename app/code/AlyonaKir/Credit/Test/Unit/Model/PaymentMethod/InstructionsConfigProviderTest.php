<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Test\Unit\Model\PaymentMethod;

use AlyonaKir\Credit\Model\PaymentMethod\CreditPayment;
use AlyonaKir\Credit\Model\PaymentMethod\InstructionsConfigProvider;
use Magento\Framework\Escaper;
use Magento\Payment\Helper\Data as PaymentHelper;
use PHPUnit\Framework\TestCase;

/** @covers InstructionsConfigProvider */
class TestInstructionsConfigProvider extends TestCase
{
    /** @test */
    public function testGetConfig(): void
    {
        $paymentHelper = $this->createMock(PaymentHelper::class);
        $escaper = $this->createMock(Escaper::class);
        $escaper->method('escapeHtml')->willReturnArgument(0);
        $creditPayment = $this->createMock(CreditPayment::class);
        $creditPayment->method('getInstructions')->willReturn('Some instructions');
        $creditPayment->method('isAvailable')->willReturn(true);
        $paymentHelper->method('getMethodInstance')->willReturn($creditPayment);
        $configProvider = new InstructionsConfigProvider($paymentHelper, $escaper);
        $expectedConfig = [
            'payment' => [
                'instructions' => [
                    'creditpayment' => 'Some instructions',
                ],
            ],
        ];
        $this->assertSame($expectedConfig, $configProvider->getConfig());
    }

}
