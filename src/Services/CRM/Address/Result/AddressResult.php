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

namespace Bitrix24\SDK\Services\CRM\Address\Result;

use Bitrix24\SDK\Core\Result\AbstractResult;

/**
 * Class AddressResult
 *
 * @package Bitrix24\SDK\Services\CRM\Address\Result
 */
class AddressResult extends AbstractResult
{
    /**
     * @throws \Bitrix24\SDK\Core\Exceptions\BaseException
     */
    public function address(): AddressItemResult
    {
        return new AddressItemResult($this->getCoreResponse()->getResponseData()->getResult());
    }
}