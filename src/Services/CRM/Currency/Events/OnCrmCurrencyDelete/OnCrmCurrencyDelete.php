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

namespace Bitrix24\SDK\Services\CRM\Currency\Events\OnCrmCurrencyDelete;

use Bitrix24\SDK\Application\Requests\Events\AbstractEventRequest;

class OnCrmCurrencyDelete extends AbstractEventRequest
{
    public const CODE = 'ONCRMCURRENCYDELETE';

    public function getPayload(): OnCrmCurrencyDeletePayload
    {
        return new OnCrmCurrencyDeletePayload($this->eventPayload['data']);
    }
}