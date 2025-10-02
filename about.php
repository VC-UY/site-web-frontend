<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À propos - VCUY1</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb',
                        secondary: '#f97316',
                        accent: '#06b6d4'
                    }
                }
            }
        }
    </script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <i data-lucide="cpu" class="h-8 w-8 text-primary mr-2"></i>
                        <span class="text-xl font-bold text-gray-900">VCUY1</span>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="index.php" class="text-gray-700 hover:text-primary transition-colors">Accueil</a>
                    <a href="dashboard.php" class="text-gray-700 hover:text-primary transition-colors">Tableau de bord</a>
                    <a href="volunteers.php" class="text-gray-700 hover:text-primary transition-colors">Volontaires</a>
                    <a href="analytics.php" class="text-gray-700 hover:text-primary transition-colors">Analyses</a>
                    <a href="about.php" class="text-primary font-semibold">À propos</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-bg py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-6">
                À Propos de VCUY1
            </h1>
            <p class="text-xl text-gray-200 max-w-3xl mx-auto">
                Un système révolutionnaire de calcul distribué volontaire développé à l'Université de Yaoundé I, 
                conçu pour démocratiser l'accès aux ressources de calcul haute performance.
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <!-- Mission Section -->
        <section class="mb-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Notre Mission</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Rendre le calcul haute performance accessible à tous en exploitant la puissance collective des volontaires
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="globe" class="h-8 w-8 text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Accessibilité</h3>
                    <p class="text-gray-600">
                        Démocratiser l'accès aux ressources de calcul pour les chercheurs, étudiants et entreprises du monde entier.
                    </p>
                </div>
                
                <div class="text-center">
                    <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="leaf" class="h-8 w-8 text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Durabilité</h3>
                    <p class="text-gray-600">
                        Optimiser l'utilisation des ressources existantes pour réduire l'empreinte carbone du calcul intensif.
                    </p>
                </div>
                
                <div class="text-center">
                    <div class="bg-purple-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="users" class="h-8 w-8 text-purple-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Collaboration</h3>
                    <p class="text-gray-600">
                        Créer une communauté mondiale de contributeurs unis par la passion de la science et de la technologie.
                    </p>
                </div>
            </div>
        </section>

        <!-- Technology Section -->
        <section class="mb-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Architecture Technique</h2>
                    <p class="text-gray-600 mb-6">
                        VCUY1 est entièrement développé en Python pour garantir une intégration fluide et une maintenance aisée. 
                        Notre architecture moderne s'appuie sur des technologies éprouvées pour offrir performance et fiabilité.
                    </p>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="bg-blue-500 rounded-full w-8 h-8 flex items-center justify-center mr-4 mt-1">
                                <i data-lucide="server" class="h-4 w-4 text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Serveur Central</h4>
                                <p class="text-gray-600 text-sm">
                                    Architecture pub/sub avec Redis et MongoDB pour la gestion des workflows et des résultats
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-green-500 rounded-full w-8 h-8 flex items-center justify-center mr-4 mt-1">
                                <i data-lucide="laptop" class="h-4 w-4 text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Application Client</h4>
                                <p class="text-gray-600 text-sm">
                                    Interface Python intuitive pour la soumission et le suivi des calculs
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-purple-500 rounded-full w-8 h-8 flex items-center justify-center mr-4 mt-1">
                                <i data-lucide="box" class="h-4 w-4 text-white"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Conteneurisation Docker</h4>
                                <p class="text-gray-600 text-sm">
                                    Isolation complète et sécurité maximale pour l'exécution des tâches
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="relative">
                    <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl p-8">
                        <div class="text-center">
                            <div class="animate-float">
                                <i data-lucide="cpu" class="h-32 w-32 text-primary mx-auto mb-4"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Python + Docker</h3>
                            <p class="text-gray-600">
                                Une combinaison puissante pour la flexibilité et la sécurité
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- University Section -->
        <section class="mb-16 bg-white rounded-2xl shadow-lg p-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Université de Yaoundé I</h2>
                    <p class="text-gray-600 mb-6">
                        VCUY1 est né de la recherche académique menée à l'Université de Yaoundé I, l'une des institutions 
                        d'enseignement supérieur les plus prestigieuses d'Afrique centrale. Ce projet illustre l'engagement 
                        de l'université dans l'innovation technologique et la recherche de pointe.
                    </p>
                    
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600">1962</div>
                            <div class="text-sm text-gray-600">Fondée en</div>
                        </div>
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <div class="text-2xl font-bold text-green-600">60,000+</div>
                            <div class="text-sm text-gray-600">Étudiants</div>
                        </div>
                    </div>
                    
                    <p class="text-gray-600">
                        L'université continue de jouer un rôle clé dans le développement technologique de la région, 
                        formant la prochaine génération d'ingénieurs et de chercheurs africains.
                    </p>
                </div>
                
                <div class="text-center">
                    <div class="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl p-8">
                        <i data-lucide="graduation-cap" class="h-24 w-24 text-orange-500 mx-auto mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Excellence Académique</h3>
                        <p class="text-gray-600">
                            Un centre d'excellence pour la recherche et l'innovation en Afrique
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Benefits Section -->
        <section class="mb-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Avantages du Système</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    VCUY1 offre des avantages significatifs par rapport aux solutions traditionnelles
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-lg shadow-lg p-6 text-center hover:shadow-xl transition-shadow">
                    <div class="bg-red-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="trending-down" class="h-8 w-8 text-red-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Réduction des Coûts</h3>
                    <p class="text-3xl font-bold text-red-600 mb-2">90%</p>
                    <p class="text-gray-600 text-sm">d'économies par rapport aux solutions cloud traditionnelles</p>
                </div>
                
                <div class="bg-white rounded-lg shadow-lg p-6 text-center hover:shadow-xl transition-shadow">
                    <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="shield-check" class="h-8 w-8 text-blue-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Sécurité</h3>
                    <p class="text-3xl font-bold text-blue-600 mb-2">100%</p>
                    <p class="text-gray-600 text-sm">isolation grâce à la conteneurisation Docker</p>
                </div>
                
                <div class="bg-white rounded-lg shadow-lg p-6 text-center hover:shadow-xl transition-shadow">
                    <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="zap" class="h-8 w-8 text-green-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Performance</h3>
                    <p class="text-3xl font-bold text-green-600 mb-2">24/7</p>
                    <p class="text-gray-600 text-sm">surveillance et optimisation en temps réel</p>
                </div>
                
                <div class="bg-white rounded-lg shadow-lg p-6 text-center hover:shadow-xl transition-shadow">
                    <div class="bg-purple-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="globe" class="h-8 w-8 text-purple-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Accessibilité</h3>
                    <p class="text-3xl font-bold text-purple-600 mb-2">Global</p>
                    <p class="text-gray-600 text-sm">réseau de volontaires dans le monde entier</p>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section class="mb-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Équipe de Développement</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Une équipe passionnée de chercheurs et d'ingénieurs dédiés à l'innovation
                </p>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="w-24 h-24 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="user" class="h-12 w-12 text-white"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Équipe de Recherche</h3>
                        <p class="text-gray-600 text-sm">
                            Chercheurs spécialisés en calcul distribué et systèmes parallèles
                        </p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-24 h-24 bg-gradient-to-r from-green-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="code" class="h-12 w-12 text-white"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Développeurs</h3>
                        <p class="text-gray-600 text-sm">
                            Ingénieurs logiciels experts en Python, Docker et architectures distribuées
                        </p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-24 h-24 bg-gradient-to-r from-purple-500 to-pink-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i data-lucide="users" class="h-12 w-12 text-white"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Communauté</h3>
                        <p class="text-gray-600 text-sm">
                            Réseau mondial de volontaires et contributeurs passionnés
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-8 text-white text-center">
            <h2 class="text-3xl font-bold mb-4">Rejoignez-nous</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Que vous soyez chercheur, développeur ou simplement passionné de technologie, 
                il y a une place pour vous dans la communauté VCUY1.
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white bg-opacity-20 rounded-lg p-6">
                    <i data-lucide="mail" class="h-8 w-8 mx-auto mb-3"></i>
                    <h3 class="font-semibold mb-2">Contact</h3>
                    <p class="text-sm">contact@vcuy1.org</p>
                </div>
                
                <div class="bg-white bg-opacity-20 rounded-lg p-6">
                    <i data-lucide="map-pin" class="h-8 w-8 mx-auto mb-3"></i>
                    <h3 class="font-semibold mb-2">Localisation</h3>
                    <p class="text-sm">Université de Yaoundé I<br>Cameroun</p>
                </div>
                
                <div class="bg-white bg-opacity-20 rounded-lg p-6">
                    <i data-lucide="github" class="h-8 w-8 mx-auto mb-3"></i>
                    <h3 class="font-semibold mb-2">Open Source</h3>
                    <p class="text-sm">Contribuez sur GitHub</p>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="dashboard.php" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    Découvrir le Système
                </a>
                <a href="#" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                    Devenir Volontaire
                </a>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center mb-4">
                        <i data-lucide="cpu" class="h-8 w-8 text-primary mr-2"></i>
                        <span class="text-xl font-bold">VCUY1</span>
                    </div>
                    <p class="text-gray-400">
                        Système de calcul distribué volontaire développé à l'Université de Yaoundé I.
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Navigation</h3>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="text-gray-400 hover:text-white transition-colors">Accueil</a></li>
                        <li><a href="dashboard.php" class="text-gray-400 hover:text-white transition-colors">Tableau de bord</a></li>
                        <li><a href="volunteers.php" class="text-gray-400 hover:text-white transition-colors">Volontaires</a></li>
                        <li><a href="analytics.php" class="text-gray-400 hover:text-white transition-colors">Analyses</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Ressources</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Documentation</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">API</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Support</a></li>
                        <li><a href="about.php" class="text-gray-400 hover:text-white transition-colors">À propos</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <p class="text-gray-400 mb-2">Université de Yaoundé I</p>
                    <p class="text-gray-400 mb-2">Cameroun</p>
                    <p class="text-gray-400">contact@vcuy1.org</p>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <p class="text-gray-400">© 2025 VCUY1. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>

