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

namespace Bitrix24\SDK\Services\CRM\Item\Productrow\Result;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AbstractResult;

class ProductrowsResult extends AbstractResult
{
    /**
     * @return ProductrowItemResult[]
     * @throws BaseException
     */
    public function getProductrows(): array
    {
        $items = [];
        foreach ($this->getCoreResponse()->getResponseData()->getResult()['productRows'] as $item) {
            $items[] = new ProductrowItemResult($item);
        }

        return $items;
    }
}
