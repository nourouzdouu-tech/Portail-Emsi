<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMSI Career Connect - Profil Candidat</title>
    @php
    $user = Auth::user();
    $initials = 'G'; // Par défaut Guest
    if ($user) {
        $nameParts = explode(' ', $user->name);
        $initials = strtoupper(substr($nameParts[0], 0, 1));
        if (isset($nameParts[1])) {
            $initials .= strtoupper(substr($nameParts[1], 0, 1));
        }
    }
    @endphp

   <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    body { background-color: #f5f7fa; min-height: 100vh; display: flex; }
    
    /* Sidebar */
    .sidebar { width: 260px; background-color: #166534; color: white; padding: 20px 0; height: 100vh; position: fixed; }
    .sidebar-logo { padding: 0 20px 20px; font-size: 22px; font-weight: bold; border-bottom: 1px solid #22c55e; }
    .sidebar-logo span { color: #4ade80; }
    .sidebar-menu { margin-top: 30px; }
    .menu-item { padding: 12px 20px; display: flex; align-items: center; margin-bottom: 5px; cursor: pointer; transition: all 0.3s; }
    .menu-item:hover, .menu-item.active { background-color: #22c55e; }
    .menu-item .icon { margin-right: 10px; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; }
    .user-info { padding: 20px; border-top: 1px solid #22c55e; margin-top: auto; position: absolute; bottom: 0; width: 100%; }
    .user-profile { display: flex; align-items: center; }
    .user-avatar { width: 40px; height: 40px; border-radius: 50%; background-color: #d1fae5; margin-right: 10px; display: flex; align-items: center; justify-content: center; color: #166534; font-weight: bold; }
    .user-details { flex: 1; }
    .user-name { font-weight: 600; }
    .user-role { font-size: 12px; opacity: 0.8; }
    
    /* Main Content */
    .main-content { flex: 1; margin-left: 260px; padding: 20px; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
    .page-title { font-size: 24px; font-weight: bold; }
    .actions { display: flex; align-items: center; }
    .notification-bell { position: relative; margin-right: 20px; cursor: pointer; }
    .notification-badge { position: absolute; top: -5px; right: -5px; background-color: #ef4444; color: white; width: 18px; height: 18px; border-radius: 50%; font-size: 11px; display: flex; align-items: center; justify-content: center; }
    .profile-dropdown { display: flex; align-items: center; cursor: pointer; }
    .profile-name { margin-right: 10px; }
    
    /* Profile Header */
    .profile-header { background-color: white; border-radius: 12px; padding: 30px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); position: relative; }
    .profile-cover { height: 180px; background: linear-gradient(to right, #166534, #22c55e); border-radius: 8px; margin-bottom: 60px; }
    .profile-photo { width: 150px; height: 150px; border-radius: 50%; background-color: white; position: absolute; top: 150px; left: 50px; padding: 5px; }
    .profile-photo-inner { width: 100%; height: 100%; border-radius: 50%; background-color: #d1fae5; display: flex; align-items: center; justify-content: center; font-size: 40px; color: #166534; }
    .profile-info { display: flex; justify-content: space-between; align-items: flex-end; }
    .profile-basics { flex: 1; }
    .profile-name-title { display: flex; align-items: center; margin-bottom: 10px; }
    .profile-full-name { font-size: 24px; font-weight: bold; margin-right: 15px; }
    .profile-headline { font-size: 16px; color: #6b7280; }
    .profile-details { display: flex; color: #6b7280; font-size: 14px; }
    .profile-detail { display: flex; align-items: center; margin-right: 20px; }
    .profile-detail-icon { margin-right: 5px; }
    .profile-actions { display: flex; }
    .profile-action-btn { padding: 8px 15px; border-radius: 5px; font-weight: 500; margin-left: 10px; cursor: pointer; }
    .btn-primary { background-color: #166534; color: white; border: none; }
    .btn-secondary { background-color: white; color: #166534; border: 1px solid #166534; }
    .completion-bar-container { margin-top: 20px; background-color: #e5e7eb; height: 8px; border-radius: 4px; width: 100%; }
    .completion-bar { height: 100%; border-radius: 4px; background-color: #10b981; width: 83%; }
    .completion-text { font-size: 14px; color: #6b7280; margin-top: 5px; }
    
    /* Profile Tabs */
    .profile-tabs { display: flex; margin-bottom: 20px; border-bottom: 1px solid #e5e7eb; }
    .profile-tab { padding: 12px 20px; cursor: pointer; font-weight: 500; }
    .profile-tab.active { border-bottom: 2px solid #166534; color: #166534; }
    
    /* Profile Grid */
    .profile-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; }
    
    /* Profile Section */
    .profile-section { background-color: white; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
    .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
    .section-title { font-size: 18px; font-weight: 600; }
    .section-action { color: #166534; cursor: pointer; font-size: 14px; }
    
    /* About */
    .about-text { line-height: 1.6; color: #4b5563; }
    
    /* Education */
    .education-item { margin-bottom: 20px; }
    .education-item:last-child { margin-bottom: 0; }
    .education-header { display: flex; margin-bottom: 10px; }
    .education-logo { width: 60px; height: 60px; background-color: #f3f4f6; border-radius: 5px; margin-right: 15px; display: flex; align-items: center; justify-content: center; }
    .education-info { flex: 1; }
    .education-school { font-weight: 600; margin-bottom: 5px; }
    .education-degree { color: #4b5563; }
    .education-dates { color: #6b7280; font-size: 14px; }
    .education-description { color: #4b5563; line-height: 1.5; }
    
    /* Skills */
    .skills-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; }
    .skill-item { background-color: #f3f4f6; border-radius: 5px; padding: 12px; display: flex; align-items: center; }
    .skill-icon { width: 36px; height: 36px; background-color: #d1fae5; border-radius: 5px; display: flex; align-items: center; justify-content: center; margin-right: 10px; }
    .skill-info { flex: 1; }
    .skill-name { font-weight: 500; margin-bottom: 5px; }
    .skill-level { display: flex; align-items: center; }
    .skill-level-bar { height: 6px; background-color: #e5e7eb; flex: 1; border-radius: 3px; overflow: hidden; }
    .skill-level-fill { height: 100%; background-color: #166534; }
    .skill-level-text { margin-left: 10px; font-size: 12px; color: #6b7280; }
    
    /* Experience */
    .experience-item { margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #e5e7eb; }
    .experience-item:last-child { margin-bottom: 0; border-bottom: none; padding-bottom: 0; }
    .experience-header { display: flex; margin-bottom: 10px; }
    .experience-logo { width: 60px; height: 60px; background-color: #f3f4f6; border-radius: 5px; margin-right: 15px; display: flex; align-items: center; justify-content: center; }
    .experience-info { flex: 1; }
    .experience-title { font-weight: 600; margin-bottom: 5px; }
    .experience-company { color: #4b5563; }
    .experience-dates { color: #6b7280; font-size: 14px; }
    .experience-description { color: #4b5563; line-height: 1.5; }
    
    /* Projects */
    .projects-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; }
    .project-card { background-color: #f3f4f6; border-radius: 8px; overflow: hidden; }
    .project-image { height: 120px; background-color: #d1d5db; }
    .project-content { padding: 15px; }
    .project-title { font-weight: 600; margin-bottom: 5px; }
    .project-desc { color: #4b5563; font-size: 14px; line-height: 1.5; margin-bottom: 10px; height: 42px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
    .project-tags { display: flex; flex-wrap: wrap; gap: 5px; }
    .project-tag { background-color: #d1fae5; color: #166534; padding: 3px 8px; border-radius: 20px; font-size: 12px; }
    
    /* Languages */
    .languages-list { display: flex; flex-wrap: wrap; gap: 15px; }
    .language-item { width: calc(50% - 8px); }
    .language-name { font-weight: 500; margin-bottom: 5px; }
    .language-level-bar { height: 6px; background-color: #e5e7eb; width: 100%; border-radius: 3px; overflow: hidden; }
    .language-level-fill { height: 100%; background-color: #166534; }
    
    /* Right Sidebar */
    .profile-sidebar { position: sticky; top: 20px; }
    .network-stats { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-bottom: 10px; }
    .network-stat { background-color: #f3f4f6; padding: 15px; border-radius: 8px; text-align: center; }
    .network-stat-value { font-size: 22px; font-weight: 600; color: #166534; margin-bottom: 5px; }
    .network-stat-label { color: #6b7280; font-size: 14px; }
    
    /* Connections */
    .connections-list { margin-top: 15px; }
    .connection-item { display: flex; padding: 10px 0; border-bottom: 1px solid #e5e7eb; }
    .connection-item:last-child { border-bottom: none; }
    .connection-avatar { width: 40px; height: 40px; border-radius: 50%; background-color: #d1fae5; margin-right: 15px; display: flex; align-items: center; justify-content: center; color: #166534; font-weight: bold; }
    .connection-info { flex: 1; }
    .connection-name { font-weight: 500; margin-bottom: 5px; }
    .connection-title { color: #6b7280; font-size: 13px; }
    
    /* Certifications */
    .certification-item { display: flex; padding: 15px; background-color: #f3f4f6; border-radius: 8px; margin-bottom: 10px; }
    .certification-logo { width: 50px; height: 50px; background-color: white; border-radius: 5px; margin-right: 15px; display: flex; align-items: center; justify-content: center; }
    .certification-info { flex: 1; }
    .certification-name { font-weight: 600; margin-bottom: 5px; }
    .certification-org { color: #4b5563; font-size: 14px; }
    .certification-date { color: #6b7280; font-size: 13px; }
    
    /* Scrollbar */
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: #f5f7fa; }
    ::-webkit-scrollbar-thumb { background-color: #22c55e; border-radius: 10px; }
</style>

</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-logo">EMSI <span>Career</span></div>
        <div class="sidebar-menu">
           <div class="menu-item">
                <a href="/home" style="display: flex; align-items: center; color: inherit; text-decoration: none; width: 100%;">
                    <div class="icon">📊</div>
                    <span>Tableau de bord</span>
                </a>
            </div>

            <div class="menu-item active">
                <a href="/ProfilCandidat" style="display: flex; align-items: center; color: inherit; text-decoration: none; width: 100%;">
                    <div class="icon">👤</div>
                    <span>Mon profil</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="/CVLettre" style="display: flex; align-items: center; color: inherit; text-decoration: none; width: 100%;">
                    <div class="icon">📄</div>
                    <span>CV & Lettres</span>
                </a>
            </div>
           <div class="menu-item">
                <a href="/GestionOffreCand" style="display: flex; align-items: center; color: inherit; text-decoration: none; width: 100%;">
                    <div class="icon">🔍</div>
                    <span>Offres d'emploi</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="/RéseauSocial" style="display: flex; align-items: center; color: inherit; text-decoration: none; width: 100%;">
                    <div class="icon">👥</div>
                    <span>Réseau social</span>
                </a>
            </div>
           
             <div class="menu-item">
                <a href="/edit-profile" style="display: flex; align-items: center; color: inherit; text-decoration: none; width: 100%;">
                    <div class="icon">⚙️</div>
                    <span>Editer Profil</span>
                </a>
            </div>
              </br>
    </br>
      </br>
    </br>
      </br>
    
      
             <div class="menu-item">
                <a href="/login" style="display: flex; align-items: center; color: inherit; text-decoration: none; width: 100%;">
                    <div class="icon" aria-hidden="true">🔓</div>
                    <span>Se déconnecter</span>
                </a>
            </div>
        </div>
        <div class="user-info">
            <div class="user-profile">
               <div class="user-avatar">{{ $initials }}</div>

                <div class="user-details">
                    <div class="user-name">{{ $user ? $user->name : 'Invité' }}</div>
                    <div class="user-role">EMSI User</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="page-header">
            <h1 class="page-title">Mon Profil</h1>
            <div class="actions">
                <div class="notification-bell">
                    🔔
                    <span class="notification-badge">3</span>
                </div>
                 @if($user)
                    <span class="profile-name">{{ $user->name }}</span>
                @else
                    <span class="profile-name">Invité</span>
                @endif
            </div>
        </div>
        
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-cover"></div>
            <div class="profile-photo">
               <div class="profile-photo-inner">{{ $initials }}</div>
            </div>
            <br>
            <div class="profile-info">
                <div class="profile-basics">
                    <div class="profile-name-title">
                        @if($user)
                            <h2 class="profile-full-name">{{ $user->name }}</h2>
                        @else
                            <h2 class="profile-full-name">Invité</h2>
                        @endif
                        <span class="profile-headline">Ingénieur Logiciel | Lauréat EMSI</span>&nbsp
                        @if($user)
                            <span class="profile-headline">{{ $user->ville }}</span>
                        @else
                            <span class="profile-headline">ville inconnue</span>
                        @endif
                    </div>
                    <div class="profile-details">
                        <div class="profile-detail">
                            <span class="profile-detail-icon">📍</span>
                            @if($user)
                                <span>{{ $user->ville }}</span>
                            @else
                                <span>ville inconnue</span>
                            @endif
                        </div>
                        <div class="profile-detail">
                            <span class="profile-detail-icon">🎓</span>
                            <span>EMSI (2020-2024)</span>
                        </div>
                        <div class="profile-detail">
                            <span class="profile-detail-icon">📧</span>
                            @if($user)
                                <span>{{ $user->email }}</span>
                            @else
                                <span>Email inconnu</span>
                            @endif
                        </div>
                    </div>
                    <div class="completion-bar-container">
                        <div class="completion-bar"></div>
                    </div>
                    <div class="completion-text">Profil complété à 83% - Complétez votre profil pour augmenter vos chances</div>
                </div>
                <div class="profile-actions">
                    <!-- Boutons d'action optionnels -->
                </div>
            </div>
        </div>
        
        <!-- Profile Tabs -->
        <div class="profile-tabs">
            <div class="profile-tab active">Profil</div>
        </div>
        
        <!-- Profile Content -->
        <div class="profile-grid">
            <!-- Main Profile Content -->
            <div>
                <!-- About Section -->
                <div class="profile-section">
                    <div class="section-header">
                        <h3 class="section-title">À propos</h3>
                        <span class="section-action" onclick="editAbout()">Modifier</span>
                    </div>
                    <div class="about-text" id="aboutText">
                        Récemment diplômé de l'EMSI Casablanca, je suis un Ingénieur Logiciel passionné par le développement d'applications web modernes et performantes. Spécialisé en JavaScript et ses frameworks, j'aime résoudre des problèmes complexes et créer des expériences utilisateur exceptionnelles.
                    </div>
                    <div id="aboutEditForm" style="display: none;">
                        <textarea id="aboutTextarea" rows="5" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ddd;"></textarea>
                        <div style="margin-top: 10px;">
                            <button onclick="saveAbout()" class="btn-primary" style="padding: 8px 15px;">Enregistrer</button>
                            <button onclick="cancelEditAbout()" class="btn-secondary" style="padding: 8px 15px; margin-left: 10px;">Annuler</button>
                        </div>
                    </div>
                </div>
                
                <!-- Education Section -->
                <div class="profile-section">
                    <div class="section-header">
                        <h3 class="section-title">Formation</h3>
                        <span class="section-action" onclick="showAddEducationForm()">Ajouter</span>
                    </div>
                    
                    <!-- Formulaire d'ajout -->
                    <div id="addEducationForm" style="display: none; margin-bottom: 20px; background: #f9f9f9; padding: 15px; border-radius: 8px;">
                        <div style="margin-bottom: 10px;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 500;">École/Université</label>
                            <input type="text" id="educationSchool" style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #ddd;">
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Diplôme</label>
                            <input type="text" id="educationDegree" style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #ddd;">
                        </div>
                        <div style="display: flex; gap: 15px; margin-bottom: 10px;">
                            <div style="flex: 1;">
                                <label style="display: block; margin-bottom: 5px; font-weight: 500;">Date de début</label>
                                <input type="text" id="educationStartDate" placeholder="Ex: Sept 2020" style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #ddd;">
                            </div>
                            <div style="flex: 1;">
                                <label style="display: block; margin-bottom: 5px; font-weight: 500;">Date de fin</label>
                                <input type="text" id="educationEndDate" placeholder="Ex: Juin 2024" style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #ddd;">
                            </div>
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Description</label>
                            <textarea id="educationDescription" rows="3" placeholder="Décrivez votre formation..." style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #ddd;"></textarea>
                        </div>
                        <div>
                            <button onclick="addEducation()" class="btn-primary" style="padding: 8px 15px;">Ajouter</button>
                            <button onclick="cancelAddEducation()" class="btn-secondary" style="padding: 8px 15px; margin-left: 10px;">Annuler</button>
                        </div>
                    </div>
                    
                    <!-- Liste des formations -->
                    <div id="educationList">
                        <!-- Les formations seront ajoutées ici dynamiquement -->
                    </div>
                </div>
                
                <!-- Skills Section -->
                <div class="profile-section">
                    <div class="section-header">
                        <h3 class="section-title">Compétences</h3>
                        <span class="section-action" onclick="showAddSkillForm()">Ajouter</span>
                    </div>
                    
                    <!-- Formulaire d'ajout de compétence -->
                    <div id="addSkillForm" style="display: none; margin-bottom: 20px; background: #f9f9f9; padding: 15px; border-radius: 8px;">
                        <div style="margin-bottom: 10px;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Nom de la compétence</label>
                            <input type="text" id="skillName" placeholder="Ex: JavaScript" style="width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #ddd;">
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Niveau (1-100%)</label>
                            <input type="range" id="skillLevel" min="0" max="100" value="50" style="width: 100%;">
                            <span id="skillLevelValue">50%</span>
                        </div>
                        <div>
                            <button onclick="addSkill()" class="btn-primary" style="padding: 8px 15px;">Ajouter</button>
                            <button onclick="cancelAddSkill()" class="btn-secondary" style="padding: 8px 15px; margin-left: 10px;">Annuler</button>
                        </div>
                    </div>
                    
                    <!-- Liste des compétences -->
                    <div class="skills-grid" id="skillsList">
                        <!-- Les compétences seront ajoutées ici dynamiquement -->
                    </div>
                </div>
            </div>
            
            <!-- Right Sidebar -->
            <div class="profile-sidebar">
                <!-- Network Stats -->
                <div class="profile-section">
                    <div class="network-stats">
                        <div class="network-stat">
                            <div class="network-stat-value" id="connectionCount">0</div>
                            <div class="network-stat-label">Connexions</div>
                        </div>
                        <div class="network-stat">
                            <div class="network-stat-value" id="viewCount">0</div>
                            <div class="network-stat-label">Vues du profil</div>
                        </div>
                    </div>
                </div>
                
                <!-- Certifications -->
                <div class="profile-section">
                    <div class="section-header">
                        <h3 class="section-title">Certifications</h3>
                        <span class="section-action">Ajouter</span>
                    </div>
                    <div id="certificationsList">
                        <div class="certification-item">
                            <div class="certification-logo">AWS</div>
                            <div class="certification-info">
                                <div class="certification-name">AWS Certified Developer</div>
                                <div class="certification-org">Amazon Web Services</div>
                                <div class="certification-date">Obtenue en Mars 2023</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Fonctions utilitaires pour le localStorage
        function saveToLocalStorage(key, data) {
            localStorage.setItem(key, JSON.stringify(data));
        }

        function loadFromLocalStorage(key) {
            const data = localStorage.getItem(key);
            return data ? JSON.parse(data) : null;
        }

        // Fonctions pour la section À propos
        function editAbout() {
            const aboutText = document.getElementById('aboutText').innerText;
            document.getElementById('aboutText').style.display = 'none';
            document.getElementById('aboutEditForm').style.display = 'block';
            document.getElementById('aboutTextarea').value = aboutText;
        }

        function saveAbout() {
            const newText = document.getElementById('aboutTextarea').value;
            document.getElementById('aboutText').innerText = newText;
            document.getElementById('aboutText').style.display = 'block';
            document.getElementById('aboutEditForm').style.display = 'none';
            
            // Sauvegarde dans localStorage
            saveToLocalStorage('profileAbout', newText);
        }

        function cancelEditAbout() {
            document.getElementById('aboutText').style.display = 'block';
            document.getElementById('aboutEditForm').style.display = 'none';
        }

        // Fonctions pour la section Formation
        function showAddEducationForm() {
            document.getElementById('addEducationForm').style.display = 'block';
        }

        function addEducation() {
            const school = document.getElementById('educationSchool').value;
            const degree = document.getElementById('educationDegree').value;
            const startDate = document.getElementById('educationStartDate').value;
            const endDate = document.getElementById('educationEndDate').value;
            const description = document.getElementById('educationDescription').value;
            
            if (!school || !degree) {
                alert('Veuillez remplir au moins les champs École et Diplôme');
                return;
            }
            
            const newEducation = {
                school,
                degree,
                startDate,
                endDate,
                description
            };
            
            // Charger les formations existantes
            let educations = loadFromLocalStorage('profileEducations') || [];
            
            // Ajouter la nouvelle formation
            educations.unshift(newEducation);
            
            // Sauvegarder
            saveToLocalStorage('profileEducations', educations);
            
            // Mettre à jour l'affichage
            renderEducations();
            
            cancelAddEducation();
        }

        function renderEducations() {
            const educations = loadFromLocalStorage('profileEducations') || [];
            const educationList = document.getElementById('educationList');
            educationList.innerHTML = '';
            
            if (educations.length === 0) {
                // Afficher un message si aucune formation
                educationList.innerHTML = '<p style="color: #6b7280; font-style: italic;">Aucune formation ajoutée pour le moment</p>';
                return;
            }
            
            educations.forEach(edu => {
                const newEducation = document.createElement('div');
                newEducation.className = 'education-item';
                newEducation.innerHTML = `
                    <div class="education-header">
                        <div class="education-logo">${edu.school.substring(0, 3)}</div>
                        <div class="education-info">
                            <div class="education-school">${edu.school}</div>
                            <div class="education-degree">${edu.degree}</div>
                            <div class="education-dates">${edu.startDate} - ${edu.endDate}</div>
                        </div>
                    </div>
                    <div class="education-description">${edu.description}</div>
                `;
                educationList.appendChild(newEducation);
            });
        }

        function cancelAddEducation() {
            document.getElementById('addEducationForm').style.display = 'none';
            document.getElementById('educationSchool').value = '';
            document.getElementById('educationDegree').value = '';
            document.getElementById('educationStartDate').value = '';
            document.getElementById('educationEndDate').value = '';
            document.getElementById('educationDescription').value = '';
        }

        // Fonctions pour les compétences
        function showAddSkillForm() {
            document.getElementById('addSkillForm').style.display = 'block';
        }

        function addSkill() {
            const name = document.getElementById('skillName').value;
            const level = document.getElementById('skillLevel').value;
            
            if (!name) {
                alert('Veuillez entrer un nom de compétence');
                return;
            }
            
            const newSkill = {
                name,
                level: parseInt(level)
            };
            
            // Charger les compétences existantes
            let skills = loadFromLocalStorage('profileSkills') || [];
            
            // Ajouter la nouvelle compétence
            skills.push(newSkill);
            
            // Sauvegarder
            saveToLocalStorage('profileSkills', skills);
            
            // Mettre à jour l'affichage
            renderSkills();
            
            cancelAddSkill();
        }

        function renderSkills() {
            const skills = loadFromLocalStorage('profileSkills') || [];
            const skillsList = document.getElementById('skillsList');
            skillsList.innerHTML = '';
            
            if (skills.length === 0) {
                // Afficher un message si aucune compétence
                skillsList.innerHTML = '<p style="color: #6b7280; font-style: italic; grid-column: 1 / -1;">Aucune compétence ajoutée pour le moment</p>';
                return;
            }
            
            skills.forEach(skill => {
                const newSkill = document.createElement('div');
                newSkill.className = 'skill-item';
                newSkill.innerHTML = `
                    <div class="skill-icon">${skill.name.substring(0, 2)}</div>
                    <div class="skill-info">
                        <div class="skill-name">${skill.name}</div>
                        <div class="skill-level">
                            <div class="skill-level-bar">
                                <div class="skill-level-fill" style="width: ${skill.level}%;"></div>
                            </div>
                            <span class="skill-level-text">${getSkillLevelText(skill.level)}</span>
                        </div>
                    </div>
                `;
                skillsList.appendChild(newSkill);
            });
        }

        function getSkillLevelText(level) {
            if (level >= 80) return 'Expert';
            if (level >= 60) return 'Avancé';
            if (level >= 40) return 'Intermédiaire';
            return 'Débutant';
        }

        function cancelAddSkill() {
            document.getElementById('addSkillForm').style.display = 'none';
            document.getElementById('skillName').value = '';
            document.getElementById('skillLevel').value = '50';
            document.getElementById('skillLevelValue').textContent = '50%';
        }

        // Mettre à jour l'affichage du niveau lors du déplacement du slider
        document.getElementById('skillLevel').addEventListener('input', function() {
            document.getElementById('skillLevelValue').textContent = this.value + '%';
        });

        // Charger les données au démarrage
        document.addEventListener('DOMContentLoaded', function() {
            // Charger "À propos"
            const savedAbout = loadFromLocalStorage('profileAbout');
            if (savedAbout) {
                document.getElementById('aboutText').innerText = savedAbout;
            }
            
            // Charger les formations
            renderEducations();
            
            // Charger les compétences
            renderSkills();
            
            // Charger les stats de réseau (exemple)
            const stats = loadFromLocalStorage('profileStats') || { connections: 12, views: 45 };
            document.getElementById('connectionCount').textContent = stats.connections;
            document.getElementById('viewCount').textContent = stats.views;
        });
    </script>
</body>
</html>