<?php

declare(strict_types=1);

namespace Altek\Accountant\Models;

use Illuminate\Database\Eloquent\Model;

class Ledger extends Model implements \Altek\Accountant\Contracts\Ledger
{
    use \Altek\Accountant\Ledger;

    /**
     * {@inheritdoc}
     */
    protected $table = 'ledgers';

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'properties' => 'json',
        'modified'   => 'json',
        'pivot'      => 'json',
        'extra'      => 'json',
    ];
}
