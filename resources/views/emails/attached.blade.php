@component('mail::message')
Hello {{$Fund->User->name}},<br>
We are happy to inform you that we have just reviewed and approved your fund attachment request.<br>
Fund attachment ID: #{{$Fund->id}}<br>
Fund manager: {{config('app.trader_name')}}<br>
Amount attached : {{numberFormat($Fund->attached_amount,true)}} <br>
The approved amount has been deducted and attached from your MetaTrader 5 Live Trading Account.
You may login to your MetaTrader 5 Live Trading Account using our MetaTrader 5 Client Trading Terminal to verify the updated balance.<br>

This notification email is automatically sent by system. If you have questions, please email us {{config('app.email')}}.<br>

Trankyou,<br>
{{config('app.name')}} team<br>
{{config('app.url')}}
@endcomponent
