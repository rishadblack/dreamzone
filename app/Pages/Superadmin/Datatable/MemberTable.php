<?php
namespace App\Pages\Superadmin\Datatable;

use App\Http\Common\DataTableComponent;
use App\Http\Common\LaravelLivewireTables\ButtonGroupColumn;
use App\Http\Common\LaravelLivewireTables\LinkColumn;
use App\Models\MemberTree;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class MemberTable extends DataTableComponent
{
    protected $index = 0;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        // $this->setAdditionalSelects(['user_id']);
        $this->setSearchPlaceholder('Enter Search');
        $this->setSearchDebounce(1000);
        $this->setFilterLayoutSlideDown();

    }

    public function builder(): Builder
    {
        return MemberTree::with(['User', 'bySponsor', 'byPlacement'])->whereNotIn('user_id', [1]);
    }

    public function columns(): array
    {
        return [
            Column::make('SN', 'user_id')
                ->format(fn() => ++$this->index + ($this->getPage() - 1) * $this->perPage)
                ->sortable()
                ->searchable()
                ->excludeFromColumnSelect(),
            Column::make('Name', 'User.name')
                ->sortable()
                ->searchable(),
            Column::make('Username', 'User.username')
                ->sortable()
                ->searchable(),
            Column::make('Mobile', 'User.mobile')
                ->sortable()
                ->deselected()
                ->searchable(),
            Column::make('Email', 'User.email')
                ->sortable()
                ->deselected()
                ->searchable(),
            Column::make('Sponser Name', 'bySponsor.username')
                ->sortable()
                ->searchable(),
            Column::make('Placement Name', 'byPlacement.username')
                ->sortable()
                ->searchable(),

            Column::make('Registered', 'created_at')
                ->format(
                    fn($value, $row, Column $column) => $value ? $value->format(getTimeFormat()) : '-'
                )
                ->sortable()
                ->searchable(),
            Column::make('Valid', 'is_valid')
                ->format(
                    fn($value, $row, Column $column) => $value ? 'Y' : 'N'
                )
                ->sortable()
                ->searchable(),
            Column::make('Founder', 'is_founder')
                ->format(
                    fn($value, $row, Column $column) => $value ? 'Y' : 'N'
                )
                ->sortable()
                ->deselected()
                ->searchable(),
            Column::make('Verified', 'User.is_approve')
                ->format(
                    fn($value, $row, Column $column) => $value ? 'Y' : 'N'
                )
                ->sortable()
                ->deselected()
                ->searchable(),
            Column::make('Kyc Submit', 'User.is_agree')
                ->format(
                    fn($value, $row, Column $column) => $value ? 'Y' : 'N'
                )
                ->sortable()
                ->deselected()
                ->searchable(),
            ButtonGroupColumn::make('Actions')
                ->buttons([
                    LinkColumn::make(' View')
                        ->title(fn($row) => 'View')
                        ->location(fn($row) => 'javascript:void(0)')
                        ->attributes(function ($row) {
                            return [
                                'data-id' => $row->user_id,
                                'data-listener' => 'openMemberModal',
                                'class' => 'text-success me-1',
                                'icon' => 'fa fa-eye',
                            ];
                        }),
                ]),
        ];
    }
}
