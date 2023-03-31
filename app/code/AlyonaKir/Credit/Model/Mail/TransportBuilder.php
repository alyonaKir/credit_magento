<?php

namespace AlyonaKir\Credit\Model\Mail;

use AlyonaKir\Credit\Model\Credit\CreditRepository;
use AlyonaKir\Credit\Model\Credit\CreditFactory;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\AddressConverter;
use Magento\Framework\Mail\EmailMessageInterfaceFactory;
use Magento\Framework\Mail\MessageInterface;
use Magento\Framework\Mail\MessageInterfaceFactory;
use Magento\Framework\Mail\MimeMessageInterfaceFactory;
use Magento\Framework\Mail\MimePartInterfaceFactory;
use Magento\Framework\Mail\Template\FactoryInterface;
use Magento\Framework\Mail\Template\SenderResolverInterface;
use Magento\Framework\Mail\TransportInterfaceFactory;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Translate\Inline\StateInterface;

class TransportBuilder extends \Magento\Framework\Mail\Template\TransportBuilder
{
    protected $inlineTranslation;
    protected $escaper;
    protected $transportBuilder;
    protected $logger;
    private $creditRepository;
    private $creditFactory;
    protected $_customerRepositoryInterface;
    public function __construct(
        StateInterface                                    $inlineTranslation,
        Escaper                                           $escaper,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        FactoryInterface                                  $templateFactory,
        MessageInterface                                  $message,
        SenderResolverInterface                           $senderResolver,
        ObjectManagerInterface                            $objectManager,
        TransportInterfaceFactory                         $mailTransportFactory,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        CreditRepository                                  $creditRepository,
        CreditFactory                                     $creditFactory

    )
    {
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        $this->creditFactory = $creditFactory;
        $this->creditRepository = $creditRepository;
        $this->inlineTranslation = $inlineTranslation;
        $this->escaper = $escaper;
        $this->transportBuilder = $transportBuilder;
        parent::__construct($templateFactory, $message, $senderResolver, $objectManager, $mailTransportFactory);
    }


    public function getMessage()
    {
        return $this->message;
    }

    public function reset()
    {
        return parent::reset();
    }

    public function sendEmail()
    {
        $credit = $this->creditFactory->create();
        $credit = $this->creditRepository->getById((int)$_SESSION['id']);
        //$customer = $this->_customerRepositoryInterface->getById((int)$credit->getUserId());
        //$email = $customer->getEmail();
        $email = "mandarinkaizvinsaida@gmail.com";
        try {
            $this->inlineTranslation->suspend();
            $sender = [
                'name' => $this->escaper->escapeHtml('Test'),
                'email' => $this->escaper->escapeHtml('mandarinkaizvinsaida@gmail.com'),
            ];
            $transport = $this->transportBuilder
                ->setTemplateIdentifier('credit_email_template')
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars([
                    'templateVar' => 'Credit Info',
                    'firstName' => 'First',
                    'lastName' => 'Last',
                    'status' => $credit->getPurchaseStatus(),
                    'reason' => $credit->getReason()
                ])
                ->setFrom($sender)
                ->addTo($email)
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
//            $this->logger->debug($e->getMessage());
        }
    }
}
