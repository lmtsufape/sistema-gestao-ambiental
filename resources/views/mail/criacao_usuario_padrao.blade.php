@component('mail::message')
    <p style="color: black; font-family: 'Times New Roman', Times, serif;">
        Devido a sua multa pelo Sistema de Gestão Ambiental da cidade de Garanhuns-PE, foi criado um usuário padrão para você no sistema. <br><strong>Email de acesso:</strong> {{ $user->email }} <br><strong>Senha:</strong> {{ $senha}} <br>
        A qualquer momento é possível alterar suas credenciais no sistema <a href="http://sgagaranhuns.site/login">LINK.</a>
    </p>
    @include('mail.footer')
@endcomponent
