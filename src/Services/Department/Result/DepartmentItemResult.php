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

namespace Bitrix24\SDK\Services\Department\Result;

use Bitrix24\SDK\Core\Result\AbstractItem;

/**
 * Class DepartmentItemResult
 *
 * @property-read int $ID
 * @property-read string $NAME
 * @property-read int $SORT
 * @property-read int $PARENT
 * @property-read int $UF_HEAD
 */
class DepartmentItemResult extends AbstractItem
{
}
