<?php

namespace App\Pages\Backend\Datatable\Report;

use App\Models\Deposit;
use App\Models\MemberTree;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Http\Common\LaravelLivewireTables\LinkColumn;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

class SponsorReportTable extends DataTableComponent
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
        $MemberTree =  MemberTree::with('User:id,name,username');

        $MemberTree->whereSponsorId(auth()->id());

        return $MemberTree;
    }


    public function columns(): array
    {
        return [
            Column::make("SN", "id")->format(fn () => ++$this->index +  ($this->getPage() - 1) * $this->perPage),
            Column::make("Name", "User.name")->searchable()->sortable(),
            Column::make("Username", "User.username")->searchable()->sortable(),
            Column::make("Point", "p_point")->format(
                fn ($value, $row, Column $column) => pointFormat($value ? $value : 0, true)
            )->searchable()->sortable(),
            Column::make("Team Point", "total_point")->format(
                fn ($value, $row, Column $column) => pointFormat($value ? $value : 0, true)
            )->searchable()->sortable(),
            Column::make('Signup', 'created_at')->format(
                fn ($value, $row, Column $column) => $value->format(getTimeFormat())
            )->sortable()->searchable(),
        ];
    }
}
