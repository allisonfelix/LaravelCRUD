const d = new Date();
let year = d.getFullYear();
document.getElementById("ano").innerHTML = year;

$(document).ready(function() {
    const themeSwitch = $('#themeSwitch');
    const html = $('html');

    // Verificar tema salvo no localStorage
    const savedTheme = localStorage.getItem('theme') || 'dark';
    html.attr('data-bs-theme', savedTheme);
    themeSwitch.prop('checked', savedTheme === 'light');

    // Evento de clique no switch
    themeSwitch.on('change', function() {
        const isDark = $(this).prop('checked');
        const newTheme = isDark ? 'light' : 'dark';

    html.attr('data-bs-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    });

    // Opcional: Detectar preferência do sistema
    const darkModeMediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
    if(!localStorage.getItem('theme')) {
        html.attr('data-bs-theme', darkModeMediaQuery.matches ? 'light' : 'dark');
    themeSwitch.prop('checked', darkModeMediaQuery.matches);
    }
});

$(document).ready(function () {
    var options = {
        placeholder: '00:00',
        translation: {
            2: { pattern: /[0-5]/ },  // Para o primeiro dígito dos minutos (0-5)
            3: { pattern: /[0-9]/ },  // Para o segundo dígito dos minutos (0-9)
            5: { pattern: /[0-5]/ },  // Para o primeiro dígito dos segundos (0-5)
            6: { pattern: /[0-9]/ },  // Para o segundo dígito dos segundos (0-9)
        },
        onKeyPress: function (cep, e, field, options) {
            var mask = '59:59';  // A máscara vai até 59 minutos e 59 segundos
            field.mask(mask, options);
        }
    };

    $('#duracaoMusica').mask('59:59', options);  // Máscara para minutos:segundos
    $('#musica_duracao_editar').mask('59:59', options);  // Máscara para minutos:segundos
});
