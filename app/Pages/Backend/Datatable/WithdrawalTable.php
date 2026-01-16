<?php

namespace App\Pages\Backend\Datatable;

use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Http\Common\LaravelLivewireTables\LinkColumn;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

class WithdrawalTable extends DataTableComponent
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
        return Withdrawal::query()->whereUserId(Auth::id()); // Select some things
    }


    public function columns(): array
    {
        return [
            Column::make("SN", "id")->format(fn() => ++$this->index +  ($this->getPage() - 1) * $this->perPage),
            Column::make("Payment Method", "payment_method_id")->format(
                fn($value, $row, Column $column) => $value ? config("status.payment_method.{$value}.name") : ''
            )->searchable()->sortable(),
            Column::make("Account Number", "account_no")->searchable()->sortable(),
            Column::make("Account Additional Details ", "account_details")->searchable()->sortable(),
            Column::make("Amount", "amount")->format(
                fn($value, $row, Column $column) => numberFormat($value ? $value : 0, true)
            )->searchable()->sortable(),
            Column::make("Charges", "charge")->format(
                fn($value, $row, Column $column) => numberFormat($value ? $value : 0, true)
            )->searchable()->sortable(),
            Column::make("Net Amount", "net_amount")->format(
                fn($value, $row, Column $column) => numberFormat($value ? $value : 0, true)
            )->searchable()->sortable(),
            Column::make('Date', 'created_at')->format(
                fn($value, $row, Column $column) => $value->format(getTimeFormat())
            )->sortable()->searchable(),
            Column::make("Note", "note")->searchable()->sortable(),
            Column::make('Status', 'status')->format(
                fn($value, $row, Column $column) => $value ? '<span class="badge text-bg-' . config("status.withdrawal_status.{$value}.class") . '">' . config("status.deposit_status.{$value}.name") . '</span>' : ''
            )->sortable()->html(),
        ];
    }
}
