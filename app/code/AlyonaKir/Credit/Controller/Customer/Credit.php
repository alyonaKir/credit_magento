<?php

namespace AlyonaKir\Credit\Controller\Customer;

use Magento\Framework\App\ActionInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Credit implements ActionInterface
{

    protected PageFactory $_pageFactory;
    protected $messageManager;

    public function __construct(
        PageFactory      $pageFactory,

        ManagerInterface $messageManager,
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->messageManager = $messageManager;
    }

    public function execute(): Page
    {
        return $this->_pageFactory->create();
    }

}
