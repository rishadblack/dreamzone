<?php

namespace App\Pages\Superadmin\Datatable;

use App\Models\Balance;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Http\Common\LaravelLivewireTables\LinkColumn;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

class GenerateBalanceTable extends DataTableComponent
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
        $Balance = Balance::query(); // Select some things
        $Balance->whereNotNull('is_generated');
        return $Balance;
    }


    public function columns(): array
    {
        return [
            Column::make("Id", "id")->sortable(),
            Column::make("User Id", "User.username")->searchable()->sortable(),
            Column::make("Name", "User.name")->searchable()->sortable(),
            Column::make("Amount", "amount")->format(
                fn($value, $row, Column $column) => $value ? numberFormat($value, true) : 0
            )->searchable()->sortable(),
            Column::make('Status', 'status')->format(
                fn($value, $row, Column $column) => $value ? '<span class="badge text-bg-' . config("status.balance_status.{$value}.class") . '">' . config("status.balance_status.{$value}.name") . '</span>' : ''
            )->sortable()->html(),
            Column::make('Date', 'created_at')->format(
                fn($value, $row, Column $column) => $value ? $value->format(getTimeFormat()) : ''
            )->sortable()->searchable(),
            ButtonGroupColumn::make('Actions')
                ->buttons([
                    LinkColumn::make(' view')
                        ->title(fn($row) => 'view')
                        ->location(fn($row) => 'javascript:void(0)')
                        ->attributes(function ($row) {
                            return [
                                'data-id' => $row->id,
                                'data-listener' => 'openBalanceGenerateModal',
                                'class' => 'text-success me-1' ,
                                'icon' => 'fa fa-eye',
                            ];
                        }),
                ]),
        ];
    }
}
