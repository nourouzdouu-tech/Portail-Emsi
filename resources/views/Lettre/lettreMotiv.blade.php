<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Générateur de Lettre de Motivation</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background-color: #f9fafb;
    }

    .menu-item {
  display: flex;
  align-items: center;
  padding: 12px 20px;
  margin-bottom: 5px;
  cursor: pointer;
  transition: all 0.3s;
  background-color: #f0f0f0;
  border: none;
  border-radius: 8px;
  font-size: 16px;
  text-decoration: none;
  color: #333;
}

.menu-item:hover {
  background-color: #e0e0e0;
}


    .sidebar-menu { margin-top: 30px; }

    @media print {
      .no-print {
        display: none !important;
      }
      .print-page {
        page-break-after: always;
      }
      body {
        font-size: 12pt;
        line-height: 1.5;
      }
    }

    .preview-letter {
      font-family: 'Times New Roman', serif;
      line-height: 1.6;
    }
  </style>
</head>
<body 
class="bg-gray-50 min-h-screen">

     <div class="sidebar-menu">
  <button class="menu-item" onclick="window.location.href='/CVLettre'">
    <span>🔙 Back</span>
  </button>
</div>

  <div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">
      Lettre de Motivation
    </h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <!-- Formulaire -->
      <div class="bg-white rounded-lg shadow-lg p-6 no-print">
        <h2 class="text-2xl font-semibold text-gray-700 mb-6">Vos informations</h2>
        <form id="lettreForm" class="space-y-6">
          <!-- Informations personnelles -->
          <div class="border-b pb-6">
            <h3 class="text-lg font-medium text-gray-600 mb-4">Informations personnelles</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Prénom</label>
                <input type="text" id="prenom" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"/>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                <input type="text" id="nom" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"/>
              </div>
            </div>
            <div class="mt-4">
              <label class="block text-sm font-medium text-gray-700 mb-2">Adresse</label>
              <input type="text" id="adresse" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"/>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                <input type="tel" id="telephone" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"/>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" id="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"/>
              </div>
            </div>
          </div>

          <!-- Informations entreprise -->
          <div class="border-b pb-6">
            <h3 class="text-lg font-medium text-gray-600 mb-4">Informations de l'entreprise</h3>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Nom de l'entreprise</label>
              <input type="text" id="entreprise" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"/>
            </div>
            <div class="mt-4">
              <label class="block text-sm font-medium text-gray-700 mb-2">Adresse de l'entreprise</label>
              <input type="text" id="adresseEntreprise" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"/>
            </div>
            <div class="mt-4">
              <label class="block text-sm font-medium text-gray-700 mb-2">Poste visé</label>
              <input type="text" id="poste" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"/>
            </div>
          </div>

          <!-- Contenu -->
          <div>
            <h3 class="text-lg font-medium text-gray-600 mb-4">Contenu de la lettre</h3>
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700 mb-2">Objet</label>
              <input type="text" id="objet" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"/>
            </div>
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700 mb-2">Paragraphe d'introduction</label>
              <textarea id="introduction" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700 mb-2">Vos compétences et expériences</label>
              <textarea id="competences" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700 mb-2">Motivation et valeurs</label>
              <textarea id="motivation" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Conclusion</label>
              <textarea id="conclusion" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
          </div>

          <div class="flex gap-4 pt-6">
            <button type="button" onclick="genererModele()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition duration-200">
              Générer un modèle
            </button>
            <button type="button" onclick="viderFormulaire()" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md transition duration-200">
              Vider
            </button>
            <button type="button" onclick="imprimerLettre()" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md transition duration-200">
              Imprimer
            </button>
          </div>
        </form>
      </div>

      <!-- Prévisualisation -->
      <div class="bg-white rounded-lg shadow-lg">
        <div class="p-6 preview-letter" id="previewLettre">
          <div class="text-right text-sm mb-8" id="previewExpediteur">
            <div><span id="prevPrenom"></span> <span id="prevNom"></span></div>
            <div id="prevAdresse"></div>
            <div id="prevTelephone"></div>
            <div id="prevEmail"></div>
          </div>

          <div class="text-sm mb-8" id="previewDestinataire">
            <div id="prevEntreprise" class="font-medium"></div>
            <div id="prevAdresseEntreprise"></div>
          </div>

          <div class="text-right mb-8 text-sm" id="dateLettre"></div>

          <div class="mb-6 font-medium">Objet : <span id="prevObjet"></span></div>

          <div class="mb-6">Madame, Monsieur,</div>

          <div class="space-y-4 text-justify">
            <p id="prevIntroduction"></p>
            <p id="prevCompetences"></p>
            <p id="prevMotivation"></p>
            <p id="prevConclusion"></p>
          </div>

          <div class="mt-8 text-right">
            <div>Cordialement,</div>
            <div class="mt-4" id="prevSignature"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- JavaScript -->
  <script>
    function mettreAJourPreview() {
      document.getElementById('prevPrenom').textContent = document.getElementById('prenom').value;
      document.getElementById('prevNom').textContent = document.getElementById('nom').value;
      document.getElementById('prevAdresse').textContent = document.getElementById('adresse').value;
      document.getElementById('prevTelephone').textContent = document.getElementById('telephone').value;
      document.getElementById('prevEmail').textContent = document.getElementById('email').value;
      document.getElementById('prevEntreprise').textContent = document.getElementById('entreprise').value;
      document.getElementById('prevAdresseEntreprise').textContent = document.getElementById('adresseEntreprise').value;
      document.getElementById('prevObjet').textContent = document.getElementById('objet').value;
      document.getElementById('prevIntroduction').textContent = document.getElementById('introduction').value;
      document.getElementById('prevCompetences').textContent = document.getElementById('competences').value;
      document.getElementById('prevMotivation').textContent = document.getElementById('motivation').value;
      document.getElementById('prevConclusion').textContent = document.getElementById('conclusion').value;
      document.getElementById('prevSignature').textContent = document.getElementById('prenom').value + ' ' + document.getElementById('nom').value;

      const today = new Date();
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      document.getElementById('dateLettre').textContent = today.toLocaleDateString('fr-FR', options);
    }

    document.querySelectorAll('input, textarea').forEach(el => {
      el.addEventListener('input', mettreAJourPreview);
    });

    function genererModele() {
      document.getElementById('prenom').value = 'Jean';
      document.getElementById('nom').value = 'Dupont';
      document.getElementById('adresse').value = '123 Rue de la Paix, 75001 Paris';
      document.getElementById('telephone').value = '06 12 34 56 78';
      document.getElementById('email').value = 'jean.dupont@email.com';
      document.getElementById('entreprise').value = 'Entreprise Innovante SA';
      document.getElementById('adresseEntreprise').value = '456 Avenue des Affaires, 69000 Lyon';
      document.getElementById('poste').value = 'Développeur Full Stack';
      document.getElementById('objet').value = 'Candidature pour le poste de Développeur Full Stack';

      document.getElementById('introduction').value = 'Actuellement à la recherche de nouveaux défis professionnels, je me permets de vous adresser ma candidature pour le poste de ' + document.getElementById('poste').value + ' au sein de votre entreprise. Votre réputation d\'excellence et votre approche innovante dans le secteur m\'incitent à rejoindre vos équipes.';
      document.getElementById('competences').value = 'Fort de mes 3 années d\'expérience en développement web, je maîtrise parfaitement les technologies front-end (React, Vue.js, HTML/CSS) et back-end (Node.js, PHP, Python). J\'ai notamment participé à la création de plusieurs applications web complexes, gérant des bases de données importantes et optimisant les performances.';
      document.getElementById('motivation').value = 'Ce qui m\'attire particulièrement chez vous, c\'est votre engagement envers l\'innovation technologique et votre culture d\'entreprise collaborative.';
      document.getElementById('conclusion').value = 'Je serais ravi de pouvoir échanger avec vous lors d\'un entretien. Je reste à votre disposition pour tout complément d\'information et vous remercie par avance.';

      mettreAJourPreview();
    }

    function viderFormulaire() {
      if (confirm('Êtes-vous sûr de vouloir vider tous les champs ?')) {
        document.getElementById('lettreForm').reset();
        mettreAJourPreview();
      }
    }

    function imprimerLettre() {
      window.print();
    }

    mettreAJourPreview();
  </script>
</body>
</html>
