<?php

namespace App\Pages\Superadmin\Datatable;

use App\Models\Balance;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Http\Common\LaravelLivewireTables\LinkColumn;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

class BalanceReportTable extends DataTableComponent
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
        return Balance::query(); // Select some things
    }


    public function columns(): array
    {
        return [
           Column::make("Id", "id")->sortable(),
           Column::make("User Id", "User.username")->searchable()->sortable(),
           Column::make("Name", "User.name")->searchable()->sortable(),
           Column::make("Parent Id", "Parent.username")->searchable()->sortable(),
           Column::make("Parent Name", "Parent.name")->searchable()->sortable(),
           Column::make("Amount", "amount")->format(
               fn ($value, $row, Column $column) => $value ? numberFormat($value, true) : 0
           )->searchable()->sortable(),
           Column::make("Type", "type")->format(
               fn ($value, $row, Column $column) => $value ? config("status.balance_type.{$value}.name") : 0
           )->searchable()->sortable(),
            Column::make("Flow", "flow")->format(
                fn ($value, $row, Column $column) => $value ? config("status.balance_flow.{$value}.name") : 0
            )->searchable()->sortable(),
           Column::make('Status', 'status')->format(
               fn ($value, $row, Column $column) => $value ? '<span class="badge text-bg-' . config("status.balance_status.{$value}.class") . '">' . config("status.balance_status.{$value}.name") . '</span>' : ''
           )->sortable()->html(),
           Column::make('Date', 'created_at')->format(
               fn ($value, $row, Column $column) => $value ? $value->format(getTimeFormat()) : ''
           )->sortable()->searchable(),
        ];
    }
}
