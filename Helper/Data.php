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

namespace Nvendor\ViewOnFrontend\Helper;

/**
 * Class Data
 *
 * Main helper data for functions
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     *  Constant variable
     */
    const COOKIE_NAME = 'nvendor_product_view';

    /**
     * @var \Magento\Framework\Stdlib\CookieManagerInterface
     */
    private $manager;

    /**
     * @var \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory
     */
    private $metadataFactory;

    /**
     * Data constructor.
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager
     * @param \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $metadataFactory
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager,
        \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $metadataFactory
    ) {
        parent::__construct($context);
        $this->manager = $cookieManager;
        $this->metadataFactory = $metadataFactory;
    }

    /**
     * Set allowed flag
     *
     * @param boolean $value
     * @return void
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Stdlib\Cookie\CookieSizeLimitReachedException
     * @throws \Magento\Framework\Stdlib\Cookie\FailureToSendException
     */
    public function setAllowed($value)
    {
        //create sensitive cookie metadata
        $cookieMetadata = $this->metadataFactory->createSensitiveCookieMetadata()
                                                ->setPath('/');
        $this->manager->setSensitiveCookie(
            \Nvendor\ViewOnFrontend\Helper\Data::COOKIE_NAME,
            (int)$value,
            $cookieMetadata
        );
    }

    /**
     * Check if access is allowed.
     *
     * @return bool
     */
    public function isAllowed()
    {
        return (bool)$this->manager->getCookie(\Nvendor\ViewOnFrontend\Helper\Data::COOKIE_NAME, 0);
    }
}
