<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantProductGui\Communication\Expander;

use Generated\Shared\Transfer\MerchantCriteriaTransfer;
use Generated\Shared\Transfer\MerchantProductCriteriaTransfer;
use Generated\Shared\Transfer\PaginationTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Zed\Merchant\Business\MerchantFacadeInterface;
use Spryker\Zed\MerchantProductGui\Dependency\Facade\MerchantProductGuiToMerchantProductFacadeInterface;
use Spryker\Zed\MerchantProductGui\MerchantProductGuiConfig;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MerchantProductAbstractFormExpander implements MerchantProductAbstractFormExpanderInterface
{
    protected const string FORM_FIELD_ID_MERCHANT = 'idMerchant';

    protected const string FORM_OPTION_MERCHANT_CHOICES = 'merchantChoices';

    protected const string LABEL_MERCHANT = 'Merchant';

    protected const string LABEL_NOT_ASSIGNED = 'Not assigned';

    public function __construct(
        protected MerchantFacadeInterface $merchantFacade,
        protected MerchantProductGuiToMerchantProductFacadeInterface $merchantProductFacade,
        protected MerchantProductGuiConfig $config,
    ) {
    }

    public function expandOptionsResolver(OptionsResolver $resolver): OptionsResolver
    {
        $resolver->setRequired(static::FORM_OPTION_MERCHANT_CHOICES);

        return $resolver;
    }

    /**
     * @param array<string, mixed> $formOptions
     *
     * @return array<string, mixed>
     */
    public function expandFormOptions(array $formOptions): array
    {
        $merchantCollectionTransfer = $this->merchantFacade->get(
            (new MerchantCriteriaTransfer())
                ->setIsActive(true)
                ->setWithExpanders(false)
                ->setPagination((new PaginationTransfer())->setLimit($this->config->getProductFormMerchantSelectLimit())->setOffset(0)),
        );

        $merchantChoices = [];
        foreach ($merchantCollectionTransfer->getMerchants() as $merchantTransfer) {
            $merchantChoices[(string)$merchantTransfer->getName()] = $merchantTransfer->getIdMerchant();
        }

        $formOptions[static::FORM_OPTION_MERCHANT_CHOICES] = $merchantChoices;

        return $formOptions;
    }

    /**
     * @param array<string, mixed> $formData
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return array<string, mixed>
     */
    public function expandFormData(array $formData, ProductAbstractTransfer $productAbstractTransfer): array
    {
        if (!$productAbstractTransfer->getIdProductAbstract()) {
            return $formData;
        }

        $merchantTransfer = $this->merchantProductFacade->findMerchant(
            (new MerchantProductCriteriaTransfer())->setIdProductAbstract($productAbstractTransfer->getIdProductAbstract()),
        );

        if ($merchantTransfer !== null) {
            $formData[static::FORM_FIELD_ID_MERCHANT] = $merchantTransfer->getIdMerchant();
        }

        return $formData;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return \Symfony\Component\Form\FormBuilderInterface
     */
    public function expandForm(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        if (!$builder->hasOption(static::FORM_OPTION_MERCHANT_CHOICES)) {
            return $builder;
        }

        $builder->add(static::FORM_FIELD_ID_MERCHANT, ChoiceType::class, [
            'label' => static::LABEL_MERCHANT,
            'choices' => $options[static::FORM_OPTION_MERCHANT_CHOICES] ?? [],
            'required' => false,
            'placeholder' => static::LABEL_NOT_ASSIGNED,
            'multiple' => false,
            'attr' => [
                'class' => 'spryker-form-select2combobox',
                'data-clearable' => true,
            ],
        ]);

        return $builder;
    }
}
