<?php

namespace App\Pages\EcommerceAdmin\Datatable;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Http\Common\LaravelLivewireTables\LinkColumn;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

class ProductTable extends DataTableComponent
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
        return Product::query(); // Select some things
    }


    public function columns(): array
    {
        return [
            Column::make("Id", "id")->sortable(),
            Column::make("Name", "name")->searchable()->sortable(),
            Column::make('Date', 'created_at')->format(
                fn ($value, $row, Column $column) => $value->format(getTimeFormat())
            )->sortable()->searchable(),
            Column::make('Status', 'status')->format(
                fn ($value, $row, Column $column) => $value ? '<span class="badge text-bg-' . config("status.common_status.{$value}.class") . '">' . config("status.common_status.{$value}.name") . '</span>' : ''
            )->sortable()->html(),
            ButtonGroupColumn::make('Actions')
                ->buttons([
                    LinkColumn::make(' Edit')
                        ->title(fn ($row) => 'Edit')
                        ->location(fn ($row) => 'javascript:void(0)')
                        ->attributes(function ($row) {
                            return [
                                'data-id' => $row->id,
                                'data-listener' => 'openProductModal',
                                'class' => 'text-success' ,
                                'icon' => 'fa fa-edit',
                            ];
                        }),
                    LinkColumn::make(' Delete')
                        ->title(fn ($row) => 'Delete')
                        ->location(fn ($row) => 'javascript:void(0)')
                        ->attributes(function ($row) {
                            return [
                                'data-id' => $row->id,
                                'data-listener' => 'deleteProduct',
                                'class' => 'text-danger' ,
                                'icon' => 'fa fa-close',
                            ];
                        }),
                ]),
        ];
    }
}
