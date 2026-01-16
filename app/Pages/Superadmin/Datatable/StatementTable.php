<?php

namespace App\Pages\Superadmin\Datatable;

use App\Models\Balance;
use App\Models\Statement;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Http\Common\LaravelLivewireTables\LinkColumn;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

class StatementTable extends DataTableComponent
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
        $Statement = Statement::query(); // Select some things
        // $Statement->whereNotNull('is_generated');
        return $Statement;
    }


    public function columns(): array
    {
        return [
            Column::make("Id", "id")->sortable(),
            Column::make("Type", "type")->format(
                fn ($value, $row, Column $column) => $value ? config("status.statement_type.{$value}.name") : 0
            )->searchable()->sortable(),
            Column::make("Amount", "percentage")->format(
                fn ($value, $row, Column $column) => $value ? numberFormat($value, true) : 0
            )->searchable()->sortable(),
            Column::make('Closing Date', 'close_date')->format(
                fn ($value, $row, Column $column) => $value ? $value->format(getTimeFormat()) : ''
            )->sortable()->searchable(),
            Column::make('Distribute Date', 'is_distribute')->format(
                fn ($value, $row, Column $column) => $value ? $value->format(getTimeFormat()) : ''
            )->sortable()->searchable(),
            Column::make('Total Closing', 'total_amount')->format(
                fn ($value, $row, Column $column) => numberFormat($value ? $value : 0, true)
            )->sortable()->searchable(),
            Column::make('Distribute Amount', 'distribute_amount')->format(
                fn ($value, $row, Column $column) => numberFormat($value ? $value : 0, true)
            )->sortable()->searchable(),
            Column::make('Status', 'status')->format(
                fn ($value, $row, Column $column) => $value ? '<span class="badge text-bg-' . config("status.statement_status.{$value}.class") . '">' . config("status.statement_status.{$value}.name") . '</span>' : ''
            )->sortable()->html(),
            Column::make('Date', 'created_at')->format(
                fn ($value, $row, Column $column) => $value ? $value->format(getTimeFormat()) : ''
            )->sortable()->searchable(),
            ButtonGroupColumn::make('Actions')
                ->buttons([
                    LinkColumn::make(' Edit')
                        ->title(fn ($row) => 'Edit')
                        ->location(fn ($row) => 'javascript:void(0)')
                        ->attributes(function ($row) {
                            return [
                                'data-id' => $row->id,
                                'data-listener' => 'openStatementModal',
                                'class' => 'text-success me-1' ,
                                'icon' => 'fa fa-edit',
                            ];
                        }),
                ]),
        ];
    }
}