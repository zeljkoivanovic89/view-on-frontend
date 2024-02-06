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

namespace Nvendor\ViewOnFrontend\Block\Adminhtml\Product\Edit\Button;

use Magento\Ui\Component\Control\Container;
use Magento\Catalog\Block\Adminhtml\Product\Edit\Button\Generic;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\UiComponent\Context;
use Magento\Store\Model\StoreManagerInterface;
use Nvendor\ViewOnFrontend\Helper\Url as UrlHelper;

/**
 * Class View
 *
 * Retrieve options and button for view
 */
class View extends Generic
{

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var UrlHelper
     */
    private $urlHelper;

    /**
     * View constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param StoreManagerInterface $storeManager
     * @param UrlHelper $urlHelper
     */
    public function __construct(
        Context $context,
        Registry $registry,
        StoreManagerInterface $storeManager,
        UrlHelper $urlHelper
    ) {
        $this->storeManager = $storeManager;
        $this->urlHelper    = $urlHelper;
        parent::__construct($context, $registry);
    }

    /**
     * Getter button data
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label'      => __('View'),
            'class'      => 'frontend-link',
            'class_name' => Container::SPLIT_BUTTON,
            'options'    => $this->getOptions(),
            'sort_order' => 1
        ];
    }

    /**
     * Retrieves options
     *
     * @return array
     */
    private function getOptions()
    {
        $options      = [];
        $product      = $this->getProduct();
        $storeIds     = $product->getStoreIds();
        $storeList    = $this->storeManager->getStores();
        $defaultStore = $this->storeManager->getDefaultStoreView();

        foreach ($storeList as $store) {
            if (!in_array($store->getId(), $storeIds)) {
                continue;
            }
            $onclick = sprintf(
                "window.open('%s', 'store_view_%s');",
                $this->urlHelper->getProductUrl($product->getId(), $store->getId(), $store->getCode()),
                $store->getCode()
            );
            $options[] = [
                'label'   => $store->getName(),
                'onclick' => $onclick,
                'class'   => 'frontend-link',
                'default' => $defaultStore && $defaultStore->getCode() == $store->getCode()
            ];
        }
        return $options;
    }
}
