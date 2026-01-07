<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMSI Career Connect - CV & Letter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
    :root {
        --primary-green: #22c55e;
        --dark-green: #16a34a;
        --light-green: #dcfce7;
        --pale-green: #f0fdf4;
        --emerald: #10b981;
        --forest: #166534;
    }

    .cv-manager {
        background: linear-gradient(135deg, var(--pale-green) 0%, #ffffff 100%);
        min-height: 100vh;
        padding: 20px;
    }

    .header-section {
        background: linear-gradient(135deg, var(--primary-green), var(--emerald));
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 30px;
        box-shadow: 0 8px 32px rgba(34, 197, 94, 0.3);
    }

    .nav-tabs {
        background: white;
        border-radius: 10px;
        padding: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }

    .nav-tabs .nav-link {
        border: none;
        color: var(--forest);
        font-weight: 600;
        padding: 15px 25px;
        border-radius: 8px;
        transition: all 0.3s ease;
        margin: 0 5px;
    }

    .nav-tabs .nav-link:hover {
        background-color: var(--light-green);
        color: var(--dark-green);
    }

    .nav-tabs .nav-link.active {
        background: linear-gradient(135deg, var(--primary-green), var(--emerald));
        color: white;
        box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
    }

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
        margin-bottom: 20px;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-header {
        background: linear-gradient(135deg, var(--light-green), white);
        border-bottom: 2px solid var(--primary-green);
        border-radius: 15px 15px 0 0 !important;
        padding: 20px;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-green), var(--emerald));
        border: none;
        border-radius: 10px;
        padding: 12px 25px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--dark-green), var(--primary-green));
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(34, 197, 94, 0.4);
    }

    .btn-success {
        background: linear-gradient(135deg, var(--emerald), var(--primary-green));
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .btn-outline-success {
        border: 2px solid var(--primary-green);
        color: var(--primary-green);
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-outline-success:hover {
        background: var(--primary-green);
        color: white;
    }

    .form-control {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 0.2rem rgba(34, 197, 94, 0.25);
    }

    .upload-zone {
        border: 3px dashed var(--primary-green);
        border-radius: 15px;
        background: var(--pale-green);
        padding: 40px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .upload-zone:hover {
        background: var(--light-green);
        border-color: var(--dark-green);
    }

    .upload-zone.dragover {
        background: var(--light-green);
        border-color: var(--dark-green);
        transform: scale(1.02);
    }

    .cv-template {
        border: 2px solid var(--light-green);
        border-radius: 10px;
        padding: 20px;
        background: white;
        cursor: pointer;
        transition: all 0.3s ease;
        height: 200px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .cv-template:hover {
        border-color: var(--primary-green);
        box-shadow: 0 8px 25px rgba(34, 197, 94, 0.3);
        transform: translateY(-5px);
    }

    .cv-template.selected {
        border-color: var(--primary-green);
        background: var(--light-green);
        box-shadow: 0 8px 25px rgba(34, 197, 94, 0.3);
    }

    .file-item {
        background: white;
        border: 1px solid var(--light-green);
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }

    .file-item:hover {
        box-shadow: 0 4px 15px rgba(34, 197, 94, 0.2);
        border-color: var(--primary-green);
    }

    .status-badge {
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-draft {
        background: #fef3c7;
        color: #92400e;
    }

    .status-completed {
        background: var(--light-green);
        color: var(--forest);
    }

    .editor-toolbar {
        background: var(--light-green);
        padding: 10px;
        border-radius: 10px 10px 0 0;
        border-bottom: 1px solid var(--primary-green);
    }

    .editor-content {
        min-height: 300px;
        padding: 20px;
        border: none;
        outline: none;
        font-family: Arial, sans-serif;
        line-height: 1.6;
    }

    .progress-bar {
        background: linear-gradient(135deg, var(--primary-green), var(--emerald));
        border-radius: 10px;
    }

    .alert-success {
        background: var(--light-green);
        border: 1px solid var(--primary-green);
        color: var(--forest);
        border-radius: 10px;
    }

    .modal-content {
        border-radius: 15px;
        border: none;
    }

    .modal-header {
        background: linear-gradient(135deg, var(--light-green), white);
        border-bottom: 2px solid var(--primary-green);
        border-radius: 15px 15px 0 0;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeInUp 0.6s ease-out;
    }

    .loading-spinner {
        border: 3px solid var(--light-green);
        border-top: 3px solid var(--primary-green);
        border-radius: 50%;
        width: 30px;
        height: 30px;
        animation: spin 1s linear infinite;
        margin: 0 auto;
    }
      /* Main Content */
    .main-content { flex: 1; margin-left: 260px; padding: 20px; }
</style>

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

            <div class="menu-item ">
                <a href="/ProfilCandidat" style="display: flex; align-items: center; color: inherit; text-decoration: none; width: 100%;">
                    <div class="icon">👤</div>
                    <span>Mon profil</span>
                </a>
            </div>
            <div class="menu-item active">
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
 <main class="main-content">
<div class="cv-manager">
    <div class="header-section animate-fade-in">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-2"><i class="fas fa-file-alt me-3"></i>Gestionnaire de CV & Lettres de Motivation</h1>
                <p class="mb-0">Créez, gérez et optimisez vos documents professionnels</p>
            </div>
             
        </div>
    </div>

    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs animate-fade-in" id="mainTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <!--  <button class="nav-link active" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload" type="button" role="tab">
                <i class="fas fa-upload me-2"></i>Upload de Documents
            </button>-->
        </li>
        <li class="nav-item" role="presentation">
           <a href="{{ route('cv.create') }}" class="nav-link">
    <i class="fas fa-plus-circle me-2"></i>Créer un CV
</a>

            
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('Lettre.lettreMotiv') }}" class="nav-link">
           <i class="fas fa-edit me-2"></i>Lettres de Motivation
            </a>

        </li>
        <li class="nav-item" role="presentation">
          <!--  <button class="nav-link" id="manage-tab" data-bs-toggle="tab" data-bs-target="#manage" type="button" role="tab">
                <i class="fas fa-folder-open me-2"></i>Gérer les Documents
            </button>-->
        </li>
    </ul>

    <div class="tab-content" id="mainTabsContent">
        
        <!-- Upload Tab -->
        <div class="tab-pane fade show active" id="upload" role="tabpanel">
            <div class="card animate-fade-in">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-cloud-upload-alt me-2"></i>Upload de Documents Existants</h4>
                </div>
                <div class="card-body">
                    <form id="uploadForm" enctype="multipart/form-data">
                        @csrf
                        <div class="upload-zone" id="uploadZone">
                            <div class="upload-content">
                                <i class="fas fa-cloud-upload-alt fa-3x text-success mb-3"></i>
                                <h5>Glissez vos fichiers ici ou cliquez pour sélectionner</h5>
                                <p class="text-muted">Formats acceptés: PDF, DOCX (max 5MB)</p>
                                <input type="file" id="fileInput" name="files[]" multiple accept=".pdf,.docx" style="display: none;">
                                <button type="button" class="btn btn-primary mt-3" onclick="document.getElementById('fileInput').click()">
                                    <i class="fas fa-folder-open me-2"></i>Sélectionner des fichiers
                                </button>
                            </div>
                        </div>
                        
                        <div id="filesList" class="mt-4" style="display: none;">
                            <h6>Fichiers sélectionnés:</h6>
                            <div id="filesContainer"></div>
                            
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label class="form-label">Type de document</label>
                                    <select class="form-control" id="documentType" name="document_type">
                                        <option value="cv">CV</option>
                                        <option value="letter">Lettre de motivation</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nom/Description</label>
                                    <input type="text" class="form-control" id="documentName" name="document_name" placeholder="Ex: CV Développeur Web">
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary mt-3">
                                <i class="fas fa-upload me-2"></i>Uploader les fichiers
                            </button>
                        </div>
                        
                        <div id="uploadProgress" class="mt-3" style="display: none;">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Create CV Tab -->
        <div class="tab-pane fade" id="create-cv" role="tabpanel">
            <div class="row">
                <div class="col-md-4">
                    <div class="card animate-fade-in">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-palette me-2"></i>Choisir un Modèle</h5>
                        </div>
                        <div class="card-body">
                            <div class="cv-templates">
                                <div class="cv-template" data-template="modern" onclick="selectTemplate('modern')">
                                    <i class="fas fa-file-alt fa-2x text-success mb-2"></i>
                                    <h6>Moderne</h6>
                                    <small class="text-muted">Design épuré et professionnel</small>
                                </div>
                                <div class="cv-template mt-3" data-template="classic" onclick="selectTemplate('classic')">
                                    <i class="fas fa-file-text fa-2x text-success mb-2"></i>
                                    <h6>Classique</h6>
                                    <small class="text-muted">Format traditionnel</small>
                                </div>
                                <div class="cv-template mt-3" data-template="creative" onclick="selectTemplate('creative')">
                                    <i class="fas fa-paint-brush fa-2x text-success mb-2"></i>
                                    <h6>Créatif</h6>
                                    <small class="text-muted">Pour les métiers créatifs</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <div class="card animate-fade-in">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i>Informations Personnelles</h5>
                        </div>
                        <div class="card-body">
                            <form id="cvForm">
                                @csrf
                                <input type="hidden" id="selectedTemplate" name="template" value="">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Prénom</label>
                                            <input type="text" class="form-control" name="first_name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Nom</label>
                                            <input type="text" class="form-control" name="last_name" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Téléphone</label>
                                            <input type="tel" class="form-control" name="phone">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Titre/Poste recherché</label>
                                    <input type="text" class="form-control" name="job_title" placeholder="Ex: Développeur Web Full-Stack">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Profil professionnel</label>
                                    <textarea class="form-control" name="profile" rows="4" placeholder="Décrivez brièvement votre profil professionnel..."></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Expériences professionnelles</label>
                                    <div id="experienceContainer">
                                        <div class="experience-item border rounded p-3 mb-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control mb-2" name="experiences[0][title]" placeholder="Titre du poste">
                                                    <input type="text" class="form-control mb-2" name="experiences[0][company]" placeholder="Entreprise">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control mb-2" name="experiences[0][period]" placeholder="Période (ex: 2020-2023)">
                                                    <textarea class="form-control" name="experiences[0][description]" rows="2" placeholder="Description des missions"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-outline-success btn-sm" onclick="addExperience()">
                                        <i class="fas fa-plus me-1"></i>Ajouter une expérience
                                    </button>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Compétences</label>
                                    <input type="text" class="form-control" name="skills" placeholder="Séparez les compétences par des virgules">
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Créer le CV
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Letter Tab -->
        <div class="tab-pane fade" id="create-letter" role="tabpanel">
            <div class="card animate-fade-in">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-envelope-open-text me-2"></i>Éditeur de Lettres de Motivation</h5>
                </div>
                <div class="card-body">
                    <form id="letterForm">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Titre de la lettre</label>
                                <input type="text" class="form-control" name="title" placeholder="Ex: Candidature Développeur Web" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Entreprise cible</label>
                                <input type="text" class="form-control" name="company" placeholder="Nom de l'entreprise">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Poste visé</label>
                                <input type="text" class="form-control" name="position" placeholder="Intitulé du poste">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Modèle de lettre</label>
                                <select class="form-control" id="letterTemplate" onchange="loadLetterTemplate()">
                                    <option value="">Choisir un modèle...</option>
                                    <option value="formal">Formel</option>
                                    <option value="modern">Moderne</option>
                                    <option value="startup">Start-up</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Contenu de la lettre</label>
                            <div class="editor-toolbar">
                                <button type="button" class="btn btn-sm btn-outline-success" onclick="formatText('bold')">
                                    <i class="fas fa-bold"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-success" onclick="formatText('italic')">
                                    <i class="fas fa-italic"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-success" onclick="formatText('underline')">
                                    <i class="fas fa-underline"></i>
                                </button>
                                <div class="btn-group ms-2">
                                    <button type="button" class="btn btn-sm btn-outline-success" onclick="insertTemplate('greeting')">Formule d'appel</button>
                                    <button type="button" class="btn btn-sm btn-outline-success" onclick="insertTemplate('closing')">Formule de politesse</button>
                                </div>
                            </div>
                            <div contenteditable="true" class="editor-content form-control" id="letterContent" style="min-height: 400px;">
                                <p>Madame, Monsieur,</p>
                                <br>
                                <p>Actuellement à la recherche d'un poste de [POSTE], j'ai l'honneur de vous présenter ma candidature pour rejoindre votre équipe.</p>
                                <br>
                                <p>[Développez votre motivation et vos qualifications]</p>
                                <br>
                                <p>Dans l'attente de votre retour, je vous prie d'agréer, Madame, Monsieur, l'expression de mes salutations distinguées.</p>
                            </div>
                            <textarea name="content" id="hiddenContent" style="display: none;"></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Sauvegarder la lettre
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Manage Tab -->
        <div class="tab-pane fade" id="manage" role="tabpanel">
            <div class="row">
                <div class="col-md-6">
                    <div class="card animate-fade-in">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Mes CV</h5>
                        </div>
                        <div class="card-body">
                            <div id="cvList">
                                <!-- CV items will be loaded here -->
                                <div class="text-center py-4">
                                    <div class="loading-spinner"></div>
                                    <p class="mt-2 text-muted">Chargement des CV...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card animate-fade-in">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-envelope me-2"></i>Mes Lettres</h5>
                        </div>
                        <div class="card-body">
                            <div id="letterList">
                                <!-- Letter items will be loaded here -->
                                <div class="text-center py-4">
                                    <div class="loading-spinner"></div>
                                    <p class="mt-2 text-muted">Chargement des lettres...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-eye me-2"></i>Aperçu du document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="previewContent" style="height: 600px; overflow-y: auto;">
                    <!-- Preview content will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" onclick="downloadDocument()">
                    <i class="fas fa-download me-2"></i>Télécharger
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Modifier le document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    @csrf
                    <input type="hidden" id="editDocumentId" name="document_id">
                    <div id="editFormContent">
                        <!-- Form content will be loaded here -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" onclick="saveDocument()">
                    <i class="fas fa-save me-2"></i>Sauvegarder
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize components
    initializeUpload();
    loadDocuments();
    
    // Tab switch event
    document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function(event) {
            const target = event.target.getAttribute('data-bs-target');
            if (target === '#manage') {
                loadDocuments();
            }
        });
    });
});

