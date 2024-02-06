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

namespace Nvendor\ViewOnFrontend\Plugin\Catalog\Helper;

/**
 * Class Product
 *
 * check if product can have show button
 */
class Product
{

    /**
     * @var bool
     */
    private $overrideShow = false;

    /**
     * @var \Nvendor\ViewOnFrontend\Helper\Data
     */
    private $helper;

    /**
     * Product constructor.
     *
     * @param \Nvendor\ViewOnFrontend\Helper\Data $helper
     */
    public function __construct(\Nvendor\ViewOnFrontend\Helper\Data $helper)
    {
        $this->helper = $helper;
    }

    /**
     * Init product to be used for product controller actions and layouts
     *
     * @param \Magento\Catalog\Helper\Product $subject
     * @param \Closure $proceed
     * @param $productId
     * @param \Magento\Framework\App\Action\Action $controller
     * @param null $params
     * @return bool|\Magento\Catalog\Helper\Product
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundInitProduct(
        \Magento\Catalog\Helper\Product $subject,
        \Closure $proceed,
        $productId,
        \Magento\Framework\App\Action\Action $controller,
        $params = null
    ) {
        $isLink = $controller->getRequest()->getParam('viewlink', 0);
        if ($isLink && $this->helper->isAllowed()) {
            $this->overrideShow = true;
        }

        $product = $proceed($productId, $params);

        $this->overrideShow = false;

        return $product;
    }

    /**
     * Check if a product can be shown
     *
     * @param \Magento\Catalog\Helper\Product $subject
     * @param \Closure $proceed
     * @param \Magento\Catalog\Model\Product|int $product
     * @param string $where
     * @return bool
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundCanShow(
        \Magento\Catalog\Helper\Product $subject,
        \Closure $proceed,
        $product,
        $where = 'catalog'
    ) {
        if ($this->overrideShow) {
            return true;
        }

        return $proceed($product, $where);
    }
}
