<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Controller\Adminhtml\Info;

use AlyonaKir\Credit\Model\Mail\TransportBuilder;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;

class Send extends Action
{

    private TransportBuilder $transportBuilder;

    public function __construct(
        Context          $context,
        TransportBuilder $transportBuilder
    )
    {
        parent::__construct($context);
        $this->transportBuilder = $transportBuilder;
    }

    public function execute(): Redirect
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = "";
        if (isset($_SESSION['id']) && $_SESSION['id'] != null) {
            $id = $_SESSION['id'];
        }
        $this->transportBuilder->sendEmail();
        return $resultRedirect->setPath('*/*/edit', ['id' => $id, '_current' => true]);
    }
}
