<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créateur de CV</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, rgb(105, 173, 141) 0%, rgb(36, 118, 65) 100%);
        min-height: 100vh;
        padding: 20px;
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
  background-color:rgb(31, 161, 92);
}
.sidebar-menu { margin-top: 30px; }


    .container {
        max-width: 900px;
        margin: 0 auto;
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .header {
        background: linear-gradient(45deg, rgb(36, 118, 65), rgb(109, 173, 149));
        color: white;
        text-align: center;
        padding: 30px;
    }

    .header h1 {
        font-size: 2.5rem;
        margin-bottom: 10px;
        font-weight: 300;
    }

    .header p {
        opacity: 0.9;
        font-size: 1.1rem;
    }

    .form-container {
        padding: 40px;
    }

    .form-section {
        margin-bottom: 40px;
        padding: 30px;
        background: #f0fdf4;
        border-radius: 15px;
        border-left: 5px solid #27ae60;
    }

    .form-section h2 {
        color: #1e3d2f;
        margin-bottom: 20px;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-section h2::before {
        content: "📋";
        font-size: 1.2rem;
    }

    .form-section:nth-child(2) h2::before { content: "👤"; }
    .form-section:nth-child(3) h2::before { content: "🎓"; }
    .form-section:nth-child(4) h2::before { content: "💼"; }
    .form-section:nth-child(5) h2::before { content: "🛠️"; }
    .form-section:nth-child(6) h2::before { content: "🌐"; }
    .form-section:nth-child(7) h2::before { content: "⚽"; }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-row.full-width {
        grid-template-columns: 1fr;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    label {
        color: #34495e;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    input, textarea, select {
        padding: 12px 15px;
        border: 2px solid #e1e8ed;
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    input:focus, textarea:focus, select:focus {
        outline: none;
        border-color: rgb(19, 59, 48);
        box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.2);
        transform: translateY(-2px);
    }

    textarea {
        resize: vertical;
        min-height: 100px;
    }

    .dynamic-section {
        border: 2px dashed #a3c9a8;
        border-radius: 10px;
        padding: 20px;
        margin-top: 15px;
    }

    .dynamic-item {
        background: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        position: relative;
    }

    .remove-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #e74c3c;
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        cursor: pointer;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .remove-btn:hover {
        background: #c0392b;
        transform: scale(1.1);
    }

    .add-btn {
        background: linear-gradient(45deg, #27ae60, #2ecc71);
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 25px;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-top: 15px;
    }

    .add-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(39, 174, 96, 0.3);
    }

    .submit-btn {
        background: linear-gradient(45deg, rgb(36, 118, 65), rgb(24, 64, 27));
        color: white;
        border: none;
        padding: 15px 40px;
        border-radius: 50px;
        font-size: 1.2rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        margin-top: 30px;
    }

    .submit-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(39, 174, 96, 0.4);
    }

    .alert {
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        border-left: 5px solid;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border-left-color: #28a745;
    }

    .alert-error {
        background: #f8d7da;
        color: #721c24;
        border-left-color: #dc3545;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .header h1 {
            font-size: 2rem;
        }

        .form-container {
            padding: 20px;
        }
    }
</style>

</head>
<body>
   
<div class="sidebar-menu">
  <button class="menu-item" onclick="window.location.href='/CVLettre'">
    <span>🔙 Back</span>
  </button>
</div>


    <div class="container">
        <div class="header">
            <p><h2>Mon CV</h2></p>
        </div>
         

        <div class="form-container">
            <form action="/cv" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <!-- Informations personnelles -->
                <div class="form-section">
                    <h2> Informations personnelles</h2>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name">Prénom *</label>
                            <input type="text" id="first_name" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Nom *</label>
                            <input type="text" id="last_name" name="last_name" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Téléphone</label>
                            <input type="tel" id="phone" name="phone">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="adresse">Adresse</label>
                            <input type="text" id="adresse" name="adresse">
                        </div>
                        <div class="form-group">
                            <label for="ville">Ville</label>
                            <input type="text" id="ville" name="ville">
                        </div>
                    </div>

                    <div class="form-row full-width">
                        <div class="form-group">
                            <label for="profile">Profil professionnel</label>
                            <textarea id="profile" name="profile" placeholder="Décrivez brièvement votre profil professionnel..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Formation -->
                <div class="form-section">
                    <h2>Formation</h2>
                    <div id="formations-container">
                        <div class="dynamic-item">
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Diplôme/Formation</label>
                                    <input type="text" name="formations[0][diplome]">
                                </div>
                                <div class="form-group">
                                    <label>Établissement</label>
                                    <input type="text" name="formations[0][etablissement]">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Année de début</label>
                                    <input type="number" name="formations[0][annee_debut]" min="1950" max="2025">
                                </div>
                                <div class="form-group">
                                    <label>Année de fin</label>
                                    <input type="number" name="formations[0][annee_fin]" min="1950" max="2025">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="add-btn" onclick="addFormation()">+ Ajouter une formation</button>
                </div>

                <!-- Expérience professionnelle -->
                <div class="form-section">
                    <h2>Expérience professionnelle</h2>
                    <div id="experiences-container">
                        <div class="dynamic-item">
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Poste</label>
                                    <input type="text" name="experiences[0][poste]">
                                </div>
                                <div class="form-group">
                                    <label>Entreprise</label>
                                    <input type="text" name="experiences[0][entreprise]">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Date de début</label>
                                    <input type="month" name="experiences[0][date_debut]">
                                </div>
                                <div class="form-group">
                                    <label>Date de fin</label>
                                    <input type="month" name="experiences[0][date_fin]">
                                </div>
                            </div>
                            <div class="form-row full-width">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="experiences[0][description]" placeholder="Décrivez vos missions et réalisations..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="add-btn" onclick="addExperience()">+ Ajouter une expérience</button>
                </div>

                <!-- Compétences -->
                <div class="form-section">
                    <h2>Compétences</h2>
                    <div id="competences-container">
                        <div class="dynamic-item">
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Compétence</label>
                                    <input type="text" name="competences[0][nom]">
                                </div>
                                <div class="form-group">
                                    <label>Niveau</label>
                                    <select name="competences[0][niveau]">
                                        <option value="Débutant">Débutant</option>
                                        <option value="Intermédiaire">Intermédiaire</option>
                                        <option value="Avancé">Avancé</option>
                                        <option value="Expert">Expert</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="add-btn" onclick="addCompetence()">+ Ajouter une compétence</button>
                </div>

                <!-- Langues -->
                <div class="form-section">
                    <h2>Langues</h2>
                    <div id="langues-container">
                        <div class="dynamic-item">
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Langue</label>
                                    <input type="text" name="langues[0][nom]">
                                </div>
                                <div class="form-group">
                                    <label>Niveau</label>
                                    <select name="langues[0][niveau]">
                                        <option value="Débutant">Débutant</option>
                                        <option value="Intermédiaire">Intermédiaire</option>
                                        <option value="Avancé">Avancé</option>
                                        <option value="Bilingue">Bilingue</option>
                                        <option value="Langue maternelle">Langue maternelle</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="add-btn" onclick="addLangue()">+ Ajouter une langue</button>
                </div>

                <!-- Loisirs -->
                <div class="form-section">
                    <h2>Loisirs et centres d'intérêt</h2>
                    <div id="loisirs-container">
                        <div class="dynamic-item">
                            <div class="form-row full-width">
                                <div class="form-group">
                                    <label>Loisir/Activité</label>
                                    <input type="text" name="loisirs[0][activite]">
                                </div>
                            </div>
                            <div class="form-row full-width">
                                <div class="form-group">
                                    <label>Description (facultatif)</label>
                                    <textarea name="loisirs[0][description]" placeholder="Décrivez brièvement cette activité si pertinent..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="add-btn" onclick="addLoisir()">+ Ajouter un loisir</button>
                </div>

                <button type="button" class="submit-btn" onclick="generatePDF()">Télécharger le CV</button>
            </form>
        </div>
    </div>

    <script>
        let formationCount = 1;
        let experienceCount = 1;
        let competenceCount = 1;
        let langueCount = 1;
        let loisirCount = 1;

        function addFormation() {
            const container = document.getElementById('formations-container');
            const newFormation = document.createElement('div');
            newFormation.className = 'dynamic-item';
            
            newFormation.innerHTML = `
                <button type="button" class="remove-btn" onclick="removeElement(this)">×</button>
                <div class="form-row">
                    <div class="form-group">
                        <label>Diplôme/Formation</label>
                        <input type="text" name="formations[${formationCount}][diplome]">
                    </div>
                    <div class="form-group">
                        <label>Établissement</label>
                        <input type="text" name="formations[${formationCount}][etablissement]">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Année de début</label>
                        <input type="number" name="formations[${formationCount}][annee_debut]" min="1950" max="2025">
                    </div>
                    <div class="form-group">
                        <label>Année de fin</label>
                        <input type="number" name="formations[${formationCount}][annee_fin]" min="1950" max="2025">
                    </div>
                </div>
            `;
            
            container.appendChild(newFormation);
            formationCount++;
        }

        function addExperience() {
            const container = document.getElementById('experiences-container');
            const newExperience = document.createElement('div');
            newExperience.className = 'dynamic-item';
            
            newExperience.innerHTML = `
                <button type="button" class="remove-btn" onclick="removeElement(this)">×</button>
                <div class="form-row">
                    <div class="form-group">
                        <label>Poste</label>
                        <input type="text" name="experiences[${experienceCount}][poste]">
                    </div>
                    <div class="form-group">
                        <label>Entreprise</label>
                        <input type="text" name="experiences[${experienceCount}][entreprise]">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Date de début</label>
                        <input type="month" name="experiences[${experienceCount}][date_debut]">
                    </div>
                    <div class="form-group">
                        <label>Date de fin</label>
                        <input type="month" name="experiences[${experienceCount}][date_fin]">
                    </div>
                </div>
                <div class="form-row full-width">
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="experiences[${experienceCount}][description]" placeholder="Décrivez vos missions et réalisations..."></textarea>
                    </div>
                </div>
            `;
            
            container.appendChild(newExperience);
            experienceCount++;
        }

        function addCompetence() {
            const container = document.getElementById('competences-container');
            const newCompetence = document.createElement('div');
            newCompetence.className = 'dynamic-item';
            
            newCompetence.innerHTML = `
                <button type="button" class="remove-btn" onclick="removeElement(this)">×</button>
                <div class="form-row">
                    <div class="form-group">
                        <label>Compétence</label>
                        <input type="text" name="competences[${competenceCount}][nom]">
                    </div>
                    <div class="form-group">
                        <label>Niveau</label>
                        <select name="competences[${competenceCount}][niveau]">
                            <option value="Débutant">Débutant</option>
                            <option value="Intermédiaire">Intermédiaire</option>
                            <option value="Avancé">Avancé</option>
                            <option value="Expert">Expert</option>
                        </select>
                    </div>
                </div>
            `;
            
            container.appendChild(newCompetence);
            competenceCount++;
        }

        function addLangue() {
            const container = document.getElementById('langues-container');
            const newLangue = document.createElement('div');
            newLangue.className = 'dynamic-item';
            
            newLangue.innerHTML = `
                <button type="button" class="remove-btn" onclick="removeElement(this)">×</button>
                <div class="form-row">
                    <div class="form-group">
                        <label>Langue</label>
                        <input type="text" name="langues[${langueCount}][nom]">
                    </div>
                    <div class="form-group">
                        <label>Niveau</label>
                        <select name="langues[${langueCount}][niveau]">
                            <option value="Débutant">Débutant</option>
                            <option value="Intermédiaire">Intermédiaire</option>
                            <option value="Avancé">Avancé</option>
                            <option value="Bilingue">Bilingue</option>
                            <option value="Langue maternelle">Langue maternelle</option>
                        </select>
                    </div>
                </div>
            `;
            
            container.appendChild(newLangue);
            langueCount++;
        }

        function addLoisir() {
            const container = document.getElementById('loisirs-container');
            const newLoisir = document.createElement('div');
            newLoisir.className = 'dynamic-item';
            
            newLoisir.innerHTML = `
                <button type="button" class="remove-btn" onclick="removeElement(this)">×</button>
                <div class="form-row full-width">
                    <div class="form-group">
                        <label>Loisir/Activité</label>
                        <input type="text" name="loisirs[${loisirCount}][activite]">
                    </div>
                </div>
                <div class="form-row full-width">
                    <div class="form-group">
                        <label>Description (facultatif)</label>
                        <textarea name="loisirs[${loisirCount}][description]" placeholder="Décrivez brièvement cette activité si pertinent..."></textarea>
                    </div>
                </div>
            `;
            
            container.appendChild(newLoisir);
            loisirCount++;
        }

        function removeElement(button) {
            button.parentElement.remove();
        }

        // Animation d'entrée
        window.addEventListener('load', function() {
            const sections = document.querySelectorAll('.form-section');
            sections.forEach((section, index) => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(30px)';
                setTimeout(() => {
                    section.style.transition = 'all 0.6s ease';
                    section.style.opacity = '1';
                    section.style.transform = 'translateY(0)';
                }, index * 200);
            });
        });
    </script>
    <script>
  const { jsPDF } = window.jspdf;

  function generatePDF() {
    const doc = new jsPDF();

    // Récupérer les valeurs du formulaire
    const firstName = document.getElementById('first_name').value;
    const lastName = document.getElementById('last_name').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    const adresse = document.getElementById('adresse').value;
    const ville = document.getElementById('ville').value;
    const profile = document.getElementById('profile').value;

    // Titre
    doc.setFontSize(22);
    doc.text(`${firstName} ${lastName}`, 20, 20);

    doc.setFontSize(14);
    doc.text(`Email: ${email}`, 20, 30);
    doc.text(`Téléphone: ${phone}`, 20, 37);
    doc.text(`Adresse: ${adresse}, ${ville}`, 20, 44);

    doc.setFontSize(16);
    doc.text("Profil professionnel :", 20, 60);
    doc.setFontSize(12);

    // Découper le texte du profil en lignes si trop long (max 80 caractères par ligne)
    const splitProfile = doc.splitTextToSize(profile, 170);
    doc.text(splitProfile, 20, 70);

    let y = 70 + splitProfile.length * 7 + 10;

    // Formation
    doc.setFontSize(16);
    doc.text("Formation :", 20, y);
    doc.setFontSize(12);
    y += 10;

    const formations = document.querySelectorAll('#formations-container .dynamic-item');
    formations.forEach((formation, index) => {
      const diplome = formation.querySelector('input[name^="formations"][name$="[diplome]"]').value;
      const etablissement = formation.querySelector('input[name^="formations"][name$="[etablissement]"]').value;
      const anneeDebut = formation.querySelector('input[name^="formations"][name$="[annee_debut]"]').value;
      const anneeFin = formation.querySelector('input[name^="formations"][name$="[annee_fin]"]').value;

      const formationText = `${diplome} - ${etablissement} (${anneeDebut} - ${anneeFin})`;
      doc.text(formationText, 25, y);
      y += 7;
    });

    y += 10;

    // Expériences
    doc.setFontSize(16);
    doc.text("Expérience professionnelle :", 20, y);
    doc.setFontSize(12);
    y += 10;

    const experiences = document.querySelectorAll('#experiences-container .dynamic-item');
    experiences.forEach((exp, index) => {
      const poste = exp.querySelector('input[name^="experiences"][name$="[poste]"]').value;
      const entreprise = exp.querySelector('input[name^="experiences"][name$="[entreprise]"]').value;
      const dateDebut = exp.querySelector('input[name^="experiences"][name$="[date_debut]"]').value;
      const dateFin = exp.querySelector('input[name^="experiences"][name$="[date_fin]"]').value;
      const description = exp.querySelector('textarea[name^="experiences"][name$="[description]"]').value;

      doc.text(`${poste} - ${entreprise} (${dateDebut} - ${dateFin})`, 25, y);
      y += 7;

      const splitDesc = doc.splitTextToSize(description, 160);
      doc.text(splitDesc, 30, y);
      y += splitDesc.length * 7 + 5;
    });

    y += 10;

    // Compétences
    doc.setFontSize(16);
    doc.text("Compétences :", 20, y);
    doc.setFontSize(12);
    y += 10;

    const competences = document.querySelectorAll('#competences-container .dynamic-item');
    competences.forEach((comp, index) => {
      const nom = comp.querySelector('input[name^="competences"][name$="[nom]"]').value;
      const niveau = comp.querySelector('select[name^="competences"][name$="[niveau]"]').value;
      doc.text(`${nom} - Niveau : ${niveau}`, 25, y);
      y += 7;
    });

    y += 10;

    // Langues
    doc.setFontSize(16);
    doc.text("Langues :", 20, y);
    doc.setFontSize(12);
    y += 10;

    const langues = document.querySelectorAll('#langues-container .dynamic-item');
    langues.forEach((langue, index) => {
      const nom = langue.querySelector('input[name^="langues"][name$="[nom]"]').value;
      const niveau = langue.querySelector('select[name^="langues"][name$="[niveau]"]').value;
      doc.text(`${nom} - Niveau : ${niveau}`, 25, y);
      y += 7;
    });

    y += 10;

    // Loisirs
    doc.setFontSize(16);
    doc.text("Loisirs et centres d'intérêt :", 20, y);
    doc.setFontSize(12);
    y += 10;

    const loisirs = document.querySelectorAll('#loisirs-container .dynamic-item');
    loisirs.forEach((loisir, index) => {
      const activite = loisir.querySelector('input[name^="loisirs"][name$="[activite]"]').value;
      const description = loisir.querySelector('textarea[name^="loisirs"][name$="[description]"]').value;
      
      doc.text(`• ${activite}`, 25, y);
      y += 7;
      
      if (description) {
        const splitDesc = doc.splitTextToSize(description, 160);
        doc.text(splitDesc, 30, y);
        y += splitDesc.length * 7 + 5;
      }
    });

    // Téléchargement du PDF
    doc.save(`${firstName}_${lastName}_CV.pdf`);
  }
</script>

</body>
</html>