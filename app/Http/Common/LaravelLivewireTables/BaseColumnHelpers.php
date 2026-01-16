<?php

namespace App\Http\Common\LaravelLivewireTables;

use Illuminate\Database\Eloquent\Model;
use Rappasoft\LaravelLivewireTables\Views\Traits\Helpers\ColumnHelpers;

trait BaseColumnHelpers
{
    use ColumnHelpers;

    public function getValue(Model $row)
    {
        if ($this->isBaseColumn()) {
            return $row->{$this->getField()};
        }

        if(isset($row->{$this->getRelationString()})) {
            return $row->{$this->getRelationString()}->{$this->getField()};
        }

        return $row->{$this->getRelationString().'.'.$this->getField()};

    }
}
