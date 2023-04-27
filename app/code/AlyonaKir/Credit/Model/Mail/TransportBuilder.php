<?php

namespace AlyonaKir\Credit\Model\Mail;

use AlyonaKir\Credit\Model\Application\ApplicationRepositoryFactory;
use AlyonaKir\Credit\Model\Application\ApplicationRepository;
use AlyonaKir\Credit\Model\Credit\CreditRepository;
use AlyonaKir\Credit\Model\Credit\CreditFactory;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\MessageInterface;
use Magento\Framework\Mail\Template\FactoryInterface;
use Magento\Framework\Mail\Template\SenderResolverInterface;
use Magento\Framework\Mail\TransportInterfaceFactory;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Mail\Template\TransportBuilder as OriginalTransportBuilder;

class TransportBuilder extends \Magento\Framework\Mail\Template\TransportBuilder
{
    protected StateInterface $inlineTranslation;
    protected Escaper $escaper;
    protected OriginalTransportBuilder $transportBuilder;
    private CreditRepository $creditRepository;
    private CreditFactory $creditFactory;
    protected ApplicationRepository $applicationRepository;
    protected ManagerInterface $messageManager;

    public function __construct(
        StateInterface               $inlineTranslation,
        Escaper                      $escaper,
        OriginalTransportBuilder     $transportBuilder,
        FactoryInterface             $templateFactory,
        MessageInterface             $message,
        SenderResolverInterface      $senderResolver,
        ObjectManagerInterface       $objectManager,
        TransportInterfaceFactory    $mailTransportFactory,
        ApplicationRepositoryFactory $applicationRepositoryFactory,
        CreditRepository             $creditRepository,
        CreditFactory                $creditFactory,
        ManagerInterface             $messageManager

    )
    {
        $this->creditFactory = $creditFactory;
        $this->creditRepository = $creditRepository;
        $this->applicationRepository = $applicationRepositoryFactory->create();
        $this->inlineTranslation = $inlineTranslation;
        $this->escaper = $escaper;
        $this->transportBuilder = $transportBuilder;
        $this->messageManager = $messageManager;
        parent::__construct($templateFactory, $message, $senderResolver, $objectManager, $mailTransportFactory);
    }


    public function getMessage(): MessageInterface
    {
        return $this->message;
    }

    public function reset(): TransportBuilder
    {
        return parent::reset();
    }

    public function sendEmail(int $applicationId, int $creditId): void
    {
        $credit = $this->creditFactory->create();
        $application = $this->applicationRepository->getById($applicationId);
        $credit = $this->creditRepository->getById((int)$creditId);
        try {
            $this->inlineTranslation->suspend();
            $sender = [
                'name' => $this->escaper->escapeHtml('Admin'),
                'email' => $this->escaper->escapeHtml('admin@magento.com'),
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
                    'firstName' => $application->getFirstName(),
                    'lastName' => $application->getLastName(),
                    'status' => $credit->getPurchaseStatus(),
                    'reason' => $credit->getReason()
                ])
                ->setFrom($sender)
                ->addTo($application->getEmail())
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();
            $this->messageManager->addSuccessMessage("Email was send to the client");
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage("Something went wrong: ".$e);
        }
    }
}
