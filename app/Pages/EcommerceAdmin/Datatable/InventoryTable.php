<?php
namespace App\Pages\EcommerceAdmin\Datatable;

use App\Http\Common\LaravelLivewireTables\LinkColumn;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

class InventoryTable extends DataTableComponent
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
        return Product::sumStock(); // Select some things
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")->sortable(),
            Column::make("Name", "name")->searchable()->sortable(),
            Column::make("Stock In")
                ->label(
                    fn($row, Column $column) => $row->stock_in ?? 0
                )
                ->searchable()
                ->sortable(),
            Column::make("Stock Out")
                ->label(
                    fn($row, Column $column) => $row->stock_out ?? 0
                )
                ->searchable()
                ->sortable(),
            Column::make("Availavble Stock")
                ->label(
                    fn($row, Column $column) => $row->stock_in - $row->stock_out ?? 0
                )
                ->searchable()
                ->sortable(),
            Column::make('Date', 'created_at')->format(
                fn($value, $row, Column $column) => $value->format(getTimeFormat())
            )->sortable()->searchable(),
            Column::make('Status', 'status')->format(
                fn($value, $row, Column $column) => $value ? '<span class="badge text-bg-' . config("status.common_status.{$value}.class") . '">' . config("status.common_status.{$value}.name") . '</span>' : ''
            )->sortable()->html(),
            ButtonGroupColumn::make('Actions')
                ->buttons([
                    LinkColumn::make(' Add/Remove Stock')
                        ->title(fn($row) => 'Add/Remove Stock')
                        ->location(fn($row) => 'javascript:void(0)')
                        ->attributes(function ($row) {
                            return [
                                'data-id' => $row->id,
                                'data-listener' => 'openInventoryModal',
                                'class' => 'text-success',
                                'icon' => 'fa fa-eye',
                            ];
                        }),
                ]),
        ];
    }
}