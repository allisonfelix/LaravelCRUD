<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Meu Perfil Musical</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="/css/estilo.css">
  <link rel="stylesheet" href="/css/el.css">
  <link rel="stylesheet" href="/css/switch.css">

  <!-- jQuery 3.6.4 -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>
<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                @if(Auth::user()->sexo == "Masculino")
                    Bem-vindo,
                @elseif(Auth::user()->sexo == "Feminino")
                    Bem-vinda,
                @else
                    Bem-vindx,
                @endif
                {{ explode(' ', Auth::user()->nome)[0] }}
            </a>

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
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#albuns">Álbuns</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" data-bs-target="#musicas">Músicas</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Meu Perfil
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="nav-item"><a class="dropdown-item" data-bs-toggle="tab" data-bs-target="#perfil">Meus Dados</a></li>
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

  <div class="container mt-4">
    <div class="tab-content">
      <!-- Aba de Álbuns -->
      <div class="tab-pane fade show active" id="albuns">
        <h2 class="mb-4">Meus Álbuns</h2>
        
        <!-- Formulário de Álbum -->
        <form id="formAlbumUsuario" class="mb-4" method="POST">
          @csrf
          <div class="row g-3">
            <div class="col-md-3">
              <input type="hidden" name="sid" value="{{ Auth::user()->id }}">
              <input type="text" name="nomeAlbum" id="nomeAlbum" class="form-control" placeholder="Nome do Álbum" required>
            </div>
            <div class="col-md-2">
              <input type="number" name="ano_lancamento" id="ano_lancamento" class="form-control" placeholder="Ano de Lançamento" required>
            </div>
            <div class="col-md-3">
              <input type="text" name="artistaAlbum" id="artistaAlbum" class="form-control" placeholder="Artista" required>
            </div>
            <div class="col-md-2">
              <button type="submit" formaction="{{ route('albuns.store') }}" class="btn btn-primary w-100">Adicionar</button>
            </div>
            <div class="col-md-2">
              <button type="button" id="buscaAlbumUsuario" class="btn btn-primary w-100"><i class="bi bi-search"></i> Buscar</button>
            </div>
          </div>
        </form>

        <!-- Lista de Álbuns -->
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th>Álbum</th>
                <th>Ano</th>
                <th>Artista</th>
                <th class="text-end">Ações</th>
              </tr>
            </thead>
            <tbody id="albumTabelaCorpo">
              <!-- Álbuns do Usuário -->
              @if(isset($albuns) && count($albuns) > 0)
                    @foreach($albuns as $album)
                      <tr>
                        <td>{{ $album->nome }}</td>
                        <td>{{ $album->ano }}</td>
                        <td>{{ $album->artista }}</td>
                        <td class="text-end">
                        <button class="btn btn-sm editar-album" data-id="{{ $album->id }}" data-nome="{{ $album->nome }}" data-ano="{{ $album->ano }}" data-artista="{{ $album->artista }}" data-bs-toggle="modal" data-bs-target="#modalEditarAlbum">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form action="{{ route('albuns.destroy', $album->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm delete-btn" type="submit">
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

      <!-- Aba de Músicas -->
      <div class="tab-pane fade" id="musicas">
        <h2 class="mb-4">Minhas Músicas</h2>
        
        <!-- Formulário de Música -->
        <form id="formMusicaUsuario" class="mb-4" method="POST">
          @csrf
          <input type="hidden" name="sid" value="{{ Auth::user()->id }}">
          <div class="row g-3">
            <div class="col-md-3">
              <input type="text" class="form-control" name="nomeMusica" id="nomeMusica" placeholder="Nome da Música" required>
            </div>
            <div class="col-md-2">
              <input type="number" class="form-control" name="numeroMusica" id="numeroMusica" placeholder="Número da Faixa" required>
            </div>
            <div class="col-md-1">
              <input type="text" id="duracaoMusica" class="form-control" name="duracaoMusica" placeholder="00:00" required>
            </div>
            <div class="col-md-2">
              <select class="form-select" name="albumMusica" id="albumMusica" required>
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
            <div class="col-md-2">
              <button type="submit" formaction="{{ route('musicas.store') }}" class="btn btn-primary w-100">Adicionar</button>
            </div>
            <div class="col-md-2">
              <button type="button" id="buscaMusicaUsuario" class="btn btn-primary w-100">
                <i class="bi bi-search"></i> Buscar
              </button>
            </div>
          </div>
        </form>

        <!-- Lista de Músicas -->
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th>Música</th>
                <th>Duração</th>
                <th>Faixa</th>
                <th>Álbum</th>
                <th class="text-end">Ações</th>
              </tr>
            </thead>
            <tbody id="musicaTabelaCorpo">
              @if(isset($musicas) && count($musicas) > 0)
                @foreach($musicas as $musica)
                    <tr>
                    <td>{{ $musica->nome }}</td>
                    <td>{{ str_pad(floor( $musica->duracao / 60), 2, '0', STR_PAD_LEFT) . ':' . str_pad( $musica->duracao % 60, 2, '0', STR_PAD_LEFT); }}</td>
                    <td>{{ $musica->ordem }}</td>
                    <td>{{ $musica->album ? $musica->album->nome : 'Álbum não encontrado' }}</td>
                            
                    <td class="text-end">
                      <button class="btn btn-sm editar-musica" data-id="{{ $musica->id }}" data-nome="{{ $musica->nome }}" data-faixa="{{ $musica->ordem }}" data-duracao="{{ $musica->duracao }}" data-album-id="{{ $musica->album ? $musica->album->id : 'Álbum não encontrado' }}" data-bs-toggle="modal" data-bs-target="#modalEditarMusica">
                        <i class="bi bi-pencil"></i>
                      </button>
                      <form action="{{ route('musicas.destroy', $musica->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                          <button class="btn btn-sm">
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

      <!-- Aba de Perfil -->
      <div class="tab-pane fade" id="perfil">
        <div class="row justify-content-center">
          <div class="col-md-8">
            <h2 class="mb-4">Editar Perfil</h2>
            
            <form id="formEditarPerfil">
              @csrf
              @method('PUT')
              <div class="mb-3">
                <label class="form-label">Nome Completo</label>
                <input type="text" class="form-control" value="{{ Auth::user()->nome }}" id="usuario_nome_editar" required>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <label class="form-label">Data de Nascimento</label>
                  <input type="date" class="form-control" value="{{ Auth::user()->data_nascimento }}" id="usuario_nascimento_editar" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Gênero</label>
                  <select class="form-select" id="usuario_sexo_editar" required>
                    <option value="Masculino" {{ Auth::user()->sexo == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="Feminino" {{ Auth::user()->sexo == 'Feminino' ? 'selected' : '' }}>Feminino</option>
                    <option value="Outro" {{ Auth::user()->sexo == 'Outro' ? 'selected' : '' }}>Outro</option>
                </select>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label">Nome de Usuário</label>
                <input type="text" class="form-control" value="{{ Auth::user()->usuario }}" id="usuario_usuario_editar" required>
              </div>

              <div class="mb-4">
                <label class="form-label">Alterar Senha</label>
                <input type="password" class="form-control" id="usuario_senha_editar" placeholder="Deixe em branco para manter a atual">
              </div>

              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">Salvar Alterações</button>
              </div>
            </form>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Função para ativar uma tab
        function activateTab(tabId) {
        const tabTrigger = document.querySelector(`a[href="${tabId}"]`);
        if (tabTrigger) {
            const tab = bootstrap.Tab.getInstance(tabTrigger) || new bootstrap.Tab(tabTrigger);
            tab.show();
        }
        }

        // Ativar tab inicial baseada no hash da URL
        const initialTab = window.location.hash || '#albuns';
        activateTab(initialTab);

        // Atualizar URL quando tab mudar
        document.querySelectorAll('#navbarNav a[data-bs-toggle="tab"]').forEach(link => {
        link.addEventListener('shown.bs.tab', function(e) {
            window.history.replaceState(null, null, e.target.href);
        });
        });

        // Manipular o dropdown do perfil
        const profileDropdown = document.querySelector('.nav-item.dropdown');
        if (profileDropdown) {
        profileDropdown.querySelector('.dropdown-item[data-bs-toggle="tab"]').addEventListener('click', function(e) {
            e.preventDefault();
            activateTab(this.getAttribute('href'));
        });
        }
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Função para ativar uma tab
        function activateTab(tabId) {
            const tabTrigger = document.querySelector(`a[href="${tabId}"]`)
            if (tabTrigger) {
                const tab = new bootstrap.Tab(tabTrigger)
                tab.show()
            }
        }

        // Ativar tabs ao clicar nos links
        const tabLinks = document.querySelectorAll('#navbarNav a[data-bs-toggle="tab"]')
        tabLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault()
                activateTab(this.getAttribute('href'))
            })
        })

        // Ativar tab inicial baseada no hash da URL
        const initialTab = window.location.hash || '#albuns'
        activateTab(initialTab)

        // Atualizar URL quando tab mudar
        tabLinks.forEach(link => {
            link.addEventListener('shown.bs.tab', function(e) {
                window.history.replaceState(null, null, e.target.href)
            })
        })

        // Manipular o dropdown do perfil
        const profileDropdown = document.querySelector('.nav-item.dropdown')
        if (profileDropdown) {
            profileDropdown.querySelector('.dropdown-item[data-bs-toggle="tab"]')
                .addEventListener('click', function(e) {
                    e.preventDefault()
                    activateTab(this.getAttribute('href'))
                })
        }
    })
  </script>
  <script>
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

        $("#formEditarPerfil").submit(function (e) {
              e.preventDefault();

              let nome = $("#usuario_nome_editar").val();
              let data_nascimento = $("#usuario_nascimento_editar").val();
              let sexo = $("#usuario_sexo_editar").val();
              let usuario = $("#usuario_usuario_editar").val();
              let senha = $("#usuario_senha_editar").val();

              $.ajax({
                  url: "/usuarios/" + {{ Auth::user()->id }},
                  type: "PUT",
                  data: {
                    _token: "{{ csrf_token() }}",
                    nome: nome,
                    data_nascimento: data_nascimento,
                    sexo: sexo,
                    usuario: usuario,
                    senha: senha
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

        $('#buscaMusicaUsuario').click(function(e) {
            e.preventDefault();
            let query = $('#nomeMusica').val();

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
                                        <td>${musica.nome}</td>
                                        <td>${duracaoFormatada}</td>
                                        <td>${musica.ordem}</td>
                                        <td>${albumNome}</td>
                                        <td class="text-end">
                                          <button class="btn btn-sm editar-musica" data-id="${musica.id}" data-nome="${musica.nome}" data-faixa="${musica.ordem}" data-duracao="${musica.duracao}" data-album-id="${albumId}" data-bs-toggle="modal" data-bs-target="#modalEditarMusica">
                                            <i class="bi bi-pencil"></i>
                                          </button>
                                          <form action="/musicas/${musica.id}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                              <button class="btn btn-sm">
                                                <i class="bi bi-trash"></i>
                                              </button>
                                          </form>
                                        </td>
                                    </tr>
                                `;
                            });
                        } else {
                            resultHtml = '<tr><td colspan="6" class="text-center">Nenhuma música encontrada</td></tr>';
                        }
                        $('#musicaTabelaCorpo').html(resultHtml);
                    }
                });
            } else {
                location.reload(); // Volta à lista inicial se o campo estiver vazio
            }
        });

        $('#buscaAlbumUsuario').click(function(e) {
            e.preventDefault();
            let query = $('#nomeAlbum').val();

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
                                      <td>${album.nome}</td>
                                      <td>${album.ano}</td>
                                      <td>${album.artista}</td>
                                      <td class="text-end">
                                      <button class="btn btn-sm editar-album" data-id="${album.id}" data-nome="${album.nome}" data-ano="${album.ano}" data-artista="${album.artista}" data-bs-toggle="modal" data-bs-target="#modalEditarAlbum">
                                          <i class="bi bi-pencil"></i>
                                      </button>
                                      <form action="/albuns/${album.id}" method="POST" style="display:inline;">
                                          @csrf
                                          @method('DELETE')
                                          <button class="btn btn-sm delete-btn" type="submit">
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
    });
  </script>
</body>
</html>
