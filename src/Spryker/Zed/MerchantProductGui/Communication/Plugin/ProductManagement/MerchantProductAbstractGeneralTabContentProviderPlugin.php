<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantProductGui\Communication\Plugin\ProductManagement;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductManagementExtension\Dependency\Plugin\ProductAbstractFormTabContentProviderWithPriorityPluginInterface;

class MerchantProductAbstractGeneralTabContentProviderPlugin extends AbstractPlugin implements ProductAbstractFormTabContentProviderWithPriorityPluginInterface
{
    protected const string TAB_NAME = 'general';

    protected const int PRIORITY = 45;

    protected const string TEMPLATE_PATH = '@MerchantProductGui/Product/_partials/merchant-general-tab.twig';

    /**
     * {@inheritDoc}
     * - Returns 'general' as the target tab name.
     *
     * @api
     *
     * @return string
     */
    public function getTabName(): string
    {
        return static::TAB_NAME;
    }

    /**
     * {@inheritDoc}
     * - Returns the rendering priority within the general tab.
     *
     * @api
     *
     * @return int
     */
    public function getPriority(): int
    {
        return static::PRIORITY;
    }

    /**
     * {@inheritDoc}
     * - Provides merchant selection field template to be displayed in the general tab.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer|null $productAbstractTransfer
     *
     * @return array<string>
     */
    public function provideTabContent(?ProductAbstractTransfer $productAbstractTransfer = null): array
    {
        return [static::TEMPLATE_PATH];
    }
}
