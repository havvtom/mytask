@component('mail::message')
# Introduction

Your one time pin is {{ $one_time_pin }}

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
