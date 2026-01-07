<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EMSI Career Connect - Tableau de bord recruteur</title>
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
        .sidebar { width: 260px; background-color: #059669; color: white; padding: 20px 0; height: 100vh; position: fixed; }
        .sidebar-logo { padding: 0 20px 20px; font-size: 22px; font-weight: bold; border-bottom: 1px solid #10b981; }
        .sidebar-logo span { color: #86efac; }
        .sidebar-menu { margin-top: 30px; }
        .menu-item { padding: 12px 20px; display: flex; align-items: center; margin-bottom: 5px; cursor: pointer; transition: all 0.3s; position: relative; }
        .menu-item:hover, .menu-item.active { background-color: #10b981; }
        .menu-item .icon { margin-right: 10px; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; }
        .user-info { padding: 20px; border-top: 1px solid #10b981; margin-top: auto; position: absolute; bottom: 0; width: 100%; }
        .user-profile { display: flex; align-items: center; }
        .user-avatar { width: 40px; height: 40px; border-radius: 50%; background-color: #dcfce7; margin-right: 10px; display: flex; align-items: center; justify-content: center; color: #059669; font-weight: bold; }
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
        .quick-action { background-color: #059669; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: 500; margin-left: 10px; cursor: pointer; border: none; }
        .quick-action:hover { background-color: #047857; }
        
        /* Dashboard Content */
        .dashboard-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px; }
        .dashboard-card { background-color: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 20px; margin-bottom: 20px; }
        .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .card-title { font-size: 18px; font-weight: 600; }
        .card-action { color: #059669; text-decoration: none; font-size: 14px; }
        
        /* Stats */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 20px; }
        .stat-card { background-color: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 20px; text-align: center; position: relative; overflow: hidden; }
        .stat-card::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 4px; }
        .stat-card.jobs::before { background-color: #3b82f6; }
        .stat-card.applications::before { background-color: #f59e0b; }
        .stat-card.interviews::before { background-color: #059669; }
        .stat-card.hires::before { background-color: #8b5cf6; }
        .stat-value { font-size: 28px; font-weight: bold; margin-bottom: 5px; }
        .stat-label { color: #6b7280; font-size: 14px; }
        .stat-change { font-size: 12px; margin-top: 5px; }
        .stat-change.positive { color: #059669; }
        .stat-change.negative { color: #dc2626; }
        
        /* Recent Applications */
        .applications-table { width: 100%; border-collapse: collapse; }
        .applications-table th, .applications-table td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        .applications-table th { font-weight: 600; color: #6b7280; }
        .candidate-info { display: flex; align-items: center; }
        .candidate-avatar { width: 40px; height: 40px; border-radius: 50%; background-color: #e0f2fe; margin-right: 10px; display: flex; align-items: center; justify-content: center; color: #1e40af; font-weight: bold; }
        .candidate-details { flex: 1; }
        .candidate-name { font-weight: 500; }
        .candidate-title { color: #6b7280; font-size: 14px; }
        .status-badge { padding: 5px 10px; border-radius: 20px; font-size: 12px; display: inline-block; }
        .status-new { background-color: #dbeafe; color: #1d4ed8; }
        .status-reviewed { background-color: #fef3c7; color: #d97706; }
        .status-interview { background-color: #e0f2fe; color: #0284c7; }
        .status-rejected { background-color: #fee2e2; color: #ef4444; }
        .status-hired { background-color: #dcfce7; color: #16a34a; }
        .match-score { background-color: #dcfce7; color: #059669; padding: 3px 8px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        
        /* Active Jobs */
        .jobs-list { margin-top: 15px; }
        .job-item { display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid #e5e7eb; }
        .job-item:last-child { border-bottom: none; }
        .job-info { flex: 1; }
        .job-title { font-weight: 600; margin-bottom: 5px; }
        .job-details { color: #6b7280; font-size: 14px; }
        .job-stats { display: flex; align-items: center; }
        .job-stat { margin-left: 20px; text-align: center; }
        .job-stat-value { font-weight: 600; color: #059669; }
        .job-stat-label { color: #6b7280; font-size: 12px; }
        
        /* Pipeline */
        .pipeline-stages { display: flex; justify-content: space-between; margin-top: 15px; }
        .pipeline-stage { flex: 1; text-align: center; margin: 0 5px; }
        .pipeline-stage-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .pipeline-stage-title { font-weight: 500; font-size: 14px; }
        .pipeline-stage-count { background-color: #f3f4f6; color: #6b7280; padding: 2px 8px; border-radius: 12px; font-size: 12px; }
        .pipeline-candidates { background-color: #f9fafb; border-radius: 8px; padding: 10px; min-height: 200px; }
        .pipeline-candidate { background-color: white; border-radius: 6px; padding: 10px; margin-bottom: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); cursor: pointer; }
        .pipeline-candidate:hover { box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        .pipeline-candidate:last-child { margin-bottom: 0; }
        .pipeline-candidate-name { font-weight: 500; font-size: 13px; margin-bottom: 3px; }
        .pipeline-candidate-role { color: #6b7280; font-size: 11px; }
        
        /* Top Candidates */
        .candidates-list { margin-top: 15px; }
        .candidate-item { display: flex; padding: 15px; background-color: #f9fafb; border-radius: 8px; margin-bottom: 10px; }
        .candidate-photo { width: 60px; height: 60px; border-radius: 50%; background-color: #e0f2fe; margin-right: 15px; display: flex; align-items: center; justify-content: center; color: #1e40af; font-weight: bold; }
        .candidate-info-detailed { flex: 1; }
        .candidate-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; }
        .candidate-name-title { flex: 1; }
        .candidate-name-main { font-weight: 600; margin-bottom: 5px; }
        .candidate-position { color: #6b7280; font-size: 14px; }
        .candidate-actions { display: flex; gap: 10px; }
        .action-btn { padding: 6px 12px; border-radius: 4px; font-size: 12px; cursor: pointer; border: none; }
        .btn-primary { background-color: #059669; color: white; }
        .btn-secondary { background-color: white; color: #059669; border: 1px solid #059669; }
        .candidate-skills { display: flex; flex-wrap: wrap; gap: 5px; margin-bottom: 10px; }
        .skill-tag { background-color: #e0f2fe; color: #0284c7; padding: 3px 8px; border-radius: 20px; font-size: 11px; }
        .candidate-meta { display: flex; justify-content: space-between; align-items: center; }
        .candidate-location { color: #6b7280; font-size: 13px; }
        .candidate-match { background-color: #dcfce7; color: #059669; padding: 3px 8px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        
        /* Quick Actions */
        .quick-actions { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; }
        .quick-action-card { background-color: white; border-radius: 8px; padding: 20px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.05); cursor: pointer; transition: all 0.3s; }
        .quick-action-card:hover { transform: translateY(-2px); box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .quick-action-icon { width: 50px; height: 50px; border-radius: 50%; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; font-size: 24px; }
        .quick-action-card:nth-child(1) .quick-action-icon { background-color: #dbeafe; color: #1d4ed8; }
        .quick-action-card:nth-child(2) .quick-action-icon { background-color: #dcfce7; color: #059669; }
        .quick-action-card:nth-child(3) .quick-action-icon { background-color: #fef3c7; color: #d97706; }
        .quick-action-title { font-weight: 600; margin-bottom: 5px; }
        .quick-action-desc { color: #6b7280; font-size: 14px; }

        /* Styles pour la modale */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            animation: fadeIn 0.3s ease-out;
        }

        .modal.show {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background-color: white;
            margin: 3% auto;
            padding: 25px;
            border-radius: 8px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            max-height: 90vh;
            overflow-y: auto;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .close-modal {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            line-height: 1;
        }

        .close-modal:hover {
            color: #555;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #059669;
            box-shadow: 0 0 0 2px rgba(5, 150, 105, 0.1);
        }

        .submit-btn {
            background-color: #059669;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            width: 100%;
            margin-top: 10px;
            transition: background-color 0.3s;
        }

        .submit-btn:hover {
            background-color: #047857;
        }

        .submit-btn:disabled {
            background-color: #9ca3af;
            cursor: not-allowed;
        }

        .offer-count {
            position: absolute;
            right: 20px;
            background-color: #ef4444;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
        }

        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .half-width {
            flex: 1;
        }

        /* Messages de succès et d'erreur */
        .alert {
            padding: 12px 16px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* Amélioration de la responsive */
        @media (max-width: 768px) {
            .modal-content {
                width: 95%;
                margin: 5% auto;
                padding: 20px;
            }
            
            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .sidebar {
                width: 200px;
            }

            .main-content {
                margin-left: 200px;
                padding: 15px;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-logo">EMSI <span>Recruiter</span></div>
        <div class="sidebar-menu">
            <div class="menu-item active">
                <div class="icon">📊</div>
                <span>Tableau de bord</span>
            </div>
             <div class="menu-item">
                <a href="/presentation" style="display: flex; align-items: center; color: inherit; text-decoration: none; width: 100%;">
                    <div class="icon">🏢</div>
                    <span>Profil entreprise</span>
                </a>
            </div>
          
            <div class="menu-item" id="jobOffersMenuItem">
                <a href="/GestionOffre" style="display: flex; align-items: center; color: inherit; text-decoration: none; width: 100%;">
                <div class="icon">📝</div>
                <span>Offres d'emploi</span>
                <span class="offer-count" id="offerCount">7</span>
               </a>
            </div>
            
          
            <div class="menu-item">
                <a href="/RéseauSocialRecrut" style="display: flex; align-items: center; color: inherit; text-decoration: none; width: 100%;">
                    <div class="icon">👥</div>
                    <span>Réseau social</span>
                </a>
            </div>
    </br>
    </br>
      </br>
    </br>
      </br>
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
                    <div class="user-role">Entreprise</div>
                </div>
            </div>
        </div>
        
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="page-header">
            <h1 class="page-title">Tableau de bord recruteur</h1>
            <div class="actions">
                <div class="notification-bell">
                    🔔
                    <span class="notification-badge">7</span>
                </div>
              <!--  <button type="button" class="quick-action" id="newOfferBtn">+ Nouvelle offre</button>-->
            </div>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card jobs">
                <div class="stat-value" id="activeJobs">8</div>
                <div class="stat-label">Offres actives</div>
                <div class="stat-change positive">+2 ce mois</div>
            </div>
            <div class="stat-card applications">
                <div class="stat-value">47</div>
                <div class="stat-label">Candidatures reçues</div>
                <div class="stat-change positive">+12 cette semaine</div>
            </div>
            <div class="stat-card interviews">
                <div class="stat-value">15</div>
                <div class="stat-label">Entretiens programmés</div>
                <div class="stat-change positive">+5 cette semaine</div>
            </div>
            <div class="stat-card hires">
                <div class="stat-value">3</div>
                <div class="stat-label">Embauches récentes</div>
                <div class="stat-change negative">-1 ce mois</div>
            </div>
        </div>

        <!-- Dashboard Grid -->
        <div class="dashboard-grid">
            <!-- Left Column -->
            <div class="left-column">
                <!-- Recent Applications -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3 class="card-title">Candidatures récentes</h3>
                        <a href="#" class="card-action">Voir tout</a>
                    </div>
                    <table class="applications-table">
                        <thead>
                            <tr>
                                <th>Candidat</th>
                                <th>Poste</th>
                                <th>Date</th>
                                <th>Statut</th>
                                <th>Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="candidate-info">
                                        <div class="candidate-avatar">AM</div>
                                        <div class="candidate-details">
                                            <div class="candidate-name">Ahmed Moussa</div>
                                            <div class="candidate-title">Ingénieur logiciel</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Développeur Full Stack</td>
                                <td>12/06/2023</td>
                                <td><span class="status-badge status-new">Nouveau</span></td>
                                <td><span class="match-score">87%</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="candidate-info">
                                        <div class="candidate-avatar">FK</div>
                                        <div class="candidate-details">
                                            <div class="candidate-name">Fatima Khalil</div>
                                            <div class="candidate-title">UX Designer</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Designer UI/UX</td>
                                <td>10/06/2023</td>
                                <td><span class="status-badge status-reviewed">Revu</span></td>
                                <td><span class="match-score">92%</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="candidate-info">
                                        <div class="candidate-avatar">RS</div>
                                        <div class="candidate-details">
                                            <div class="candidate-name">Rachid Saadi</div>
                                            <div class="candidate-title">Data Scientist</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Analyste de données</td>
                                <td>08/06/2023</td>
                                <td><span class="status-badge status-interview">Entretien</span></td>
                                <td><span class="match-score">78%</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="candidate-info">
                                        <div class="candidate-avatar">NA</div>
                                        <div class="candidate-details">
                                            <div class="candidate-name">Nadia Ahmed</div>
                                            <div class="candidate-title">Chef de projet</div>
                                        </div>
                                    </div>
                                </td>
                                <td>PMO Junior</td>
                                <td>05/06/2023</td>
                                <td><span class="status-badge status-rejected">Rejeté</span></td>
                                <td><span class="match-score">65%</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="candidate-info">
                                        <div class="candidate-avatar">MB</div>
                                        <div class="candidate-details">
                                            <div class="candidate-name">Mehdi Benani</div>
                                            <div class="candidate-title">Développeur mobile</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Dev Android Senior</td>
                                <td>01/06/2023</td>
                                <td><span class="status-badge status-hired">Embauché</span></td>
                                <td><span class="match-score">95%</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Active Jobs -->
               <!-- <div class="dashboard-card">
                    <div class="card-header">
                        <h3 class="card-title">Offres actives</h3>
                        <a href="#" class="card-action">Voir tout</a>
                    </div>-->
                    <div class="jobs-list" id="jobsList">
                        <div class="job-item">
                            <div class="job-info">
                                <div class="job-title">Développeur Full Stack (React/Node)</div>
                                <div class="job-details">Publiée le 15/05/2023 • 12 candidats</div>
                            </div>
                            <div class="job-stats">
                                <div class="job-stat">
                                    <div class="job-stat-value">87%</div>
                                    <div class="job-stat-label">Score moyen</div>
                                </div>
                                <div class="job-stat">
                                    <div class="job-stat-value">4</div>
                                    <div class="job-stat-label">Entretiens</div>
                                </div>
                            </div>
                        </div>
                        <div class="job-item">
                            <div class="job-info">
                                <div class="job-title">Data Scientist Python</div>
                                <div class="job-details">Publiée le 10/05/2023 • 8 candidats</div>
                            </div>
                            <div class="job-stats">
                                <div class="job-stat">
                                    <div class="job-stat-value">82%</div>
                                    <div class="job-stat-label">Score moyen</div>
                                </div>
                                <div class="job-stat">
                                    <div class="job-stat-value">3</div>
                                    <div class="job-stat-label">Entretiens</div>
                                </div>
                            </div>
                        </div>
                        <div class="job-item">
                            <div class="job-info">
                                <div class="job-title">UX Designer Senior</div>
                                <div class="job-details">Publiée le 05/05/2023 • 5 candidats</div>
                            </div>
                            <div class="job-stats">
                                <div class="job-stat">
                                    <div class="job-stat-value">91%</div>
                                    <div class="job-stat-label">Score moyen</div>
                                </div>
                                <div class="job-stat">
                                    <div class="job-stat-value">2</div>
                                    <div class="job-stat-label">Entretiens</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="right-column">
               

            <!-- Top Candidates -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h3 class="card-title">Top candidats</h3>
                    <a href="#" class="card-action">Voir tout</a>
                </div>
                <div class="candidates-list">
                    <div class="candidate-item">
                        <div class="candidate-photo">HZ</div>
                        <div class="candidate-info-detailed">
                            <div class="candidate-header">
                                <div class="candidate-name-title">
                                    <div class="candidate-name-main">Hind Zoufir</div>
                                    <div class="candidate-position">Ingénieur logiciel senior - 5 ans d'expérience</div>
                                </div>
                                <div class="candidate-match">87%</div>
                            </div>
                            <div class="candidate-skills">
                                <span class="skill-tag">JavaScript</span>
                                <span class="skill-tag">React</span>
                                <span class="skill-tag">Node.js</span>
                                <span class="skill-tag">TypeScript</span>
                            </div>
                            <div class="candidate-meta">
                                <div class="candidate-location">📍 Fes, Maroc</div>
                              <!--  <div class="candidate-actions">
                                    <button class="action-btn btn-primary">Contacter</button>
                                    <button class="action-btn btn-secondary">Profil</button>
                                </div>-->
                            </div>
                        </div>
                    </div>
                    <div class="candidate-item">
                        <div class="candidate-photo">ON</div>
                        <div class="candidate-info-detailed">
                            <div class="candidate-header">
                                <div class="candidate-name-title">
                                    <div class="candidate-name-main">Ouzdou Nour</div>
                                    <div class="candidate-position">UX/UI Designer - 3 ans d'expérience</div>
                                </div>
                                <div class="candidate-match">92%</div>
                            </div>
                            <div class="candidate-skills">
                                <span class="skill-tag">Figma</span>
                                <span class="skill-tag">UI Design</span>
                                <span class="skill-tag">Prototypage</span>
                                <span class="skill-tag">User Research</span>
                            </div>
                            <div class="candidate-meta">
                                <div class="candidate-location">📍 Rabat, Maroc</div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="dashboard-card">
        <div class="card-header">
            <h3 class="card-title">Actions rapides</h3>
        </div>
        <!-- <div id="activeJobOffersList" class="card-body">
         Les offres seront insérées ici 
    </div>-->
        <div class="quick-actions">
            <div class="quick-action-card">
                <div class="quick-action-icon">📝</div>
                <h4 class="quick-action-title">Créer une nouvelle offre</h4>
                <p class="quick-action-desc">Publiez une nouvelle offre d'emploi en quelques minutes</p>
            </div>
            <div class="quick-action-card">
                <div class="quick-action-icon">🔍</div>
                <h4 class="quick-action-title">Rechercher des candidats</h4>
                <p class="quick-action-desc">Explorez notre CVthèque pour trouver des talents</p>
            </div>
            <div class="quick-action-card">
                <div class="quick-action-icon">📊</div>
                <h4 class="quick-action-title">Générer un rapport</h4>
                <p class="quick-action-desc">Obtenez des insights sur vos recrutements</p>
            </div>
        </div>
    </div>
</main>

<!-- Modal for New Job Offer -->
<div class="modal" id="jobOfferModal">
    <div class="modal-content">
        <span class="close-modal" id="closeModal">&times;</span>
        <h2 style="margin-bottom: 20px;">Créer une nouvelle offre d'emploi</h2>
        
        <form id="jobOfferForm" method="POST">
    @csrf
    <div class="form-group">
        <label for="titre">Intitulé du poste *</label>
        <input type="text" id="titre" name="titre" required placeholder="Ex: Développeur Full Stack">
    </div>
    
    <div class="form-group">
        <label for="entreprise">Entreprise *</label>
        <input type="text" id="entreprise" name="entreprise" required placeholder="Nom de l'entreprise">
    </div>
    
    <div class="form-row">
        <div class="form-group half-width">
            <label for="type_contrat">Type de contrat *</label>
            <select id="type_contrat" name="type_contrat" required>
                <option value="">Sélectionnez...</option>
                <option value="CDI">CDI</option>
                <option value="CDD">CDD</option>
                <option value="Freelance">Freelance</option>
                <option value="Stage">Stage</option>
                <option value="Alternance">Alternance</option>
            </select>
        </div>
        <div class="form-group half-width">
            <label for="lieu">Localisation *</label>
            <input type="text" id="lieu" name="lieu" required placeholder="Ex: Casablanca">
        </div>
    </div>
    
    <div class="form-row">
        <div class="form-group half-width">
            <label for="region">Région *</label>
            <input type="text" id="region" name="region" required placeholder="Ex: Île-de-France">
        </div>
        <div class="form-group half-width">
            <label for="secteur">Secteur d'activité *</label>
            <input type="text" id="secteur" name="secteur" required placeholder="Ex: Informatique">
        </div>
    </div>
    
    <div class="form-group">
        <label for="description">Description du poste *</label>
        <textarea id="description" name="description" rows="5" required></textarea>
    </div>
    
    <div class="form-group">
        <label for="competences">Compétences requises (séparées par des virgules) *</label>
        <textarea id="competences" name="competences" rows="3" required placeholder="Ex: PHP, Laravel, JavaScript"></textarea>
    </div>
    
    <div class="form-row">
        <div class="form-group half-width">
            <label for="salaire_min">Salaire minimum (€)</label>
            <input type="number" id="salaire_min" name="salaire_min" placeholder="Ex: 30000">
        </div>
        <div class="form-group half-width">
            <label for="salaire_max">Salaire maximum (€)</label>
            <input type="number" id="salaire_max" name="salaire_max" placeholder="Ex: 45000">
        </div>
    </div>
    
    <div class="form-group">
        <label for="experience_requise">Expérience requise (années) *</label>
        <input type="number" id="experience_requise" name="experience_requise" min="0" required>
    </div>
    
    <div class="form-group">
        <label for="url_candidature">URL de candidature</label>
        <input type="url" id="url_candidature" name="url_candidature" placeholder="https://">
    </div>
    
    <button type="submit" class="submit-btn">Publier l'offre</button>
</form>
    </div>
</div>
<script>
   const csrfMeta = document.querySelector('meta[name="csrf-token"]');
if (!csrfMeta) {
    console.error('CSRF token meta tag not found');
}

const modal = document.getElementById('jobOfferModal');
const newOfferBtn = document.getElementById('newOfferBtn');
const closeModal = document.getElementById('closeModal');
const jobOfferForm = document.getElementById('jobOfferForm');

if (newOfferBtn) {
    newOfferBtn.addEventListener('click', () => {
        if (modal) modal.classList.add('show');
    });
}

if (closeModal) {
    closeModal.addEventListener('click', () => {
        if (modal) modal.classList.remove('show');
    });
}

window.addEventListener('click', (e) => {
    if (modal && e.target === modal) {
        modal.classList.remove('show');
    }
});

if (jobOfferForm) {
    jobOfferForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const competencesInput = document.getElementById('competences');
        const competences = competencesInput
            ? competencesInput.value.split(',').map(item => item.trim()).filter(item => item)
            : [];

        const formData = new FormData();
        formData.append('titre', document.getElementById('titre')?.value || '');
        formData.append('entreprise', document.getElementById('entreprise')?.value || '');
        formData.append('description', document.getElementById('description')?.value || '');
        formData.append('type_contrat', document.getElementById('type_contrat')?.value || '');
        formData.append('lieu', document.getElementById('lieu')?.value || '');
        formData.append('region', document.getElementById('region')?.value || '');
        formData.append('secteur', document.getElementById('secteur')?.value || '');

        // Append competences as multiple entries to support Laravel array validation
        competences.forEach(comp => {
            formData.append('competences[]', comp);
        });

        formData.append('salaire_min', document.getElementById('salaire_min')?.value || '');
        formData.append('salaire_max', document.getElementById('salaire_max')?.value || '');
        formData.append('experience_requise', document.getElementById('experience_requise')?.value || '');
        formData.append('url_candidature', document.getElementById('url_candidature')?.value || '');

        if (csrfMeta) {
            formData.append('_token', csrfMeta.content);
        }

        try {
            const response = await fetch('/offres-emploi', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (!response.ok) {
                const errors = data.errors ? Object.values(data.errors).flat().join('\n') : (data.message || 'Erreur de validation');
                throw new Error(errors);
            }

            updateOfferCount();
            addJobToList(data);
            if (modal) modal.classList.remove('show');
            jobOfferForm.reset();
            showAlert('Offre publiée avec succès!', 'success');

        } catch (error) {
            console.error('Erreur lors de la soumission du formulaire :', error);

            const offer = {
                id: Date.now(),
                titre: document.getElementById('titre')?.value || '',
                entreprise: document.getElementById('entreprise')?.value || '',
                description: document.getElementById('description')?.value || '',
                type_contrat: document.getElementById('type_contrat')?.value || '',
                lieu: document.getElementById('lieu')?.value || '',
                region: document.getElementById('region')?.value || '',
                secteur: document.getElementById('secteur')?.value || '',
                competences: competences,
                salaire_min: document.getElementById('salaire_min')?.value || null,
                salaire_max: document.getElementById('salaire_max')?.value || null,
                experience_requise: parseInt(document.getElementById('experience_requise')?.value) || 0,
                url_candidature: document.getElementById('url_candidature')?.value || null,
                date_publication: new Date().toISOString(),
                date_expiration: new Date(Date.now() + 30 * 24 * 60 * 60 * 1000).toISOString(),
                actif: true,
                vues: 0,
                favoris: 0,
                candidatures_count: 0
            };

            saveOfferLocally(offer);
            showAlert(error.message || 'Erreur lors de la création de l\'offre', 'error');
        }
    });
}

function saveOfferLocally(offer) {
    const savedOffers = JSON.parse(localStorage.getItem('jobOffers')) || [];
    savedOffers.unshift(offer);
    localStorage.setItem('jobOffers', JSON.stringify(savedOffers));
    updateOfferCount();
    addJobToList(offer);
    showAlert('Offre sauvegardée localement', 'warning');
}

function addJobToList(offer) {
    const jobsList = document.getElementById('jobsList');
    if (!jobsList) return;

    const newJob = document.createElement('div');
    newJob.className = 'job-item';
    newJob.innerHTML = `
        <div class="job-info">
            <div class="job-title">${offer.titre}</div>
            <div class="job-details">
                ${offer.entreprise} • ${offer.lieu} • 
                Publiée le ${new Date(offer.date_publication).toLocaleDateString('fr-FR')}
            </div>
        </div>
        <div class="job-stats">
            <div class="job-stat">
                <div class="job-stat-value">${offer.candidatures_count || 0}</div>
                <div class="job-stat-label">Candidats</div>
            </div>
            <div class="job-stat">
                <div class="job-stat-value">${offer.vues || 0}</div>
                <div class="job-stat-label">Vues</div>
            </div>
        </div>
    `;
    jobsList.prepend(newJob);
}

async function updateOfferCount() {
    let count = 0;
    try {
        const response = await fetch('/offres-emploi?recruteur=1');
        if (response.ok) {
            const data = await response.json();
            count = data.length;
        }
    } catch {
        const savedOffers = JSON.parse(localStorage.getItem('jobOffers')) || [];
        count = savedOffers.length;
    }
    setOfferCount(count);
}

function setOfferCount(count) {
    const offerCountEl = document.getElementById('offerCount');
    const activeJobsEl = document.getElementById('activeJobs');

    if (offerCountEl) offerCountEl.textContent = count;
    if (activeJobsEl) activeJobsEl.textContent = count;
}

function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;
    document.body.prepend(alertDiv);
    setTimeout(() => alertDiv.remove(), 5000);
}

document.addEventListener('DOMContentLoaded', () => {
    loadJobOffers();
});

async function loadJobOffers() {
    try {
        const response = await fetch('/offres-emploi?recruteur=1');
        if (!response.ok) throw new Error('Erreur de chargement');
        const data = await response.json();
        renderJobOffers(data);
    } catch (error) {
        console.error('Chargement local des offres suite à une erreur :', error);
        const savedOffers = JSON.parse(localStorage.getItem('jobOffers')) || [];
        renderJobOffers(savedOffers);
    }
}

function renderJobOffers(offers) {
    const jobsList = document.getElementById('jobsList');
    if (!jobsList) return;

    jobsList.innerHTML = '';

    offers.forEach(offer => {
        const newJob = document.createElement('div');
        newJob.className = 'job-item';
        newJob.innerHTML = `
            <div class="job-info">
                <div class="job-title">${offer.titre}</div>
                <div class="job-details">
                    ${offer.entreprise} • ${offer.lieu} • 
                    Publiée le ${new Date(offer.date_publication).toLocaleDateString('fr-FR')}
                </div>
            </div>
            <div class="job-stats">
                <div class="job-stat">
                    <div class="job-stat-value">${offer.candidatures_count || 0}</div>
                    <div class="job-stat-label">Candidats</div>
                </div>
                <div class="job-stat">
                    <div class="job-stat-value">${offer.vues || 0}</div>
                    <div class="job-stat-label">Vues</div>
                </div>
            </div>
        `;
        jobsList.appendChild(newJob);
    });

    setOfferCount(offers.length);
}
// Fonction pour afficher les offres dans la dashboard-card
function renderActiveJobOffers(offers) {
    const container = document.getElementById('activeJobOffersList');
    if (!container) return;

    container.innerHTML = ''; // Vide le contenu actuel

    if (offers.length === 0) {
        container.innerHTML = '<p>Aucune offre active pour le moment.</p>';
        return;
    }

    offers.forEach(offer => {
        const offerDiv = document.createElement('div');
        offerDiv.className = 'job-item'; // Utilise ta classe CSS existante pour le style
        offerDiv.innerHTML = `
            <div class="job-info">
                <div class="job-title">${offer.titre}</div>
                <div class="job-details">
                    ${offer.entreprise} • ${offer.lieu} • 
                    Publiée le ${new Date(offer.date_publication).toLocaleDateString('fr-FR')}
                </div>
            </div>
            <div class="job-stats">
                <div class="job-stat">
                    <div class="job-stat-value">${offer.candidatures_count || 0}</div>
                    <div class="job-stat-label">Candidats</div>
                </div>
                <div class="job-stat">
                    <div class="job-stat-value">${offer.vues || 0}</div>
                    <div class="job-stat-label">Vues</div>
                </div>
            </div>
        `;
        container.appendChild(offerDiv);
    });
}

// Charger les offres et les afficher dans dashboard-card au chargement
async function loadActiveJobOffers() {
    try {
        const response = await fetch('/offres-emploi?recruteur=1');
        if (!response.ok) throw new Error('Erreur de chargement des offres');
        const data = await response.json();
        renderActiveJobOffers(data);
    } catch (error) {
        console.error(error);
        // Optionnel : afficher les offres sauvegardées localement en fallback
        const savedOffers = JSON.parse(localStorage.getItem('jobOffers')) || [];
        renderActiveJobOffers(savedOffers);
    }
}

// Appelle cette fonction au chargement de la page
document.addEventListener('DOMContentLoaded', () => {
    loadActiveJobOffers();
});

</script>


</body>
</html>