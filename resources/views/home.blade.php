 <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMSI Career Connect - Tableau de bord candidat</title>
    <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    body { background-color: #f5f7fa; min-height: 100vh; display: flex; }

    /* Sidebar */
    .sidebar { width: 260px; background-color: #15803d; color: white; padding: 20px 0; height: 100vh; position: fixed; }
    .sidebar-logo { padding: 0 20px 20px; font-size: 22px; font-weight: bold; border-bottom: 1px solid #22c55e; }
    .sidebar-logo span { color: #86efac; }
    .sidebar-menu { margin-top: 30px; }
    .menu-item { padding: 12px 20px; display: flex; align-items: center; margin-bottom: 5px; cursor: pointer; transition: all 0.3s; }
    .menu-item:hover, .menu-item.active { background-color: #22c55e; }
    .menu-item .icon { margin-right: 10px; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; }
    .user-info { padding: 20px; border-top: 1px solid #22c55e; margin-top: auto; position: absolute; bottom: 0; width: 100%; }
    .user-profile { display: flex; align-items: center; }
    .user-avatar { width: 40px; height: 40px; border-radius: 50%; background-color: #dcfce7; margin-right: 10px; display: flex; align-items: center; justify-content: center; color: #15803d; font-weight: bold; }
    .user-details { flex: 1; }
    .user-name { font-weight: 600; }
    .user-role { font-size: 12px; opacity: 0.8; }

    /* Main Content */
    .main-content { flex: 1; margin-left: 260px; padding: 20px; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
    .page-title { font-size: 24px; font-weight: bold; }
    .actions { display: flex; align-items: center; }
    .notification-bell { position: relative; margin-right: 20px; cursor: pointer; }
    .notification-badge { position: absolute; top: -5px; right: -5px; background-color: #dc2626; color: white; width: 18px; height: 18px; border-radius: 50%; font-size: 11px; display: flex; align-items: center; justify-content: center; }
    .profile-dropdown { display: flex; align-items: center; cursor: pointer; }
    .profile-name { margin-right: 10px; }

    /* Dashboard Content */
    .dashboard-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px; }
    .dashboard-card { background-color: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 20px; margin-bottom: 20px; }
    .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
    .card-title { font-size: 18px; font-weight: 600; }
    .card-action { color: #15803d; text-decoration: none; font-size: 14px; }

    /* Stats */
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 20px; }
    .stat-card { background-color: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 20px; text-align: center; }
    .stat-value { font-size: 28px; font-weight: bold; margin-bottom: 5px; }
    .stat-label { color: #6b7280; font-size: 14px; }

    /* Recent Applications */
    .applications-table { width: 100%; border-collapse: collapse; }
    .applications-table th, .applications-table td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #e5e7eb; }
    .applications-table th { font-weight: 600; color: #6b7280; }
    .status-badge { padding: 5px 10px; border-radius: 20px; font-size: 12px; display: inline-block; }
    .status-pending { background-color: #fef3c7; color: #ca8a04; }
    .status-interview { background-color: #dcfce7; color: #15803d; }
    .status-rejected { background-color: #fee2e2; color: #b91c1c; }
    .status-accepted { background-color: #dcfce7; color: #166534; }

    /* Recommended Jobs */
    .jobs-list { margin-top: 15px; }
    .job-item { display: flex; padding: 15px 0; border-bottom: 1px solid #e5e7eb; }
    .job-item:last-child { border-bottom: none; }
    .job-company-logo { width: 50px; height: 50px; background-color: #d9f99d; border-radius: 5px; margin-right: 15px; display: flex; align-items: center; justify-content: center; }
    .job-info { flex: 1; }
    .job-title { font-weight: 600; margin-bottom: 5px; }
    .job-company { color: #6b7280; font-size: 14px; }
    .job-match { background-color: #dcfce7; color: #15803d; padding: 3px 8px; border-radius: 20px; font-size: 12px; margin-left: 10px; }

    /* Activity Feed */
    .activity-feed { margin-top: 15px; }
    .activity-item { display: flex; padding: 10px 0; border-bottom: 1px solid #e5e7eb; }
    .activity-item:last-child { border-bottom: none; }
    .activity-icon { width: 36px; height: 36px; border-radius: 50%; background-color: #dcfce7; margin-right: 15px; display: flex; align-items: center; justify-content: center; color: #15803d; }
    .activity-content { flex: 1; }
    .activity-text { margin-bottom: 5px; }
    .activity-time { color: #6b7280; font-size: 12px; }

    /* Upcoming Events */
    .events-list { margin-top: 15px; }
    .event-item { padding: 15px; background-color: #f3f4f6; border-radius: 8px; margin-bottom: 10px; }
    .event-date { display: flex; align-items: center; margin-bottom: 10px; }
    .event-calendar { width: 40px; height: 40px; background-color: #15803d; color: white; border-radius: 5px; display: flex; flex-direction: column; align-items: center; justify-content: center; margin-right: 10px; }
    .event-day { font-weight: bold; font-size: 16px; }
    .event-month { font-size: 10px; text-transform: uppercase; }
    .event-title { font-weight: 600; margin-bottom: 5px; }
    .event-details { color: #6b7280; font-size: 14px; }
</style>

</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-logo">EMSI <span>Career</span></div>
        <div class="sidebar-menu">
            <div class="menu-item active">
                <div class="icon">📊</div>
                <span>Tableau de bord</span>
            </div>
           <!-- <div class="menu-item">
                <div class="icon">👤</div>
                <span> <a href="/ProfilCandidat">Mon Profil</a> </span>
            </div>-->
            <div class="menu-item">
            <a href="/ProfilCandidat" style="display: flex; align-items: center; color: inherit; text-decoration: none; width: 100%;">
                <div class="icon">👤</div>
                <span>Mon Profil</span>
            </a>
            </div>
           <!-- <div class="menu-item">
                <div class="icon">📄</div>
                <span><a href="/CVLettre">CV & Lettres</a></span>
            </div>

            <div class="menu-item">
                <div class="icon">🔍</div>
                <span>Offres d'emploi</span>
            </div>-->
           <!-- <div class="menu-item">
                <div class="icon">👥</div>
                <span>Réseau social</span>
            </div>
            <div class="menu-item">
                <div class="icon">📱</div>
                <span>Messages</span>
            </div>-->
            
        </div>
        <div class="user-info">
            <div class="user-profile">
                <div class="user-avatar">
                    @php
                        $user = Auth::user();
                        if($user) {
                            // Extract initials from user name
                            $nameParts = explode(' ', $user->name);
                            $initials = strtoupper(substr($nameParts[0], 0, 1));
                            if(isset($nameParts[1])) {
                                $initials .= strtoupper(substr($nameParts[1], 0, 1));
                            }
                        } else {
                            $initials = 'G'; // Guest
                        }
                    @endphp
                    {{ $initials }}
                </div>
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
            <h1 class="page-title">Tableau de bord</h1>
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

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value">12</div>
                <div class="stat-label">Candidatures envoyées</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">5</div>
                <div class="stat-label">Entretiens programmés</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">83%</div>
                <div class="stat-label">Profil complété</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">47</div>
                <div class="stat-label">Vues de profil</div>
            </div>
        </div>

        <!-- Dashboard Grid -->
        <div class="dashboard-grid">
            <!-- Left Column -->
            <div>
                <!-- Recent Applications -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h2 class="card-title">Candidatures récentes</h2>
                        <a href="#" class="card-action">Voir tout</a>
                    </div>
                    <table class="applications-table">
                        <thead>
                            <tr>
                                <th>Entreprise</th>
                                <th>Poste</th>
                                <th>Date</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>TechMaroc Solutions</td>
                                <td>Développeur Full Stack</td>
                                <td>18 Mai 2025</td>
                                <td><span class="status-badge status-interview">Entretien</span></td>
                            </tr>
                            <tr>
                                <td>MarocAnalytics</td>
                                <td>Data Scientist</td>
                                <td>15 Mai 2025</td>
                                <td><span class="status-badge status-pending">En attente</span></td>
                            </tr>
                            <tr>
                                <td>CloudTech Maroc</td>
                                <td>Ingénieur DevOps</td>
                                <td>10 Mai 2025</td>
                                <td><span class="status-badge status-rejected">Refusé</span></td>
                            </tr>
                            <tr>
                                <td>Digital Agency</td>
                                <td>UX/UI Designer</td>
                                <td>5 Mai 2025</td>
                                <td><span class="status-badge status-accepted">Accepté</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Recommended Jobs -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h2 class="card-title">Offres recommandées</h2>
                        <a href="#" class="card-action">Voir tout</a>
                    </div>
                    <div class="jobs-list">
                        <div class="job-item">
                            <div class="job-company-logo">DF</div>
                            <div class="job-info">
                                <div>
                                    <span class="job-title">Développeur Front-End</span>
                                    <span class="job-match">Match 95%</span>
                                </div>
                                <div class="job-company">WebTech Solutions - Casablanca</div>
                            </div>
                        </div>
                        <div class="job-item">
                            <div class="job-company-logo">SE</div>
                            <div class="job-info">
                                <div>
                                    <span class="job-title">Software Engineer</span>
                                    <span class="job-match">Match 92%</span>
                                </div>
                                <div class="job-company">InnoTech - Rabat</div>
                            </div>
                        </div>
                        <div class="job-item">
                            <div class="job-company-logo">DE</div>
                            <div class="job-info">
                                <div>
                                    <span class="job-title">DevOps Engineer</span>
                                    <span class="job-match">Match 87%</span>
                                </div>
                                <div class="job-company">CloudMaroc - Tanger</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div>
                <!-- Upcoming Events -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h2 class="card-title">Événements à venir</h2>
                        <a href="#" class="card-action">Voir tout</a>
                    </div>
                    <div class="events-list">
                        <div class="event-item">
                            <div class="event-date">
                                <div class="event-calendar">
                                    <div class="event-day">25</div>
                                    <div class="event-month">Mai</div>
                                </div>
                                <div>
                                    <div class="event-title">Entretien avec TechMaroc</div>
                                    <div class="event-details">14:00 - 15:00 | En ligne</div>
                                </div>
                            </div>
                        </div>
                        <div class="event-item">
                            <div class="event-date">
                                <div class="event-calendar">
                                    <div class="event-day">28</div>
                                    <div class="event-month">Mai</div>
                                </div>
                                <div>
                                    <div class="event-title">Salon virtuel de l'emploi</div>
                                    <div class="event-details">10:00 - 17:00 | Plateforme EMSI</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Feed -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h2 class="card-title">Activités récentes</h2>
                        <a href="#" class="card-action">Voir tout</a>
                    </div>
                    <div class="activity-feed">
                        <div class="activity-item">
                            <div class="activity-icon">👁️</div>
                            <div class="activity-content">
                                <div class="activity-text">TechMaroc Solutions a consulté votre profil</div>
                                <div class="activity-time">Il y a 2 heures</div>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon">📬</div>
                            <div class="activity-content">
                                <div class="activity-text">Vous avez reçu un message de Ahmed Kaddouri</div>
                                <div class="activity-time">Il y a 5 heures</div>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon">✅</div>
                            <div class="activity-content">
                                <div class="activity-text">Votre candidature chez Digital Agency a été acceptée</div>
                                <div class="activity-time">Il y a 1 jour</div>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon">🔗</div>
                            <div class="activity-content">
                                <div class="activity-text">Sara Alaoui a accepté votre demande de contact</div>
                                <div class="activity-time">Il y a 2 jours</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
