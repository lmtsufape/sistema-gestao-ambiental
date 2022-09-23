@component('mail::message')
    <p style="color: black; font-family: 'Times New Roman', Times, serif;">
        A visita agendada para {{$data_marcada}}, para a empresa {{$requerimento->empresa->nome}} do requerimento de {{$requerimento->tipoString()}} foi cancelada. <br>
    </p>
    @include('mail.footer')
@endcomponent
