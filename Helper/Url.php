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

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\UrlInterface;
use Magento\Store\Api\StoreResolverInterface;
use Magento\CatalogUrlRewrite\Model\ProductUrlRewriteGenerator;
use Magento\UrlRewrite\Service\V1\Data\UrlRewrite;
use Magento\UrlRewrite\Model\UrlFinderInterface;

/**
 * Class Url
 *
 * Get Product Url from admin to be displayed on frontend
 */
class Url extends AbstractHelper
{

    /** @var UrlInterface */
    private $frontendUrlModel;

    /** @var UrlFinderInterface */
    private $urlFinder;

    /**
     * Data constructor.
     *
     * @param Context $context
     * @param UrlInterface $frontendUrlModel
     * @param UrlFinderInterface $urlFinder
     */
    public function __construct(
        Context $context,
        UrlInterface $frontendUrlModel,
        UrlFinderInterface $urlFinder
    ) {
        $this->frontendUrlModel = $frontendUrlModel;
        $this->urlFinder        = $urlFinder;
        parent::__construct($context);
    }

    /**
     * Get product frontend URL
     *
     * @param int    $productId
     * @param int    $storeId
     * @param string $storeCode
     * @return string
     */
    public function getProductUrl($productId, $storeId, $storeCode)
    {
        $routeParams = [
            '_nosid'   => true,
            '_current' => false,
            '_query'   =>
                [
                    'viewlink'                         => 1,
                    StoreResolverInterface::PARAM_NAME => $storeCode
                ],
            'id' => $productId
        ];
        //set scope
        $this->frontendUrlModel->setScope($storeCode);
        //get rewrite
        $rewrites = $this->urlFinder->findAllByData([
            UrlRewrite::ENTITY_TYPE => ProductUrlRewriteGenerator::ENTITY_TYPE,
            UrlRewrite::ENTITY_ID => $productId,
            UrlRewrite::STORE_ID => $storeId,
        ]);

        if ($rewrites) {
            return $this->frontendUrlModel->getDirectUrl($rewrites[0]->getRequestPath(), $routeParams);
        }
        return $this->frontendUrlModel->getUrl('catalog/product/view', $routeParams);
    }
}
