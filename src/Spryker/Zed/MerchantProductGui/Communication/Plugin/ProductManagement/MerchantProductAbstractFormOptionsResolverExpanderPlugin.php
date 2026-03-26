<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantProductGui\Communication\Plugin\ProductManagement;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductManagementExtension\Dependency\Plugin\ProductAbstractFormOptionsResolverExpanderPluginInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @method \Spryker\Zed\MerchantProductGui\Communication\MerchantProductGuiCommunicationFactory getFactory()
 */
class MerchantProductAbstractFormOptionsResolverExpanderPlugin extends AbstractPlugin implements ProductAbstractFormOptionsResolverExpanderPluginInterface
{
    /**
     * {@inheritDoc}
     * - Registers the merchant choices option in the abstract product form options resolver.
     *
     * @api
     */
    public function expand(OptionsResolver $resolver): OptionsResolver
    {
        return $this->getFactory()->createMerchantProductAbstractFormExpander()->expandOptionsResolver($resolver);
    }
}
