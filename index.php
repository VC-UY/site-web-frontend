<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VCUY1 - Système de Calcul Distribué Volontaire</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script src="assets/js/animations.js"></script>
    <script src="assets/js/realtime.js"></script>
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
        .card-gradient {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .stats-gradient {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .animate-pulse-slow {
            animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <i data-lucide="cpu" class="h-8 w-8 text-primary mr-2"></i>
                        <span class="text-xl font-bold text-gray-900">VCUY1</span>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#accueil" class="text-gray-700 hover:text-primary transition-colors">Accueil</a>
                    <a href="dashboard.php" class="text-gray-700 hover:text-primary transition-colors">Tableau de bord</a>
                    <a href="volunteers.php" class="text-gray-700 hover:text-primary transition-colors">Volontaires</a>
                    <a href="analytics.php" class="text-gray-700 hover:text-primary transition-colors">Analyses</a>
                    <a href="downloads.php" class="text-gray-700 hover:text-primary transition-colors">Telechargements</a>
                    <a href="badges.php" class="text-gray-700 hover:text-primary transition-colors">Badges</a>
                    <a href="about.php" class="text-gray-700 hover:text-primary transition-colors">À propos</a>
                    
                </div>
                <div class="md:hidden flex items-center">
                    <button class="mobile-menu-button">
                        <i data-lucide="menu" class="h-6 w-6"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="accueil" class="gradient-bg pt-20 pb-16 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <canvas id="particle-canvas" class="absolute inset-0 pointer-events-none"></canvas>
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 animate-fade-in">
                    Calcul Distribué
                    <span class="text-yellow-300 gradient-shift">Volontaire</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-200 mb-8 max-w-3xl mx-auto animate-slide-up">
                    Exploitez la puissance collective des volontaires pour vos calculs intensifs. 
                    Économisez jusqu'à <span class="text-yellow-300 font-bold pulse-glow">90%</span> des coûts traditionnels.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center animate-scale-in">
                    <a href="dashboard.php" class="bg-white text-primary px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors shadow-lg ripple-btn">
                        Voir le Tableau de Bord
                    </a>
                    <a href="#fonctionnalites" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-primary transition-colors ripple-btn">
                        En Savoir Plus
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center animate-on-scroll hover-card">
                    <div class="stats-gradient rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 floating">
                        <i data-lucide="users" class="h-8 w-8 text-white"></i>
                    </div>
                    <div class="text-3xl font-bold text-gray-900 mb-2" id="volunteers-count" data-counter="127">127</div>
                    <div class="text-gray-600">Volontaires Actifs</div>
                </div>
                <div class="text-center animate-on-scroll hover-card">
                    <div class="stats-gradient rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 floating">
                        <i data-lucide="zap" class="h-8 w-8 text-white"></i>
                    </div>
                    <div class="text-3xl font-bold text-gray-900 mb-2" id="tasks-count" data-counter="3387">3,387</div>
                    <div class="text-gray-600">Tâches Traitées</div>
                </div>
                <div class="text-center animate-on-scroll hover-card">
                    <div class="stats-gradient rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 floating">
                        <i data-lucide="dollar-sign" class="h-8 w-8 text-white"></i>
                    </div>
                    <div class="text-3xl font-bold text-gray-900 mb-2" id="savings-count">€33,134</div>
                    <div class="text-gray-600">Économies Réalisées</div>
                </div>
                <div class="text-center animate-on-scroll hover-card">
                    <div class="stats-gradient rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 floating">
                        <i data-lucide="activity" class="h-8 w-8 text-white"></i>
                    </div>
                    <div class="text-3xl font-bold text-gray-900 mb-2" id="performance-count">67%</div>
                    <div class="text-gray-600">Utilisation CPU</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fonctionnalites" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Pourquoi Choisir VCUY1 ?
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Notre système révolutionnaire transforme la façon dont vous abordez le calcul intensif
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow">
                    <div class="card-gradient rounded-full w-16 h-16 flex items-center justify-center mb-6">
                        <i data-lucide="trending-down" class="h-8 w-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Réduction des Coûts</h3>
                    <p class="text-gray-600">
                        Économisez jusqu'à 90% par rapport aux solutions cloud traditionnelles grâce à notre réseau de volontaires.
                    </p>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow">
                    <div class="card-gradient rounded-full w-16 h-16 flex items-center justify-center mb-6">
                        <i data-lucide="shield-check" class="h-8 w-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Sécurité Avancée</h3>
                    <p class="text-gray-600">
                        Conteneurisation Docker et isolation complète garantissent la sécurité de vos calculs.
                    </p>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow">
                    <div class="card-gradient rounded-full w-16 h-16 flex items-center justify-center mb-6">
                        <i data-lucide="gauge" class="h-8 w-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Performance Optimale</h3>
                    <p class="text-gray-600">
                        Surveillance en temps réel et optimisation automatique pour des performances maximales.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Architecture Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Architecture du Système
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Une architecture moderne et robuste développée à l'Université de Yaoundé I
                </p>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="bg-primary rounded-full w-12 h-12 flex items-center justify-center mr-4">
                                <i data-lucide="server" class="h-6 w-6 text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Serveur Central (Manager)</h3>
                                <p class="text-gray-600">
                                    Architecture pub/sub avec Redis et base de données MongoDB pour une gestion efficace des workflows et des résultats.
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-secondary rounded-full w-12 h-12 flex items-center justify-center mr-4">
                                <i data-lucide="laptop" class="h-6 w-6 text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Application Client</h3>
                                <p class="text-gray-600">
                                    Interface Python permettant aux clients de soumettre facilement leurs calculs au système.
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-accent rounded-full w-12 h-12 flex items-center justify-center mr-4">
                                <i data-lucide="users" class="h-6 w-6 text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Applications Volontaires</h3>
                                <p class="text-gray-600">
                                    Conteneurisation Docker pour l'exécution sécurisée des tâches sur les machines des participants.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="relative">
                    <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl p-8">
                        <div class="text-center">
                            <div class="animate-float">
                                <i data-lucide="network" class="h-32 w-32 text-primary mx-auto mb-4"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Réseau Distribué</h3>
                            <p class="text-gray-600">
                                Connexion automatique et gestion intelligente des ressources de calcul
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="gradient-bg py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                Prêt à Révolutionner Vos Calculs ?
            </h2>
            <p class="text-xl text-gray-200 mb-8 max-w-2xl mx-auto">
                Rejoignez notre réseau de calcul distribué et découvrez une nouvelle façon d'optimiser vos ressources.
            </p>
            <a href="dashboard.php" class="bg-white text-primary px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors shadow-lg inline-block">
                Commencer Maintenant
            </a>
        </div>
    </section>

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
                        <li><a href="#accueil" class="text-gray-400 hover:text-white transition-colors">Accueil</a></li>
                        <li><a href="dashboard.php" class="text-gray-400 hover:text-white transition-colors">Tableau de bord</a></li>
                        <li><a href="volunteers.php" class="text-gray-400 hover:text-white transition-colors">Volontaires</a></li>
                        <li><a href="analytics.php" class="text-gray-400 hover:text-white transition-colors">Analyses</a></li>
                        <li><a href="downloads.php" class="text-gray-400 hover:text-white transition-colors">Téléchargements</a></li>
                        <li><a href="badges.php" class="text-gray-400 hover:text-white transition-colors">Badges</a></li>
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
        
        // Load real-time stats
        async function loadStats() {
            try {
                const response = await fetch('http://localhost:5000/api/system-metrics');
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('volunteers-count').textContent = data.data.total_volunteers;
                    document.getElementById('tasks-count').textContent = data.data.total_tasks.toLocaleString();
                    document.getElementById('savings-count').textContent = '€' + Math.round(data.data.cost_savings).toLocaleString();
                    document.getElementById('performance-count').textContent = Math.round(data.data.cpu_usage) + '%';
                }
            } catch (error) {
                console.error('Erreur lors du chargement des statistiques:', error);
            }
        }
        
        // Load stats on page load
        loadStats();
        
        // Refresh stats every 30 seconds
        setInterval(loadStats, 30000);
        
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
        
        // Mobile menu toggle
        const mobileMenuButton = document.querySelector('.mobile-menu-button');
        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', function() {
                // Add mobile menu functionality here
                console.log('Mobile menu clicked');
            });
        }
    </script>


</body>
</html>

