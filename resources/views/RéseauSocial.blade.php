<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réseau Social</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">


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
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f5f7fa;
        min-height: 100vh;
        color: #333;
        margin-left: 260px; /* Pour la sidebar fixe */
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .header {
        background: rgba(255, 255, 255, 0.95);
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .nav-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        background: white;
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .nav-tab {
        padding: 12px 24px;
        background: #f0f4f8;
        color: #4a5568;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .nav-tab:hover {
        background: #e2e8f0;
        transform: translateY(-2px);
    }

    .nav-tab.active {
        background: linear-gradient(45deg, #4CAF50, #2E7D32);
        color: white;
    }

    .tab-content {
        display: none;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .tab-content.active {
        display: block;
    }

    .card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    }

    .card h2 {
        margin-bottom: 20px;
        color: #2d3748;
        font-size: 1.5rem;
        border-bottom: 2px solid #e2e8f0;
        padding-bottom: 10px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #4a5568;
    }

    .form-input, .form-select, .form-textarea {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: #f8fafc;
    }

    .form-input:focus, .form-select:focus, .form-textarea:focus {
        outline: none;
        border-color: #4CAF50;
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        background: white;
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary {
        background: linear-gradient(45deg, #4CAF50, #2E7D32);
        color: white;
    }

    .btn-success {
        background: linear-gradient(45deg, #56ab2f, #a8e6cf);
        color: white;
    }

    .btn-danger {
        background: linear-gradient(45deg, #ff6b6b, #ee5a24);
        color: white;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        opacity: 0.9;
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }

    .item-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .item-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    }

    .item-card h3 {
        color: #2d3748;
        margin-bottom: 10px;
    }

    .item-card p {
        color: #4a5568;
        margin-bottom: 15px;
    }

    .media-preview {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 8px;
        overflow: hidden;
        margin: 10px 0;
    }

    .media-preview:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .file-placeholder {
        transition: background-color 0.3s ease;
        padding: 20px;
        background: #f8fafc;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        margin: 10px 0;
    }

    .file-placeholder:hover {
        background-color: #e2e8f0 !important;
    }

    .member-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 15px;
    }

    .member-tag {
        background: linear-gradient(45deg, #81C784, #66BB6A);
        color: white;
        padding: 4px 12px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .status-pending {
        background: #fff3bf;
        color: #f59f00;
    }

    .status-accepted {
        background: #d3f9d8;
        color: #2b8a3e;
    }

    .status-rejected {
        background: #ffd8d8;
        color: #c92a2a;
    }

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
        z-index: 1000;
        animation: fadeIn 0.3s ease;
    }

    .modal-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 30px;
        border-radius: 15px;
        max-width: 500px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .close {
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 24px;
        cursor: pointer;
        color: #999;
        transition: color 0.3s;
    }

    .close:hover {
        color: #333;
    }

    .search-box {
        position: relative;
        margin-bottom: 20px;
    }

    .search-input {
        width: 100%;
        padding: 12px 40px 12px 16px;
        background: #f8fafc;
    }

    .search-icon {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #718096;
    }

    .message-you {
        background: #e3f2fd;
        padding: 12px;
        border-radius: 12px;
        margin: 8px 0;
        max-width: 80%;
        margin-left: auto;
        text-align: right;
    }

    .message-friend {
        background: #f1f1f1;
        padding: 12px;
        border-radius: 12px;
        margin: 8px 0;
        max-width: 80%;
    }

    .message-time {
        font-size: 0.75em;
        color: #666;
        display: block;
        margin-top: 5px;
    }

    .post-form-textarea {
        width: 100%;
        padding: 12px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-family: inherit;
        font-size: 14px;
        resize: vertical;
        min-height: 120px;
        transition: border-color 0.3s ease;
        background: #f8fafc;
    }

    .post-form-textarea:focus {
        border-color: #4CAF50;
        outline: none;
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        background: white;
    }

    /* Structure de mise en page */
    .media-container {
        display: flex;
        gap: 20px;
        margin-top: 20px;
    }

    .media-form-container {
        flex: 0 0 350px;
        position: sticky;
        top: 20px;
        align-self: flex-start;
        height: fit-content;
    }

    .media-feed-container {
        flex: 1;
    }

    /* Sidebar améliorée */
    .sidebar { 
        width: 260px; 
        background-color: #166534; 
        color: white; 
        padding: 20px 0; 
        height: 100vh; 
        position: fixed;
        left: 0;
        top: 0;
        z-index: 100;
        display: flex;
        flex-direction: column;
    }

    .sidebar-logo { 
        padding: 0 20px 20px; 
        font-size: 22px; 
        font-weight: bold; 
        border-bottom: 1px solid rgba(255, 255, 255, 0.1); 
    }

    .sidebar-logo span { 
        color: #86efac; 
    }

    .sidebar-menu { 
        margin-top: 20px;
        flex: 1;
        overflow-y: auto;
        padding: 0 10px;
    }

    .menu-item { 
        padding: 12px 16px; 
        display: flex; 
        align-items: center; 
        margin-bottom: 5px; 
        cursor: pointer; 
        transition: all 0.3s; 
        border-radius: 8px;
    }

    .menu-item:hover, .menu-item.active { 
        background-color: rgba(255, 255, 255, 0.1); 
    }

    .menu-item a {
        display: flex;
        align-items: center;
        color: inherit;
        text-decoration: none;
        width: 100%;
    }

    .menu-item .icon { 
        margin-right: 12px; 
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .user-info { 
        padding: 20px; 
        border-top: 1px solid rgba(255, 255, 255, 0.1); 
        margin-top: auto;
    }

    .user-profile { 
        display: flex; 
        align-items: center; 
    }

    .user-avatar { 
        width: 40px; 
        height: 40px; 
        border-radius: 50%; 
        background-color: #d1fae5; 
        margin-right: 12px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        color: #166534; 
        font-weight: bold;
        font-size: 16px;
    }

    .user-details { 
        flex: 1; 
        overflow: hidden;
    }

    .user-name { 
        font-weight: 600; 
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .user-role { 
        font-size: 12px; 
        opacity: 0.8; 
    }

    /* Main content adjustments */
    .main-content {
        margin-left: 10px;
        padding: 20px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e2e8f0;
    }

    .page-title {
        font-size: 1.8rem;
        color: #2d3748;
    }

    .actions {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .notification-bell {
        position: relative;
        cursor: pointer;
        font-size: 1.2rem;
    }

    .notification-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #ef4444;
        color: white;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        font-size: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profile-name {
        font-weight: 600;
        color: #4a5568;
    }

    /* Responsive design */
    @media (max-width: 992px) {
        body {
            margin-left: 0;
        }

        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .sidebar.active {
            transform: translateX(0);
        }

        .main-content {
            margin-left: 0;
        }

        .media-container {
            flex-direction: column;
        }

        .media-form-container {
            position: static;
            margin-bottom: 20px;
        }
    }

    @media (max-width: 768px) {
        .nav-tabs {
            flex-wrap: wrap;
        }

        .nav-tab {
            flex: 1 0 auto;
            text-align: center;
        }

        .grid {
            grid-template-columns: 1fr;
        }

        .card {
            padding: 15px;
        }

        .modal-content {
            width: 95%;
            padding: 20px;
        }
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Scrollbar styling */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
</style>
</head>
<body>
      <aside class="sidebar">
        <div class="sidebar-logo">EMSI <span>Social</span></div>
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
                <a href="/#" style="display: flex; align-items: center; color: inherit; text-decoration: none; width: 100%;">
                    <div class="icon">🔍</div>
                    <span>Offres d'emploi</span>
                </a>
            </div>
            <div class="menu-item active">
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
            <h1 class="page-title">Emsi Social</h1>
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
    </div>
    <div class="container">
      <!--  <div class="header">
            <h1>EmsiSocial</h1>
        </div>-->

        <!-- Navigation -->
        <div class="nav-tabs">
            <button class="nav-tab active" onclick="showTab('groups')">👥 Groupes</button>
            <button class="nav-tab" onclick="showTab('media')">📸 Posts</button>
            <button class="nav-tab" onclick="showTab('friends')">👫 Amis</button>
        </div>

        <!-- Gestion des Groupes -->
        <div id="groups" class="tab-content active">
            <div class="card">
                <h2>Créer un nouveau groupe</h2>
                <form id="groupForm">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Nom du groupe</label>
                        <input type="text" name="name" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-textarea" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Type de groupe</label>
                        <select name="type" class="form-select">
                            <option value="public">Public</option>
                            <option value="private">Privé</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Créer le groupe</button>
                </form>
            </div>

            <div class="card">
                <h2>Mes Groupes</h2>
                <div class="search-box">
                    <input type="text" class="search-input form-input" placeholder="Rechercher un groupe..." id="groupSearch">
                    <span class="search-icon">🔍</span>
                </div>
                <div class="grid" id="groupsList">
                    @foreach($groups as $group)
                    <div class="item-card">
                        <h3>{{ $group->name }}</h3>
                        <p>{{ $group->description }}</p>
                        <p><strong>Type:</strong> {{ ucfirst($group->type) }}</p>
                        <p><strong>Membres:</strong> {{ $group->members->count() }}</p>
                        <div class="member-list">
                            @foreach($group->members->take(5) as $member)
                                <span class="member-tag">{{ $member->name }}</span>
                            @endforeach
                            @if($group->members->count() > 5)
                                <span class="member-tag">+{{ $group->members->count() - 5 }}</span>
                            @endif
                        </div>
                        <div style="margin-top: 15px;">
                            <button class="btn btn-danger" onclick="deleteGroup({{ $group->id }})">Supprimer</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Gestion des Médias -->
        <div id="media" class="tab-content">
            <div class="media-container">
                <!-- Colonne gauche - Formulaire -->
                <div class="media-form-container">
                    <div class="card">
                        <h2>Publier un post</h2>
                        <form id="mediaForm" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="form-label">Fichier média</label>
                                <input type="file" name="file" class="form-input" accept="image/*,video/*" required onchange="previewMedia(this)">
                            </div>
                            <div id="mediaPreview"></div>
                            <div class="form-group">
                                <label class="form-label">Titre</label>
                                <input type="text" name="title" class="form-input" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="post-form-textarea" rows="3" 
                                          placeholder="Partagez vos idées, vos projets ou posez une question à la communauté..." 
                                          required></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Partager avec le groupe</label>
                                <select name="group_id" class="form-select">
                                    <option value="">Aucun groupe</option>
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Publier</button>
                        </form>
                    </div>
                </div>

                <!-- Colonne centrale - Fil d'actualité -->
                <div class="media-feed-container">
                    <div class="card">
                        <h2>Fil d'actualité</h2>
                        <div class="search-box">
                            <input type="text" class="search-input form-input" placeholder="Rechercher dans les posts..." id="mediaSearch">
                            <span class="search-icon">🔍</span>
                        </div>
                        <div class="grid" id="mediaList">
                            @foreach($medias as $media)
                            <div class="item-card">
                                <h3>{{ $media->title }}</h3>
                                <p>{{ $media->description }}</p>
                                @if(str_contains($media->file_type, 'image'))
                                    <img src="{{ Storage::url($media->file_path) }}" 
                                         alt="{{ $media->title }}" 
                                         class="media-preview" 
                                         style="width: 100%; height: auto; max-height: 300px; object-fit: contain; border-radius: 8px; margin: 10px 0; cursor: pointer;"
                                         onclick="shareMedia({{ $media->id }}, '{{ $media->file_type }}', '{{ Storage::url($media->file_path) }}', '{{ addslashes($media->title) }}')">
                                @elseif(str_contains($media->file_type, 'video'))
                                    <video controls 
                                           class="media-preview" 
                                           style="width: 100%; max-height: 300px; border-radius: 8px; margin: 10px 0; cursor: pointer;"
                                           onclick="shareMedia({{ $media->id }}, '{{ $media->file_type }}', '{{ Storage::url($media->file_path) }}', '{{ addslashes($media->title) }}')">
                                        <source src="{{ Storage::url($media->file_path) }}" type="{{ $media->file_type }}">
                                    </video>
                                @else
                                    <div class="file-placeholder" 
                                         style="padding: 20px; background: #f5f5f5; border-radius: 8px; text-align: center; cursor: pointer;"
                                         onclick="shareMedia({{ $media->id }}, '{{ $media->file_type }}', '{{ Storage::url($media->file_path) }}', '{{ addslashes($media->title) }}')">
                                        <p>Type de fichier: {{ $media->file_type }}</p>
                                        <p>{{ $media->title }}</p>
                                    </div>
                                @endif
                               <!-- <p><strong>Type:</strong> {{ $media->file_type }}</p>
                                <p><strong>Taille:</strong> {{ number_format($media->file_size / 1024, 2) }} KB</p>-->
                                @if($media->group)
                                    <p><strong>Partagé avec:</strong> {{ $media->group->name }}</p>
                                @endif
                                <div style="margin-top: 15px; display: flex; gap: 10px;">
                                    <button class="btn btn-danger" onclick="deleteMedia({{ $media->id }})">Supprimer</button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gestion des Amis -->
        <div id="friends" class="tab-content">
            <div class="card">
                <h2>Rechercher des amis</h2>
                <div class="form-group">
                    <input type="text" class="form-input" placeholder="Rechercher par nom ou email..." id="friendSearch">
                </div>
                <div id="searchResults"></div>
            </div>

            <div class="card">
                <h2>Demandes d'amitié</h2>
                <div class="grid" id="friendRequests">
                    @foreach($friendRequests as $request)
                    <div class="item-card">
                        <h3>{{ $request->sender->name }}</h3>
                        <p>{{ $request->sender->email }}</p>
                        <span class="status-badge status-{{ $request->status }}">{{ ucfirst($request->status) }}</span>
                        @if($request->status === 'pending')
                        <div style="margin-top: 15px;">
                            <button class="btn btn-success" onclick="respondToRequest({{ $request->id }}, 'accepted')">Accepter</button>
                            <button class="btn btn-danger" onclick="respondToRequest({{ $request->id }}, 'rejected')">Refuser</button>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="card">
                <h2>Mes Amis</h2>
                <div class="grid" id="friendsList">
                    @foreach($friends as $friend)
                    <div class="item-card">
                        <h3>{{ $friend->name }}</h3>
                        <p>{{ $friend->email }}</p>
                        <p><strong>Amis depuis:</strong> {{ $friend->pivot->created_at->format('d/m/Y') }}</p>
                
                        <div style="margin-top: 15px;">
                            <button class="btn btn-primary" onclick="openChat({{ $friend->id }}, '{{ $friend->name }}')">Messagerie</button>
                            <button class="btn btn-danger" onclick="removeFriend({{ $friend->id }})">Supprimer</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div id="modalContent"></div>
        </div>
    </div>

    <script>
        // Configuration CSRF
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Navigation entre onglets
        function showTab(tabName) {
            // Masquer tous les contenus
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Désactiver tous les boutons
            document.querySelectorAll('.nav-tab').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Afficher le contenu sélectionné
            document.getElementById(tabName).classList.add('active');
            event.target.classList.add('active');
        }

        // Gestion des groupes
        document.getElementById('groupForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            try {
                const response = await fetch('/groups', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                });
                
                if (response.ok) {
                    const result = await response.json();
                    alert('Groupe créé avec succès!');
                    location.reload();
                } else {
                    alert('Erreur lors de la création du groupe');
                }
            } catch (error) {
                console.error('Erreur:', error);
                alert('Erreur de connexion');
            }
        });

        // Gestion des médias
        document.getElementById('mediaForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            try {
                const response = await fetch('/media', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                });
                
                if (response.ok) {
                    const result = await response.json();
                    alert('Média uploadé avec succès!');
                    location.reload();
                } else {
                    alert('Erreur lors de l\'upload du média');
                }
            } catch (error) {
                console.error('Erreur:', error);
                alert('Erreur de connexion');
            }
        });

        // Prévisualisation des médias
        function previewMedia(input) {
            const preview = document.getElementById('mediaPreview');
            preview.innerHTML = '';
            preview.style.margin = '10px 0';
            
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    if (file.type.startsWith('image/')) {
                        preview.innerHTML = `
                            <img src="${e.target.result}" 
                                 style="max-width: 100%; max-height: 300px; object-fit: contain; border-radius: 8px; border: 1px solid #ddd;"
                                 alt="Preview">
                            <p style="margin-top: 5px; font-size: 0.9em;">${file.name} (${(file.size/1024).toFixed(2)} KB)</p>
                        `;
                    } else if (file.type.startsWith('video/')) {
                        preview.innerHTML = `
                            <video src="${e.target.result}" 
                                   style="max-width: 100%; max-height: 300px; border-radius: 8px; border: 1px solid #ddd;"
                                   controls>
                            </video>
                            <p style="margin-top: 5px; font-size: 0.9em;">${file.name} (${(file.size/1024).toFixed(2)} KB)</p>
                        `;
                    } else {
                        preview.innerHTML = `
                            <div style="padding: 15px; background: #f5f5f5; border-radius: 8px; text-align: center;">
                                <p>Type de fichier: ${file.type || 'inconnu'}</p>
                                <p>${file.name} (${(file.size/1024).toFixed(2)} KB)</p>
                            </div>
                        `;
                    }
                };
                
                reader.readAsDataURL(file);
            }
        }

        // Recherche d'amis
        let searchTimeout;
        document.getElementById('friendSearch').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value;
            
            if (query.length < 2) {
                document.getElementById('searchResults').innerHTML = '';
                return;
            }
            
            searchTimeout = setTimeout(async () => {
                try {
                    const response = await fetch(`/friends/search?q=${encodeURIComponent(query)}`, {
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });
                    
                    if (response.ok) {
                        const users = await response.json();
                        displaySearchResults(users);
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                }
            }, 300);
        });

        function displaySearchResults(users) {
            const container = document.getElementById('searchResults');
            
            if (users.length === 0) {
                container.innerHTML = '<p>Aucun utilisateur trouvé</p>';
                return;
            }
            
            container.innerHTML = users.map(user => `
                <div class="item-card" style="margin-top: 10px;">
                    <h4>${user.name}</h4>
                    <p>${user.email}</p>
                    <button class="btn btn-success" onclick="sendFriendRequest(${user.id})">
                        Envoyer une demande
                    </button>
                </div>
            `).join('');
        }

        // Envoyer une demande d'amitié
        async function sendFriendRequest(userId) {
            try {
                const response = await fetch('/friends/request', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ receiver_id: userId })
                });
                
                if (response.ok) {
                    alert('Demande d\'amitié envoyée!');
                } else {
                    alert('Erreur lors de l\'envoi de la demande');
                }
            } catch (error) {
                console.error('Erreur:', error);
                alert('Erreur de connexion');
            }
        }

        // Répondre à une demande d'amitié
        async function respondToRequest(requestId, status) {
            try {
                const response = await fetch(`/friends/respond/${requestId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ status: status })
                });
                
                if (response.ok) {
                    alert(`Demande ${status === 'accepted' ? 'acceptée' : 'refusée'}!`);
                    location.reload();
                } else {
                    alert('Erreur lors de la réponse');
                }
            } catch (error) {
                console.error('Erreur:', error);
                alert('Erreur de connexion');
            }
        }

        // Supprimer un groupe
        async function deleteGroup(groupId) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce groupe?')) {
                try {
                    const response = await fetch(`/groups/${groupId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });
                    
                    if (response.ok) {
                        alert('Groupe supprimé!');
                        location.reload();
                    } else {
                        alert('Erreur lors de la suppression');
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                    alert('Erreur de connexion');
                }
            }
        }

        // Supprimer un média
        async function deleteMedia(mediaId) {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce média?')) {
                try {
                    const response = await fetch(`/media/${mediaId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });
                    
                    if (response.ok) {
                        alert('Média supprimé!');
                        location.reload();
                    } else {
                        alert('Erreur lors de la suppression');
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                    alert('Erreur de connexion');
                }
            }
        }

        // Supprimer un ami
        async function removeFriend(friendId) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cet ami?')) {
                try {
                    const response = await fetch(`/friends/${friendId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });
                    
                    if (response.ok) {
                        alert('Ami supprimé!');
                        location.reload();
                    } else {
                        alert('Erreur lors de la suppression');
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                    alert('Erreur de connexion');
                }
            }
        }

        // Fonctions modales
        function openModal(content) {
            document.getElementById('modalContent').innerHTML = content;
            document.getElementById('modal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }

        // Fonctions supplémentaires
        function manageGroup(groupId) {
            openModal(`
                <h2>Gérer le groupe</h2>
                <p>Fonctionnalité de gestion du groupe ${groupId} à implémenter</p>
                <button class="btn btn-primary" onclick="closeModal()">Fermer</button>
            `);
        }

        // Fonction pour partager un média avec aperçu
        function shareMedia(mediaId, mediaType, mediaPath, mediaTitle) {
            let mediaContent = '';
            
            if (mediaType.startsWith('image/')) {
                mediaContent = `
                    <div style="text-align: center; margin-bottom: 20px;">
                        <img src="${mediaPath}" 
                             style="max-width: 100%; max-height: 300px; object-fit: contain; border-radius: 8px; border: 1px solid #ddd;">
                    </div>
                `;
            } else if (mediaType.startsWith('video/')) {
                mediaContent = `
                    <div style="text-align: center; margin-bottom: 20px;">
                        <video controls 
                               style="max-width: 100%; max-height: 300px; border-radius: 8px; border: 1px solid #ddd;">
                            <source src="${mediaPath}" type="${mediaType}">
                            Votre navigateur ne supporte pas la lecture de vidéos.
                        </video>
                    </div>
                `;
            } else {
                mediaContent = `
                    <div style="padding: 15px; background: #f5f5f5; border-radius: 8px; text-align: center; margin-bottom: 20px;">
                        <p>Type de fichier: ${mediaType || 'inconnu'}</p>
                        <a href="${mediaPath}" download class="btn btn-primary">Télécharger le fichier</a>
                    </div>
                `;
            }

            openModal(`
                <h2>Partager "${mediaTitle}"</h2>
                ${mediaContent}
                <form id="shareMediaForm">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Partager avec un groupe</label>
                        <select name="group_id" class="form-select">
                            <option value="">Sélectionnez un groupe</option>
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="display: flex; gap: 10px; margin-top: 20px;">
                        <button type="submit" class="btn btn-success">Partager</button>
                        <button type="button" class="btn btn-danger" onclick="closeModal()">Annuler</button>
                    </div>
                </form>
            `);

            document.getElementById('shareMediaForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                
                try {
                    const response = await fetch(`/media/share/${mediaId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData
                    });
                    
                    if (response.ok) {
                        alert('Média partagé avec succès!');
                        closeModal();
                        location.reload();
                    } else {
                        alert('Erreur lors du partage');
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                    alert('Erreur de connexion');
                }
            });
        }

        // Fonction pour afficher un média en grand
        function viewMediaFullscreen(mediaId, mediaType, mediaPath) {
            let mediaHtml = '';
            
            if (mediaType.startsWith('image/')) {
                mediaHtml = `<img src="${mediaPath}" style="max-width: 100%; max-height: 80vh; display: block; margin: 0 auto;">`;
            } else if (mediaType.startsWith('video/')) {
                mediaHtml = `
                    <video controls autoplay style="max-width: 100%; max-height: 80vh; display: block; margin: 0 auto;">
                        <source src="${mediaPath}" type="${mediaType}">
                        Votre navigateur ne supporte pas la lecture de vidéos.
                    </video>
                `;
            } else {
                mediaHtml = `
                    <div style="text-align: center; padding: 20px;">
                        <p>Ce type de média ne peut pas être affiché en plein écran</p>
                        <a href="${mediaPath}" download class="btn btn-primary">Télécharger le fichier</a>
                    </div>
                `;
            }
            
            openModal(mediaHtml);
        }

        function sendMessage(friendId) {
            openModal(`
                <h2>Envoyer un message</h2>
                <form id="messageForm">
                    @csrf
                    <div class="form-group">
                        <textarea name="message" class="form-textarea" placeholder="Tapez votre message..." rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Envoyer</button>
                    <button type="button" class="btn btn-danger" onclick="closeModal()">Annuler</button>
                </form>
            `);

            // Ajoutez l'écouteur d'événement pour le formulaire
            document.getElementById('messageForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const message = formData.get('message');
                
                try {
                    const response = await fetch(`/messages/send/${friendId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ message: message })
                    });
                    
                    if (response.ok) {
                        alert('Message envoyé avec succès!');
                        closeModal();
                    } else {
                        const error = await response.json();
                        alert(error.error || 'Erreur lors de l\'envoi du message');
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                    alert('Erreur de connexion');
                }
            });
        }

        // Recherche en temps réel
        document.addEventListener('DOMContentLoaded', function() {
            // Recherche de groupes
            const groupSearch = document.getElementById('groupSearch');
            if (groupSearch) {
                groupSearch.addEventListener('input', function() {
                    const query = this.value.toLowerCase();
                    const items = document.querySelectorAll('#groupsList .item-card');
                    
                    items.forEach(item => {
                        const title = item.querySelector('h3').textContent.toLowerCase();
                        const description = item.querySelector('p').textContent.toLowerCase();
                        
                        if (title.includes(query) || description.includes(query)) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            }

            // Recherche de médias
            const mediaSearch = document.getElementById('mediaSearch');
            if (mediaSearch) {
                mediaSearch.addEventListener('input', function() {
                    const query = this.value.toLowerCase();
                    const items = document.querySelectorAll('#mediaList .item-card');
                    
                    items.forEach(item => {
                        const title = item.querySelector('h3').textContent.toLowerCase();
                        const description = item.querySelector('p').textContent.toLowerCase();
                        
                        if (title.includes(query) || description.includes(query)) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            }
        });

        async function viewMessages(friendId) {
            try {
                const response = await fetch(`/messages/${friendId}`);
                
                if (response.ok) {
                    const messages = await response.json();
                    let messagesHtml = '<h2>Conversation</h2><div style="max-height: 400px; overflow-y: auto;">';
                    
                    messages.forEach(msg => {
                        messagesHtml += `
                            <div style="margin-bottom: 10px; padding: 10px; 
                                background: ${msg.sender_id === {{ auth()->id() }} ? '#e3f2fd' : '#f5f5f5'}; 
                                border-radius: 5px;">
                                <strong>${msg.sender_id === {{ auth()->id() }} ? 'Vous' : 'Ami'}:</strong>
                                <p>${msg.content}</p>
                                <small>${new Date(msg.created_at).toLocaleString()}</small>
                            </div>
                        `;
                    });
                    
                    messagesHtml += '</div>';
                    openModal(messagesHtml);
                }
            } catch (error) {
                console.error('Erreur:', error);
            }
        }

        function openChat(friendId, friendName) {
            // Charger les messages existants
            fetch(`/messages/${friendId}`)
                .then(response => response.json())
                .then(messages => {
                    // Construire l'interface de chat
                    let chatHtml = `
                        <h2>Conversation avec ${friendName}</h2>
                        <div id="chatWindow" style="height: 300px; overflow-y: scroll; margin-bottom: 15px; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                            ${renderMessages(messages)}
                        </div>
                        <form id="messageForm">
                            @csrf
                            <div class="form-group">
                                <textarea name="message" class="form-textarea" placeholder="Tapez votre message..." rows="3" required style="width: 100%;"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Envoyer</button>
                            <button type="button" class="btn btn-danger" onclick="closeModal()">Fermer</button>
                        </form>
                    `;

                    openModal(chatHtml);

                    // Faire défiler vers le bas pour voir les derniers messages
                    const chatWindow = document.getElementById('chatWindow');
                    chatWindow.scrollTop = chatWindow.scrollHeight;

                    // Gérer l'envoi de nouveaux messages
                    document.getElementById('messageForm').addEventListener('submit', function(e) {
                        e.preventDefault();
                        const formData = new FormData(this);
                        const message = formData.get('message');
                        
                        fetch(`/messages/send/${friendId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({ message: message })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Ajouter le nouveau message à la conversation
                                const chatWindow = document.getElementById('chatWindow');
                                chatWindow.innerHTML += `
                                    <div style="margin-bottom: 10px; padding: 10px; background: #e3f2fd; border-radius: 5px;">
                                        <strong>Vous:</strong>
                                        <p>${message}</p>
                                        <small>${new Date().toLocaleString()}</small>
                                    </div>
                                `;
                                // Effacer le champ de texte
                                this.reset();
                                // Faire défiler vers le bas
                                chatWindow.scrollTop = chatWindow.scrollHeight;
                            } else {
                                alert(data.error || 'Erreur lors de l\'envoi du message');
                            }
                        })
                        .catch(error => {
                            console.error('Erreur:', error);
                            alert('Erreur de connexion');
                        });
                    });
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    openModal(`<p>Erreur lors du chargement des messages</p>`);
                });
        }

        function renderMessages(messages) {
            return messages.map(msg => {
                const isYou = msg.sender_id === {{ auth()->id() }};
                return `
                    <div class="${isYou ? 'message-you' : 'message-friend'}">
                        <strong>${isYou ? 'Vous' : 'Ami'}</strong>
                        <p>${msg.content}</p>
                        <span class="message-time">${new Date(msg.created_at).toLocaleString()}</span>
                    </div>
                `;
            }).join('');
        }

        // Fermer la modal en cliquant à l'extérieur
        window.onclick = function(event) {
            const modal = document.getElementById('modal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>