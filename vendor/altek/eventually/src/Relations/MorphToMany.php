<?php

declare(strict_types=1);

namespace Altek\Eventually\Relations;

class MorphToMany extends \Illuminate\Database\Eloquent\Relations\MorphToMany
{
    use Concerns\InteractsWithPivotTable;
}
