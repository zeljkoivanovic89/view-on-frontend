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

namespace Nvendor\ViewOnFrontend\Ui\Component\Listing\Columns;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Store\Model\StoreManagerInterface;
use Nvendor\ViewOnFrontend\Helper\Url;

/**
 * Class ProductView
 *
 * Get store view and link for product view button
 */
class ProductView extends Column
{

    /** @var Url */
    private $helper;

    /** @var StoreManagerInterface */
    private $storeManager;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param Url $helper
     * @param StoreManagerInterface $storeManager
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Url $helper,
        StoreManagerInterface $storeManager,
        array $components = [],
        array $data = []
    ) {
        $this->helper       = $helper;
        $this->storeManager = $storeManager;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Preparing Data Source
     *
     * @param array $dataSource
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $store     = $this->getStore();
            $storeId   = $store->getId();
            $storeCode = $store->getCode();
            $key       = $this->getData('name');
            $title     = __('View');
            //get link with href with _blank to open in new tab
            foreach ($dataSource['data']['items'] as &$item) {
                $link = $this->helper->getProductUrl($item['entity_id'], $storeId, $storeCode);
                $html = '<a href="' . $link . '" target="_blank" onclick="window.open(this.href)">' . $title . '</a>';
                $item[$key] = $html;
            }
        }

        return $dataSource;
    }

    /**
     * Gets current store by store_id
     *
     * @return \Magento\Store\Api\Data\StoreInterface|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getStore()
    {
        $storeId   = $this->context->getFilterParam('store_id');
        if ($storeId) {
            return $this->storeManager->getStore($storeId);
        } else {
            return $this->storeManager->getDefaultStoreView();
        }
    }
}