// Upload functionality
function initializeUpload() {
    const uploadZone = document.getElementById('uploadZone');
    const fileInput = document.getElementById('fileInput');
    
    // Drag and drop events
    uploadZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadZone.classList.add('dragover');
    });
    
    uploadZone.addEventListener('dragleave', () => {
        uploadZone.classList.remove('dragover');
    });
    
    uploadZone.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadZone.classList.remove('dragover');
        const files = e.dataTransfer.files;
        handleFiles(files);
    });
    
    // Click to upload
    uploadZone.addEventListener('click', () => {
        fileInput.click();
    });
    
    fileInput.addEventListener('change', (e) => {
        handleFiles(e.target.files);
    });
    
    // Upload form submission
    document.getElementById('uploadForm').addEventListener('submit', handleUpload);
}

function handleFiles(files) {
    const filesList = document.getElementById('filesList');
    const filesContainer = document.getElementById('filesContainer');
    
    if (files.length > 0) {
        filesList.style.display = 'block';
        filesContainer.innerHTML = '';
        
        Array.from(files).forEach((file, index) => {
            const fileItem = document.createElement('div');
            fileItem.className = 'file-item d-flex justify-content-between align-items-center';
            fileItem.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="fas fa-file-${getFileIcon(file.type)} fa-2x text-success me-3"></i>
                    <div>
                        <h6 class="mb-0">${file.name}</h6>
                        <small class="text-muted">${formatFileSize(file.size)}</small>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeFile(${index})">
                    <i class="fas fa-trash"></i>
                </button>
            `;
            filesContainer.appendChild(fileItem);
        });
    }
}

function getFileIcon(fileType) {
    if (fileType.includes('pdf')) return 'pdf';
    if (fileType.includes('word')) return 'word';
    return 'alt';
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function removeFile(index) {
    const fileInput = document.getElementById('fileInput');
    const dt = new DataTransfer();
    const files = Array.from(fileInput.files);
    
    files.splice(index, 1);
    files.forEach(file => dt.items.add(file));
    fileInput.files = dt.files;
    
    handleFiles(fileInput.files);
}

async function handleUpload(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const progressBar = document.querySelector('#uploadProgress .progress-bar');
    const uploadProgress = document.getElementById('uploadProgress');
    
    uploadProgress.style.display = 'block';
    
    try {
        const response = await fetch('{{ route("documents.upload") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        if (response.ok) {
            const result = await response.json();
            showAlert('Documents uploadés avec succès!', 'success');
            
            // Reset form
            document.getElementById('uploadForm').reset();
            document.getElementById('filesList').style.display = 'none';
            uploadProgress.style.display = 'none';
            
            // Refresh documents list
            loadDocuments();
        } else {
            throw new Error('Erreur lors de l\'upload');
        }
    } catch (error) {
        showAlert('Erreur lors de l\'upload: ' + error.message, 'error');
        uploadProgress.style.display = 'none';
    }
}

// CV Creation functionality
let experienceCount = 1;

function selectTemplate(template) {
    document.querySelectorAll('.cv-template').forEach(t => t.classList.remove('selected'));
    document.querySelector(`[data-template="${template}"]`).classList.add('selected');
    document.getElementById('selectedTemplate').value = template;
}

function addExperience() {
    const container = document.getElementById('experienceContainer');
    const newExperience = document.createElement('div');
    newExperience.className = 'experience-item border rounded p-3 mb-3';
    newExperience.innerHTML = `
        <div class="row">
            <div class="col-md-6">
                <input type="text" class="form-control mb-2" name="experiences[${experienceCount}][title]" placeholder="Titre du poste">
                <input type="text" class="form-control mb-2" name="experiences[${experienceCount}][company]" placeholder="Entreprise">
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control mb-2" name="experiences[${experienceCount}][period]" placeholder="Période (ex: 2020-2023)">
                <textarea class="form-control" name="experiences[${experienceCount}][description]" rows="2" placeholder="Description des missions"></textarea>
            </div>
        </div>
        <button type="button" class="btn btn-outline-danger btn-sm mt-2" onclick="removeExperience(this)">
            <i class="fas fa-trash me-1"></i>Supprimer
        </button>
    `;
    container.appendChild(newExperience);
    experienceCount++;
}

function removeExperience(button) {
    button.closest('.experience-item').remove();
}

// CV Form submission
document.getElementById('cvForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    if (!document.getElementById('selectedTemplate').value) {
        showAlert('Veuillez sélectionner un modèle de CV', 'warning');
        return;
    }
    
    const formData = new FormData(this);
    
    try {
        const response = await fetch('{{ route("cv.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        if (response.ok) {
            const result = await response.json();
            showAlert('CV créé avec succès!', 'success');
            
            // Reset form
            this.reset();
            document.querySelectorAll('.cv-template').forEach(t => t.classList.remove('selected'));
            document.getElementById('selectedTemplate').value = '';
            
            // Refresh documents list
            loadDocuments();
        } else {
            throw new Error('Erreur lors de la création du CV');
        }
    } catch (error) {
        showAlert('Erreur: ' + error.message, 'error');
    }
});

// Letter functionality
function loadLetterTemplate() {
    const template = document.getElementById('letterTemplate').value;
    const content = document.getElementById('letterContent');
    
    const templates = {
        formal: `
            <p>Madame, Monsieur,</p>
            <br>
            <p>Suite à votre annonce parue sur [SOURCE], j'ai l'honneur de vous présenter ma candidature pour le poste de [POSTE].</p>
            <br>
            <p>Diplômé(e) de [FORMATION] et fort(e) de [X] années d'expérience dans [DOMAINE], je souhaite mettre mes compétences au service de votre entreprise.</p>
            <br>
            <p>Mon parcours professionnel m'a permis de développer des compétences en [COMPÉTENCES] qui correspondent parfaitement aux exigences du poste.</p>
            <br>
            <p>Je serais ravi(e) de vous rencontrer pour vous exposer plus en détail mes motivations.</p>
            <br>
            <p>Dans l'attente de votre retour, je vous prie d'agréer, Madame, Monsieur, l'expression de mes salutations distinguées.</p>
        `,
        modern: `
            <p>Bonjour,</p>
            <br>
            <p>Passionné(e) par [DOMAINE], je candidate avec enthousiasme pour rejoindre votre équipe en tant que [POSTE].</p>
            <br>
            <p>Votre entreprise, reconnue pour [POINTS FORTS ENTREPRISE], correspond parfaitement à mes aspirations professionnelles.</p>
            <br>
            <p>Mon expérience de [X] ans dans [DOMAINE] m'a permis de maîtriser [COMPÉTENCES CLÉS] et de développer une approche [QUALITÉ PERSONNELLE].</p>
            <br>
            <p>Je serais ravi(e) d'échanger avec vous sur cette opportunité et de contribuer au succès de vos projets.</p>
            <br>
            <p>Cordialement,</p>
        `,
        startup: `
            <p>Hello!</p>
            <br>
            <p>Votre startup fait partie de ces entreprises qui changent la donne dans [SECTEUR]. C'est pourquoi je souhaite rejoindre votre aventure en tant que [POSTE]!</p>
            <br>
            <p>Avec [X] années d'expérience et une passion pour l'innovation, je suis convaincu(e) de pouvoir apporter ma pierre à l'édifice.</p>
            <br>
            <p>Mes compétences en [COMPÉTENCES] et mon esprit entrepreneurial sont des atouts que je souhaite mettre au service de votre croissance.</p>
            <br>
            <p>Prêt(e) à relever de nouveaux défis, j'aimerais beaucoup discuter de cette opportunité avec vous!</p>
            <br>
            <p>À bientôt,</p>
        `
    };
    
    if (templates[template]) {
        content.innerHTML = templates[template];
    }
}

function formatText(command) {
    document.execCommand(command, false, null);
    document.getElementById('letterContent').focus();
}

function insertTemplate(type) {
    const content = document.getElementById('letterContent');
    const selection = window.getSelection();
    
    const templates = {
        greeting: "Madame, Monsieur,",
        closing: "Dans l'attente de votre retour, je vous prie d'agréer, Madame, Monsieur, l'expression de mes salutations distinguées."
    };
    
    if (templates[type]) {
        const range = selection.getRangeAt(0);
        const textNode = document.createTextNode(templates[type]);
        range.insertNode(textNode);
        range.setStartAfter(textNode);
        selection.removeAllRanges();
        selection.addRange(range);
    }
}

// Letter form submission
document.getElementById('letterForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // Get content from contenteditable div
    const content = document.getElementById('letterContent').innerHTML;
    document.getElementById('hiddenContent').value = content;
    
    const formData = new FormData(this);
    
    try {
        const response = await fetch('{{ route("letters.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        if (response.ok) {
            const result = await response.json();
            showAlert('Lettre de motivation sauvegardée avec succès!', 'success');
            
            // Reset form
            this.reset();
            document.getElementById('letterContent').innerHTML = '';
            
            // Refresh documents list
            loadDocuments();
        } else {
            throw new Error('Erreur lors de la sauvegarde de la lettre');
        }
    } catch (error) {
        showAlert('Erreur: ' + error.message, 'error');
    }
});

// Documents management
async function loadDocuments() {
    try {
        const response = await fetch('{{ route("documents.index") }}', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        if (response.ok) {
            const data = await response.json();
            displayDocuments(data);
        } else {
            throw new Error('Erreur lors du chargement des documents');
        }
    } catch (error) {
        showAlert('Erreur: ' + error.message, 'error');
    }
}

function displayDocuments(data) {
    const cvList = document.getElementById('cvList');
    const letterList = document.getElementById('letterList');
    
    // Display CVs
    if (data.cvs && data.cvs.length > 0) {
        cvList.innerHTML = data.cvs.map(cv => `
            <div class="file-item">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-file-alt fa-2x text-success me-3"></i>
                        <div>
                            <h6 class="mb-0">${cv.name || 'CV sans nom'}</h6>
                            <small class="text-muted">Créé le ${new Date(cv.created_at).toLocaleDateString()}</small>
                            <br>
                            <span class="status-badge ${cv.status === 'completed' ? 'status-completed' : 'status-draft'}">
                                ${cv.status === 'completed' ? 'Terminé' : 'Brouillon'}
                            </span>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-outline-success btn-sm" onclick="previewDocument(${cv.id}, 'cv')">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-outline-primary btn-sm" onclick="editDocument(${cv.id}, 'cv')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-outline-danger btn-sm" onclick="deleteDocument(${cv.id}, 'cv')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    } else {
        cvList.innerHTML = '<p class="text-muted text-center py-4">Aucun CV trouvé</p>';
    }
    
    // Display Letters
    if (data.letters && data.letters.length > 0) {
        letterList.innerHTML = data.letters.map(letter => `
            <div class="file-item">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-envelope fa-2x text-success me-3"></i>
                        <div>
                            <h6 class="mb-0">${letter.title || 'Lettre sans titre'}</h6>
                            <small class="text-muted">
                                ${letter.company ? `Pour ${letter.company}` : ''} - 
                                Créée le ${new Date(letter.created_at).toLocaleDateString()}
                            </small>
                            <br>
                            <span class="status-badge ${letter.status === 'completed' ? 'status-completed' : 'status-draft'}">
                                ${letter.status === 'completed' ? 'Terminée' : 'Brouillon'}
                            </span>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-outline-success btn-sm" onclick="previewDocument(${letter.id}, 'letter')">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-outline-primary btn-sm" onclick="editDocument(${letter.id}, 'letter')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-outline-danger btn-sm" onclick="deleteDocument(${letter.id}, 'letter')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    } else {
        letterList.innerHTML = '<p class="text-muted text-center py-4">Aucune lettre trouvée</p>';
    }
}

async function previewDocument(id, type) {
    try {
        const response = await fetch(`{{ url('/documents') }}/${id}/preview?type=${type}`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        if (response.ok) {
            const html = await response.text();
            document.getElementById('previewContent').innerHTML = html;
            new bootstrap.Modal(document.getElementById('previewModal')).show();
        } else {
            throw new Error('Erreur lors de la prévisualisation');
        }
    } catch (error) {
        showAlert('Erreur: ' + error.message, 'error');
    }
}

async function editDocument(id, type) {
    try {
        const response = await fetch(`{{ url('/documents') }}/${id}/edit?type=${type}`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        if (response.ok) {
            const data = await response.json();
            populateEditForm(data, type);
            document.getElementById('editDocumentId').value = id;
            new bootstrap.Modal(document.getElementById('editModal')).show();
        } else {
            throw new Error('Erreur lors du chargement du document');
        }
    } catch (error) {
        showAlert('Erreur: ' + error.message, 'error');
    }
}

function populateEditForm(data, type) {
    const formContent = document.getElementById('editFormContent');
    
    if (type === 'cv') {
        formContent.innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Prénom</label>
                        <input type="text" class="form-control" name="first_name" value="${data.first_name || ''}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" class="form-control" name="last_name" value="${data.last_name || ''}">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="${data.email || ''}">
            </div>
            <div class="mb-3">
                <label class="form-label">Téléphone</label>
                <input type="tel" class="form-control" name="phone" value="${data.phone || ''}">
            </div>
            <div class="mb-3">
                <label class="form-label">Titre/Poste</label>
                <input type="text" class="form-control" name="job_title" value="${data.job_title || ''}">
            </div>
            <div class="mb-3">
                <label class="form-label">Profil professionnel</label>
                <textarea class="form-control" name="profile" rows="4">${data.profile || ''}</textarea>
            </div>
        `;
    } else {
        formContent.innerHTML = `
            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" class="form-control" name="title" value="${data.title || ''}">
            </div>
            <div class="mb-3">
                <label class="form-label">Entreprise</label>
                <input type="text" class="form-control" name="company" value="${data.company || ''}">
            </div>
            <div class="mb-3">
                <label class="form-label">Poste visé</label>
                <input type="text" class="form-control" name="position" value="${data.position || ''}">
            </div>
            <div class="mb-3">
                <label class="form-label">Contenu</label>
                <div contenteditable="true" class="form-control" style="min-height: 200px;" id="editLetterContent">
                    ${data.content || ''}
                </div>
                <textarea name="content" id="editHiddenContent" style="display: none;">${data.content || ''}</textarea>
            </div>
        `;
    }
}

async function saveDocument() {
    const documentId = document.getElementById('editDocumentId').value;
    const formData = new FormData(document.getElementById('editForm'));
    
    // If editing a letter, get content from contenteditable div
    const editLetterContent = document.getElementById('editLetterContent');
    if (editLetterContent) {
        document.getElementById('editHiddenContent').value = editLetterContent.innerHTML;
        formData.set('content', editLetterContent.innerHTML);
    }
    
    try {
        const response = await fetch(`{{ url('/documents') }}/${documentId}/update`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        if (response.ok) {
            showAlert('Document mis à jour avec succès!', 'success');
            bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
            loadDocuments();
        } else {
            throw new Error('Erreur lors de la mise à jour');
        }
    } catch (error) {
        showAlert('Erreur: ' + error.message, 'error');
    }
}

async function deleteDocument(id, type) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce document?')) {
        try {
            const response = await fetch(`{{ url('/documents') }}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            if (response.ok) {
                showAlert('Document supprimé avec succès!', 'success');
                loadDocuments();
            } else {
                throw new Error('Erreur lors de la suppression');
            }
        } catch (error) {
            showAlert('Erreur: ' + error.message, 'error');
        }
    }
}

function downloadDocument() {
    // Implementation for document download
    const documentId = document.getElementById('editDocumentId').value;
    window.open(`{{ url('/documents') }}/${documentId}/download`, '_blank');
}

// Utility functions
function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show position-fixed`;
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; max-width: 400px;';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.parentNode.removeChild(alertDiv);
        }
    }, 5000);
}

// Initialize tooltips and popovers if using Bootstrap
document.addEventListener('DOMContentLoaded', function() {
    if (typeof bootstrap !== 'undefined') {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});
</script>

</html>