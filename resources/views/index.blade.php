<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>CRUD de Usuários, Álbuns e Músicas</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="/css/estilo.css">
  <link rel="stylesheet" href="/css/el.css">
  <link rel="stylesheet" href="/css/switch.css">

  <!-- Link do jQuery 3.6.4 -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>    
  
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Administrador</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="nav ms-auto">
                    <li class="nav-item d-flex align-items-center ms-2">
                        <div class="form-check form-switch my-0">
                            <input type="checkbox" class="form-check-input" id="themeSwitch">
                            <a><label class="form-check-label theme-switch" for="themeSwitch">Mudar tema</label></a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Meu Perfil
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="nav-item"><a class="dropdown-item editar-usuario" data-id="{{ Auth::user()->id }}" data-nome="{{ Auth::user()->nome }}" data-nascimento="{{ Auth::user()->data_nascimento }}" data-sexo="{{ Auth::user()->sexo }}" data-usuario="{{ Auth::user()->usuario }}"  data-bs-toggle="modal" data-bs-target="#modalEditarUsuario">
                                    Meus dados
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ url('/logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item border-0 bg-transparent">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
  </nav>

      <div class="container mt-5">
        <h1 class="text-center">Painel Administrativo</h1>
        <h4 class="text-center">Biblioteca Musical</h4>
        <br>
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
            <form id="formUsuario" class="mb-3" method="POST" action="{{ route('usuarios.store') }}">
              @csrf
              <input type="hidden" name="sid" value="{{ Auth::user()->id }}">
              <div class="mb-3">
                <label for="nomeUsuario" class="form-label">Nome:</label>
                <input type="text" class="form-control" id="nomeUsuario" name="nomeUsuario" required>
              </div>
              <div class="mb-3">
                <label for="dataNascimentoUsuario" class="form-label">Data de Nascimento:</label>
                <input type="date" class="form-control" id="dataNascimentoUsuario" name="dataNascimentoUsuario" required>
              </div>
              <div class="mb-3">
                <label for="sexoUsuario" class="form-label">Sexo:</label>
                <select class="form-control" id="sexoUsuario" name="sexoUsuario" required>
                  <option value="Masculino">Masculino</option>
                  <option value="Feminino">Feminino</option>
                  <option value="Outro">Outro</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="usuarioUsuario" class="form-label">Usuário:</label>
                <input type="text" class="form-control" id="usuarioUsuario" name="usuarioUsuario" required>
              </div>
              <div class="mb-3">
                <label for="senhaUsuario" class="form-label">Senha:</label>
                <input type="password" class="form-control" id="senhaUsuario" name="senhaUsuario" required>
              </div>
              <button type="submit" class="btn btn-primary">Cadastrar</button>
            </form>

            <!-- Listagem de Usuários -->
            <div class="table-responsive">
                <h3>Lista de Usuários</h3>

                <!-- Pesquisa de Usuários -->
                <div class="container">
                    <div class="row height d-flex justify-content-center align-items-center">
                      <div class="col-md">
                        <div class="search">
                          <i class="fa fa-search"></i>
                          <input type="text" class="form-control" id="buscaUsuario" placeholder="Pesquise um usuário">
                          <button class="btn btn-primary">Buscar</button>
                        </div>
                      </div>
                    </div>
                </div>

                <table class="table table-striped" id="tabelaUsuarios">
                  @csrf
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
                  <tbody id="usuarioTabelaCorpo">
                  @if(isset($usuarios) && count($usuarios) > 0)
                    @foreach($usuarios as $usuario)
                        <tr>
                          <td>{{ $usuario->id }}</td>
                          <td>{{ $usuario->nome }}</td>
                          <td>{{ \Carbon\Carbon::parse($usuario->data_nascimento)->format('d/m/Y') }}</td>
                          <td>{{ $usuario->sexo }}</td>
                          <td>{{ $usuario->usuario }}</td>
                          <td>
                                <a href="#" class="editar-usuario" data-id="{{ $usuario->id }}" data-nome="{{ $usuario->nome }}" data-nascimento="{{ $usuario->data_nascimento }}" data-sexo="{{ $usuario->sexo }}" data-usuario="{{ $usuario->usuario }}"  data-bs-toggle="modal" data-bs-target="#modalEditarUsuario">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                &#9;
                                <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="dashboardAction delete-btn" type="submit" style="border:none; background:none; cursor:pointer;">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                  @endif
                  </tbody>
                </table>
            </div>

            <!-- Modal para Editar Usuário -->
         <div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">
             <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                 <h5 class="modal-title" id="modalEditarUsuarioLabel">Editar Usuário</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                 </div>
                 <div class="modal-body">
                 <form id="formEditarUsuario">
                     @csrf
                     @method('PUT')
                     <input type="hidden" id="usuario_id_editar">
                     <div class="mb-3">
                     <label for="usuario_nome_editar" class="form-label">Nome:</label>
                     <input type="text" class="form-control" id="usuario_nome_editar" name="nome" required>
                     </div>
                     <div class="mb-3">
                     <label for="usuario_nascimento_editar" class="form-label">Data de Nascimento:</label>
                     <input type="date" class="form-control" id="usuario_nascimento_editar" name="data_nascimento" required>
                     </div>
                     <div class="mb-3">
                     <label for="usuario_sexo_editar" class="form-label">Sexo:</label>
                     <select class="form-control" id="usuario_sexo_editar" name="sexo" required>
                         <option value="Masculino">Masculino</option>
                         <option value="Feminino">Feminino</option>
                         <option value="Outro">Outro</option>
                     </select>
                     </div>
                     <div class="mb-3">
                     <label for="usuario_usuario_editar" class="form-label">Usuário:</label>
                     <input type="text" class="form-control" id="usuario_usuario_editar" name="usuario" required>
                     </div>
                     <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                 </form>
                 </div>
             </div>
             </div>
         </div>
          </div>

            <!-- Aba de Álbuns -->
            <div class="tab-pane fade" id="albuns">
            <h2>Álbuns</h2>
            <!-- Formulário de Cadastro de Álbum -->
            <form id="formAlbum" class="mb-3" method="POST" action="{{ route('albuns.store') }}">
                @csrf
                <input type="hidden" name="sid" value="{{ Auth::user()->id }}">
                <div class="mb-3">
                <label for="nomeAlbum" class="form-label">Nome:</label>
                <input type="text" class="form-control" id="nomeAlbum" name="nomeAlbum" required>
                </div>
                <div class="mb-3">
                <label for="ano_lancamento" class="form-label">Ano de Lançamento:</label>
                <input type="number" class="form-control" id="ano_lancamento" name="ano_lancamento" required>
                </div>
                <div class="mb-3">
                <label for="artistaAlbum" class="form-label">Artista:</label>
                <input type="text" class="form-control" id="artistaAlbum" name="artistaAlbum" required>
                </div>
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </form>

            <!-- Listagem de Álbuns -->
            <div class="table-responsive">
                <h3>Lista de Álbuns</h3>

                <!-- Pesquisa de Álbuns -->
                <div class="container">
                    <div class="row height d-flex justify-content-center align-items-center">
                      <div class="col-md">
                        <div class="search">
                          <i class="fa fa-search"></i>
                          <input type="text" class="form-control" id="buscaAlbum" placeholder="Pesquise um álbum">
                          <button class="btn btn-primary">Buscar</button>
                        </div>
                      </div>
                    </div>
                </div>

                <table class="table table-striped" id="tabelaAlbuns">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Ano</th>
                        <th>Artista</th>
                        <th>Criado por</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody id="albumTabelaCorpo">
                    @if(isset($albuns) && count($albuns) > 0)
                    @foreach($albuns as $album)
                        <tr>
                        <td>{{ $album->id }}</td>
                        <td>{{ $album->nome }}</td>
                        <td>{{ $album->ano }}</td>
                        <td>{{ $album->artista }}</td>
                        <td>{{ \App\Models\User::find($album->user_id)->nome }}</td>
                        <td>
                            <a href="#" class="dashboardAction editar-album" data-id="{{ $album->id }}" data-nome="{{ $album->nome }}" data-ano="{{ $album->ano }}" data-artista="{{ $album->artista }}" data-bs-toggle="modal" data-bs-target="#modalEditarAlbum">
                                <i class="bi bi-pencil"></i>
                            </a>
                            &#9;
                            <form action="{{ route('albuns.destroy', $album->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="dashboardAction delete-btn" type="submit" style="border:none; background:none; cursor:pointer;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                        </tr>
                    @endforeach
                    @endif
                    </tbody>
                </table>
            </div>

            <!-- Modal para Editar de Álbum -->
            <div class="modal fade" id="modalEditarAlbum" tabindex="-1" aria-labelledby="modalEditarAlbumLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editarAlbumLabel">Editar Álbum</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formEditarAlbum">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="album_id_editar">
        
                                <div class="mb-3">
                                    <label for="album_nome_editar" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="album_nome_editar" required>
                                </div>

                                <div class="mb-3">
                                    <label for="album_ano_editar" class="form-label">Ano de Lançamento</label>
                                    <input type="number" class="form-control" id="album_ano_editar" required>
                                </div>

                                <div class="mb-3">
                                    <label for="album_artista_editar" class="form-label">Artista</label>
                                    <input type="text" class="form-control" id="album_artista_editar" required>
                                </div>
        
                                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

              </div>

              <!-- Aba de Músicas -->
              <div class="tab-pane fade" id="musicas">
                <h2>Músicas</h2>
                <!-- Formulário de Cadastro de Música -->
                <form id="formMusica" class="mb-3" method="POST" action="{{ route('musicas.store') }}">
                  @csrf
                  <input type="hidden" name="sid" value="{{ Auth::user()->id }}">
                  <div class="mb-3">
                    <label for="nomeMusica" class="form-label">Nome:</label>
                    <input type="text" class="form-control" id="nomeMusica" name="nomeMusica" required>
                  </div>
                  <div class="mb-3">
                    <label for="numeroMusica" class="form-label">Número da faixa:</label>
                    <input type="number" class="form-control" id="numeroMusica" name="numeroMusica" required>
                  </div>
                  <div class="mb-3">
                    <label for="duracaoMusica" class="form-label">Duração (em minutos):</label>
                    <input type="text" placeholder="00:00" class="form-control" id="duracaoMusica" name="duracaoMusica" required>
                  </div>
                  <div class="mb-3">
                    <label for="albumMusica" class="form-label">Álbum:</label>
                    <select class="form-control" id="albumMusica" name="albumMusica" required>
                      @if(isset($albuns) && count($albuns) > 0)
                          <option value="">Selecione um álbum</option>
                          @foreach($albuns as $album)
                              <option value="{{ $album->id }}">{{ $album->nome }} ({{ $album->artista }})</option>
                          @endforeach
                      @else
                          <option value="">Nenhum álbum encontrado</option>
                      @endif
                    </select>
                  </div>
                  <button type="submit" class="btn btn-primary">Cadastrar</button>
                </form>

                <!-- Listagem de Músicas -->
                <div class="table-responsive">
                    <h3>Lista de Músicas</h3>

                    <!-- Pesquisa de Músicas -->
                    <div class="container">
                        <div class="row height d-flex justify-content-center align-items-center">
                          <div class="col-md">
                            <div class="search">
                              <i class="fa fa-search"></i>
                              <input type="text" class="form-control" id="buscaMusica" placeholder="Pesquise uma música">
                              <button class="btn btn-primary">Buscar</button>
                            </div>
                          </div>
                        </div>
                    </div>

                    <table class="table table-striped" id="tabelaMusicas">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Nome</th>
                          <th>#</th>
                          <th>Duração</th>
                          <th>Álbum</th>
                          <th>Ações</th>
                        </tr>
                      </thead>
                      <tbody id="musicaTabelaCorpo">
                      @if(isset($musicas) && count($musicas) > 0)
                        @foreach($musicas as $musica)
                          <tr>
                            <td>{{ $musica->id }}</td>
                            <td>{{ $musica->nome }}</td>
                            <td>{{ $musica->ordem }}</td>
                            <td>{{ str_pad(floor( $musica->duracao / 60), 2, '0', STR_PAD_LEFT) . ':' . str_pad( $musica->duracao % 60, 2, '0', STR_PAD_LEFT); }}</td>
                            <td>{{ $musica->album ? $musica->album->nome : 'Álbum não encontrado' }}</td>
                            <td>
                                <a href="#" class="dashboardAction editar-musica" data-id="{{ $musica->id }}" data-nome="{{ $musica->nome }}" data-faixa="{{ $musica->ordem }}" data-duracao="{{ $musica->duracao }}" data-album-id="{{ $musica->album ? $musica->album->id : 'Álbum não encontrado' }}" data-bs-toggle="modal" data-bs-target="#modalEditarMusica">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                &#9;
                                <form action="{{ route('musicas.destroy', $musica->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="dashboardAction delete-btn" type="submit" style="border:none; background:none; cursor:pointer;">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                          </tr>
                        @endforeach
                      @endif
                      </tbody>
                    </table>
                </div>
              </div>

              <!-- Modal para Editar Música -->
              <div class="modal fade" id="modalEditarMusica" tabindex="-1" aria-labelledby="modalEditarMusicaLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalEditarMusicaLabel">Editar Música</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                      <form id="formEditarMusica">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="musica_id_editar" name="musica_id_editar">
                        <div class="mb-3">
                          <label for="musica_nome_editar" class="form-label">Nome:</label>
                          <input type="text" class="form-control" id="musica_nome_editar" name="nomeMusica" required>
                        </div>
                        <div class="mb-3">
                          <label for="musica_ordem_editar" class="form-label">Número da faixa:</label>
                          <input type="number" class="form-control" id="musica_ordem_editar" required>
                        </div>
                        <div class="mb-3">
                          <label for="musica_duracao_editar" class="form-label">Duração (em minutos):</label>
                          <input type="text" placeholder="00:00" class="form-control" id="musica_duracao_editar" required>
                        </div>
                        <div class="mb-3">
                          <label for="musica_album_editar" class="form-label">Álbum:</label>
                          <select class="form-control" id="musica_album_editar" required>
                            @if(isset($albuns) && count($albuns) > 0)
                                <option value="">Selecione um álbum</option>
                                @foreach($albuns as $album)
                                    <option value="{{ $album->id }}">{{ $album->nome }} ({{ $album->artista }})</option>
                                @endforeach
                            @else
                                <option value="">Nenhum álbum encontrado</option>
                            @endif
                          </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
        </div>
      </div>
      
    <div class="container footer static-bottom">
        <footer class="py-1">
            <div class="d-flex justify-content-between py-4 my-4">
                <div class="col-md-4 d-flex align-items-center">
                <span class="mb-3 mb-md-0 text-body-secondary">© <span id="ano"></span> Allison S. Felix
                </span>
                </div>

                <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                <li class="ms-3"><a class="text-body-secondary" href="https://wa.me/5521979487551" target="_blank"><i class="bi bi-whatsapp"></i></a></li>
                <li class="ms-3"><a class="text-body-secondary" href="https://www.linkedin.com/in/allison-dos-santos-felix-743814a2/" target="_blank"><i class="bi bi-linkedin"></i></a></li>
                <li class="ms-3"><a class="text-body-secondary" href="https://github.com/allisonfelix" target="_blank"><i class="bi bi-github"></i></a></li>
                </ul>
            </div>
        </footer>
    </div>

  <!-- Bootstrap e Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.rawgit.com/igorescobar/jQuery-Mask-Plugin/1.14.15/dist/jquery.mask.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="/scripts/crud.js"></script>
  <script>
        var msg = '{{Session::get('alert')}}';
        var exist = '{{Session::has('alert')}}';
        if(exist){
          alert(msg);
        }

        /*
        $("#meuModal").on("show.bs.modal", function () {
            $(this).removeAttr("aria-hidden");
        });

        $("#meuModal").on("hide.bs.modal", function () {
            $(this).attr("aria-hidden", "true");
        });
        */

        $(document).ready(function () {
            // Abrir modal e preencher campos
            $(".editar-album").click(function () {
                let albumId = $(this).data("id");
                let nome = $(this).data("nome");
                let ano = $(this).data("ano");
                let artista = $(this).data("artista");

                $("#album_id_editar").val(albumId);
                $("#album_nome_editar").val(nome);
                $("#album_ano_editar").val(ano);
                $("#album_artista_editar").val(artista);
            });

            $(".editar-usuario").click(function () {
                let id = $(this).data("id");
                let usuario = $(this).data("usuario");
                let nome = $(this).data("nome");
                let nascimento = $(this).data("nascimento");
                let sexo = $(this).data("sexo");

                $("#usuario_id_editar").val(id);
                $("#usuario_usuario_editar").val(usuario);
                $("#usuario_nome_editar").val(nome);
                $("#usuario_nascimento_editar").val(nascimento);
                $("#usuario_sexo_editar").val(sexo);
            });

            $(".editar-musica").click(function () {
                let musicaId = $(this).data("id");
                let nome = $(this).data("nome");
                let faixa = $(this).data("faixa");
                let duracao = ('0' + Math.floor($(this).data("duracao") / 60)).slice(-2) + ':' + ('0' + ($(this).data("duracao") % 60)).slice(-2);
                let albumId = $(this).data("album-id");

                $("#musica_id_editar").val(musicaId);
                $("#musica_nome_editar").val(nome);
                $("#musica_ordem_editar").val(faixa);
                $("#musica_duracao_editar").val(duracao);
                $("#musica_album_editar").val(albumId);
            });

            // Submeter formulário via AJAX
            $("#formEditarAlbum").submit(function (e) {
                e.preventDefault();

                let albumId = $("#album_id_editar").val();
                let nome = $("#album_nome_editar").val();
                let ano = $("#album_ano_editar").val();
                let artista = $("#album_artista_editar").val();

                $.ajax({
                    url: "/albuns/" + albumId,
                    type: "PUT",
                    data: {
                        _token: "{{ csrf_token() }}",
                        nome: nome,
                        ano: ano,
                        artista: artista
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: "success",
                            title: "Sucesso!",
                            text: "Álbum atualizado com sucesso!",
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload(); // Recarregar página para atualizar tabela
                        });
                    },
                    error: function (error) {
                        Swal.fire({
                            icon: "error",
                            title: "Erro!",
                            text: "Não foi possível atualizar o álbum.",
                            confirmButtonColor: "#789b37",
                        });
                    }
                });
            });

          $("#formEditarUsuario").submit(function (e) {
              e.preventDefault();

              let usuario_id = $("#usuario_id_editar").val();
              let nome = $("#usuario_nome_editar").val();
              let data_nascimento = $("#usuario_nascimento_editar").val();
              let sexo = $("#usuario_sexo_editar").val();
              let usuario = $("#usuario_usuario_editar").val();

              $.ajax({
                  url: "/usuarios/" + usuario_id,
                  type: "PUT",
                  data: {
                    _token: "{{ csrf_token() }}",
                    nome: nome,
                    data_nascimento: data_nascimento,
                    sexo: sexo,
                    usuario: usuario,
                  },
                  success: function (response) {
                      console.log("Resposta do servidor:", response);
                      Swal.fire({
                          icon: "success",
                          title: "Sucesso!",
                          text: "Usuário atualizado com sucesso!",
                          timer: 2000,
                          showConfirmButton: false
                      }).then(() => {
                          location.reload();
                      });
                  },
                  error: function (xhr) {
                      console.error("Erro na requisição:", xhr.responseText);
                      Swal.fire({
                          icon: "error",
                          title: "Erro!",
                          text: "Não foi possível atualizar o usuário.",
                          confirmButtonColor: "#789b37",
                      });
                  }
              });
          });

          $("#formEditarMusica").submit(function (e) {
              e.preventDefault();

              let musica_id = $("#musica_id_editar").val();
              let nome = $("#musica_nome_editar").val();
              let faixa = $("#musica_ordem_editar").val();
              let duracao = $("#musica_duracao_editar").val();
              let album_id = $("#musica_album_editar").val();

              let dadosEnviados = {
                  _token: "{{ csrf_token() }}",
                  nome: nome,
                  duracao: duracao,
                  album_id: album_id,
                  ordem: faixa
              };

              $.ajax({
                  url: "/musicas/" + musica_id,
                  type: "PUT",
                  data: dadosEnviados,
                  success: function (response) {
                      Swal.fire({
                          icon: "success",
                          title: "Sucesso!",
                          text: "Música atualizada com sucesso!",
                          timer: 2000,
                          showConfirmButton: false
                      }).then(() => {
                          location.reload(); // Recarregar página para atualizar tabela
                      });
                  },
                  error: function (error) {
                      alert(musica_id + ": " + dadosEnviados.duracao);
                      Swal.fire({
                          icon: "error",
                          title: "Erro!",
                          text: "Não foi possível atualizar a música.",
                          confirmButtonColor: "#789b37",
                      });
                  }
              });
          });
        });

        $(document).ready(function(){
            $('#buscaUsuario').on('keyup', function() {
                let query = $(this).val();

                if (query.length > 0) {
                    $.ajax({
                        url: "{{ route('usuarios.search') }}",
                        type: "GET",
                        data: { query: query },
                        success: function(data) {
                            let resultHtml = '';
                            if (data.length > 0) {
                                data.forEach(usuario => {
                                    resultHtml += `
                                        <tr>
                                            <td>${usuario.id}</td>
                                            <td>${usuario.nome}</td>
                                            <td>${new Date(usuario.data_nascimento).toLocaleDateString('pt-BR')}</td>
                                            <td>${usuario.sexo}</td>
                                            <td>${usuario.usuario}</td>
                                            <td>
                                                <a href="#" class="editar-usuario" data-id="${usuario.id}" data-nome="${usuario.nome}" data-nascimento="${usuario.data_nascimento}" data-sexo="${usuario.sexo}" data-usuario="${usuario.usuario}" data-bs-toggle="modal" data-bs-target="#modalEditarUsuario">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                &#9;
                                                <form action="/usuarios/${usuario.id}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="dashboardAction delete-btn" type="submit" style="border:none; background:none; cursor:pointer;">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    `;
                                });
                            } else {
                                resultHtml = '<tr><td colspan="6" class="text-center">Nenhum usuário encontrado</td></tr>';
                            }
                            $('#usuarioTabelaCorpo').html(resultHtml);
                        }
                    });
                } else {
                    location.reload(); // Volta à lista inicial se o campo estiver vazio
                }
            });

            $('#buscaAlbum').on('keyup', function() {
                let query = $(this).val();

                if (query.length > 0) {
                    $.ajax({
                        url: "{{ route('albuns.search') }}",
                        type: "GET",
                        data: { query: query },
                        success: function(data) {
                            let resultHtml = '';
                            if (data.length > 0) {
                                data.forEach(album => {
                                    resultHtml += `
                                        <tr>
                                            <td>${album.id}</td>
                                            <td>${album.nome}</td>
                                            <td>${album.ano}</td>
                                            <td>${album.artista}</td>
                                            <td>
                                                <a href="#" class="dashboardAction editar-album" data-id="${album.id}" data-nome="${album.nome}" data-ano="${album.ano}" data-artista="${album.artista}" data-bs-toggle="modal" data-bs-target="#modalEditarAlbum">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                &#9;
                                                <form action="/albuns/${album.id}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="dashboardAction delete-btn" type="submit" style="border:none; background:none; cursor:pointer;">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    `;
                                });
                            } else {
                                resultHtml = '<tr><td colspan="6" class="text-center">Nenhum usuário encontrado</td></tr>';
                            }
                            $('#albumTabelaCorpo').html(resultHtml);
                        }
                    });
                } else {
                    location.reload(); // Volta à lista inicial se o campo estiver vazio
                }
            });

            $('#buscaMusica').on('keyup', function() {
                let query = $(this).val();

                if (query.length > 0) {
                    $.ajax({
                        url: "{{ route('musicas.search') }}",
                        type: "GET",
                        data: { query: query },
                        success: function(data) {
                            let resultHtml = '';
                            if (data.length > 0) {
                                data.forEach(musica => {
                                    let minutos = String(Math.floor(musica.duracao / 60)).padStart(2, '0');
                                    let segundos = String(musica.duracao % 60).padStart(2, '0');
                                    let duracaoFormatada = `${minutos}:${segundos}`;
                                    let albumNome = musica.album.nome;
                                    let albumId = musica.album.id;
                                    
                                    resultHtml += `
                                        <tr>
                                            <td>${musica.id}</td>
                                            <td>${musica.nome}</td>
                                            <td>${musica.ordem}</td>
                                            <td>${duracaoFormatada}</td>
                                            <td>${albumNome}</td>
                                            <td>
                                                <a href="#" class="dashboardAction editar-musica"
                                                   data-id="${musica.id}" data-nome="${musica.nome}"
                                                   data-faixa="${musica.ordem}" data-duracao="${musica.duracao}"
                                                   data-album-id="${albumId}" data-bs-toggle="modal"
                                                   data-bs-target="#modalEditarMusica">
                                                    <i class="bi bi-pencil"></i>
                                                &#9;
                                                <form action="/musicas/${musicas.id}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="dashboardAction delete-btn" type="submit" style="border:none; background:none; cursor:pointer;">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    `;
                                });
                            } else {
                                resultHtml = '<tr><td colspan="6" class="text-center">Nenhum usuário encontrado</td></tr>';
                            }
                            $('#musicaTabelaCorpo').html(resultHtml);
                        }
                    });
                } else {
                    location.reload(); // Volta à lista inicial se o campo estiver vazio
                }
            });
        });
    </script>
</body>
</html>
