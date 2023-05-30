<?php

namespace AlyonaKir\Credit\Test\Unit\Model\Mail;

use AlyonaKir\Credit\Model\Application\ApplicationRepository;
use AlyonaKir\Credit\Model\Application\ApplicationRepositoryFactory;
use AlyonaKir\Credit\Model\Credit\Credit;
use AlyonaKir\Credit\Model\Credit\CreditFactory;
use AlyonaKir\Credit\Model\Credit\CreditRepository;
use AlyonaKir\Credit\Model\Mail\TransportBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder as OriginalTransportBuilder;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Mail\Template\FactoryInterface;
use Magento\Framework\Mail\MessageInterface;
use Magento\Framework\Mail\Template\SenderResolverInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Mail\TransportInterfaceFactory;

/** @covers TransportBuilder */
class TestTransportBuilder extends TestCase
{
    protected TransportBuilder|MockObject $object;
    protected StateInterface|MockObject $inlineTranslation;
    protected Escaper|MockObject $escaper;
    protected OriginalTransportBuilder|MockObject $transportBuilder;
    protected CreditRepository|MockObject $creditRepository;
    protected CreditFactory|MockObject $creditFactory;
    protected ApplicationRepositoryFactory|MockObject $applicationRepositoryFactory;
    protected ManagerInterface|MockObject $messageManager;
    protected MessageInterface|MockObject $message;

    public function setUp(): void
    {
        $this->inlineTranslation = $this->getMockForAbstractClass(StateInterface::class);
        $this->escaper = $this->getMockBuilder(Escaper::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->transportBuilder = $this->getMockBuilder(OriginalTransportBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();
        $templateFactory = $this->getMockForAbstractClass(FactoryInterface::class);
        $this->message = $this->getMockForAbstractClass(MessageInterface::class);
        $senderResolver = $this->getMockForAbstractClass(SenderResolverInterface::class);
        $objectManager = $this->getMockForAbstractClass(ObjectManagerInterface::class);
        $mailTransportFactory = $this->getMockBuilder(TransportInterfaceFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->creditRepository = $this->getMockBuilder(CreditRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->creditFactory = $this->createPartialMock(
            CreditFactory::class,
            ['create']
        );

        $this->messageManager = $this->getMockBuilder(ManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->applicationRepositoryFactory = $this->createPartialMock(
            ApplicationRepositoryFactory::class,
            ['create']
        );

        $applicationMock = $this->getMockBuilder(ApplicationRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->applicationRepositoryFactory->expects($this->once())
            ->method('create')
            ->willReturn($applicationMock);

        $this->object = new TransportBuilder(
            $this->inlineTranslation,
            $this->escaper,
            $this->transportBuilder,
            $templateFactory,
            $this->message,
            $senderResolver,
            $objectManager,
            $mailTransportFactory,
            $this->applicationRepositoryFactory,
            $this->creditRepository,
            $this->creditFactory,
            $this->messageManager
        );

    }


    public function testGetMessage()
    {
        $this->message->setSubject("message");
        //$this->assertInstanceOf(MessageInterface::class, $this->object->getMessage());
    }

    public function testReset(){
        $this->assertInstanceOf(TransportBuilder::class, $this->object->reset());
    }

    public function testSendEmail(){
        $credit = $this->getMockBuilder(Credit::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->creditFactory->expects($this->once())
            ->method('create')
            ->willReturn($credit);
    }
}
