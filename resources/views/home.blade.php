@extends('layouts.app')

@section('content')
<style>
    /* Estilo personalizado para arredondar os cards */
    .custom-card {
        border-radius: 15px;
    }

    /* Centralizar os cards na tela */
    .center-cards {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh; /* Isso centraliza verticalmente na tela */
    }
</style>
<div class="container">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ 'Serviços no Conforto' }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>

                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editarPerfil">
                                    {{ __('Perfil') }}
                                </a>
                            </div>
                        </li>
                        <div class="modal fade" id="editarPerfil" tabindex="-1" aria-labelledby="editarPerfil" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editarPerfil">Editar perfil</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/perfil/update/{{ auth()->user()->id }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="name">Nome:</label>
                                                <input type="text" id="name" class="form-control" name="updateName" value="{{ auth()->user()->name }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="phone">Telefone:</label>
                                                <input type="text" id="phone" class="form-control" name="updatePhone" value="{{ auth()->user()->phone }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="password">Trocar Senha:</label>
                                                <input type="password" id="password" class="form-control" name="updatePassword">
                                            </div>
                                            
                                            <input type="submit"  style="margin-top: 10px;" class="btn btn-primary" value="Editar">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>




                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <div class="row justify-content-center">
        <div class="text-center mt-4"  style="margin: 20px;">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#criarAnuncio">Criar Anúncio</button>
        </div>
        <div id="search-container" class="col-md-12">
            <h1 style="margin-bottom: 10px;">Busque por um anúncio</h1>
            <form action="/home" method="GET">
                <input type="text" id="search" name="search" class="form-control rounded-pill" style="margin-bottom: 40px;" placeholder="Procurar...">
            </form>
        </div>
        @if($search)
            <h2 style="margin-bottom: 20px;">Buscando por: {{ $search }}</h2><br> 
        @endif
        <div class="modal fade" id="criarAnuncio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Criar seu anúncio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/anuncios" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="titulo">Título do Anúncio:</label>
                                <input type="text" id="titulo" class="form-control" name="tituloAnuncio">
                            </div>
                            <div class="form-group">
                                <label for="descricao">Descrição do Anúncio:</label>
                                <textarea id="descricao" class="form-control" name="descricaoAnuncio" rows="3"></textarea>
                            </div>
                            <input type="submit"  style="margin-top: 10px;" class="btn btn-primary" value="Criar">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach($anuncios as $anuncio)
            <div class="col-md-4 mb-3">
                <div class="card custom-card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $anuncio->titulo }}</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal{{ $anuncio->id }}">
                            Visualizar
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal{{ $anuncio->id }}" tabindex="-1" aria-labelledby="modalTitle{{ $anuncio->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitle{{ $anuncio->id }}">{{ $anuncio->titulo }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex">
                                <h6 style="margin: 2px;">Descrição: </h6>
                                <p>{{ $anuncio->descricao }}</p>
                            </div>
                            <div class="d-flex">
                                <h6 style="margin: 2px;">Dono: </h6>
                                <p>{{ $anuncio->user->name }}</p>
                            </div>
                            <div class="d-flex">
                                <h6 style="margin: 2px;">Telefone: </h6>
                                <p>{{ $anuncio->user->phone }}</p>
                            </div>


                            
                            @if($anuncio->user->id == auth()->user()->id)
                                <div class="d-flex">
                                    <form action="/anuncios/{{ $anuncio->id }}" method="POST"> 
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon" style="color: red;">
                                            <h6>Deletar</h6>
                                            <ion-icon name="trash-outline" style="font-size: 24px;"></ion-icon>
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-icon" style="color: blue;" data-bs-toggle="modal" data-bs-target="#editar{{ $anuncio->id }}">
                                        <h6>Editar</h6>
                                        <ion-icon name="document-outline" style="font-size: 24px;"></ion-icon>
                                    </button>
                                </div>
                            @endif     
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editar{{ $anuncio->id }}" tabindex="-1" aria-labelledby="editarModalTitle{{ $anuncio->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editarModalTitle{{ $anuncio->id }}">Editar anúncio: {{ $anuncio->titulo }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>



                        <div class="modal-body">
                            <form action="/anuncios/update/{{ $anuncio->id }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="titulo">Título do Anúncio:</label>
                                    <input type="text" id="titulo" class="form-control" name="updateTitulo" value="{{ $anuncio->titulo }}">
                                </div>
                                <div class="form-group">
                                    <label for="descricao">Descrição do Anúncio:</label>
                                    <textarea id="descricao" class="form-control" name="updateDescricao" rows="3">{{ $anuncio->descricao }}</textarea>
                                </div>
                                <input type="submit"  style="margin-top: 10px;" class="btn btn-primary" value="Editar">
                            </form>
                        </div>


                       
                    </div>
                </div>
            </div>
            












            
        @endforeach
    </div>

</div>
@endsection
