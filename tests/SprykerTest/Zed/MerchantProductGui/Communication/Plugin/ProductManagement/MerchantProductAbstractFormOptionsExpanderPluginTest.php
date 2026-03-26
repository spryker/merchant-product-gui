<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\MerchantProductGui\Communication\Plugin\ProductManagement;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\MerchantCollectionTransfer;
use Generated\Shared\Transfer\MerchantCriteriaTransfer;
use Generated\Shared\Transfer\MerchantProductCriteriaTransfer;
use Generated\Shared\Transfer\MerchantTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Zed\Merchant\Business\MerchantFacadeInterface;
use Spryker\Zed\MerchantProductGui\Communication\Expander\MerchantProductAbstractFormExpander;
use Spryker\Zed\MerchantProductGui\Dependency\Facade\MerchantProductGuiToMerchantProductFacadeInterface;
use Spryker\Zed\MerchantProductGui\MerchantProductGuiConfig;
use SprykerTest\Zed\MerchantProductGui\MerchantProductGuiCommunicationTester;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group MerchantProductGui
 * @group Communication
 * @group Plugin
 * @group ProductManagement
 * @group MerchantProductAbstractFormOptionsExpanderPluginTest
 * Add your own group annotations below this line
 */
class MerchantProductAbstractFormOptionsExpanderPluginTest extends Unit
{
    /**
     * @var \SprykerTest\Zed\MerchantProductGui\MerchantProductGuiCommunicationTester
     */
    protected MerchantProductGuiCommunicationTester $tester;

    public function testExpandFormOptionsPopulatesMerchantChoices(): void
    {
        // Arrange
        $merchantTransfer1 = (new MerchantTransfer())->setIdMerchant(1)->setName('Merchant One');
        $merchantTransfer2 = (new MerchantTransfer())->setIdMerchant(2)->setName('Merchant Two');

        $merchantCollectionTransfer = (new MerchantCollectionTransfer())
            ->setMerchants(new ArrayObject([$merchantTransfer1, $merchantTransfer2]));

        $merchantFacadeMock = $this->createMock(MerchantFacadeInterface::class);
        $merchantFacadeMock
            ->method('get')
            ->with($this->isInstanceOf(MerchantCriteriaTransfer::class))
            ->willReturn($merchantCollectionTransfer);

        $merchantProductFacadeMock = $this->createMock(MerchantProductGuiToMerchantProductFacadeInterface::class);

        $expander = new MerchantProductAbstractFormExpander($merchantFacadeMock, $merchantProductFacadeMock, new MerchantProductGuiConfig());

        // Act
        $formOptions = $expander->expandFormOptions([]);

        // Assert
        $this->assertArrayHasKey('merchantChoices', $formOptions);
        $this->assertSame(['Merchant One' => 1, 'Merchant Two' => 2], $formOptions['merchantChoices']);
    }

    public function testExpandFormOptionsOnlyFetchesActiveMerchants(): void
    {
        // Arrange
        $merchantTransfer = (new MerchantTransfer())->setIdMerchant(1)->setName('Active Merchant');

        $merchantCollectionTransfer = (new MerchantCollectionTransfer())
            ->setMerchants(new ArrayObject([$merchantTransfer]));

        $merchantFacadeMock = $this->createMock(MerchantFacadeInterface::class);
        $merchantFacadeMock
            ->expects($this->once())
            ->method('get')
            ->with($this->callback(static function (MerchantCriteriaTransfer $criteria): bool {
                return $criteria->getIsActive() === true;
            }))
            ->willReturn($merchantCollectionTransfer);

        $merchantProductFacadeMock = $this->createMock(MerchantProductGuiToMerchantProductFacadeInterface::class);

        $expander = new MerchantProductAbstractFormExpander($merchantFacadeMock, $merchantProductFacadeMock, new MerchantProductGuiConfig());

        // Act
        $formOptions = $expander->expandFormOptions([]);

        // Assert
        $this->assertSame(['Active Merchant' => 1], $formOptions['merchantChoices']);
    }

    public function testExpandPreSelectsMerchantWhenProductAbstractHasExistingAssignment(): void
    {
        // Arrange
        $merchantCollectionTransfer = (new MerchantCollectionTransfer())
            ->setMerchants(new ArrayObject());

        $merchantFacadeMock = $this->createMock(MerchantFacadeInterface::class);
        $merchantFacadeMock->method('get')->willReturn($merchantCollectionTransfer);

        $assignedMerchantTransfer = (new MerchantTransfer())->setIdMerchant(42)->setName('Assigned Merchant');

        $merchantProductFacadeMock = $this->createMock(MerchantProductGuiToMerchantProductFacadeInterface::class);
        $merchantProductFacadeMock
            ->method('findMerchant')
            ->with($this->callback(static function (MerchantProductCriteriaTransfer $criteria): bool {
                return $criteria->getIdProductAbstract() === 5;
            }))
            ->willReturn($assignedMerchantTransfer);

        $expander = new MerchantProductAbstractFormExpander($merchantFacadeMock, $merchantProductFacadeMock, new MerchantProductGuiConfig());

        $productAbstractTransfer = (new ProductAbstractTransfer())->setIdProductAbstract(5);

        // Act
        $formData = $expander->expandFormData([], $productAbstractTransfer);

        // Assert
        $this->assertArrayHasKey('idMerchant', $formData);
        $this->assertSame(42, $formData['idMerchant']);
    }
}
