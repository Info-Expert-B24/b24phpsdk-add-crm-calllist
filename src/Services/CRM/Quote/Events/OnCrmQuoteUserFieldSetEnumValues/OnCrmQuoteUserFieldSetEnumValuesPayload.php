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

namespace Bitrix24\SDK\Services\CRM\Quote\Events\OnCrmQuoteUserFieldSetEnumValues;

use Bitrix24\SDK\Core\Result\AbstractItem;
use Bitrix24\SDK\Services\Telephony\Common\CrmEntityType;

/**
 * @property-read  positive-int $id
 * @property-read  non-empty-string $entityId
 * @property-read  non-empty-string $fieldName
 */
class OnCrmQuoteUserFieldSetEnumValuesPayload extends AbstractItem
{
}
