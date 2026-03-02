<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantProductGui\Communication\Expander;

use Generated\Shared\Transfer\MerchantProductCriteriaTransfer;
use Generated\Shared\Transfer\QueryCriteriaTransfer;
use Spryker\Zed\MerchantProductGui\Persistence\MerchantProductGuiRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

class MerchantProductQueryCriteriaExpander implements MerchantProductQueryCriteriaExpanderInterface
{
    /**
     * @var string
     */
    protected const URL_PARAM_ID_MERCHANT = 'id-merchant';

    /**
     * @var \Spryker\Zed\MerchantProductGui\Persistence\MerchantProductGuiRepositoryInterface
     */
    protected $merchantProductGuiRepository;

    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    public function __construct(
        MerchantProductGuiRepositoryInterface $merchantProductGuiRepository,
        Request $request
    ) {
        $this->merchantProductGuiRepository = $merchantProductGuiRepository;
        $this->request = $request;
    }

    public function expandQueryCriteria(QueryCriteriaTransfer $queryCriteriaTransfer): QueryCriteriaTransfer
    {
        $idMerchant = $this->request->get(static::URL_PARAM_ID_MERCHANT);

        if (!$idMerchant) {
            return $queryCriteriaTransfer;
        }

        return $this->merchantProductGuiRepository->expandQueryCriteriaTransferWithMerchantProductRelation(
            $queryCriteriaTransfer,
            (new MerchantProductCriteriaTransfer())->setIdMerchant($idMerchant),
        );
    }
}
