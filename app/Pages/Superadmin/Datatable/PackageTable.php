<?php
namespace App\Pages\Superadmin\Datatable;

use App\Http\Common\LaravelLivewireTables\LinkColumn;
use App\Models\Package;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

class PackageTable extends DataTableComponent
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
        return Package::query(); // Select some things
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")->sortable(),
            Column::make("Title", "name")->searchable()->sortable(),
            // Column::make("Amount", "amount")
            // ->format(
            //     fn ($value, $row, Column $column) => $value ? numberFormat($value, true) : 0
            // )
            // ->searchable()
            // ->sortable(),
            Column::make("PV", "point_value")
                ->format(
                    fn($value, $row, Column $column) => $value ? pointFormat($value, true) : 0
                )
                ->searchable()
                ->sortable(),
            Column::make('Date', 'created_at')->format(
                fn($value, $row, Column $column) => $value ? $value->format(getTimeFormat()) : ''
            )->sortable()->searchable(),
            ButtonGroupColumn::make('Actions')
                ->buttons([
                    LinkColumn::make(' Edit')
                        ->title(fn($row) => 'Edit')
                        ->location(fn($row) => 'javascript:void(0)')
                        ->attributes(function ($row) {
                            return [
                                'data-id' => $row->id,
                                'data-listener' => 'openPackageModal',
                                'class' => 'text-success me-1',
                                'icon' => 'fa fa-edit',
                            ];
                        }),
                ]),
        ];
    }
}