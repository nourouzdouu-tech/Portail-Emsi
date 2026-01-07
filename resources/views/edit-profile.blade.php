<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Éditer le profil</title>
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
    /* Reset minimal */
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: white;
      margin: 0;
      padding: 0;
      color: #333;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
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
    header {
      background-color: white;
      color: #166534;
      padding: 1rem 0;
      text-align: center;
    }

    main {
      flex-grow: 1;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding: 2rem 1rem;
    }

    .form-container {
      background: white;
      padding: 2rem;
      border-radius: 8px;
      width: 100%;
      max-width: 450px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    h1, h3 {
      margin-top: 0;
      margin-bottom: 1.5rem;
    }

    .form-group {
      margin-bottom: 1.25rem;
    }

    label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 600;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"],
    textarea {
      width: 100%;
      padding: 0.5rem 0.75rem;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 1rem;
      font-family: inherit;
      transition: border-color 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="tel"]:focus,
    textarea:focus {
      outline: none;
      border-color: #3498db;
      box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
    }

    .error-message {
      color: #e74c3c;
      font-size: 0.85rem;
      margin-top: 0.25rem;
      height: 1rem;
    }

    .form-actions {
      display: flex;
      gap: 1rem;
      justify-content: flex-end;
      margin-top: 1.5rem;
    }

    .btn {
      padding: 0.6rem 1.25rem;
      font-weight: 600;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      text-decoration: none;
      text-align: center;
      user-select: none;
      transition: background-color 0.3s ease;
      font-size: 1rem;
    }

    .btn-primary {
      background-color:rgb(24, 88, 66);
      color: white;
    }

    .btn-primary:hover {
      background-color:rgb(137, 210, 176);
    }

    .btn-secondary {
      background-color: #bdc3c7;
      color: #2c3e50;
      line-height: 1.5;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }

    .btn-secondary:hover {
      background-color: #95a5a6;
    }

    /* Responsive */
    @media (max-width: 500px) {
      .form-container {
        padding: 1rem;
        width: 100%;
      }

      .form-actions {
        flex-direction: column;
      }

      .btn {
        width: 100%;
      }
    }
  </style>
</head>
<body>
  <header>
    <h1>Modifier le profil</h1>
  </header>
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

          
             <div class="menu-item">
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
                <div class="icon">🔍</div>
                <span>Offres d'emploi</span>
            </div>
          <!--  <div class="menu-item">
                <div class="icon">📋</div>
                <span>Mes candidatures</span>
            </div>-->
            <div class="menu-item">
                <div class="icon">👥</div>
                <span>Réseau social</span>
            </div>
           
             <div class="menu-item active">
            <a href="/edit-profile" style="display: flex; align-items: center; color: inherit; text-decoration: none; width: 100%;">
                <div class="icon">⚙️</div>
                <span>Editer Profil</span>
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
  <main>
    @if(session('success'))
  <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px; border-radius: 4px;">
    {{ session('success') }}
  </div>
@endif

    <section class="form-container">
      <form id="edit-profile-form" novalidate method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label for="name">Nom</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Nom">
          @error('name')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>


        <div class="form-group">
          <label for="email">Email</label>
           <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Email">
          @error('email')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="phone">Téléphone</label>
          <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Téléphone">
          @error('phone')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="ville">Ville</label>
             <input type="text" name="ville" value="{{ old('ville', $user->ville) }}" placeholder="Ville">
        </div>


        <div class="form-actions">
          <button type="submit" class="btn btn-primary">Mettre à jour</button>
          <a href="{{ route('profile.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
      </form>
    </section>
  </main>

  
</body>
</html>
