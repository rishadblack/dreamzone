<?php
namespace App\Pages\Ecommerce\Datatable;

use App\Http\Common\LaravelLivewireTables\LinkColumn;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

class OrderTable extends DataTableComponent
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
        $Order = Order::query(); // Select some things

        $Order->whereUserId(auth()->id());

        return $Order;
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")->sortable(),
            Column::make('Subtotal', 'subtotal')
                ->format(
                    fn($value, $row, Column $column) => $value ? numberFormat($value, true) : 0
                )
                ->sortable()
                ->searchable(),
            Column::make('Discount', 'discount_amount')
                ->format(
                    fn($value, $row, Column $column) => $value ? numberFormat($value, true) : 0
                )
                ->sortable()
                ->searchable(),
            Column::make('Net Amount', 'net_amount')
                ->format(
                    fn($value, $row, Column $column) => $value ? numberFormat($value, true) : 0
                )
                ->sortable()
                ->searchable(),
            Column::make('Total Point', 'point')
                ->format(
                    fn($value, $row, Column $column) => $value ? numberFormat($value, true) : 0
                )
                ->sortable()
                ->searchable(),
            Column::make('Date', 'created_at')->format(
                fn($value, $row, Column $column) => $value->format(getTimeFormat())
            )->sortable()->searchable(),
            Column::make('Payment Status', 'payment_status')->format(
                fn($value, $row, Column $column) => $value ? '<span class="badge text-bg-' . config("status.order_payment_status.{$value}.class") . '">' . config("status.order_payment_status.{$value}.name") . '</span>' : ''
            )->sortable()->html(),
            Column::make('Delivery Status', 'delivery_status')->format(
                fn($value, $row, Column $column) => $value ? '<span class="badge text-bg-' . config("status.order_delivery_status.{$value}.class") . '">' . config("status.order_delivery_status.{$value}.name") . '</span>' : ''
            )->sortable()->html(),
            Column::make('Status', 'status')->format(
                fn($value, $row, Column $column) => $value ? '<span class="badge text-bg-' . config("status.order_status.{$value}.class") . '">' . config("status.order_status.{$value}.name") . '</span>' : ''
            )->sortable()->html(),
            ButtonGroupColumn::make('Actions')
                ->buttons([
                    LinkColumn::make(' view')
                        ->title(fn($row) => 'view')
                        ->location(fn($row) => 'javascript:void(0)')
                        ->attributes(function ($row) {
                            return [
                                'data-id' => $row->id,
                                'data-listener' => 'openOrderModal',
                                'class' => 'text-success',
                                'icon' => 'fa fa-view',
                            ];
                        }),
                ]),
        ];
    }
}
