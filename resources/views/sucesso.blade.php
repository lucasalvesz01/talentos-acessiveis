<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Realizado - Talentos Acessíveis</title>

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

        /* Seção de Sucesso */
        .success-section {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #343a40;
        }

        .success-section h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            animation: fadeIn 2s ease-in-out;
        }

        .success-section p {
            font-size: 1.2rem;
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

    <!-- Seção de Sucesso -->
    <section class="success-section">
        <div class="container">
            <h1><i class="fas fa-check-circle text-success me-2"></i> Cadastro Realizado com Sucesso!</h1>
            <p>Agora você faz parte da comunidade Talentos Acessíveis.</p>
            <div>
                <!-- Botão Fazer Postagem -->
                <a href="{{ route('postagem') }}" class="btn btn-primary btn-custom">
                    Fazer Postagem <i class="fas fa-pen-to-square ms-2"></i>
                </a>
                <!-- Botão Voltar ao Início -->
                <a href="{{ route('welcome') }}" class="btn btn-secondary btn-custom">
                    Voltar ao Início <i class="fas fa-home ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Bootstrap 5 JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>