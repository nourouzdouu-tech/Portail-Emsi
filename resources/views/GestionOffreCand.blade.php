<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Gestion des Offres</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
       /* --- Reset and base --- */
* {
    box-sizing: border-box;
}

body, html {
    margin: 0;
    padding: 0;
    height: 100%;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f9fafb;
    color: #111827;
}

/* Pagination centered */
.pagination {
    justify-content: center;
    margin-top: 1rem;
}

/* Responsive table */
.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    border-radius: 6px;
    box-shadow: 0 0 8px rgb(0 0 0 / 0.1);
    background-color: white;
}

table {
    width: 100%;
    border-collapse: collapse;
    min-width: 700px; /* force horizontal scroll on small screens */
}

th, td {
    padding: 12px 15px;
    text-align: left;
    border: 1px solid #ddd;
    white-space: nowrap;
}

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


 .quick-action { background-color: #059669; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: 500; margin-left: 10px; cursor: pointer; border: none; }
        .quick-action:hover { background-color: #047857; }
         
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
           <div class="menu-item active">
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

    <!-- Main Content -->
    <main class="main-content">
        <div class="page-header">
            <h1 class="page-title">Postuler aux offres</h1>
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
    

    <main class="container mt-4" role="main">
        <form method="GET" action="{{ route('gestionCand.offres') }}" class="mb-3" role="search" aria-label="Recherche d'offres">
            <div class="input-group">
                <input
                    type="search"
                    name="search"
                    class="form-control"
                    placeholder="Rechercher..."
                    value="{{ request('search') }}"
                    aria-label="Rechercher une offre"
                >
                <button type="submit" class="btn btn-primary">Rechercher</button>
            </div>
        </form>

        <div class="table-responsive mb-4">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Entreprise</th>
                        <th>Type Contrat</th>
                        <th>Lieu</th>
                        <th>Secteur</th>
                        <th>Expérience</th>
                        <th>Salaire min / max</th>
                        <th>Date Publication</th>
                    </tr>
                </thead>
                <tbody>
@forelse($offres as $offre)
    <tr>
        <td>{{ $offre->titre }}</td>
        <td>{{ $offre->entreprise }}</td>
        <td>{{ $offre->type_contrat }}</td>
        <td>{{ $offre->lieu }}</td>
        <td>{{ $offre->secteur }}</td>
        <td>{{ $offre->experience_requise }} ans</td>
        <td>{{ number_format($offre->salaire_min, 0, ',', ' ') }} - {{ number_format($offre->salaire_max, 0, ',', ' ') }} MAD</td>
        <td>{{ \Carbon\Carbon::parse($offre->date_publication)->format('d/m/Y') }}</td>
        @if(Auth::check() && Auth::user()->type === 'candidat')
            <td>
              <button class="apply-btn" data-offre-id="{{ $offre->id }}">Postuler</button>
            </td>
        @endif
    </tr>
@empty
    <tr><td colspan="9" class="text-center">Aucune offre trouvée.</td></tr>
@endforelse
</tbody>
            </table>
        </div>

        {{ $offres->withQueryString()->links() }}

        <!-- Liste dynamique des offres chargées par JS -->
        <div id="jobsList" aria-live="polite" aria-atomic="true"></div>
    </main>
    
<!-- Modal for New Job Offer -->
<div class="modal" id="jobOfferModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-content">
        <span class="close-modal" id="closeModal" aria-label="Fermer la fenêtre">&times;</span>
        <h2 id="modalTitle" style="margin-bottom: 20px;">Créer une nouvelle offre d'emploi</h2>
        
        <form id="jobOfferForm" method="POST" novalidate>
            @csrf
            <div class="form-group">
                <label for="titre">Intitulé du poste *</label>
                <input type="text" id="titre" name="titre" required placeholder="Ex: Développeur Full Stack" class="form-control">
            </div>
            
            <div class="form-group">
                <label for="entreprise">Entreprise *</label>
                <input type="text" id="entreprise" name="entreprise" required placeholder="Nom de l'entreprise" class="form-control">
            </div>

            <div class="form-group">
                <label for="description">Description *</label>
                <textarea id="description" name="description" rows="3" required class="form-control"></textarea>
            </div>
            
            <div class="form-group">
                <label for="type_contrat">Type de contrat *</label>
                <select id="type_contrat" name="type_contrat" required class="form-select">
                    <option value="">-- Sélectionnez --</option>
                    <option value="CDI">CDI</option>
                    <option value="CDD">CDD</option>
                    <option value="Stage">Stage</option>
                    <option value="Freelance">Freelance</option>
                </select>
            </div>

            <div class="form-group">
                <label for="lieu">Lieu *</label>
                <input type="text" id="lieu" name="lieu" required class="form-control">
            </div>

            <div class="form-group">
                <label for="region">Région *</label>
                <input type="text" id="region" name="region" required class="form-control">
            </div>

            <div class="form-group">
                <label for="secteur">Secteur d'activité *</label>
                <input type="text" id="secteur" name="secteur" required class="form-control">
            </div>

            <div class="form-group">
                <label for="competences">Compétences (séparées par des virgules) *</label>
                <input type="text" id="competences" name="competences" required class="form-control" placeholder="Ex: PHP, Laravel, JavaScript">
            </div>

            <div class="form-group half-width">
                <label for="salaire_min">Salaire minimum</label>
                <input type="number" id="salaire_min" name="salaire_min" min="0" class="form-control">
            </div>

            <div class="form-group half-width">
                <label for="salaire_max">Salaire maximum</label>
                <input type="number" id="salaire_max" name="salaire_max" min="0" class="form-control">
            </div>

            <div class="form-group">
                <label for="experience_requise">Expérience requise (en années) *</label>
                <input type="number" id="experience_requise" name="experience_requise" min="0" required class="form-control">
            </div>

            <div class="form-group">
                <label for="url_candidature">URL de candidature (facultatif)</label>
                <input type="url" id="url_candidature" name="url_candidature" placeholder="https://..." class="form-control">
            </div>

            <button type="submit" class="btn btn-success mt-3">Publier l'offre</button>
        </form>
    </div>
</div>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Modal HTML + JS -->
<div class="modal" id="applyModal" role="dialog" aria-modal="true" aria-hidden="true" tabindex="-1">
    <div class="modal-content">
        <span class="close-modal" id="closeApplyModal" aria-label="Fermer">&times;</span>
        <h2 id="modalTitle">Postuler à cette offre</h2>
<form id="applyForm" action="{{ route('candidature.storeCandidat') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="offre_id" id="applyOffreId">
            <div class="form-group">
                <label for="cv">CV (PDF)</label>
                <input type="file" name="cv" id="cv" accept=".pdf" required class="form-control">
            </div>
            <div class="form-group">
                <label for="lettre">Lettre de motivation (PDF)</label>
                <input type="file" name="lettre_motivation" id="lettre_motivation" accept=".pdf" required class="form-control">
            </div>
            <button type="submit" class="btn btn-primary mt-3">Envoyer ma candidature</button>
        </form>
    </div>
</div>

<script>
document.querySelectorAll('.apply-btn').forEach(button => {
    button.addEventListener('click', () => {
        const offreId = button.getAttribute('data-offre-id');
        document.getElementById('applyOffreId').value = offreId;
        const modal = document.getElementById('applyModal');
        modal.classList.add('show');
        modal.setAttribute('aria-hidden', 'false');
    });
});

const closeBtn = document.getElementById('closeApplyModal');
if (closeBtn) {
    closeBtn.addEventListener('click', () => {
        const modal = document.getElementById('applyModal');
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');
    });
}


document.addEventListener('keydown', e => {
    const modal = document.getElementById('applyModal');
    if (e.key === 'Escape' && modal.classList.contains('show')) {
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');
    }
});

    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('jobOfferModal');
        const closeModalBtn = document.getElementById('closeModal');
        const form = document.getElementById('jobOfferForm');
        const jobsList = document.getElementById('jobsList');
        const offerCount = document.getElementById('offerCount');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

       

        // Fermer modal
        closeModalBtn.addEventListener('click', () => {
            modal.classList.remove('show');
            modal.setAttribute('aria-hidden', 'true');
        });

        // Fermer modal avec ESC
        document.addEventListener('keydown', e => {
            if (e.key === "Escape" && modal.classList.contains('show')) {
                modal.classList.remove('show');
                modal.setAttribute('aria-hidden', 'true');
            }
        });

        // Afficher message alert temporaire
        function showAlert(message, type = 'success') {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type === 'error' ? 'danger' : type}`;
            alertDiv.textContent = message;
            document.body.appendChild(alertDiv);
            setTimeout(() => alertDiv.remove(), 3000);
        }

        // Ajouter une offre dans la liste dynamique
        function addJobToList(offre) {
            const div = document.createElement('div');
            div.className = 'job-item';
            div.innerHTML = `
                <div class="job-title">${offre.titre} - ${offre.entreprise}</div>
                <div class="job-details">
                    <small>Type: ${offre.type_contrat} | Lieu: ${offre.lieu} | Secteur: ${offre.secteur} | Expérience: ${offre.experience_requise} ans</small>
                </div>
            `;
            jobsList.prepend(div);
        }

        /* Mettre à jour compteur offres (GET /offres-emploi?recruteur=1)
        async function updateOfferCount() {
            try {
                const response = await fetch('/offres-emploi?recruteur=1');
                if (!response.ok) throw new Error('Erreur réseau');
                const offres = await response.json();
                offerCount.textContent = offres.length;
                // Optionnel : mettre à jour la liste dynamique
                jobsList.innerHTML = '';
                offres.forEach(addJobToList);
            } catch (error) {
                console.error('Erreur récupération offres:', error);
            }
        }

        updateOfferCount();*/

        // Gestion soumission formulaire
        form.addEventListener('submit', async e => {
            e.preventDefault();

            const formData = new FormData(form);
            const data = {
                titre: formData.get('titre'),
                entreprise: formData.get('entreprise'),
                description: formData.get('description'),
                type_contrat: formData.get('type_contrat'),
                lieu: formData.get('lieu'),
                region: formData.get('region'),
                secteur: formData.get('secteur'),
                competences: formData.get('competences').split(',').map(s => s.trim()).filter(Boolean),
                salaire_min: formData.get('salaire_min') || null,
                salaire_max: formData.get('salaire_max') || null,
                experience_requise: formData.get('experience_requise'),
                url_candidature: formData.get('url_candidature') || null,
            };

            try {
                const response = await fetch('/offres-emploi', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify(data),
                });

                if (response.status === 422) {
                    // Validation Laravel
                    const errorData = await response.json();
                    let errors = '';
                    for (const field in errorData.errors) {
                        errors += errorData.errors[field].join(' ') + ' ';
                    }
                    showAlert(errors, 'error');
                    return;
                }

                if (!response.ok) throw new Error('Erreur serveur');

                const offreCreee = await response.json();

                addJobToList(offreCreee);
                updateOfferCount();
                showAlert('Offre créée avec succès !');
                modal.classList.remove('show');
                modal.setAttribute('aria-hidden', 'true');

            } catch (error) {
                console.error('Erreur création offre:', error);
                showAlert('Erreur lors de la création de l\'offre.', 'error');
            }
        });
    });
    

</script>

</body>
</html>
