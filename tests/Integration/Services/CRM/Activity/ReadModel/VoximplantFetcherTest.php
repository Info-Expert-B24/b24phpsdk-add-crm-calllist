<?php

/**
 * This file is part of the bitrix24-php-sdk package.
 *
 * © Maksim Mesilov <mesilov.maxim@gmail.com>
 *
 * For the full copyright and license information, please view the MIT-LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Bitrix24\SDK\Tests\Integration\Services\CRM\Activity\ReadModel;

use Bitrix24\SDK\Services\CRM\Activity\ReadModel\VoximplantFetcher;
use Bitrix24\SDK\Services\CRM\Activity\ReadModel\WebFormFetcher;
use Bitrix24\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;

#[\PHPUnit\Framework\Attributes\CoversClass(\Bitrix24\SDK\Services\CRM\Activity\ReadModel\WebFormFetcher::class)]
class VoximplantFetcherTest extends TestCase
{
    private VoximplantFetcher $voximplantFetcher;

    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function testGetListWithAllResults(): void
    {
        // we can't guarantee calls data on test env
        $itemsCnt = 0;
        foreach ($this->voximplantFetcher->getList(['ID' => 'DESC'], [], ['*', 'COMMUNICATIONS',], 5) as $item) {
            $itemsCnt++;
//            print(sprintf(
//                    '%s | %s | %s ',
//                    $item->PROVIDER_TYPE_ID,
//                    $item->CREATED,
//                    $item->SUBJECT,
//                ) . PHP_EOL);
        }

        $this->assertTrue(true);
    }

    protected function setUp(): void
    {
        $this->voximplantFetcher = Fabric::getServiceBuilder()->getCRMScope()->activityFetcher()->voximplantFetcher();
    }
}