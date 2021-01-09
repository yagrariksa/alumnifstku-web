@component('mail::message')
# Informasi Lowongan Kerja

Jabatan : {{$data->jabatan}}

Perusahaan : {{$data->perusahaan}}

Deskripsi : {{$data->deskripsi}}

Link : <a href="{{$data->link}}">click here</a>

Cluster : {{$data->cluster}}

Deadline : {{$data->deadline}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
