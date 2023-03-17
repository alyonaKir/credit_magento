<?php
declare(strict_types=1);
namespace AlyonaKir\Credit\Controller\Adminhtml\Info;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{
    protected PageFactory $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute(): Page
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('AlyonaKir_Credit::module');
        $resultPage->getConfig()->getTitle()->prepend((__('Credit info')));
        $_SESSION['id'] = null;
        return $resultPage;
    }
}
