<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Service;
use App\Models\TeamMember;

class CompanySeeder extends Seeder
{
    public function run()
    {
        // Créer la société
        Company::create([
            'name' => 'Blade',
            'description' => 'Innovation, Excellence et Performance dans le développement web',
            'mission' => 'Transformer les idées en solutions digitales innovantes et performantes qui propulsent votre business vers le succès.',
            'vision' => 'Être le partenaire technologique de référence pour les entreprises qui veulent innover et se démarquer dans l\'économie numérique.',
            'founded_year' => 2020,
            'employees_count' => 25,
            'projects_completed' => 150,
            'clients_count' => 80,
            'phone' => '+212 5 37 XX XX XX',
            'email' => 'contact@blade.ma',
            'address' => 'Quartier Agdal, Rabat, Maroc',
            'website' => 'https://blade.ma'
        ]);

        // Créer les services
        $services = [
            [
                'title' => 'Développement Web',
                'short_description' => 'Applications web modernes et performantes avec les dernières technologies.',
                'description' => 'Nous créons des applications web sur mesure en utilisant Laravel, React, Vue.js et les technologies les plus récentes. Nos solutions sont optimisées pour la performance, la sécurité et l\'expérience utilisateur.',
                'icon' => 'fas fa-code',
                'order' => 1
            ],
            [
                'title' => 'Applications Mobile',
                'short_description' => 'Applications natives et hybrides pour iOS et Android.',
                'description' => 'Développement d\'applications mobiles natives avec React Native et Flutter. Nous créons des expériences utilisateur exceptionnelles sur tous les appareils.',
                'icon' => 'fas fa-mobile-alt',
                'order' => 2
            ],
            [
                'title' => 'E-commerce',
                'short_description' => 'Boutiques en ligne complètes et optimisées pour la conversion.',
                'description' => 'Solutions e-commerce complètes avec gestion des stocks, paiements sécurisés, analytics et optimisation pour les moteurs de recherche.',
                'icon' => 'fas fa-shopping-cart',
                'order' => 3
            ],
            [
                'title' => 'Cloud & DevOps',
                'short_description' => 'Infrastructure cloud et déploiement automatisé.',
                'description' => 'Migration vers le cloud, automatisation des déploiements, monitoring et optimisation des performances pour une infrastructure robuste.',
                'icon' => 'fas fa-cloud',
                'order' => 4
            ],
            [
                'title' => 'Consulting Digital',
                'short_description' => 'Stratégie digitale et transformation numérique.',
                'description' => 'Accompagnement dans votre transformation digitale avec audit technique, stratégie digitale et conseils pour optimiser vos processus.',
                'icon' => 'fas fa-lightbulb',
                'order' => 5
            ],
            [
                'title' => 'Maintenance & Support',
                'short_description' => 'Support technique et maintenance continue.',
                'description' => 'Services de maintenance, mises à jour de sécurité, monitoring 24/7 et support technique pour assurer la continuité de vos services.',
                'icon' => 'fas fa-tools',
                'order' => 6
            ]
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        // Créer les membres de l'équipe
        $teamMembers = [
            [
                'name' => 'Ahmed Benali',
                'position' => 'CEO & Fondateur',
                'bio' => 'Expert en transformation digitale avec plus de 10 ans d\'expérience dans le développement de solutions innovantes.',
                'linkedin' => 'https://linkedin.com/in/ahmed-benali',
                'order' => 1
            ],
            [
                'name' => 'Fatima Zahra',
                'position' => 'CTO & Lead Developer',
                'bio' => 'Architecte logiciel passionnée par les nouvelles technologies et l\'innovation technique.',
                'linkedin' => 'https://linkedin.com/in/fatima-zahra',
                'order' => 2
            ],
            [
                'name' => 'Youssef Mansouri',
                'position' => 'Lead Designer',
                'bio' => 'Designer UX/UI créatif, spécialisé dans la création d\'expériences utilisateur exceptionnelles.',
                'linkedin' => 'https://linkedin.com/in/youssef-mansouri',
                'order' => 3
            ],
            [
                'name' => 'Aicha Benali',
                'position' => 'Project Manager',
                'bio' => 'Gestionnaire de projets expérimentée, garantit la livraison dans les délais et la satisfaction client.',
                'linkedin' => 'https://linkedin.com/in/aicha-benali',
                'order' => 4
            ]
        ];

        foreach ($teamMembers as $member) {
            TeamMember::create($member);
        }
    }}