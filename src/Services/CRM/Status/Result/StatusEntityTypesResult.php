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

namespace Bitrix24\SDK\Services\CRM\Status\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

/**
 * Class StatusEntityTypesResult
 *
 * @package Bitrix24\SDK\Services\CRM\Status\Result
 */
class StatusEntityTypesResult extends AbstractResult
{
    /**
     * @return StatusEntityTypeItemResult[]
     * @throws BaseException
     */
    public function getEntityTypes(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult() as $item) {
            $res[] = new StatusEntityTypeItemResult($item);
        }

        return $res;
    }
}
