<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Conseils CV, Lettre de Motivation & Entretien</title>
    
      <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #166534 );
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .header {
            text-align: center;
            margin-bottom: 3rem;
            color: white;
        }

        .header h1 {
            font-size: 3rem;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .header p {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        .tabs-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .tabs-header {
            display: flex;
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }

        .tab-button {
            flex: 1;
            padding: 1.5rem 1rem;
            background: none;
            border: none;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            color: #166534;
        }

        .tab-button:hover {
            background: #e9ecef;
            color: #495057;
        }

        .tab-button.active {
            color: #166534;
            background: white;
        }

        .tab-button.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #166534, #2E7D32);
        }

        .tab-content {
            display: none;
            padding: 2rem;
            animation: fadeIn 0.5s ease-in-out;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .conseil-card {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid #166534;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .conseil-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .conseil-card.expanded {
            border-left-color: #2E7D32;
        }

        .conseil-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .conseil-icon {
            width: 24px;
            height: 24px;
            transition: transform 0.3s ease;
        }

        .conseil-card.expanded .conseil-icon {
            transform: rotate(180deg);
        }

        .conseil-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .conseil-card.expanded .conseil-content {
            max-height: 500px;
        }

        .conseil-list {
            list-style: none;
            padding-top: 1rem;
        }

        .conseil-list li {
            padding: 0.5rem 0;
            padding-left: 1.5rem;
            position: relative;
            color: #495057;
        }

        .conseil-list li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color:#166534;
            font-weight: bold;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #166534;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #6c757d;
            font-weight: 500;
        }

        .tips-banner {
            background: linear-gradient(135deg,rgb(22, 53, 29),rgb(34, 83, 69));
            color: white;
            padding: 2rem;
            border-radius: 12px;
            text-align: center;
            margin-top: 2rem;
        }

        .tips-banner h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 1.5rem;
            flex-wrap: wrap;
        }

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

        .search-container {
            margin-bottom: 2rem;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid #e9ecef;
            border-radius: 50px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .search-input:focus {
            outline: none;
            border-color: #166534;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .header h1 {
                font-size: 2rem;
            }

            .tabs-header {
                flex-direction: column;
            }

            .tab-button {
                text-align: center;
            }

            .stats-container {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
                align-items: center;
            }
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #000;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .hidden {
            display: none !important;
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

    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Conseils Emploi</h1>
            <p>Votre guide complet pour réussir CV, lettre de motivation et entretien</p>
        </div>

        <!-- Stats -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-number" id="statsCV">{{ $conseilsCV->count() }}</div>
                <div class="stat-label">Conseils CV</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="statsLettre">{{ $conseilsLettre->count() }}</div>
                <div class="stat-label">Conseils Lettre</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="statsEntretien">{{ $conseilsEntretien->count() }}</div>
                <div class="stat-label">Conseils Entretien</div>
            </div>
        </div>

        <!-- Search -->
        <div class="search-container">
            <input type="text" class="search-input" id="searchInput" placeholder="Rechercher un conseil...">
            <div class="search-icon">🔍</div>
        </div>

        <!-- Tabs Container -->
        <div class="tabs-container">
            <!-- Tabs Header -->
            <div class="tabs-header">
                <button class="tab-button active" data-tab="cv">
                    CV ({{ $conseilsCV->count() }})
                </button>
                <button class="tab-button" data-tab="lettre">
                    Lettre ({{ $conseilsLettre->count() }})
                </button>
                <button class="tab-button" data-tab="entretien">
                    Entretien ({{ $conseilsEntretien->count() }})
                </button>
            </div>

            <!-- CV Tab -->
            <div class="tab-content active" id="cv-tab">
                <h2 style="margin-bottom: 1.5rem; color: #2c3e50;">Conseils pour votre CV</h2>
                <div id="cv-conseils">
                    @foreach($conseilsCV as $conseil)
                    <div class="conseil-card" data-category="cv">
                        <div class="conseil-title">
                            {{ $conseil->titre }}
                            <svg class="conseil-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        <div class="conseil-content">
                            <ul class="conseil-list">
                                @if(is_array($conseil->contenu))
                                    @foreach($conseil->contenu as $item)
                                    <li>{{ $item }}</li>
                                    @endforeach
                                @else
                                    <li>{{ $conseil->contenu }}</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Lettre Tab -->
            <div class="tab-content" id="lettre-tab">
                <h2 style="margin-bottom: 1.5rem; color: #2c3e50;">Conseils pour votre lettre de motivation</h2>
                <div id="lettre-conseils">
                    @foreach($conseilsLettre as $conseil)
                    <div class="conseil-card" data-category="lettre">
                        <div class="conseil-title">
                            {{ $conseil->titre }}
                            <svg class="conseil-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        <div class="conseil-content">
                            <ul class="conseil-list">
                                @if(is_array($conseil->contenu))
                                    @foreach($conseil->contenu as $item)
                                    <li>{{ $item }}</li>
                                    @endforeach
                                @else
                                    <li>{{ $conseil->contenu }}</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Entretien Tab -->
            <div class="tab-content" id="entretien-tab">
                <h2 style="margin-bottom: 1.5rem; color: #2c3e50;">Conseils pour votre entretien</h2>
                <div id="entretien-conseils">
                    @foreach($conseilsEntretien as $conseil)
                    <div class="conseil-card" data-category="entretien">
                        <div class="conseil-title">
                            {{ $conseil->titre }}
                            <svg class="conseil-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        <div class="conseil-content">
                            <ul class="conseil-list">
                                @if(is_array($conseil->contenu))
                                    @foreach($conseil->contenu as $item)
                                    <li>{{ $item }}</li>
                                    @endforeach
                                @else
                                    <li>{{ $conseil->contenu }}</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Action Banner -->
        <div class="tips-banner">
            <h3>Prêt à passer à l'action ?</h3>
            <p>Utilisez nos outils pour créer votre CV et lettre de motivation parfaits</p>
            <div class="action-buttons">
               <!-- <a href="#" class="btn btn-primary">Créer mon CV</a>
                <a href="#" class="btn btn-primary">Rédiger ma lettre</a>-->
                <button class="btn btn-secondary" onclick="imprimerConseils()">Imprimer les conseils</button>
            </div>
        </div>
    </div>

    <script>
        // Configuration CSRF pour les requêtes AJAX
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Gestion des onglets
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-tab');
                
                // Désactiver tous les onglets et contenus
                document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
                
                // Activer l'onglet et le contenu sélectionnés
                this.classList.add('active');
                document.getElementById(targetTab + '-tab').classList.add('active');
            });
        });

        // Gestion de l'expansion des cartes de conseils
        document.querySelectorAll('.conseil-card').forEach(card => {
            card.addEventListener('click', function() {
                this.classList.toggle('expanded');
            });
        });

        // Fonction de recherche
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const allCards = document.querySelectorAll('.conseil-card');
            
            allCards.forEach(card => {
                const title = card.querySelector('.conseil-title').textContent.toLowerCase();
                const content = card.querySelector('.conseil-content').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || content.includes(searchTerm)) {
                    card.style.display = 'block';
                    // Highlight search terms
                    if (searchTerm.length > 2) {
                        card.style.backgroundColor = '#fff3cd';
                        setTimeout(() => {
                            card.style.backgroundColor = '#f8f9fa';
                        }, 2000);
                    }
                } else {
                    card.style.display = 'none';
                }
            });

            // Si aucun résultat trouvé
            const visibleCards = Array.from(allCards).filter(card => card.style.display !== 'none');
            if (visibleCards.length === 0 && searchTerm.length > 0) {
                showNoResultsMessage();
            } else {
                hideNoResultsMessage();
            }
        });

        function showNoResultsMessage() {
            // Supprimer le message existant s'il y en a un
            hideNoResultsMessage();
            
            const activeTab = document.querySelector('.tab-content.active');
            const noResultsDiv = document.createElement('div');
            noResultsDiv.id = 'no-results-message';
            noResultsDiv.innerHTML = `
                <div style="text-align: center; padding: 2rem; color: #6c757d;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🔍</div>
                    <h3>Aucun résultat trouvé</h3>
                    <p>Essayez avec d'autres mots-clés</p>
                </div>
            `;
            activeTab.appendChild(noResultsDiv);
        }

        function hideNoResultsMessage() {
            const noResultsMessage = document.getElementById('no-results-message');
            if (noResultsMessage) {
                noResultsMessage.remove();
            }
        }

        // Fonction d'impression
        function imprimerConseils() {
            const printWindow = window.open('', '_blank');
            const activeTab = document.querySelector('.tab-content.active');
            const tabTitle = document.querySelector('.tab-button.active').textContent;
            
            printWindow.document.write(`
                <html>
                <head>
                    <title>Conseils ${tabTitle}</title>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; }
                        .conseil-card { margin-bottom: 1rem; padding: 1rem; border: 1px solid #ddd; }
                        .conseil-title { font-weight: bold; margin-bottom: 0.5rem; }
                        .conseil-list { list-style-type: disc; margin-left: 1rem; }
                    </style>
                </head>
                <body>
                    <h1>Conseils ${tabTitle}</h1>
                    ${activeTab.innerHTML}
                </body>
                </html>
            `);
            
            printWindow.document.close();
            printWindow.print();
        }

        // Animation au scroll
        function animateOnScroll() {
            const cards = document.querySelectorAll('.conseil-card');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            });

            cards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(card);
            });
        }

        // Sauvegarder les préférences utilisateur
        function saveUserPreferences() {
            const activeTab = document.querySelector('.tab-button.active').getAttribute('data-tab');
            localStorage.setItem('preferred_tab', activeTab);
        }

        function loadUserPreferences() {
            const preferredTab = localStorage.getItem('preferred_tab');
            if (preferredTab) {
                const tabButton = document.querySelector(`[data-tab="${preferredTab}"]`);
                if (tabButton) {
                    tabButton.click();
                }
            }
        }

        // Fonctions utilitaires
        function expandAllCards() {
            document.querySelectorAll('.conseil-card').forEach(card => {
                card.classList.add('expanded');
            });
        }

        function collapseAllCards() {
            document.querySelectorAll('.conseil-card').forEach(card => {
                card.classList.remove('expanded');
            });
        }

        // Ajouter les boutons d'expansion/réduction
        function addToggleButtons() {
            const tabsContainer = document.querySelector('.tabs-container');
            const toggleContainer = document.createElement('div');
            toggleContainer.style.cssText = 'padding: 1rem; background: #f8f9fa; border-top: 1px solid #e9ecef; text-align: center; gap: 1rem; display: flex; justify-content: center; flex-wrap: wrap;';
            
            toggleContainer.innerHTML = `
                <button onclick="expandAllCards()" class="btn btn-secondary" style="margin: 0.25rem;">
                    Tout développer
                </button>
                <button onclick="collapseAllCards()" class="btn btn-secondary" style="margin: 0.25rem;">
                    Tout réduire
                </button>
                
            `;
            
            tabsContainer.appendChild(toggleContainer);
        }

        // Export des données en JSON
        function exportToJSON() {
            const activeTabName = document.querySelector('.tab-button.active').getAttribute('data-tab');
            const activeTabContent = document.querySelector('.tab-content.active');
            const cards = activeTabContent.querySelectorAll('.conseil-card');
            
            const conseils = Array.from(cards).map(card => {
                const title = card.querySelector('.conseil-title').textContent.trim();
                const items = Array.from(card.querySelectorAll('.conseil-list li')).map(li => li.textContent.trim());
                return {
                    titre: title,
                    contenu: items,
                    categorie: activeTabName
                };
            });

            const dataStr = JSON.stringify(conseils, null, 2);
            const dataBlob = new Blob([dataStr], {type: 'application/json'});
            const url = URL.createObjectURL(dataBlob);
            
            const link = document.createElement('a');
            link.href = url;
            link.download = `conseils_${activeTabName}_${new Date().toISOString().split('T')[0]}.json`;
            link.click();
            
            URL.revokeObjectURL(url);
        }

        // Fonction pour ajouter de nouveaux conseils (pour les administrateurs)
        function ajouterConseil(categorie) {
            const titre = prompt('Titre du conseil:');
            if (!titre) return;
            
            const contenu = prompt('Contenu du conseil (séparez les points par des virgules):');
            if (!contenu) return;
            
            const contenuArray = contenu.split(',').map(item => item.trim());
            
            fetch('{{ route("conseils.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    titre: titre,
                    contenu: contenuArray,
                    categorie: categorie,
                    ordre: 999
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Conseil ajouté avec succès!');
                    location.reload();
                } else {
                    alert('Erreur lors de l\'ajout du conseil');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de l\'ajout du conseil');
            });
        }

        // Fonction de partage
        function partagerConseils() {
            if (navigator.share) {
                navigator.share({
                    title: 'Conseils Emploi',
                    text: 'Découvrez ces conseils pour réussir votre recherche d\'emploi',
                    url: window.location.href
                });
            } else {
                // Fallback pour les navigateurs qui ne supportent pas l'API de partage
                const url = window.location.href;
                navigator.clipboard.writeText(url).then(() => {
                    alert('Lien copié dans le presse-papiers!');
                });
            }
        }

        // Système de favoris
        function toggleFavori(cardElement) {
            const titre = cardElement.querySelector('.conseil-title').textContent.trim();
            let favoris = JSON.parse(localStorage.getItem('favoris_conseils') || '[]');
            
            if (favoris.includes(titre)) {
                favoris = favoris.filter(f => f !== titre);
                cardElement.classList.remove('favori');
            } else {
                favoris.push(titre);
                cardElement.classList.add('favori');
            }
            
            localStorage.setItem('favoris_conseils', JSON.stringify(favoris));
            updateFavorisDisplay();
        }

        function loadFavoris() {
            const favoris = JSON.parse(localStorage.getItem('favoris_conseils') || '[]');
            document.querySelectorAll('.conseil-card').forEach(card => {
                const titre = card.querySelector('.conseil-title').textContent.trim();
                if (favoris.includes(titre)) {
                    card.classList.add('favori');
                }
            });
        }

        function updateFavorisDisplay() {
            const favoris = JSON.parse(localStorage.getItem('favoris_conseils') || '[]');
            document.querySelectorAll('.conseil-card').forEach(card => {
                const heartIcon = card.querySelector('.heart-icon');
                if (heartIcon) {
                    const titre = card.querySelector('.conseil-title').textContent.trim();
                    heartIcon.style.color = favoris.includes(titre) ? '#e74c3c' : '#6c757d';
                }
            });
        }

        // Ajouter les icônes de cœur aux cartes
        function addHeartIcons() {
            document.querySelectorAll('.conseil-card').forEach(card => {
                const title = card.querySelector('.conseil-title');
                const heartIcon = document.createElement('span');
                heartIcon.innerHTML = '♥';
                heartIcon.className = 'heart-icon';
                heartIcon.style.cssText = 'cursor: pointer; margin-left: 0.5rem; color: #6c757d; transition: color 0.3s ease;';
                heartIcon.addEventListener('click', (e) => {
                    e.stopPropagation();
                    toggleFavori(card);
                });
                title.appendChild(heartIcon);
            });
        }

        // Fonction de feedback
        function envoyerFeedback() {
            const feedback = prompt('Votre avis sur ces conseils (optionnel):');
            const rating = prompt('Note de 1 à 5 (5 = excellent):');
            
            if (rating && rating >= 1 && rating <= 5) {
                // Ici vous pourriez envoyer le feedback à votre serveur
                console.log('Feedback:', { feedback, rating });
                alert('Merci pour votre retour!');
                
                // Sauvegarder localement pour analytics
                const feedbackData = JSON.parse(localStorage.getItem('user_feedback') || '[]');
                feedbackData.push({
                    date: new Date().toISOString(),
                    rating: parseInt(rating),
                    comment: feedback,
                    page: window.location.pathname
                });
                localStorage.setItem('user_feedback', JSON.stringify(feedbackData));
            }
        }

        // Initialisation au chargement de la page
        document.addEventListener('DOMContentLoaded', function() {
            // Charger les préférences utilisateur
            loadUserPreferences();
            
            // Ajouter les boutons de contrôle
            addToggleButtons();
            
            // Ajouter les icônes de favoris
            addHeartIcons();
            
            // Charger les favoris
            loadFavoris();
            
            // Animation au scroll
            animateOnScroll();
            
            // Sauvegarder les préférences quand on change d'onglet
            document.querySelectorAll('.tab-button').forEach(button => {
                button.addEventListener('click', saveUserPreferences);
            });
            
            // Ajouter un bouton de feedback
            const feedbackButton = document.createElement('button');
            feedbackButton.textContent = '💬 Donner votre avis';
            feedbackButton.className = 'btn btn-secondary';
            feedbackButton.style.cssText = 'position: fixed; bottom: 20px; right: 20px; z-index: 1000; border-radius: 25px;';
            feedbackButton.addEventListener('click', envoyerFeedback);
            document.body.appendChild(feedbackButton);
            
            // Ajouter un bouton de partage
            const shareButton = document.createElement('button');
            shareButton.textContent = '🔗 Partager';
            shareButton.className = 'btn btn-primary';
            shareButton.style.cssText = 'position: fixed; bottom: 20px; left: 20px; z-index: 1000; border-radius: 25px;';
            shareButton.addEventListener('click', partagerConseils);
            document.body.appendChild(shareButton);
            
            // Analytics simples
            const visitData = JSON.parse(localStorage.getItem('visit_stats') || '{}');
            const today = new Date().toDateString();
            visitData[today] = (visitData[today] || 0) + 1;
            localStorage.setItem('visit_stats', JSON.stringify(visitData));
            
            console.log('📊 Statistiques de visite:', visitData);
        });

        // Raccourcis clavier
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey || e.metaKey) {
                switch(e.key) {
                    case '1':
                        e.preventDefault();
                        document.querySelector('[data-tab="cv"]').click();
                        break;
                    case '2':
                        e.preventDefault();
                        document.querySelector('[data-tab="lettre"]').click();
                        break;
                    case '3':
                        e.preventDefault();
                        document.querySelector('[data-tab="entretien"]').click();
                        break;
                    case 'f':
                        e.preventDefault();
                        document.getElementById('searchInput').focus();
                        break;
                    case 'p':
                        e.preventDefault();
                        imprimerConseils();
                        break;
                }
            }
        });

        // CSS supplémentaire pour les favoris
        const additionalCSS = `
            .conseil-card.favori {
                border-left-color: #e74c3c;
                background: linear-gradient(135deg, #fff5f5, #f8f9fa);
            }
            
            .heart-icon:hover {
                color: #e74c3c !important;
                transform: scale(1.2);
            }
            
            @media print {
                .btn, .search-container, .tips-banner {
                    display: none !important;
                }
                .tabs-header {
                    display: none !important;
                }
                .conseil-card {
                    break-inside: avoid;
                    margin-bottom: 1rem;
                }
            }
        `;
        
        const styleSheet = document.createElement('style');
        styleSheet.textContent = additionalCSS;
        document.head.appendChild(styleSheet);
    </script>
</body>
</html>