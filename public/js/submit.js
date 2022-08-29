var btn = document.getElementsByClassName("submeterFormBotao");
if(btn.length > 0){
    $(document).on('submit', 'form', function() {
        $('button').attr('disabled', 'disabled');
        for (var i = 0; i < btn.length; i++) {
        btn[i].textContent = 'Aguarde...';
        btn[i].style.backgroundColor = btn[i].style.backgroundColor + 'd8';
    }
    });
}
