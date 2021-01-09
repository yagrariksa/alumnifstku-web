@component('mail::message')
# Notifikasi Sharing Memory

<img src="{{$foto}}" alt="">

{{$subjek}} {{$tindakan}} postingan anda.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
