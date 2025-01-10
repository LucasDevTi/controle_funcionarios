<!-- views/template.php -->
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Painel Administrativo' ?></title>
    <link rel="stylesheet" href="/controle_funcionarios/public/assets/css/home.css">
    <link rel="stylesheet" href="/controle_funcionarios/public/assets/css/style.css">
    <script src="/controle_funcionarios/public/assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Menu Lateral -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="#" class="brand-link">
                <span class="brand-text font-weight-light">Painel Admin</span>
            </a>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="/controle_funcionarios/public/home" class="nav-link <?= $activePage === 'home' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/controle_funcionarios/public/usuarios" class="nav-link <?= $activePage === 'usuarios' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Usuários</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/controle_funcionarios/public/configuracoes" class="nav-link <?= $activePage === 'configuracoes' ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>Configurações</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Área de Conteúdo -->
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid" id="page-content">
                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>

    <div id="loading-overlay">
        <div class="loading-spinner"></div>
    </div>

    
</body>

</html>