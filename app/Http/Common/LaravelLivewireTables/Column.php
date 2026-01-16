<?php

namespace App\Http\Common\LaravelLivewireTables;

use App\Http\Common\LaravelLivewireTables\BaseColumnHelpers;
use Rappasoft\LaravelLivewireTables\Views\Column as ColumnBase;
use Rappasoft\LaravelLivewireTables\Views\Traits\Helpers\RelationshipHelpers;
use Rappasoft\LaravelLivewireTables\Views\Traits\Configuration\ColumnConfiguration;

class Column extends ColumnBase
{
    use ColumnConfiguration;
    use BaseColumnHelpers;
    use RelationshipHelpers;
}
