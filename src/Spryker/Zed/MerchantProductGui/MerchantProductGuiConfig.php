<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantProductGui;

use Spryker\Zed\Kernel\AbstractBundleConfig;

class MerchantProductGuiConfig extends AbstractBundleConfig
{
    protected const int PRODUCT_FORM_MERCHANT_DROPDOWN_LIMIT = 100;

    /**
     * Specification:
     * - Returns the maximum number of active merchants fetched for the product form merchant dropdown.
     *
     * @api
     */
    public function getProductFormMerchantSelectLimit(): int
    {
        return static::PRODUCT_FORM_MERCHANT_DROPDOWN_LIMIT;
    }
}
