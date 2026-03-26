<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantProductGui\Communication\Plugin\ProductManagement;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductManagementExtension\Dependency\Plugin\ProductAbstractFormOptionsExpanderPluginInterface;

/**
 * @method \Spryker\Zed\MerchantProductGui\Communication\MerchantProductGuiCommunicationFactory getFactory()
 */
class MerchantProductAbstractFormOptionsExpanderPlugin extends AbstractPlugin implements ProductAbstractFormOptionsExpanderPluginInterface
{
    /**
     * {@inheritDoc}
     * - Provides merchant choices for the abstract product form.
     * - The `$productAbstractTransfer` is not used as merchant choices are loaded globally for all products.
     *
     * @api
     *
     * @param array<string, mixed> $formOptions
     *
     * @return array<string, mixed>
     */
    public function expand(array $formOptions, ProductAbstractTransfer $productAbstractTransfer): array
    {
        return $this->getFactory()->createMerchantProductAbstractFormExpander()->expandFormOptions($formOptions);
    }
}
