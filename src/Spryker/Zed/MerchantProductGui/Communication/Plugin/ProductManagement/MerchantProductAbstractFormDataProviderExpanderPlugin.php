<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantProductGui\Communication\Plugin\ProductManagement;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductManagementExtension\Dependency\Plugin\ProductAbstractFormDataProviderExpanderPluginInterface;

/**
 * @method \Spryker\Zed\MerchantProductGui\Communication\MerchantProductGuiCommunicationFactory getFactory()
 */
class MerchantProductAbstractFormDataProviderExpanderPlugin extends AbstractPlugin implements ProductAbstractFormDataProviderExpanderPluginInterface
{
    /**
     * {@inheritDoc}
     * - Expands form data with `idMerchant` of the merchant assigned to the abstract product.
     * - Requires `ProductAbstractTransfer.idProductAbstract` to be set.
     *
     * @api
     *
     * @param array<string, mixed> $formData
     *
     * @return array<string, mixed>
     */
    public function expand(array $formData, ProductAbstractTransfer $productAbstractTransfer): array
    {
        return $this->getFactory()->createMerchantProductAbstractFormExpander()->expandFormData($formData, $productAbstractTransfer);
    }
}
