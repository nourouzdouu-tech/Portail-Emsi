<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMSI Career Connect - Portail d'emploi pour lauréats</title>
    <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    body { background-color: #f5f7fa; }
    .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

    /* Header */
    header { background-color: #166534; color: white; padding: 15px 0; }
    .header-content { display: flex; justify-content: space-between; align-items: center; }
    .logo { font-size: 24px; font-weight: bold; }
    .logo span { color: #4ade80; }
    nav ul { display: flex; list-style: none; }
    nav ul li { margin-left: 20px; }
    nav ul li a { color: white; text-decoration: none; font-weight: 500; }

    /* Hero Section */
    .hero { background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url("/api/placeholder/1200/400") center/cover; color: white; padding: 80px 0; text-align: center; }
    .hero h1 { font-size: 40px; margin-bottom: 20px; }
    .hero p { font-size: 18px; margin-bottom: 30px; max-width: 700px; margin-left: auto; margin-right: auto; }
    .hero-buttons { display: flex; justify-content: center; gap: 20px; }
    .btn { display: inline-block; padding: 12px 30px; border-radius: 5px; font-weight: 600; text-decoration: none; transition: all 0.3s; }
    .btn-primary { background-color: #166534; color: white; }
    .btn-secondary { background-color: transparent; color: white; border: 2px solid white; }
    .btn:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }

    /* Stats */
    .stats { background-color: white; padding: 50px 0; }
    .stats-container { display: flex; justify-content: space-around; text-align: center; }
    .stat-item { padding: 20px; }
    .stat-number { font-size: 36px; font-weight: bold; color: #166534; margin-bottom: 10px; }
    .stat-label { font-size: 16px; color: #6b7280; }

    /* Recent Jobs */
    .recent-jobs { padding: 60px 0; }
    .section-title { text-align: center; font-size: 32px; margin-bottom: 40px; color: #166534; }
    .jobs-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 25px; }
    .job-card { background-color: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); transition: all 0.3s; }
    .job-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    .job-header { display: flex; align-items: center; padding: 15px; }
    .company-logo { width: 60px; height: 60px; background-color: #f3f4f6; border-radius: 5px; margin-right: 15px; display: flex; align-items: center; justify-content: center; }
    .job-title { font-size: 18px; font-weight: 600; margin-bottom: 5px; }
    .company-name { color: #6b7280; font-size: 14px; }
    .job-content { padding: 0 15px 15px; }
    .job-tags { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 15px; }
    .job-tag { background-color: #dcfce7; color: #22c55e; font-size: 12px; padding: 5px 10px; border-radius: 20px; }
    .job-footer { display: flex; justify-content: space-between; align-items: center; padding: 15px; border-top: 1px solid #e5e7eb; }
    .job-location { display: flex; align-items: center; color: #6b7280; font-size: 14px; }
    .job-apply { color: #166534; font-weight: 600; text-decoration: none; }

    /* Features */
    .features { background-color: #f3f4f6; padding: 60px 0; }
    .features-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px; }
    .feature-card { background-color: white; border-radius: 8px; padding: 30px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
    .feature-icon { width: 60px; height: 60px; background-color: #dcfce7; border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; }
    .feature-title { font-size: 20px; margin-bottom: 15px; color: #166534; }
    .feature-desc { color: #6b7280; line-height: 1.6; }

    /* Footer */
    footer { background-color: #14532d; color: white; padding: 50px 0 20px; }
    .footer-content { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 30px; margin-bottom: 40px; }
    .footer-column h3 { margin-bottom: 20px; font-size: 18px; }
    .footer-column ul { list-style: none; }
    .footer-column ul li { margin-bottom: 10px; }
    .footer-column ul li a { color: #bbf7d0; text-decoration: none; transition: color 0.3s; }
    .footer-column ul li a:hover { color: white; }
    .footer-bottom { text-align: center; padding-top: 20px; border-top: 1px solid #166534; font-size: 14px; color: #86efac; }

    /* Login/Register Modal */
    .modal { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 1000; }
    .modal-content { background-color: white; border-radius: 10px; max-width: 400px; width: 90%; }
    .modal-header { padding: 15px 20px; border-bottom: 1px solid #e5e7eb; position: relative; }
    .modal-title { font-size: 20px; font-weight: 600; }
    .close-modal { position: absolute; right: 20px; top: 15px; font-size: 24px; cursor: pointer; }
    .modal-body { padding: 20px; }
    .tabs { display: flex; margin-bottom: 20px; border-bottom: 1px solid #e5e7eb; }
    .tab { padding: 10px 20px; cursor: pointer; }
    .tab.active { border-bottom: 2px solid #166534; color: #166534; font-weight: 600; }
    .form-group { margin-bottom: 20px; }
    .form-label { display: block; margin-bottom: 5px; font-weight: 500; }
    .form-input { width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px; }
    .form-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 20px; }
    .remember-me { display: flex; align-items: center; }
    .checkbox { margin-right: 5px; }
    .forgot-password { color: #166534; text-decoration: none; font-size: 14px; }
    .form-button { width: 100%; padding: 12px; background-color: #166534; color: white; border: none; border-radius: 5px; font-weight: 600; cursor: pointer; margin-top: 15px; }
    .or-divider { text-align: center; margin: 20px 0; position: relative; }
    .or-divider:before,
    .or-divider:after { content: ''; position: absolute; top: 50%; width: 40%; height: 1px; background-color: #e5e7eb; }
    .or-divider:before { left: 0; }
    .or-divider:after { right: 0; }
    .social-login { display: flex; gap: 10px; }
    .social-btn { flex: 1; padding: 10px; border: 1px solid #d1d5db; border-radius: 5px; background-color: white; cursor: pointer; display: flex; align-items: center; justify-content: center; }
    .social-icon { width: 20px; height: 20px; margin-right: 10px; }
</style>

</head>
<body>
    <!-- Header -->
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

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Votre carrière commence ici</h1>
            <p>Rejoignez la communauté des lauréats EMSI et connectez-vous avec les meilleures entreprises du Maroc. Trouvez l'emploi de vos rêves et développez votre réseau professionnel.</p>
            <div class="hero-buttons">
                <a href="/login" class="btn btn-primary">Je suis lauréat</a>
                <a href="/login2" class="btn btn-secondary">Je recrute</a>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container stats-container">
            <div class="stat-item">
                <div class="stat-number">2,500+</div>
                <div class="stat-label">Lauréats inscrits</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">350+</div>
                <div class="stat-label">Entreprises partenaires</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">1,200+</div>
                <div class="stat-label">Offres d'emploi</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">85%</div>
                <div class="stat-label">Taux d'employabilité</div>
            </div>
        </div>
    </section>

    <!-- Recent Jobs Section -->
    <section class="recent-jobs">
        <div class="container">
            <h2 class="section-title">Offres d'emploi récentes</h2>
            <div class="jobs-grid">
                <!-- Job Card 1 -->
                <div class="job-card">
                    <div class="job-header">
                        <div class="company-logo">TS</div>
                        <div>
                            <div class="job-title">Développeur Full Stack</div>
                            <div class="company-name">TechMaroc Solutions</div>
                        </div>
                    </div>
                    <div class="job-content">
                        <div class="job-tags">
                            <span class="job-tag">React</span>
                            <span class="job-tag">Node.js</span>
                            <span class="job-tag">MongoDB</span>
                        </div>
                        <p>Nous recherchons un développeur Full Stack expérimenté pour rejoindre notre équipe dynamique...</p>
                    </div>
                    <div class="job-footer">
                        <div class="job-location">Casablanca</div>
                    </div>
                </div>
                
                <!-- Job Card 2 -->
                <div class="job-card">
                    <div class="job-header">
                        <div class="company-logo">MA</div>
                        <div>
                            <div class="job-title">Data Scientist</div>
                            <div class="company-name">MarocAnalytics</div>
                        </div>
                    </div>
                    <div class="job-content">
                        <div class="job-tags">
                            <span class="job-tag">Python</span>
                            <span class="job-tag">Machine Learning</span>
                            <span class="job-tag">SQL</span>
                        </div>
                        <p>Rejoignez notre équipe de data science pour travailler sur des projets innovants...</p>
                    </div>
                    <div class="job-footer">
                        <div class="job-location">Rabat</div>
                    </div>
                </div>
                
                <!-- Job Card 3 -->
                <div class="job-card">
                    <div class="job-header">
                        <div class="company-logo">CM</div>
                        <div>
                            <div class="job-title">Ingénieur DevOps</div>
                            <div class="company-name">CloudTech Maroc</div>
                        </div>
                    </div>
                    <div class="job-content">
                        <div class="job-tags">
                            <span class="job-tag">Docker</span>
                            <span class="job-tag">Kubernetes</span>
                            <span class="job-tag">AWS</span>
                        </div>
                        <p>Notre entreprise recherche un Ingénieur DevOps pour soutenir notre infrastructure cloud...</p>
                    </div>
                    <div class="job-footer">
                        <div class="job-location">Tanger</div>
                    </div>
                </div>
            </div>
            <div style="text-align: center; margin-top: 30px;">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <h2 class="section-title">Pourquoi nous choisir ?</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <h3 class="feature-title">Réseau social professionnel</h3>
                    <p class="feature-desc">Connectez-vous avec d'autres lauréats et des professionnels du secteur pour élargir votre réseau.</p>
                </div>
                <div class="feature-card">
                    <h3 class="feature-title">CV optimisés</h3>
                    <p class="feature-desc">Créez un CV attrayant avec nos modèles professionnels et augmentez vos chances d'être remarqué.</p>
                </div>
                <div class="feature-card">
                    <h3 class="feature-title">Offres exclusives</h3>
                    <p class="feature-desc">Accédez à des offres d'emploi exclusives, disponibles uniquement pour les lauréats de l'EMSI.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>À propos</h3>
                    <ul>
                        <li><a href="#">Notre mission</a></li>
                        <li><a href="#">L'équipe</a></li>
                        <li><a href="#">Partenaires</a></li>
                        <li><a href="#">Témoignages</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Ressources</h3>
                    <ul>
                        <li><a href="#">Conseils CV</a></li>
                        <li><a href="#">Préparation entretien</a></li>
                        <li><a href="#">Blog carrière</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Légal</h3>
                    <ul>
                        <li><a href="#">Conditions d'utilisation</a></li>
                        <li><a href="#">Politique de confidentialité</a></li>
                        <li><a href="#">Cookies</a></li>
                        <li><a href="#">Mentions légales</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Contact</h3>
                    <ul>
                        <li><a href="#">Support</a></li>
                        <li><a href="#">Signaler un problème</a></li>
                        <li><a href="#">Devenir partenaire</a></li>
                        <li><a href="#">Nous contacter</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 EMSI Career Connect. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
</body>
</html>