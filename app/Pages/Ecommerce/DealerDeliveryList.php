<?php
namespace App\Pages\Ecommerce;

use App\Http\Common\Component;
use App\Models\Dealer;
use App\Models\Order;
use App\Models\Point;
use App\Models\User;
use App\Traits\MemberUpgradeTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DealerDeliveryList extends Component
{
    use MemberUpgradeTrait;
    public $order;
    public $payment_status;
    public $delivery_status;

    protected $listeners = [
        'openOrderModal',
    ];

    public function openOrderModal($data = null)
    {
        $this->dispatch('modalOpen', 'OrderModal');
        $this->reset();

        if ($data && isset($data['id'])) {
            $this->orderView($data['id']);
        }
    }

    public function orderView($id)
    {
        $this->order = Order::with(['User:id,name,username'])->find($id);
        $this->payment_status = $this->order->payment_status;
        $this->delivery_status = $this->order->delivery_status;
    }

    public function updatedPaymentStatus()
    {
        $CurrentUser = Auth::User();

        try {
            DB::beginTransaction();

            if (! $CurrentUser->hasRole('superadmin') && $this->order->payment_status == 1) {
                $this->alert('error', 'Sorry! Order already paid');
                $this->payment_status = 1;

                return true;
            }

            $this->order->payment_status = $this->payment_status;
            $this->order->save();

            $this->orderStatusCheck($this->order);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->alert('error', 'System Error. Please contact Administrator.');

            return true;
        }

        $this->dispatch('refreshDatatable');
        $this->alert('success', 'Order Payment Status Updated Successfully');
    }

    public function updatedDeliveryStatus()
    {
        $CurrentUser = Auth::User();

        try {
            DB::beginTransaction();

            if (! $CurrentUser->hasRole('superadmin') && $this->order->delivery_status == 1) {
                $this->alert('error', 'Sorry! Order already delivered');
                $this->delivery_status = 1;

                return true;
            }

            $this->order->delivery_status = $this->delivery_status;
            $this->order->save();
            $this->order->orderItem()->update(['status' => $this->order->delivery_status == 1 ? 1 : 2]);

            if ($this->order->payment_method_id == 1) {
                $Point = Point::whereOrderId($this->order->id)->whereType(1)->whereFlow(1)->firstOrNew();
                $Point->order_id = $this->order->id;
                $Point->user_id = $this->order->user_id;
                $Point->parent_id = $this->order->Dealer->user_id;
                $Point->value = $this->order->point;
                $Point->type = 1;
                $Point->flow = 1;
                $Point->generated_by = $CurrentUser->id;
                $Point->status = $this->delivery_status == 1 ? 1 : 2;
                $Point->save();

                $PointUpgrade = Point::whereOrderId($this->order->id)->whereType(2)->whereFlow(2)->firstOrNew();
                $PointUpgrade->user_id = $Point->user_id;
                $PointUpgrade->parent_id = $Point->parent_id;
                $PointUpgrade->order_id = $Point->order_id;
                $PointUpgrade->value = $Point->value;
                $PointUpgrade->type = 2;
                $PointUpgrade->flow = 2;
                $PointUpgrade->generated_by = $CurrentUser->id;
                $PointUpgrade->status = $this->delivery_status == 1 ? 1 : 2;
                $PointUpgrade->save();

                $this->memberUpgrade($PointUpgrade->user_id);
            }

            if ($this->order->type != 1) {
                $Point = Point::whereOrderId($this->order->id)->whereType(7)->whereFlow(2)->firstOrNew();
                $Point->order_id = $this->order->id;
                $Point->user_id = $this->order->Dealer->user_id;
                $Point->parent_id = $this->order->user_id;
                $Point->value = $this->order->point;
                $Point->type = 7;
                $Point->flow = 2;
                $Point->generated_by = $CurrentUser->id;
                $Point->status = $this->delivery_status == 1 ? 1 : 2;
                $Point->save();
            }

            $this->orderStatusCheck($this->order);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            $this->alert('error', 'System Error. Please contact Administrator.');

            return true;
        }

        $this->dispatch('refreshDatatable');
        $this->alert('success', 'Order Delivery Status Updated Successfully');
    }

    public function orderStatusCheck($order)
    {
        $CurrentUser = Auth::User();

        if ($order->payment_status == 1 && $order->delivery_status == 1) {
            $order->status = 1;
        } else {
            $order->status = 2;
        }

        $order->save();

        if ($order->payment_method_id != 1 && $CurrentUser->hasRole('dealer') && Dealer::whereUserId($CurrentUser->id)->whereNull('is_office')->exists()) {
            //dealer Commission
        }

        if ($order->status != 1) {
            return true;
        }

        // Dealer Condition
        if (Auth::User()->hasRole('dealer')) {
            // $dealerBonusAmount = $order->point * config('mlm.income_list.6.percentage') / 100;

            // $generationBonus = $order->re_point * config('mlm.income_list.9.percentage') / 100;

            // if ($order->re_point > 0) {
            //     $this->genarationBonus($order->user_id, $generationBonus, $order->User, $order);
            // }

            // Income::create([
            //     'user_id' => $order->Dealer->user_id,
            //     'parent_id' => $order->user_id,
            //     'order_id' => $order->id,
            //     'amount' => $dealerBonusAmount,
            //     'net_amount' => $dealerBonusAmount,
            //     'wallet_type' => 1,
            //     'type' => 6,
            //     'flow' => 1,
            //     'generated_by' => $order->Dealer->user_id,
            //     'status' => 1,
            // ]);
        }
    }

    public function render()
    {
        return view('pages.ecommerce.dealer-delivery-list');
    }
}