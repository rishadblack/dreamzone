<?php
namespace App\Pages\Backend\Datatable\Report;

use App\Models\Balance;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class BalanceReportTable extends DataTableComponent
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
        $Balance = Balance::query()->with('Parent:id,username');

        $Balance->whereUserId(auth()->id());

        return $Balance;
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")->format(fn() => ++$this->index + ($this->getPage() - 1) * $this->perPage),
            Column::make("Type", "type")->format(
                fn($value, $row, Column $column) => $value ? config("status.balance_type.{$value}.name") : 0
            )->searchable()->sortable(),
            Column::make("Flow", "flow")->format(
                fn($value, $row, Column $column) => $value ? config("status.balance_flow.{$value}.name") : 0
            )->searchable()->sortable(),
            Column::make("Transaction Details", "parent_id")->format(function ($value, $row, Column $column) {
                if ($row->type == 1 || $row->type == 6) {
                    if ($row->flow == 1) {
                        return $value ? 'Received from ' . $row->Parent->username : '-';
                    } else {
                        return $value ? 'Sent to ' . $row->Parent->username : '-';
                    }
                } elseif ($row->type == 2) {
                    if ($row->flow == 1) {
                        return 'Received from System';
                    } else {
                        return 'Sent to System';
                    }
                } elseif ($row->type == 5) {
                    return 'Online Shopping';
                } else {
                    return '-';
                }
            })->searchable()->sortable(),
            Column::make("Amount", "amount")->format(
                fn($value, $row, Column $column) => numberFormat($value ? $value : 0, true)
            )->searchable()->sortable(),
            Column::make('Date', 'created_at')->format(
                fn($value, $row, Column $column) => $value->format(getTimeFormat())
            )->sortable()->searchable(),
            Column::make('Status', 'status')->format(
                fn($value, $row, Column $column) => $value ? '<span class="badge text-bg-' . config("status.balance_status.{$value}.class") . '">' . config("status.balance_status.{$value}.name") . '</span>' : ''
            )->sortable()->html(),
            Column::make("Note", "note")->searchable()->sortable(),
        ];
    }
}