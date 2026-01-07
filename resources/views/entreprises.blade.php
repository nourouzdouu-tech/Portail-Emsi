<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Entreprises au Maroc 2025</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    body { background-color: #f5f7fa; }
    .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
       
        .header {
            background-color: #166534;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: 0.3s;
        }
        .card:hover {
            transform: scale(1.02);
        }
        .btn-custom {
            background-color: #166534;
            color: white;
        }
         /* Header */
    header { background-color: #166534; color: white; padding: 15px 0; }
    .header-content { display: flex; justify-content: space-between; align-items: center; }
    .logo { font-size: 24px; font-weight: bold; }
    .logo span { color: #4ade80; }
    nav ul { display: flex; list-style: none; }
    nav ul li { margin-left: 20px; }
    nav ul li a { color: white; text-decoration: none; font-weight: 500; }

            .company-logo { width: 60px; height: 60px; background-color: #f3f4f6; border-radius: 5px; margin-right: 15px; display: flex; align-items: center; justify-content: center; }
           .logo { font-size: 24px; font-weight: bold; }
          .logo span { color: #4ade80; }
             /* Hero Section */
    .hero { background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url("/api/placeholder/1200/400") center/cover; color: white; padding: 80px 0; text-align: center; }
    .hero h1 { font-size: 40px; margin-bottom: 20px; }
    .hero p { font-size: 18px; margin-bottom: 30px; max-width: 700px; margin-left: auto; margin-right: auto; }
    .hero-buttons { display: flex; justify-content: center; gap: 20px; }
    .btn { display: inline-block; padding: 12px 30px; border-radius: 5px; font-weight: 600; text-decoration: none; transition: all 0.3s; }
    .btn-primary { background-color: #166534; color: white; }
    .btn-secondary { background-color: transparent; color: white; border: 2px solid white; }
    .btn:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
  .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient( #166534);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.4);
        }

        .btn-secondary {
            background:rgb(24, 86, 78);
            color: white;
        }

        .btn-secondary:hover {
            background: #166534;
            transform: translateY(-2px);
        }

    </style>
</head>
<body>
       <header>
        <div class="container header-content">
            <div class="logo">EMSI <span>Career Connect</span></div>
            <nav>
                <ul>
                    <li><a href="http://127.0.0.1:8000/">Accueil</a></li>
                   <!--  <li><a href="#">Offres d'emploi</a></li>-->
                    <li><a href="entreprises">Entreprises</a></li>
                    <li><a href="/conseils">Conseils</a></li>
                   <!--  <li><a href="/login">Connexion</a></li>-->
                    <li><a href="/register" class="btn btn-primary">Inscription</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="header">
        <h1>Entreprises au Maroc - 2025</h1>
        <p>Découvrez les entreprises qui font bouger le marché marocain cette année</p>
    </div>

    <div class="container my-5">
        <div class="row">
            @foreach ($entreprises as $entreprise)
                <div class="col-md-4 mb-4">
                    <div class="card p-3">
                        <h4 style="color:#166534;">{{ $entreprise->nom }}</h4>
                        <p><strong>Secteur :</strong> {{ $entreprise->secteur }}</p>
                        <p><strong>Localisation :</strong> {{ $entreprise->ville }}, {{ $entreprise->pays }}</p>
                        <p><strong>Email :</strong> {{ $entreprise->email }}</p>
                        <a href="mailto:{{ $entreprise->email }}" class="btn btn-custom mt-2">Contacter</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</body>
</html>
