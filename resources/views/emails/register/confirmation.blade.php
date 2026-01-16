@component('mail::message')
Hello {{$User->name}},

We&#8217;re happy that another incredible person joined our {{config('app.name')}} community.Please check Username, Password & Pin below.<br>

Username : {{$User->username}}<br>
Password : {{$password}}<br>

Let&#8217;s start with the basics!<br>

To get you started, try out these three simple tasks that will help you understand our platform:<br>

Task 1 [login]<br>
Task 2 [verify you identity]<br>
Task 3 [start investment]<br>

Login Url : <a href="{{route('login')}}" target="_blank" rel="noopener noreferrer">{{route('login')}}</a>

Thank you for joining, let&#8217;s make great things happen together!<br>

Sincerely,<br>
{{config('app.name')}} team<br>
{{config('app.url')}}
@endcomponent
