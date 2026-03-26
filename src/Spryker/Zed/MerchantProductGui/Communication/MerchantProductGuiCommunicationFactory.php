<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantProductGui\Communication;

use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Spryker\Zed\Merchant\Business\MerchantFacadeInterface;
use Spryker\Zed\MerchantProductGui\Communication\Expander\MerchantProductAbstractFormExpander;
use Spryker\Zed\MerchantProductGui\Communication\Expander\MerchantProductAbstractFormExpanderInterface;
use Spryker\Zed\MerchantProductGui\Communication\Expander\MerchantProductQueryCriteriaExpander;
use Spryker\Zed\MerchantProductGui\Communication\Expander\MerchantProductQueryCriteriaExpanderInterface;
use Spryker\Zed\MerchantProductGui\Communication\Expander\MerchantProductViewDataExpander;
use Spryker\Zed\MerchantProductGui\Communication\Expander\MerchantProductViewDataExpanderInterface;
use Spryker\Zed\MerchantProductGui\Dependency\Facade\MerchantProductGuiToMerchantProductFacadeInterface;
use Spryker\Zed\MerchantProductGui\MerchantProductGuiDependencyProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @method \Spryker\Zed\MerchantProductGui\Persistence\MerchantProductGuiRepositoryInterface getRepository()
 * @method \Spryker\Zed\MerchantProductGui\MerchantProductGuiConfig getConfig()
 */
class MerchantProductGuiCommunicationFactory extends AbstractCommunicationFactory
{
    public function createMerchantProductQueryCriteriaExpander(): MerchantProductQueryCriteriaExpanderInterface
    {
        return new MerchantProductQueryCriteriaExpander(
            $this->getRepository(),
            $this->getRequest(),
        );
    }

    public function createMerchantProductViewDataExpander(): MerchantProductViewDataExpanderInterface
    {
        return new MerchantProductViewDataExpander($this->getMerchantProductFacade());
    }

    public function getRequest(): Request
    {
        return $this->getRequestStack()->getCurrentRequest();
    }

    public function getRequestStack(): RequestStack
    {
        return $this->getProvidedDependency(MerchantProductGuiDependencyProvider::SERVICE_REQUEST_STACK);
    }

    public function getMerchantProductFacade(): MerchantProductGuiToMerchantProductFacadeInterface
    {
        return $this->getProvidedDependency(MerchantProductGuiDependencyProvider::FACADE_MERCHANT_PRODUCT);
    }

    public function getMerchantFacade(): MerchantFacadeInterface
    {
        return $this->getProvidedDependency(MerchantProductGuiDependencyProvider::FACADE_MERCHANT);
    }

    public function createMerchantProductAbstractFormExpander(): MerchantProductAbstractFormExpanderInterface
    {
        return new MerchantProductAbstractFormExpander(
            $this->getMerchantFacade(),
            $this->getMerchantProductFacade(),
            $this->getConfig(),
        );
    }
}
