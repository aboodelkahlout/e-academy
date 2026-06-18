<x-mail::message>
# Introduction

The body of your message.

from: {{ $data['email'] }}
<br>
message: {{ $data['message'] }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
