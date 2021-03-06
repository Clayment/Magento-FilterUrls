<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Core
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Flagbit_FilterUrls_Controller_Varien_Router_Standard extends Mage_Core_Controller_Varien_Router_Standard
{
    /**
     * Match the request
     *
     * @param Zend_Controller_Request_Http $request
     * @return boolean
     */
    public function match(Zend_Controller_Request_Http $request)
    {
        $match = parent::match($request);

        if ($request->getModuleName() === 'catalog' && $request->getControllerName() === 'category' && $request->getActionName() === 'view') {
            $redirect = Mage::getModel('filterurls/catalog_layer_filter_item')->getSpeakingFilterUrl(FALSE, TRUE);
            $redirectR = new Zend_Controller_Request_Http($redirect);
            /* @var $parser Flagbit_FilterUrls_Model_Parser */
            $identifier = trim($redirectR->getPathInfo(), '/');
            $parser = Mage::getModel('filterurls/parser');
            $parsedRequestInfo = $parser->parseFilterInformationFromRequest($identifier, Mage::app()->getStore()->getId());

            if ($parsedRequestInfo) {
                Mage::app()->getFrontController()->getResponse()
                    ->setRedirect($redirect, 301)
                    ->sendResponse();
                exit();
            }

        }

        return $match;
    }

}
