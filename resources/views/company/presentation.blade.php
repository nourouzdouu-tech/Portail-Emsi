<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>  Présentation d'entreprise </title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", sans-serif;
    }

    /* Sidebar */
    .sidebar {
      width: 260px;
      background-color: #059669;
      color: white;
      padding: 20px 0;
      height: 100vh;
      position: fixed;
    }

    .sidebar-logo {
      padding: 0 20px 20px;
      font-size: 22px;
      font-weight: bold;
      border-bottom: 1px solid #10b981;
    }

    .sidebar-logo span {
      color: #86efac;
    }

    .sidebar-menu {
      margin-top: 30px;
    }

    .menu-item {
      padding: 12px 20px;
      display: flex;
      align-items: center;
      margin-bottom: 5px;
      cursor: pointer;
      transition: all 0.3s;
      position: relative;
    }

    .menu-item:hover, .menu-item.active {
      background-color: #10b981;
    }

    .menu-item .icon {
      margin-right: 10px;
      width: 20px;
      height: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .user-info {
      padding: 20px;
      border-top: 1px solid #10b981;
      margin-top: auto;
      position: absolute;
      bottom: 0;
      width: 100%;
    }

    .user-profile {
      display: flex;
      align-items: center;
    }

    .user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background-color: #dcfce7;
      margin-right: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #059669;
      font-weight: bold;
    }

    .user-details {
      flex: 1;
    }

    .user-name {
      font-weight: 600;
    }

    .user-role {
      font-size: 12px;
      opacity: 0.8;
    }

    /* Main Content */
    .main-content {
      flex: 1;
      margin-left: 260px;
      padding: 20px;
    }

    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .page-title {
      font-size: 24px;
      font-weight: bold;
    }

    .actions {
      display: flex;
      align-items: center;
    }

    .notification-bell {
      position: relative;
      margin-right: 20px;
      cursor: pointer;
    }

    .notification-badge {
      position: absolute;
      top: -5px;
      right: -5px;
      background-color: #ef4444;
      color: white;
      width: 18px;
      height: 18px;
      border-radius: 50%;
      font-size: 11px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .quick-action {
      background-color: #059669;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      text-decoration: none;
      font-weight: 500;
      margin-left: 10px;
      cursor: pointer;
      border: none;
    }

    .quick-action:hover {
      background-color: #047857;
    }

    body {
      background-color: #fdfdfd;
      color: #333;
      line-height: 1.6;
    }

    .container {
      width: 90%;
      max-width: 1100px;
      margin: auto;
      padding: 60px 0;
    }

    .hero {
      background: #059669;
      color: white;
      padding: 100px 20px;
      text-align: center;
    }

    .logo {
      font-size: 40px;
      font-weight: bold;
    }

    .logo span {
      color: #a2d729;
    }

    .tagline {
      font-size: 20px;
      margin-top: 10px;
    }

    .about, .values, .team, .contact {
      text-align: center;
    }

    .about h2,
    .values h2,
    .team h2,
    .contact h2 {
      color:  #059669;
      font-size: 32px;
      margin-bottom: 20px;
    }

    .about p,
    .contact p {
      max-width: 700px;
      margin: 0 auto;
    }

    .grid {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 30px;
      margin-top: 30px;
    }

    .value,
    .team-member {
      background: #ffffff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      width: 250px;
    }

    .value h3 {
      color: #2e8b57;
      margin-bottom: 10px;
    }

    .team-member img {
      border-radius: 50%;
      width: 120px;
      height: 120px;
      margin-bottom: 10px;
    }

    .team-member h4 {
      color: #2e8b57;
      margin-bottom: 5px;
    }

    .btn {
      background-color: #4CAF50;
      color: #fff;
      display: inline-block;
      padding: 12px 25px;
      border-radius: 5px;
      margin-top: 20px;
      text-decoration: none;
      font-weight: bold;
      transition: background 0.3s;
    }

    .btn:hover {
      background-color: #388e3c;
    }

    .footer {
      background-color:  #059669;
      color: white;
      text-align: center;
      padding: 20px;
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
  </style>
</head>

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

<body>
  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar-logo">EMSI <span>Recruiter</span></div>
    <div class="sidebar-menu">
      <div class="menu-item">
      <a href="/ProfilRecruteur" style="display: flex; align-items: center; color: inherit; text-decoration: none; width: 100%;">
        <div class="icon">📊</div>
        <span>Tableau de bord</span>
      </a>
      </div>
      <div class="menu-item active">
        <a href="/presentation" style="display: flex; align-items: center; color: inherit; text-decoration: none; width: 100%;">
          <div class="icon">🏢</div>
          <span>Profil entreprise</span>
        </a>
      </div>
      <div class="menu-item" id="jobOffersMenuItem">
        <div class="icon">📝</div>
            <a href="/GestionOffre" style="display: flex; align-items: center; color: inherit; text-decoration: none; width: 100%;">
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

  <main class="main-content">
    <header class="hero">
      <div class="container">
        <h1 class="logo">{{ $user ? $user->name : 'Invité' }} <span></span></h1>
        <p class="tagline">Innover. Transformer. Réussir.</p>
      </div>
    </header>

    <section class="about">
      <div class="container">
        <h2>Qui sommes-nous ?</h2>
        <p>
          Fondée en 2020, {{ $user ? $user->name : 'Invité' }} Solutions est une entreprise spécialisée dans le développement de solutions numériques innovantes pour les PME. Notre mission est de transformer les idées en applications performantes, intuitives et durables.
        </p>
      </div>
    </section>

    <section class="values">
      <div class="container">
        <h2>Nos Valeurs</h2>
        <div class="grid">
          <div class="value">
            <h3>Innovation</h3>
            <p>Nous repoussons les limites de la technologie pour offrir des solutions à la pointe.</p>
          </div>
          <div class="value">
            <h3>Qualité</h3>
            <p>Chaque projet est réalisé avec rigueur, excellence et attention au détail.</p>
          </div>
          <div class="value">
            <h3>Engagement</h3>
            <p>Nous travaillons main dans la main avec nos clients pour assurer leur réussite.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="team">
      <div class="container">
        <h2>Notre Équipe</h2>
        <div class="grid">
          <div class="team-member">
            <h4>Sofia El Amrani</h4>
            <p>CEO & Co-fondatrice</p>
          </div>
          <div class="team-member">
            <h4>Rami Haddad</h4>
            <p>CTO</p>
          </div>
          <div class="team-member">
            <h4>Maya Bennis</h4>
            <p>Responsable Design</p>
          </div>
        </div>
      </div>
    </section>

    <section class="contact">
      <div class="container">
        <h2>Contactez-nous</h2>
        <p>Envie de collaborer ou de discuter d’un projet ? Écrivez-nous !</p>
        <a href="mailto:contact@technova.com" class="btn">contact@gmail.com</a>
      </div>
    </section>

    <footer class="footer">
      <p>&copy; 2025 {{ $user ? $user->name : 'Invité' }} Solutions. Tous droits réservés.</p>
    </footer>
  </main>
</body>
</html>
