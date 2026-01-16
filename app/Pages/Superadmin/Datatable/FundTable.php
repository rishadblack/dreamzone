<?php

namespace App\Pages\Superadmin\Datatable;

use App\Models\Fund;
use App\Http\Common\DataTableComponent;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Http\Common\LaravelLivewireTables\LinkColumn;
use App\Http\Common\LaravelLivewireTables\TextFilter;
use App\Http\Common\LaravelLivewireTables\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;

class FundTable extends DataTableComponent
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
        $Fund =  Fund::query();

        return $Fund;
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")->sortable(),
            Column::make("User Id", "User.username")->searchable()->sortable(),
            Column::make("Name", "User.name")->searchable()->sortable(),
            Column::make('Invest Date', 'is_attached')->format(
                fn($value, $row, Column $column) => $value ? $value->format(getTimeFormat()) : 'Waiting'
            )
                ->sortable()
                ->searchable(),
            Column::make('Invest Amount', 'attached_amount')->format(
                fn($value, $row, Column $column) => numberFormat($value ? $value : 0, true)
            )
                ->sortable()
                ->searchable(),
            Column::make('Status', 'status')->format(
                fn($value, $row, Column $column) => $value ? '<span class="badge text-bg-' . config("status.fund_status.{$value}.class") . '">' . config("status.fund_status.{$value}.name") . '</span>' : ''
            )->sortable()->html(),
            ButtonGroupColumn::make("Actions")
                ->buttons([
                    LinkColumn::make(' Detach')
                        ->title(fn($row) => 'Detach')
                        ->location(fn($row) => 'javascript:void(0)')
                        ->attributes(function ($row) {
                            return [
                                'data-id' => $row->id,
                                'data-listener' => 'openDetachedModal',
                                'class' => 'badge bg-info me-1 p-2 ',
                                'icon' => 'fa fa-close',
                                'title' => 'View',
                            ];
                        }),
                ]),
        ];
    }
}
