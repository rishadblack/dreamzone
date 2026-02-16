<?php
namespace App\Pages\Backend\Datatable\Report;

use App\Models\Income;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class CommonIncomeReportTable extends DataTableComponent
{
    public $income_type;
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
        $Income = Income::query()->with('Parent:id,name,username')->whereType($this->income_type);

        $Income->whereUserId(auth()->id());

        return $Income;
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")->format(fn() => ++$this->index + ($this->getPage() - 1) * $this->perPage),
            Column::make("Refer Name", "Parent.name")->searchable()->sortable()->hideIf(! in_array($this->income_type, [1])),
            Column::make("Refer ID", "Parent.username")->searchable()->sortable()->hideIf(! in_array($this->income_type, [1])),
            Column::make("From Level", "level")->searchable()->sortable()->hideIf(! in_array($this->income_type, [3])),
            Column::make("From Step", "level")->searchable()->sortable()->hideIf(! in_array($this->income_type, [4])),
            Column::make("Amount", "amount")->format(
                fn($value, $row, Column $column) => numberFormat($value ? $value : 0, true)
            )->searchable()->sortable(),
            // Column::make("Charge", "charge")->format(
            //     fn($value, $row, Column $column) => numberFormat($value ? $value : 0, true)
            // )->searchable()->sortable(),
            // Column::make("Net Amount", "net_amount")->format(
            //     fn($value, $row, Column $column) => numberFormat($value ? $value : 0, true)
            // )->searchable()->sortable(),
            Column::make('Date', 'created_at')->format(
                fn($value, $row, Column $column) => $value->format(getTimeFormat())
            )->sortable()->searchable(),
            Column::make('Status', 'status')->format(
                fn($value, $row, Column $column) => $value ? '<span class="badge text-bg-' . config("status.income_status.{$value}.class") . '">' . config("status.income_status.{$value}.name") . '</span>' : ''
            )->sortable()->html(),
        ];
    }
}
