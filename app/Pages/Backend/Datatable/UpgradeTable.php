<?php

namespace App\Pages\Backend\Datatable;

use App\Models\Point;
use App\Http\Common\DataTableComponent;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Http\Common\LaravelLivewireTables\LinkColumn;
use App\Http\Common\LaravelLivewireTables\TextFilter;
use App\Http\Common\LaravelLivewireTables\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;

class UpgradeTable extends DataTableComponent
{
    protected $index = 0;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setOfflineIndicatorEnabled();
        $this->setPerPageAccepted(perPageRows());
        $this->setTableAttributes([
            'class' => 'table-sm',
          ]);
        $this->setDefaultSort('id', 'desc');
    }

    public function builder(): Builder
    {
        $Point =  Point::query();
        $Point->whereUserId(auth()->id())->whereIn('type', [2,3]);
        return $Point;
    }

    public function columns(): array
    {
        return [
            Column::make('SN', 'id')
                ->format(fn () => ++$this->index +  ($this->getPage() - 1) * $this->perPage)
                ->sortable()
                ->searchable()
                ->excludeFromColumnSelect(),
            Column::make("Transfer User Id", "Parent.username")->format(
                fn ($value, $row, Column $column) => $row->type == 2 ? '-' : $value
            )->searchable()->sortable()->searchable()->sortable(),
            Column::make("Transfer Name", "Parent.name")->format(
                fn ($value, $row, Column $column) => $row->type == 2 ? '-' : $value
            )->searchable()->sortable(),
            Column::make("Perpose", "type")->format(
                fn ($value, $row, Column $column) => $value == 2 ? 'Salf Upgrade' : 'Transfer For Upgrade'
            )->searchable()->sortable(),
            Column::make("Point", "value")->format(
                fn ($value, $row, Column $column) => $value ? pointFormat($value, true) : 0
            )->searchable()->sortable(),
            Column::make("Remarks", "note"),
            Column::make('Status', 'status')->format(
                fn ($value, $row, Column $column) => $value ? '<span class="badge text-bg-' . config("status.point_status.{$value}.class") . '">' . config("status.point_status.{$value}.name") . '</span>' : ''
            )->sortable()->html(),
            Column::make('Date', 'created_at')->format(
                fn ($value, $row, Column $column) => $value ? $value->format(getTimeFormat()) : ''
            )->sortable()->searchable(),
        ];
    }
}
