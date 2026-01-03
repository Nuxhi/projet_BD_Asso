<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Projet BD - Gestion d'Association</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-50 min-h-screen font-sans">
    <?php require("partial/navbar.php"); ?>
    
    <div class="max-w-6xl mx-auto px-6 py-16">
        
        <div class="text-center mb-16">
            <div class="inline-block px-4 py-2  bg-indigo-100 text-indigo-700 rounded-full text-sm font-semibold mb-4">
                Projet Universitaire - L3 Informatique
            </div>
            <h1 class="text-5xl font-extrabold text-slate-900 mb-4 leading-tight">
                Projet Bases de Données
            </h1>
            <h2 class="text-2xl text-slate-600 font-light">
                Gestion d'une Association Sportive et Culturelle (ASCG)
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 mb-8">
            <div class="flex items-start mb-6">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center mr-4 flex-shrink-0">
                    <i class="fa-solid fa-graduation-cap text-indigo-600 text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">À propos du projet</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Ce projet a été développé dans le cadre du module Bases de Données en L3 Informatique 
                        durant l'année universitaire 2025/2026. L'idée était de concevoir et réaliser un système 
                        de gestion complet pour une association, en partant de la modélisation jusqu'à l'interface web. 
                        On a appliqué ce qu'on a appris en cours sur les schémas relationnels, les requêtes SQL et 
                        le développement PHP.
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 mb-8">
            <div class="flex items-start mb-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center mr-4 flex-shrink-0">
                    <i class="fa-solid fa-users text-emerald-600 text-2xl"></i>
                </div>
                <div class="flex-grow">
                    <h3 class="text-xl font-bold text-slate-800 mb-4">Réalisé par</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-center p-4 bg-slate-50 rounded-xl">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                                <span class="text-indigo-600 font-bold text-sm">FM</span>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800">Morpelli Fabien</p>
                                <p class="text-xs text-slate-500">L3 SPI Informatique</p>
                            </div>
                        </div>
                        <div class="flex items-center p-4 bg-slate-50 rounded-xl">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                                <span class="text-indigo-600 font-bold text-sm">LY</span>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800">Lodi Ylan</p>
                                <p class="text-xs text-slate-500">L3 SPI Informatique</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 mb-8">
            <div class="flex items-start mb-6">
                <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center mr-4 flex-shrink-0">
                    <i class="fa-solid fa-rocket text-amber-600 text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Ce que vous pouvez faire ici</h3>
                    <p class="text-slate-600 leading-relaxed mb-4">
                        Cette application permet de gérer une association fictive (ASCG) avec ses sections, activités, 
                        adhérents et bénévoles. C'est une simulation pour montrer comment on peut structurer 
                        et manipuler des données dans une vraie application.
                    </p>
                </div>
            </div>

            <h4 class="text-lg font-bold text-slate-800 mb-4 ml-16">Fonctionnalités implémentées</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 ml-16">
                
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i class="fa-solid fa-list text-blue-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800">Sections de l'association</p>
                        <p class="text-sm text-slate-500">Liste des sections avec leurs bénévoles et référents</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i class="fa-solid fa-calendar-days text-purple-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800">Planning des activités</p>
                        <p class="text-sm text-slate-500">Filtrage par section, jour et creneaux horaires</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i class="fa-solid fa-eye text-emerald-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800">Inscriptions aux activités</p>
                        <p class="text-sm text-slate-500">Liste des inscrits avec gestion des places disponibles</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 rounded-lg bg-orange-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i class="fa-solid fa-pen-to-square text-orange-600"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800">Ajout de données</p>
                        <p class="text-sm text-slate-500">Formulaires pour créer sections et activités</p>
                    </div>
                </div>

            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="/activite-liste" 
               class="group bg-gradient-to-br from-indigo-500 to-indigo-600 text-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-8 hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-16 h-16 rounded-xl bg-white bg-opacity-20 flex items-center justify-center">
                        <i class="fa-solid fa-calendar-check text-3xl"></i>
                    </div>
                    <i class="fa-solid fa-arrow-right text-2xl group-hover:translate-x-2 transition-transform"></i>
                </div>
                <h3 class="text-2xl font-bold mb-2">Activités</h3>
                <p class="text-indigo-100">Voir le planning complet</p>
            </a>

            <a href="/section-liste" 
               class="group bg-gradient-to-br from-emerald-500 to-emerald-600 text-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-8 hover:-translate-y-1">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-16 h-16 rounded-xl bg-white bg-opacity-20 flex items-center justify-center">
                        <i class="fa-solid fa-sitemap text-3xl"></i>
                    </div>
                    <i class="fa-solid fa-arrow-right text-2xl group-hover:translate-x-2 transition-transform"></i>
                </div>
                <h3 class="text-2xl font-bold mb-2">Sections</h3>
                <p class="text-emerald-100">Explorer les sections</p>
            </a>
        </div>

        <div class="mt-12 text-center text-slate-500 text-sm">
            <p>
                <i class="fa-solid fa-code mr-1"></i>
                PHP/MySQL • Requêtes préparées • Architecture MVC • Tailwind CSS
            </p>
        </div>

    </div>

</body>
</html>