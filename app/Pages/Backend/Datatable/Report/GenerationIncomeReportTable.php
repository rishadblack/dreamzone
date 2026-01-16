<?php

namespace App\Pages\Backend\Datatable\Report;

use App\Models\Income;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Http\Common\LaravelLivewireTables\LinkColumn;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

class GenerationIncomeReportTable extends DataTableComponent
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
        $Income =  Income::query()->with('Parent:id,name,username')->whereType(4);

        $Income->whereUserId(auth()->id());

        return $Income;
    }


    public function columns(): array
    {
        return [
            Column::make("Id", "id")->format(fn() => ++$this->index +  ($this->getPage() - 1) * $this->perPage),
            Column::make("From Level", "level")->searchable()->sortable(),
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
