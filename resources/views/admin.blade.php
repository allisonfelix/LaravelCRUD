<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Login</title>
    
    <!-- Link do Bootstrap 5.3.0 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <!-- Link para o CSS personalizado -->
    <link href="/css/login.css" rel="stylesheet">

    <!-- Link do jQuery 3.6.4 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>    
</head>

<body>

    <div class="container">
        <div class="row justify-content-center login-container">
            <div class="col-md-6 col-lg-4">
                <h1 class="text-center titulo-login">Painel Administrativo</h1>
                <div class="card login-card">
                    <div class="card-header login-card-header">
                        <h4>Login</h4>
                    </div>
                    <div class="card-body login-card-body">
                        <form id="loginForm">
                            <div class="mb-3">
                                <label for="username" class="form-label">Usuário</label>
                                <input type="text" class="form-control" id="username" placeholder="Digite seu usuário">
                                <div class="error-msg" id="usernameError">Por favor, insira seu nome de usuário.</div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="password" placeholder="Digite sua senha">
                                <div class="error-msg" id="passwordError">Por favor, insira sua senha.</div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">Lembrar-me</label>
                                </div>
                                <a href="#" class="small">Esqueceu a senha?</a>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-4">Entrar</button>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <p>Não tem uma conta? <a href="#">Cadastre-se</a></p>
                </div>
            </div>
        </div>
    </div>

    <div class="container footer">
      <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4">
        <div class="col-md-4 d-flex align-items-center">
          <span class="mb-3 mb-md-0 text-body-secondary">© <span id="ano"></span> Allison S. Felix
          </span>
        </div>

        <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
          <li class="ms-3"><a class="text-body-secondary" href="https://wa.me/5521979487551" target="_blank"><i class="bi bi-whatsapp"></i></a></li>
          <li class="ms-3"><a class="text-body-secondary" href="https://www.linkedin.com/in/allison-dos-santos-felix-743814a2/" target="_blank"><i class="bi bi-linkedin"></i></a></li>
        </ul>
      </footer>
    </div>

    <!-- Scripts Bootstrap e jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Função para validação do formulário de login
        $(document).ready(function () {
            $('#loginForm').submit(function (e) {
                e.preventDefault();

                // Limpar mensagens de erro
                $('#usernameError').hide();
                $('#passwordError').hide();

                // Obter os valores dos campos
                var username = $('#username').val().trim();
                var password = $('#password').val().trim();

                var valid = true;

                // Validar usuário
                if (username === "") {
                    $('#usernameError').show();
                    valid = false;
                }

                // Validar senha
                if (password === "") {
                    $('#passwordError').show();
                    valid = false;
                }

                // Se tudo estiver ok, podemos enviar o formulário
                if (valid) {
                    alert('Login realizado com sucesso!');
                    // Aqui você pode adicionar a lógica para enviar os dados de login para o servidor
                }
            });
        });
    </script>
    <!-- Bootstrap e Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="scripts/crud.js"></script>
</body>

</html>
