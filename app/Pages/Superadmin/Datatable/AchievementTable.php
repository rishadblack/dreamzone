<?php

namespace App\Pages\Superadmin\Datatable;

use App\Models\Achievement;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Http\Common\LaravelLivewireTables\LinkColumn;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

class AchievementTable extends DataTableComponent
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
        return Achievement::query(); // Select some things
    }


    public function columns(): array
    {
        return [
            Column::make("Id", "id")->sortable(),
            Column::make("Name", "User.name")->searchable()->sortable(),
            Column::make("Username", "User.username")->searchable()->sortable(),
            Column::make("Achieve", "incentive_id")->format(
                fn ($value, $row, Column $column) => $value ? config('mlm.incentives.'.$value.'.title', true).' ('.config('mlm.incentives.'.$value.'.name', true).')' : 0
            )->searchable()->sortable(),
            Column::make('Incentive Receive', 'is_received')->format(
                fn ($value, $row, Column $column) => $value ? '<span class="badge text-bg-success">Y</span>' : '<span class="badge text-bg-danger">N</span>'
            )->sortable()->html(),
           Column::make('Incentive Receive Date', 'is_received')->format(
               fn ($value, $row, Column $column) => $value ? $value->format(getTimeFormat()) : ''
           )->sortable()->searchable(),
            Column::make('Achieve Date', 'created_at')->format(
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
                                'data-listener' => 'changeReceiveStatus',
                                'class' => 'text-success me-1' ,
                                'icon' => 'fa fa-check',
                            ];
                        }),
                ]),
        ];
    }
}