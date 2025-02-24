<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página de Cadastro</title>
  
  <!-- Bootstrap 5.3.0 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <link href="/css/login.css" rel="stylesheet">

  <!-- jQuery 3.6.4 -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>    
</head>
<body>
  <div class="container">
    <div class="row justify-content-center login-container">
      <div class="col-md-6 col-lg-4">
        <h1 class="text-center titulo-login">Crie sua conta</h1>
        <div class="card login-card">
          <div class="card-header login-card-header">
            <h4>Cadastre-se</h4>
          </div>
          <div class="card-body login-card-body">
            <form id="formUsuario" method="POST" action="{{ route('usuarios.store') }}">
              @csrf
              <!-- Nome -->
              <div class="mb-3">
                <label for="nomeUsuario" class="form-label">Nome:</label>
                <input type="text" class="form-control" id="nomeUsuario" name="nomeUsuario" placeholder="Digite seu nome completo" required>
              </div>
              <!-- Data de Nascimento -->
              <div class="mb-3">
                <label for="dataNascimentoUsuario" class="form-label">Data de Nascimento:</label>
                <input type="date" class="form-control" id="dataNascimentoUsuario" name="dataNascimentoUsuario" required>
              </div>
              <!-- Sexo -->
              <div class="mb-3">
                <label for="sexoUsuario" class="form-label">Sexo:</label>
                <select class="form-control" id="sexoUsuario" name="sexoUsuario" required>
                  <option value="">Selecione</option>
                  <option value="Masculino">Masculino</option>
                  <option value="Feminino">Feminino</option>
                  <option value="Outro">Outro</option>
                </select>
              </div>
              <!-- Usuário -->
              <div class="mb-3">
                <label for="usuarioUsuario" class="form-label">Usuário:</label>
                <input type="text" class="form-control" id="usuarioUsuario" name="usuarioUsuario" placeholder="Escolha um nome de usuário" required>
              </div>
              <!-- Senha -->
              <div class="mb-3">
                <label for="senhaUsuario" class="form-label">Senha:</label>
                <input type="password" class="form-control" id="senhaUsuario" name="senhaUsuario" placeholder="Crie uma senha" required>
              </div>
              <!-- Confirmação de Senha (sem atributo name para não ser enviada) -->
              <div class="mb-3">
                <label for="confirmSenhaUsuario" class="form-label">Confirme sua Senha:</label>
                <input type="password" class="form-control" id="confirmSenhaUsuario" placeholder="Repita a senha" required>
              </div>
              <button type="submit" class="btn btn-primary w-100 mt-4">Cadastrar</button>
            </form>
          </div>
        </div>
        <div class="text-center mt-3">
          <p>Já tem uma conta? <a href="/">Faça login</a></p>
        </div>
      </div>
    </div>
  </div>

  <div class="container footer static-bottom">
    <footer class="py-1">
      <div class="d-flex justify-content-between py-4 my-4">
        <div class="col-md-4 d-flex align-items-center">
          <span class="mb-3 mb-md-0 text-body-secondary">© <span id="ano"></span> Allison S. Felix</span>
        </div>
        <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
          <li class="ms-3"><a class="text-body-secondary" href="https://wa.me/5521979487551" target="_blank"><i class="bi bi-whatsapp"></i></a></li>
          <li class="ms-3"><a class="text-body-secondary" href="https://www.linkedin.com/in/allison-dos-santos-felix-743814a2/" target="_blank"><i class="bi bi-linkedin"></i></a></li>
          <li class="ms-3"><a class="text-body-secondary" href="https://github.com/allisonfelix" target="_blank"><i class="bi bi-github"></i></a></li>
        </ul>
      </div>
    </footer>
  </div>

  <!-- Bootstrap Bundle -->
  <!-- Certifique-se de incluir o SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
  $('#formUsuario').submit(function(e) {
    e.preventDefault(); // Impede a submissão padrão do formulário

    // Serializa os dados do formulário
    var formData = $(this).serialize();

    $.ajax({
      url: $(this).attr('action'), // rota definida no action do form (ex: route('usuarios.store'))
      type: 'POST',
      data: formData,
      success: function(response) {
        Swal.fire({
          icon: 'success',
          title: 'Cadastro realizado com sucesso!',
          confirmButtonText: 'OK',
          confirmButtonColor: "#789b37"
        }).then(function() {
          window.location.replace("/"); // Redireciona para a página de login
        });
      },
      error: function(xhr) {
        Swal.fire({
          icon: 'error',
          title: 'Erro no cadastro',
          text: 'Verifique os dados e tente novamente.'
        });
      }
    });
  });
});
</script>

</body>
</html>
