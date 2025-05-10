<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Teste para a vaga</title>
    <link rel="apple-touch-icon" sizes="180x180" href="https://www.tgrstudio.com.br/assets/images/favicon/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="https://www.tgrstudio.com.br/assets/images/favicon/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="https://www.tgrstudio.com.br/assets/images/favicon/favicon-16x16.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!--Para o front usei um que eu tinha como base, as cores foram as que eu vi no site e as imagens acabei decidindo pegar do site em vez de fazer download e jogar para o public-->
    <style>
        
        .hero-section {
            background: linear-gradient(135deg,rgb(153, 32, 14) 0%, #000DFF 100%); 
            color: white;
            padding: 5rem 0;
        }
        .card-product {
            transition: transform 0.3s;
        }
        .card-product:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .action-buttons .btn {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <p><a href="https://www.tgrstudio.com.br/" target="_blank"><img src="https://www.tgrstudio.com.br/assets/images/logos/logo.svg" width="50" alt="TGR Logo"></a></p>
            <a class="navbar-brand"> Teste para a vaga com a criação de Produtos</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="https://www.tgrstudio.com.br/" target="_blank">TGR</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://www.instagram.com/tgrstudiodigital/" target="_blank">Instagram</a>
                    </li>
                </ul>
            </div>
            <!--<div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin">Filament (extra)</a>
                    </li>
                </ul>
            </div>-->
        </div>
    </nav>

    <section class="hero-section text-center mb-5">
        <div class="container">
            <h1 class="display-4 fw-bold">Teste Prático para Vaga de Desenvolvedor PHP/Laravel</h1>
        </div>
    </section>

    <main class="container mb-5">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p class="mb-0"> Desenvolvido por Pedro Paulo Almeida Rodrigues.</p>
        </div>
    </footer>

    <!-- Bootstrap JS + Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('scripts')
</body>
</html>