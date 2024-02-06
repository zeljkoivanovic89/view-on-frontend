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

namespace Nvendor\ViewOnFrontend\Plugin\Catalog\Helper\Product;

/**
 * Class View
 *
 * before and after execute controller action
 */
class View
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    /**
     * Product constructor.
     *
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(\Magento\Framework\Registry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * Execute controller action
     *
     * @param \Magento\Catalog\Controller\Product\View $subject
     * @param \Magento\Framework\Controller\Result\Forward|\Magento\Framework\Controller\Result\Redirect $result
     * @return \Magento\Framework\Controller\Result\Forward|\Magento\Framework\Controller\Result\Redirect
     */
    public function afterExecute(
        \Magento\Catalog\Controller\Product\View $subject,
        $result
    ) {
        $isLink = $subject->getRequest()->getParam('viewlink', 0);
        if ($isLink) {
            $result->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0', true);
        }

        return $result;
    }

    /**
     * Execute controller action
     *
     * @param \Magento\Catalog\Controller\Product\View $subject
     * @return array
     */
    public function beforeExecute(
        \Magento\Catalog\Controller\Product\View $subject
    ) {
        //get link if link disable cache in registry for that product
        $isLink = $subject->getRequest()->getParam('viewlink', 0);
        if ($isLink) {
            $this->registry->register('nvendor_disable_layout_cache', true);
        }

        return [];
    }
}
