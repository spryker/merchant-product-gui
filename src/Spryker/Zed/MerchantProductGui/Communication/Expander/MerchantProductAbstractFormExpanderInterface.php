<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantProductGui\Communication\Expander;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

interface MerchantProductAbstractFormExpanderInterface
{
    public function expandOptionsResolver(OptionsResolver $resolver): OptionsResolver;

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return \Symfony\Component\Form\FormBuilderInterface
     */
    public function expandForm(FormBuilderInterface $builder, array $options): FormBuilderInterface;

    /**
     * @param array<string, mixed> $formOptions
     *
     * @return array<string, mixed>
     */
    public function expandFormOptions(array $formOptions): array;

    /**
     * @param array<string, mixed> $formData
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return array<string, mixed>
     */
    public function expandFormData(array $formData, ProductAbstractTransfer $productAbstractTransfer): array;
}
