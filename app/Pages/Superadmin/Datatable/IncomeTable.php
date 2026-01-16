<?php

namespace App\Pages\Superadmin\Datatable;

use App\Models\Income;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Http\Common\LaravelLivewireTables\LinkColumn;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

class IncomeTable extends DataTableComponent
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
    }

    public function builder(): Builder
    {
        return Income::query()->whereFlow(1); // Select some things
    }


    public function columns(): array
    {
        return [
            Column::make("Id", "id")->sortable(),
            Column::make("User Id", "User.username")->eagerLoadRelations()->searchable()->sortable(),
            Column::make("Name", "User.name")->eagerLoadRelations()->searchable()->sortable(),
            Column::make("Income Type", "type")->format(
                fn ($value, $row, Column $column) => $value ? config('status.income_type.' . $value . '.name') : 0
            )->eagerLoadRelations()->searchable()->sortable(),
            Column::make("Amount", "amount")->format(
                fn ($value, $row, Column $column) => $value ? numberFormat($value, true) : 0
            )->searchable()->sortable(),
            Column::make('Date', 'created_at')->format(
                fn ($value, $row, Column $column) => $value ? $value->format(getTimeFormat()) : ''
            )->sortable()->searchable(),
            Column::make('Status', 'status')->format(
                fn ($value, $row, Column $column) => $value ? '<span class="badge text-bg-' . config("status.income_status.{$value}.class") . '">' . config("status.balance_status.{$value}.name") . '</span>' : ''
            )->sortable()->html(),
            ButtonGroupColumn::make('Actions')
                ->buttons([
                    LinkColumn::make(' View')
                        ->title(fn ($row) => 'View')
                        ->location(fn ($row) => 'javascript:void(0)')
                        ->attributes(function ($row) {
                            return [
                                'data-id' => $row->id,
                                'data-listener' => 'openIncomeModal',
                                'class' => 'text-success me-1' ,
                                'icon' => 'fa fa-edit',
                            ];
                        }),
                ]),
        ];
    }
}