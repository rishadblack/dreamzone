<?php

namespace App\Pages\Superadmin\Datatable;

use App\Models\User;
use App\Models\MemberTree;
use App\Http\Common\DataTableComponent;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Http\Common\LaravelLivewireTables\LinkColumn;
use App\Http\Common\LaravelLivewireTables\ButtonGroupColumn;

class MemberHistoryTable extends DataTableComponent
{
    protected $index = 0;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        // $this->setAdditionalSelects(['users.id as id']);
        $this->setSearchPlaceholder('Enter Search');
        $this->setSearchDebounce(1000);
        $this->setFilterLayoutSlideDown();

    }

    public function builder(): Builder
    {
        return MemberTree::with('User:id,name,username', 'bySponsor:id,name,username', 'byPlacement:id,name,username')
        ->withCount(['Sponsor as total_premium_sponsor' => function ($query) {
            $query->whereNotNull('is_premium');
        }])
        ->withCount('Sponsor as total_sponsor');
    }
    public function filters(): array
    {
        return [


        ];
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")->sortable(),
            Column::make("User Id", "User.username")->searchable()->sortable(),
            Column::make("Name", "User.name")->searchable()->sortable(),
            Column::make("Rank", "incentive_id")->format(
                fn ($value, $row, Column $column) => $value ? config('mlm.incentives.' . $value . '.title') : '-'
            )->searchable()->sortable(),
            Column::make("Sponsor Name", "bySponsor.name")->deselected()->searchable()->sortable(),
            Column::make("Sponsor Id", "bySponsor.username")->deselected()->searchable()->sortable(),
            Column::make("Placement Name", "byPlacement.name")->deselected()->searchable()->sortable(),
            Column::make("Placement Id", "byPlacement.username")->deselected()->searchable()->sortable(),
            Column::make("Sponsor")->label(
                fn ($row, Column $column) => $row->total_sponsor > 0 ? $row->total_sponsor : 0
            )->searchable()->sortable(),
            Column::make("Premium Sponsor")->label(
                fn ($row, Column $column) => $row->total_premium_sponsor > 0 ? $row->total_premium_sponsor : 0
            )->searchable()->sortable(),
            Column::make("Personal Sales", "p_point")->format(
                fn ($value, $row, Column $column) => $value ? numberFormat($value, true) : 0
            )->searchable()->sortable(),
            Column::make("Group Sales", "total_point")->format(
                fn ($value, $row, Column $column) => $value ? numberFormat($value, true) : 0
            )->searchable()->sortable(),
            Column::make("Group A Sales", "l_point")->format(
                fn ($value, $row, Column $column) => $value ? numberFormat($value, true) : 0
            )->searchable()->sortable(),
            Column::make("Group B Sales", "r_point")->format(
                fn ($value, $row, Column $column) => $value ? numberFormat($value, true) : 0
            )->searchable()->sortable(),
            Column::make("Total Member", "total_member")->format(
                fn ($value, $row, Column $column) => $value ? numberFormat($value, false, '-1') : 0
            )->searchable()->sortable(),
            Column::make("Group A Member", "l_member")->format(
                fn ($value, $row, Column $column) => $value ? numberFormat($value, false, '-1') : 0
            )->searchable()->sortable(),
            Column::make("Group B Member", "r_member")->format(
                fn ($value, $row, Column $column) => $value ? numberFormat($value, false, '-1') : 0
            )->searchable()->sortable(),
            Column::make("Premium Member", "total_premium")->format(
                fn ($value, $row, Column $column) => $value ? numberFormat($value, false, '-1') : 0
            )->searchable()->sortable(),
            Column::make("Group A Premium Member", "l_premium")->format(
                fn ($value, $row, Column $column) => $value ? numberFormat($value, false, '-1') : 0
            )->searchable()->sortable(),
            Column::make("Group B Premium Member", "r_premium")->format(
                fn ($value, $row, Column $column) => $value ? numberFormat($value, false, '-1') : 0
            )->searchable()->sortable(),
            Column::make("Total Matching Sales", "total_matching")->format(
                fn ($value, $row, Column $column) => $value ? numberFormat($value, true) : 0
            )->searchable()->sortable(),
            Column::make("Total Matching Flush", "flash_matching")->format(
                fn ($value, $row, Column $column) => $value ? numberFormat($value, true) : 0
            )->searchable()->sortable(),
            Column::make("Activation Date ", "is_premium")->format(
                fn ($value, $row, Column $column) => $value ? $value->format(getTimeFormat()) : '-'
            )->searchable()->sortable(),
        ];
    }
}