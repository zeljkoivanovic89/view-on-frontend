<?php
/**
 *  Nvendor Group
 *
 *  This source file is subject to the Nvendor Software License, which is available at https://www.zeljkoivanovic.com/.
 *  Do not edit or add to this file if you wish to upgrade to the newer versions in the future.
 *  If you wish to customize this module for your needs,
 *  please refer to http://www.magentocommerce.com for more information.
 *
 *  @category  Nvendor
 *  @package   Nvendor_ViewOnFrontend
 *  @author    Zeljko Ivanovic <zeljko@zeljkoivanovic.com>
 *  @copyright Copyright (C) 2020 Nvendor (https://www.zeljkoivanovic.com/)
 *  @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 *  @link      https://www.zeljkoivanovic.com/
 *
 */

namespace Nvendor\ViewOnFrontend\Observer\Backend;

/**
 * Class Login
 *
 * Login constructor and set global acl cookie
 */
class Login implements \Magento\Framework\Event\ObserverInterface
{

    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    private $session;

    /**
     * @var \Nvendor\ViewOnFrontend\Helper\Data
     */
    private $helper;

    /**
     * Login constructor.
     *
     * @param \Nvendor\ViewOnFrontend\Helper\Data $helper
     * @param \Magento\Backend\Model\Auth\Session $authSession
     */
    public function __construct(
        \Nvendor\ViewOnFrontend\Helper\Data $helper,
        \Magento\Backend\Model\Auth\Session $authSession
    ) {
        $this->helper  = $helper;
        $this->session = $authSession;
    }

    /**
     * Set global acl cookie value
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        try {
            $allowed = $this->session->isAllowed('Nvendor_ViewOnFrontend::show_disabled');
            $this->helper->setAllowed($allowed);
        } catch (\Exception $e) {
            return;
        }
    }
}
