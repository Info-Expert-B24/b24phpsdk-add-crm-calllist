<?php

/**
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Vadim Soluyanov <vadimsallee@gmail.com>
 *
 * For the full copyright and license information, please view the MIT-LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\CRM\Requisites\Service;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Core;
use Bitrix24\SDK\Services\CRM\Requisites\Result\RequisiteBankdetailItemResult;
use Bitrix24\SDK\Services\CRM\Requisites\Service\RequisiteBankdetail;
use Bitrix24\SDK\Services\CRM\Company\Service\Company;
use Bitrix24\SDK\Services\CRM\Requisites\Service\Requisite;
use Bitrix24\SDK\Services\ServiceBuilder;
use Bitrix24\SDK\Tests\Builders\Services\CRM\CompanyBuilder;
use Bitrix24\SDK\Tests\Builders\Services\CRM\RequisiteBuilder;

use Bitrix24\SDK\Tests\CustomAssertions\CustomBitrix24Assertions;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

/**
 * Class RequisiteBankdetailTest
 *
 * @package Bitrix24\SDK\Tests\Integration\Services\CRM\Requisite\Service
 */
#[CoversMethod(RequisiteBankdetail::class,'add')]
#[CoversMethod(RequisiteBankdetail::class,'delete')]
#[CoversMethod(RequisiteBankdetail::class,'get')]
#[CoversMethod(RequisiteBankdetail::class,'list')]
#[CoversMethod(RequisiteBankdetail::class,'fields')]
#[CoversMethod(RequisiteBankdetail::class,'update')]
#[CoversMethod(RequisiteBankdetail::class,'countByFilter')]
#[\PHPUnit\Framework\Attributes\CoversClass(\Bitrix24\SDK\Services\CRM\Requisites\Service\RequisiteBankdetail::class)]
class RequisiteBankdetailTest extends TestCase
{
    use CustomBitrix24Assertions;

    public const COMPANY_OWNER_TYPE_ID = 4;

    protected ServiceBuilder $sb;

    protected RequisiteBankdetail $bankService;

    protected Company $companyService;

    protected Requisite $requisiteService;

    protected array   $presets = [];

    private array $createdCompanies = [];

    protected function setUp(): void
    {
        $this->sb = Fabric::getServiceBuilder();
        $this->companyService = $this->sb->getCRMScope()->company();
        $this->requisiteService = $this->sb->getCRMScope()->requisite();
        $this->bankService = $this->sb->getCRMScope()->requisiteBankdetail();
        $requisitePreset = $this->sb->getCRMScope()->requisitePreset();
        foreach ($requisitePreset->list()->getRequisitePresets() as $requisitePresetItemResult) {
            $this->presets[] = $requisitePresetItemResult->ID;
        }
    }

    protected function tearDown(): void
    {
        foreach ($this->companyService->batch->delete($this->createdCompanies) as $result) {
            // ###
        }
    }

    public function testAllSystemFieldsAnnotated(): void
    {
        $fieldDescriptions = $this->bankService->fields()->getFieldsDescription();
        
        $propListFromApi = (new Core\Fields\FieldsFilter())->filterSystemFields(array_keys($fieldDescriptions));
        $this->assertBitrix24AllResultItemFieldsAnnotated($propListFromApi, RequisiteBankdetailItemResult::class);
    }

    public function testAllSystemFieldsHasValidTypeAnnotation():void
    {
        $allFields = $this->bankService->fields()->getFieldsDescription();
        $systemFieldsCodes = (new Core\Fields\FieldsFilter())->filterSystemFields(array_keys($allFields));
        $systemFields = array_filter($allFields, static fn($code): bool => in_array($code, $systemFieldsCodes, true), ARRAY_FILTER_USE_KEY);

        $this->assertBitrix24AllResultItemFieldsHasValidTypeAnnotation(
            $systemFields,
            RequisiteBankdetailItemResult::class);
    }

