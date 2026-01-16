<?php

namespace App\Pages\Superadmin\Datatable;

use App\Models\Point;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Http\Common\LaravelLivewireTables\LinkColumn;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

class PointTable extends DataTableComponent
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
        $Point = Point::query(); // Select some things
        $Point->whereNotNull('is_generated');
        return $Point;
    }


    public function columns(): array
    {
        return [
            Column::make("Id", "id")->sortable(),
            Column::make("User Id", "User.username")->searchable()->sortable(),
            Column::make("Name", "User.name")->searchable()->sortable(),
            Column::make("Point", "value")->format(
                fn ($value, $row, Column $column) => $value ? numberFormat($value, true) : 0
            )->searchable()->sortable(),
            Column::make("Flow", "flow")->format(
                fn ($value, $row, Column $column) => $value == 1 ? 'In' : 'Out'
            )->searchable()->sortable(),
            Column::make("Remarks", "note"),
            Column::make('Status', 'status')->format(
                fn ($value, $row, Column $column) => $value ? '<span class="badge text-bg-' . config("status.point_status.{$value}.class") . '">' . config("status.point_status.{$value}.name") . '</span>' : ''
            )->sortable()->html(),
            Column::make('Date', 'created_at')->format(
                fn ($value, $row, Column $column) => $value ? $value->format(getTimeFormat()) : ''
            )->sortable()->searchable(),
            ButtonGroupColumn::make('Actions')
                ->buttons([
                    LinkColumn::make(' view')
                        ->title(fn ($row) => 'view')
                        ->location(fn ($row) => 'javascript:void(0)')
                        ->attributes(function ($row) {
                            return [
                                'data-id' => $row->id,
                                'data-listener' => 'openPointModal',
                                'class' => 'text-success me-1' ,
                                'icon' => 'fa fa-eye',
                            ];
                        }),
                ]),
        ];
    }
}
