<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>Lost & Found System</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .navbar-brand {
            font-weight: bold;
        }
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-2px);
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
        }
        .navbar-nav .nav-link {
            font-weight: 500;
        }
        .navbar-nav .nav-link:hover {
            color: #007bff !important;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-search-location"></i> Lost & Found
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-exclamation-triangle"></i> Lost Items
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="modules/lost/add.php">
                                <i class="fas fa-plus"></i> Report Lost Item
                            </a></li>
                            <li><a class="dropdown-item" href="modules/lost/list.php">
                                <i class="fas fa-list"></i> View All Lost Items
                            </a></li>
                            
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-hand-holding-heart"></i> Found Items
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="modules/found/add.php">
                                <i class="fas fa-plus"></i> Report Found Item
                            </a></li>
                            <li><a class="dropdown-item" href="modules/found/list.php">
                                <i class="fas fa-list"></i> View All Found Items
                            </a></li>
                           
                        </ul>
                    </li>
                
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="modules/auth/logout.php">
                            <i class="fas fa-user-shield"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <main>
<!-- modules/lost/modules/lost/list.php -->