    /**
     * @throws BaseException
     * @throws TransportException
     */
    public function testAdd(): void
    {
        $presetId = $this->presets[0];
        [$companyId, $requisiteId] = $this->addCompanyAndRequisite($presetId);
        $this->createdCompanies[] = $companyId;
        $addedItemResult = $this->bankService->add([
            'ENTITY_ID' => $requisiteId,
            'NAME' => 'Test bank requisite'
        ]);
        self::assertGreaterThan(1, $addedItemResult->getId());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     */
    public function testDelete(): void
    {
        $presetId = $this->presets[0];
        [$companyId, $requisiteId] = $this->addCompanyAndRequisite($presetId);
        $this->createdCompanies[] = $companyId;
        $addedItemResult = $this->bankService->add([
            'ENTITY_ID' => $requisiteId,
            'NAME' => 'Test bank requisite'
        ]);
        self::assertTrue($this->bankService->delete($addedItemResult->getId())->isSuccess());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     */
    public function testFields(): void
    {
        self::assertIsArray($this->bankService->fields()->getFieldsDescription());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     */
    public function testGet(): void
    {
        $presetId = $this->presets[0];
        [$companyId, $requisiteId] = $this->addCompanyAndRequisite($presetId);
        $this->createdCompanies[] = $companyId;
        $addedItemResult = $this->bankService->add([
            'ENTITY_ID' => $requisiteId,
            'NAME' => 'Test bank requisite'
        ]);
        self::assertGreaterThan(
            1,
            $this->bankService->get($addedItemResult->getId())->bankdetail()->ID
        );
    }

    /**
     * @throws BaseException
     * @throws TransportException
     */
    public function testList(): void
    {
        $presetId = $this->presets[0];
        [$companyId, $requisiteId] = $this->addCompanyAndRequisite($presetId);
        $this->createdCompanies[] = $companyId;
        $this->bankService->add([
            'ENTITY_ID' => $requisiteId,
            'NAME' => 'Test bank requisite'
        ]);
        self::assertGreaterThanOrEqual(1, $this->bankService->list([], [], ['ID', 'NAME'])->getBankdetails());
    }

    /**
     * @throws BaseException
     * @throws TransportException
     */
    public function testUpdate(): void
    {
        $presetId = $this->presets[0];
        [$companyId, $requisiteId] = $this->addCompanyAndRequisite($presetId);
        $this->createdCompanies[] = $companyId;
        $addedItemResult = $this->bankService->add([
            'ENTITY_ID' => $requisiteId,
            'NAME' => 'Test bank requisite'
        ]);
        $newName = 'Test2 bank requisite';

        self::assertTrue($this->bankService->update($addedItemResult->getId(), ['NAME' => $newName])->isSuccess());
        self::assertEquals($newName, $this->bankService->get($addedItemResult->getId())->bankdetail()->NAME);
    }

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     * @throws \Bitrix24\SDK\Core\Exceptions\TransportException
     */
    public function testCountByFilter(): void
    {
        $before = $this->bankService->countByFilter();

        foreach ($this->presets as $preset) {
            [$companyId, $requisiteId] = $this->addCompanyAndRequisite($preset);
            $this->createdCompanies[] = $companyId;
            $bankRequisite = $this->bankService->add([
                'ENTITY_ID' => $requisiteId,
                'NAME' => 'Test bank requisite '.$preset
            ]);
        }

        $after = $this->bankService->countByFilter();

        $this->assertEquals($before + count($this->presets), $after);
    }

    protected function addCompanyAndRequisite(int $presetId = 0): array {
        $companyId = $this->companyService->add((new CompanyBuilder())->build())->getId();
        $requisiteId = $this->requisiteService->add(
            $companyId,
            self::COMPANY_OWNER_TYPE_ID,
            $presetId,
            'Test requisite '.$presetId,
            (new RequisiteBuilder(self::COMPANY_OWNER_TYPE_ID, $companyId, $presetId))->build()
        )->getId();

        return [$companyId, $requisiteId];
    }
}
