<?php
declare(strict_types=1);

namespace AlyonaKir\Credit\Controller\Adminhtml\Info;

use AlyonaKir\Credit\Model\Credit\CreditRepository;
use AlyonaKir\Credit\Model\Credit\CreditRepositoryFactory;
use Magento\Backend\App\Action\Context;
use AlyonaKir\Credit\Model\Credit\CreditFactory;
use Magento\Framework\Registry;
use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Action implements HttpGetActionInterface
{
    protected ?Registry $_coreRegistry = null;
    protected $_publicActions = ['edit'];

    protected CreditRepository $creditRepository;
    protected CreditFactory $creditFactory;
    private PageFactory $pageFactory;


    public function __construct(
        Context                 $context,
        Registry                $coreRegistry,
        CreditRepositoryFactory $creditRepositoryFactory,
        CreditFactory           $creditFactory,
        PageFactory             $pageFactory
    )
    {
        $this->creditRepository = $creditRepositoryFactory->create();
        $this->creditFactory = $creditFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->pageFactory = $pageFactory;
        parent::__construct($context);
    }

    public function execute()
    {

        $creditId = (int)$this->getRequest()->getParam('id');
        $credit = $this->creditFactory->create();
        if ($creditId) {
            try {
                $item = $this->creditRepository->getById($creditId);
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addError(__('This item no longer exists.'));
                $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                $resultRedirect->setPath('*/*/');
                return $resultRedirect;
            }
        } else {
            $credit = $this->creditFactory->create();
        }

        $this->_coreRegistry->register('credit_form', $credit);

        $resultPage = $this->pageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Edit'));
        $_SESSION['id'] = $creditId;
        return $resultPage;
    }

}
