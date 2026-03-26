<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantProductGui;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Merchant\Business\MerchantFacadeInterface;
use Spryker\Zed\MerchantProductGui\Dependency\Facade\MerchantProductGuiToMerchantProductFacadeBridge;

class MerchantProductGuiDependencyProvider extends AbstractBundleDependencyProvider
{
    public const string FACADE_MERCHANT_PRODUCT = 'FACADE_MERCHANT_PRODUCT';

    public const string FACADE_MERCHANT = 'FACADE_MERCHANT';

    /**
     * @uses \Spryker\Zed\Http\Communication\Plugin\Application\HttpApplicationPlugin::SERVICE_REQUEST_STACK
     *
     * @var string
     */
    public const SERVICE_REQUEST_STACK = 'request_stack';

    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        $container = $this->addRequestStack($container);
        $container = $this->addMerchantProductFacade($container);
        $container = $this->addMerchantFacade($container);

        return $container;
    }

    protected function addRequestStack(Container $container): Container
    {
        $container->set(static::SERVICE_REQUEST_STACK, function (Container $container) {
            return $container->getApplicationService(static::SERVICE_REQUEST_STACK);
        });

        return $container;
    }

    protected function addMerchantProductFacade(Container $container): Container
    {
        $container->set(static::FACADE_MERCHANT_PRODUCT, function (Container $container) {
            return new MerchantProductGuiToMerchantProductFacadeBridge(
                $container->getLocator()->merchantProduct()->facade(),
            );
        });

        return $container;
    }

    protected function addMerchantFacade(Container $container): Container
    {
        $container->set(static::FACADE_MERCHANT, function (Container $container): MerchantFacadeInterface {
            return $container->getLocator()->merchant()->facade();
        });

        return $container;
    }
}
