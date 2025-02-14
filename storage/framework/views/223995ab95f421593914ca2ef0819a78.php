<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD de Usuários, Álbuns e Músicas</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="/css/estilo.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
  <div class="container mt-5">
    <h1 class="text-center">Sistema de Gerenciamento</h1>
    <ul class="nav nav-tabs" id="crudTabs">
      <li class="nav-item">
        <a class="nav-link active" href="#usuarios" data-bs-toggle="tab">Usuários</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#albuns" data-bs-toggle="tab">Álbuns</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#musicas" data-bs-toggle="tab">Músicas</a>
      </li>
    </ul>

    <div class="tab-content mt-3">
      <!-- Aba de Usuários -->
      <div class="tab-pane fade show active" id="usuarios">
        <h2>Usuários</h2>
        <!-- Formulário de Cadastro de Usuário -->
        <form id="formUsuario" class="mb-3">
          <div class="mb-3">
            <label for="nomeUsuario" class="form-label">Nome:</label>
            <input type="text" class="form-control" id="nomeUsuario" required>
          </div>
          <div class="mb-3">
            <label for="dataNascimentoUsuario" class="form-label">Data de Nascimento:</label>
            <input type="date" class="form-control" id="dataNascimentoUsuario" required>
          </div>
          <div class="mb-3">
            <label for="sexoUsuario" class="form-label">Sexo:</label>
            <select class="form-control" id="sexoUsuario" required>
              <option value="Masculino">Masculino</option>
              <option value="Feminino">Feminino</option>
              <option value="Outro">Outro</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="usuarioUsuario" class="form-label">Usuário:</label>
            <input type="text" class="form-control" id="usuarioUsuario" required>
          </div>
          <div class="mb-3">
            <label for="senhaUsuario" class="form-label">Senha:</label>
            <input type="password" class="form-control" id="senhaUsuario" required>
          </div>
          <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>

        <!-- Listagem de Usuários -->
        <h3>Lista de Usuários</h3>
        <table class="table table-striped" id="tabelaUsuarios">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nome</th>
              <th>Data de Nascimento</th>
              <th>Sexo</th>
              <th>Usuário</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Teste</td>
              <td>Teste</td>
              <td>Teste</td>
              <td>Teste</td>
              <td>Teste</td>
              <td align="left"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"></path>
                  <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"></path>
                </svg></td>
            </tr>
          </tbody>
        </table>
      </div>

          <!-- Aba de Álbuns -->
          <div class="tab-pane fade" id="albuns">
            <h2>Álbuns</h2>
            <!-- Formulário de Cadastro de Álbum -->
            <form id="formAlbum" class="mb-3">
              <div class="mb-3">
                <label for="nomeAlbum" class="form-label">Nome:</label>
                <input type="text" class="form-control" id="nomeAlbum" required>
              </div>
              <div class="mb-3">
                <label for="anoLancamento" class="form-label">Ano de Lançamento:</label>
                <input type="number" class="form-control" id="anoLancamento" required>
              </div>
              <div class="mb-3">
                <label for="artistaAlbum" class="form-label">Artista:</label>
                <input type="text" class="form-control" id="artistaAlbum" required>
              </div>
              <button type="submit" class="btn btn-primary">Cadastrar</button>
            </form>

            <!-- Listagem de Álbuns -->
            <h3>Lista de Álbuns</h3>
            <table class="table table-striped" id="tabelaAlbuns">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nome</th>
                  <th>Ano de Lançamento</th>
                  <th>Artista</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>

          <!-- Aba de Músicas -->
          <div class="tab-pane fade" id="musicas">
            <h2>Músicas</h2>
            <!-- Formulário de Cadastro de Música -->
            <form id="formMusica" class="mb-3">
              <div class="mb-3">
                <label for="nomeMusica" class="form-label">Nome:</label>
                <input type="text" class="form-control" id="nomeMusica" required>
              </div>
              <div class="mb-3">
                <label for="duracaoMusica" class="form-label">Duração (em segundos):</label>
                <input type="number" class="form-control" id="duracaoMusica" required>
              </div>
              <div class="mb-3">
                <label for="albumMusica" class="form-label">Álbum:</label>
                <select class="form-control" id="albumMusica">
                  <!-- Populado dinamicamente -->
                </select>
              </div>
              <button type="submit" class="btn btn-primary">Cadastrar</button>
            </form>

            <!-- Listagem de Músicas -->
            <h3>Lista de Músicas</h3>
            <table class="table table-striped" id="tabelaMusicas">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nome</th>
                  <th>Duração</th>
                  <th>Álbum</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
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

  <!-- Bootstrap e Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="scripts/crud.js"></script>
</body>
</html>
<?php /**PATH C:\Users\Allison\crud-teste\resources\views/index.blade.php ENDPATH**/ ?>