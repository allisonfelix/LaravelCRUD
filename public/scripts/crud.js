const d = new Date();
let year = d.getFullYear();
document.getElementById("ano").innerHTML = year;

document.getElementById('formMusica').addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('/songs', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => alert('Música cadastrada!'))
        .catch(error => alert('Erro ao cadastrar música.'));
});

$(document).ready(function () {
    $("#formUsuario").submit(function (e) {
        e.preventDefault();

        var formData = {
            nome: $("#nomeUsuario").val(),
            data_nascimento: $("#dataNascimentoUsuario").val(),
            sexo: $("#sexoUsuario").val(),
            usuario: $("#usuarioUsuario").val(),
            senha: $("#senhaUsuario").val(),
        };

        $.ajax({
            url: '/api/usuarios', // O endpoint do seu controlador (ajuste conforme necessário)
            type: 'POST',
            data: formData,
            success: function (response) {
                alert(response.message);
                // Adicionar o usuário na tabela ou fazer outra ação
            },
            error: function (error) {
                alert("Ocorreu um erro!");
            }
        });
    });
});
