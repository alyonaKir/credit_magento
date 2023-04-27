<?php
declare(strict_types=1);
namespace AlyonaKir\Credit\Model\PaymentMethod;
use AlyonaKir\Credit\Model\Application\ApplicationRepositoryFactory;
use AlyonaKir\Credit\Model\Credit\CreditRepositoryFactory;
use AlyonaKir\Credit\Model\Application\ApplicationRepository;
use AlyonaKir\Credit\Model\Credit\CreditRepository;
use AlyonaKir\Credit\Model\Credit\CreditFactory;
use Magento\Directory\Helper\Data as DirectoryHelper;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Payment\Helper\Data;
use Magento\Payment\Model\Method\Logger;
use Magento\Sales\Model\Order\Payment;
use Magento\Payment\Model\Method\AbstractMethod;


class CreditPayment extends AbstractMethod
{
    const CREDIT_PAYMENT_CODE = 'creditpayment';

    /**
     * Payment method code
     *
     * @var string
     */
    protected $_code = self::CREDIT_PAYMENT_CODE;

    /**
     * Custom payment block paths
     *
     * @var string
     */
    protected $_formBlockType = \AlyonaKir\Credit\Block\Form\CreditPayment::class;

    /**
     * Info instructions block path
     *
     * @var string
     */
    protected $_infoBlockType = \Magento\Payment\Block\Info\Instructions::class;

    /**
     * Availability option
     *
     * @var bool
     */
    protected $_isOffline = true;
    protected CreditRepository $creditRepository;
    protected CreditFactory $creditFactory;

    protected int $application;
    protected ApplicationRepository $applicationRepository;
    protected ManagerInterface $messageManager;

    public function __construct(
        CreditRepositoryFactory      $creditRepositoryFactory,
        ApplicationRepositoryFactory $applicationRepositoryFactory,
        CreditFactory                $creditFactory,
        ManagerInterface             $messageManager,
        Context                      $context,
        Registry                     $registry,
        ExtensionAttributesFactory   $extensionFactory,
        AttributeValueFactory        $customAttributeFactory,
        Data                         $paymentData,
        ScopeConfigInterface         $scopeConfig,
        Logger                       $logger,
        AbstractResource             $resource = null,
        AbstractDb                   $resourceCollection = null,
        array                        $data = [],
        DirectoryHelper              $directory = null
    )
    {
        $this->applicationRepository = $applicationRepositoryFactory->create();
        $this->creditFactory = $creditFactory;
        $this->messageManager = $messageManager;
        $this->creditRepository = $creditRepositoryFactory->create();
        if (isset($_SESSION['customer_base']['customer_id'])) {
            $this->application = $this->applicationRepository->getByCustomerId((int)$_SESSION['customer_base']['customer_id'])->getApplicationId();
        } else $this->application = 0;
        parent::__construct($context, $registry, $extensionFactory, $customAttributeFactory, $paymentData, $scopeConfig, $logger, $resource, $resourceCollection, $data, $directory);
    }


    public function canUseCheckout(): bool
    {

        $credit = $this->creditFactory->create();
        $credit = $this->creditRepository->getByApplicationId($this->application);

        if ($credit != null && $credit->getPurchaseStatus() == 2) {
            $this->_canUseCheckout = true;
        } else {
            $this->_canUseCheckout = false;
        }
        return $this->_canUseCheckout;
    }

    /**
     * Get instructions text from config
     *
     * @return string
     */
    public function getInstructions(): string
    {
        $credit = $this->creditFactory->create();
        $credit = $this->creditRepository->getByApplicationId($this->application);
        if ($credit != null) {
            return "Your available sum: " . (string)$credit->getCreditAvailable() . "$";
        } else {
            return "You do not have a credit";
        }
    }

    public function validate(): CreditPayment|static
    {
        $paymentInfo = $this->getInfoInstance();
        $credit = $this->creditFactory->create();
        $credit = $this->creditRepository->getByApplicationId($this->application);
        $last =  $credit->getCreditAvailable();
        if ($paymentInfo instanceof Payment) {
            if ($paymentInfo->getOrder()->getGrandTotal() > $last) {
                throw new \Exception("Dont have enough money.");
            }
            $last-=$paymentInfo->getOrder()->getGrandTotal();
            $credit->setCreditAvailable($last);
            $this->creditRepository->save($credit);
        }
        return $this;
    }
}
