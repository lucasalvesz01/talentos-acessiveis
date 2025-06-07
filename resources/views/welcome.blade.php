<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Talentos Acessíveis</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Estilos Personalizados -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        /* Seção Hero */
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            height: 100vh;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .hero-section h1 {
            font-size: 4rem;
            font-weight: bold;
            margin-bottom: 20px;
            animation: fadeIn 2s ease-in-out;
        }

        .hero-section p {
            font-size: 1.5rem;
            margin-bottom: 30px;
            animation: fadeIn 3s ease-in-out;
        }

        /* Botões */
        .btn-custom {
            margin: 0 10px;
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 50px;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .btn-primary {
            background-color: #0d6efd;
            border: none;
        }

        .btn-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.4);
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .btn-secondary:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.4);
        }

        /* Animação de Fade-In */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>

    <!-- Seção Hero -->
    <section class="hero-section">
        <div class="container">
            <h1>Talentos Acessíveis</h1>
            <p>Ajudando pessoas com deficiência a conquistar seu espaço no mercado de trabalho.</p>
            <div>
                <!-- Botão Cadastrar -->
                <a href="{{ route('register') }}" class="btn btn-primary btn-custom">
                    Cadastrar <i class="fas fa-user-plus ms-2"></i>
                </a>
                <!-- Botão Entrar -->
                <a href="{{ route('login') }}" class="btn btn-secondary btn-custom">
                    Entrar <i class="fas fa-sign-in-alt ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Rodapé -->
    <footer class="footer">
        <div class="container text-center">
            <p class="mb-2">&copy; {{ date('Y') }} Talentos Acessíveis. Todos os direitos reservados.</p>
            <p>
                <a href="#">Sobre nós</a> | 
                <a href="#">Contato</a> | 
                <a href="#">Termos de uso</a>
            </p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>