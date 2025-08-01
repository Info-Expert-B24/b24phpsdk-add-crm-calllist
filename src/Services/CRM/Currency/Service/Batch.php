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

namespace Bitrix24\SDK\Services\CRM\Currency\Service;

use Bitrix24\SDK\Attributes\ApiBatchMethodMetadata;
use Bitrix24\SDK\Attributes\ApiBatchServiceMetadata;
use Bitrix24\SDK\Core\Credentials\Scope;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Result\AddedItemBatchResult;
use Bitrix24\SDK\Core\Result\DeletedItemBatchResult;
use Bitrix24\SDK\Core\Result\UpdatedItemBatchResult;
use Bitrix24\SDK\Services\CRM\Currency;
use Generator;
use Psr\Log\LoggerInterface;

#[ApiBatchServiceMetadata(new Scope(['crm']))]
class Batch
{
    /**
     * Batch constructor.
     */
    public function __construct(protected Currency\Batch $batch, protected LoggerInterface $log)
    {
    }

    /**
     * Batch adding currencies
     *
     * @param array <int, array{
     *   CURRENCY?: string,
     *   BASE?: string,
     *   AMOUNT_CNT?: int,
     *   AMOUNT?: float,
     *   SORT?: int,
     *   LANG?: array,
     *   }> $currencies
     *
     * @return Generator<int, AddedItemBatchResult>
     * @throws BaseException
     */
    #[ApiBatchMethodMetadata(
        'crm.currency.add',
        'https://apidocs.bitrix24.com/api-reference/crm/currency/crm-currency-add.html',
        'Batch adding currencies'
    )]
    public function add(array $currencies): Generator
    {
        $items = [];
        foreach ($currencies as $currency) {
            $items[] = [
                'fields' => $currency,
            ];
        }

        foreach ($this->batch->addEntityItems('crm.currency.add', $items) as $key => $item) {
            yield $key => new AddedItemBatchResult($item);
        }
    }

    /**
     * Batch delete currencies
     *
     * @param string[] $currencyId
     *
     * @return Generator<int, DeletedItemBatchResult>
     * @throws BaseException
     */
    #[ApiBatchMethodMetadata(
        'crm.currency.delete',
        'https://apidocs.bitrix24.com/api-reference/crm/currency/crm-currency-delete.html',
        'Batch delete currencies'
    )]
    public function delete(array $currencyId): Generator
    {
        foreach ($this->batch->deleteCurrencyItems('crm.currency.delete', $currencyId) as $key => $item) {
            yield $key => new DeletedItemBatchResult($item);
        }
    }

    /**
     * Batch update currencies
     *
     * @param array <string, array> $currencies
     *
     * @return Generator<int, UpdatedItemBatchResult>
     * @throws BaseException
     */
    #[ApiBatchMethodMetadata(
        'crm.currency.update',
        'https://apidocs.bitrix24.com/api-reference/crm/currency/crm-currency-update.html',
        'Batch update currencies'
    )]
    public function update(array $currencies): Generator
    {
        $items = [];
        foreach ($currencies as $id => $currency) {
            $items[$id] = [
                'fields' => $currency,
            ];
        }

        foreach ($this->batch->updateCurrencyItems('crm.currency.update', $items) as $key => $item) {
            yield $key => new UpdatedItemBatchResult($item);
        }
    }
}
