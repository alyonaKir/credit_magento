<?php

namespace AlyonaKir\Credit\Model;

use AlyonaKir\Credit\Model\Application\ApplicationRepository;
use AlyonaKir\Credit\Model\Credit\CreditRepository;
use AlyonaKir\Credit\Model\Credit\CreditRepositoryFactory;
use AlyonaKir\Credit\Model\Credit\CreditFactory;
use AlyonaKir\Credit\Model\Application\ApplicationRepositoryFactory;
use Magento\Directory\Helper\Data as DirectoryHelper;
use Magento\Payment\Model\Method\AbstractMethod;
use Magento\Payment\Model\Method\Logger;
use Magento\Sales\Model\Order\Payment;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Payment\Helper\Data;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Data\Collection\AbstractDb;

class PaymentMethod extends AbstractMethod
{
    /**
     * Payment code
     *
     * @var string
     */
    protected $_code = 'credit_payment';
    protected $_canUseCheckout;

    protected CreditRepository $creditRepository;
    protected CreditFactory $creditFactory;

    protected ApplicationRepository $applicationRepository;

    public function __construct(
        CreditRepositoryFactory      $creditRepositoryFactory,
        ApplicationRepositoryFactory $applicationRepositoryFactory,
        CreditFactory                $creditFactory,
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
        $this->creditRepository = $creditRepositoryFactory->create();
        parent::__construct($context, $registry, $extensionFactory, $customAttributeFactory, $paymentData, $scopeConfig, $logger, $resource, $resourceCollection, $data, $directory);
    }

    public function canUseCheckout(): bool
    {
        $application = $this->applicationRepository->getByCustomerId((int)$_SESSION['customer_base']['customer_id'])->getApplicationId();
        $credit = $this->creditFactory->create();
        $credit = $this->creditRepository->getByApplicationId($application);

        if ($credit->getPurchaseStatus() == 2) {
            $this->_canUseCheckout = true;
        } else {
            $this->_canUseCheckout = false;
        }
        return $this->_canUseCheckout;
    }

    public function validate(): PaymentMethod|static
    {
        /**
         * to validate payment method is allowed for billing country or not
         */
        $paymentInfo = $this->getInfoInstance();
        if ($paymentInfo instanceof Payment) {
            $billingCountry = $paymentInfo->getOrder()->getBillingAddress()->getCountryId();
        } else {
            $billingCountry = $paymentInfo->getQuote()->getBillingAddress()->getCountryId();
        }
        $billingCountry = $billingCountry ?: $this->directory->getDefaultCountry();

        if (!$this->canUseForCountry($billingCountry)) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('You can\'t use the payment type you selected to make payments to the billing country.')
            );
        }
        return $this;
    }
}

