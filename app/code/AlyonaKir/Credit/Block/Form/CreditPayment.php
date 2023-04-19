<?php
declare(strict_types=1);
namespace AlyonaKir\Credit\Block\Form;
use Magento\OfflinePayments\Block\Form\AbstractInstruction;

class CreditPayment extends AbstractInstruction
{
    /**
     * Custom payment template
     *
     * @var string
     */
    protected $_template = 'AlyonaKir_Credit::form/creditpayment.phtml';
}
