<form method="POST" action="{{route('enviar.resposta')}}" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file">

    <button>Enviar</button>
</form>