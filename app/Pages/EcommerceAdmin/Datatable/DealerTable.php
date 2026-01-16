<?php

namespace App\Pages\EcommerceAdmin\Datatable;

use App\Models\User;
use App\Models\MemberTree;
use App\Http\Common\DataTableComponent;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Http\Common\LaravelLivewireTables\LinkColumn;
use App\Http\Common\LaravelLivewireTables\ButtonGroupColumn;

class DealerTable extends DataTableComponent
{
    protected $index = 0;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        // $this->setAdditionalSelects(['member_trees.user_id as user_id']);
        $this->setSearchPlaceholder('Enter Search');
        $this->setSearchDebounce(1000);
        $this->setFilterLayoutSlideDown();

    }

     public function builder(): Builder
    {
        return MemberTree::whereHas('Dealer')->with(['User', 'bySponsor', 'byPlacement']);
    }

    public function columns(): array
    {
        return [
            Column::make('SN', 'user_id')
                ->format(fn () => ++$this->index +  ($this->getPage() - 1) * $this->perPage)
                ->sortable()
                ->searchable()
                ->excludeFromColumnSelect(),
            Column::make('Name', 'User.name')
                ->sortable()
                ->searchable(),
            Column::make('Username', 'User.username')
                ->sortable()
                ->searchable(),
            Column::make('Email', 'User.email')
                ->sortable()
                ->searchable(),
            Column::make('Sponser Name', 'bySponsor.username')
                ->sortable()
                ->searchable(),
            Column::make('Mobile', 'User.mobile')
                ->sortable()
                ->searchable(),
            Column::make('Registered', 'created_at')
                ->format(
                    fn ($value, $row, Column $column) => $value ? $value->format(getTimeFormat()) : '-'
                )
                ->sortable()
                ->searchable(),
            Column::make('Own Office', 'Dealer.is_office')
                ->format(
                    fn ($value, $row, Column $column) => $value ? 'Y' : 'N'
                )
                ->sortable()
                ->searchable(),
                ButtonGroupColumn::make('Actions')
                ->buttons([
                    LinkColumn::make(' View')
                        ->title(fn ($row) => 'View')
                        ->location(fn ($row) => 'javascript:void(0)')
                        ->attributes(function ($row) {
                            return [
                                'data-id' => $row->user_id,
                                'data-listener' => 'openDealerModal',
                                'class' => 'text-success me-1' ,
                                'icon' => 'fa fa-eye',
                            ];
                        }),
                ]),
        ];
    }
}