<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Badges - VCUY1</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script src="assets/js/badges.js"></script>
    <script src="assets/js/badges-page.js"></script>
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
        /* Styles copiés de index.php */
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        
        /* Styles spécifiques à badges.php (conservés) */
        .badge-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .badge-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .badge-icon {
            font-size: 3rem;
        }
        .loading-skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }
        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>
</head>
<body class="bg-gray-50">
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
                    <a href="index.php" class="text-gray-700 hover:text-primary transition-colors">Accueil</a>
                    <a href="dashboard.php" class="text-gray-700 hover:text-primary transition-colors">Tableau de bord</a>
                    <a href="volunteers.php" class="text-gray-700 hover:text-primary transition-colors">Volontaires</a>
                    <a href="analytics.php" class="text-gray-700 hover:text-primary transition-colors">Analyses</a>
                    <a href="downloads.php" class="text-gray-700 hover:text-primary transition-colors">Téléchargements</a>
                    <a href="badges.php" class="text-primary font-semibold border-b-2 border-primary transition-colors">Badges</a>
                    <a href="about.php" class="text-gray-700 hover:text-primary transition-colors">À propos</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="gradient-bg pt-32 pb-20 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="flex items-center justify-between text-white">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold mb-2">🏆 Badges et Récompenses</h1>
                    <p class="text-xl text-gray-200">Célébrons les meilleurs contributeurs du système VCUY1</p>
                </div>
                <div class="flex items-center space-x-4">
                    <button onclick="refreshBadges()" class="bg-white text-primary px-4 py-2 rounded-lg font-semibold hover:bg-gray-100 transition-colors flex items-center shadow-lg">
                        <i data-lucide="refresh-cw" class="h-4 w-4 mr-2"></i>
                        Actualiser
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="stats-gradient rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 animate-float">
                        <i data-lucide="users" class="h-8 w-8 text-white"></i>
                    </div>
                    <div class="text-3xl font-bold text-gray-900 mb-2" id="volunteers-count" data-counter="127">127</div>
                    <div class="text-gray-600">Volontaires Actifs</div>
                </div>
                <div class="text-center">
                    <div class="stats-gradient rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 animate-float">
                        <i data-lucide="zap" class="h-8 w-8 text-white"></i>
                    </div>
                    <div class="text-3xl font-bold text-gray-900 mb-2" id="tasks-count" data-counter="3387">3,387</div>
                    <div class="text-gray-600">Tâches Traitées</div>
                </div>
                <div class="text-center">
                    <div class="stats-gradient rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 animate-float">
                        <i data-lucide="dollar-sign" class="h-8 w-8 text-white"></i>
                    </div>
                    <div class="text-3xl font-bold text-gray-900 mb-2" id="savings-count">30000 F</div>
                    <div class="text-gray-600">Économies Réalisées</div>
                </div>
                <div class="text-center">
                    <div class="stats-gradient rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4 animate-float">
                        <i data-lucide="activity" class="h-8 w-8 text-white"></i>
                    </div>
                    <div class="text-3xl font-bold text-gray-900 mb-2" id="performance-count">67%</div>
                    <div class="text-gray-600">Utilisation CPU</div>
                </div>
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white rounded-lg shadow-md mb-8">
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button onclick="switchTab('winners')" id="tab-winners" class="tab-button active px-6 py-4 text-sm font-medium border-b-2 border-primary text-primary">
                        <i data-lucide="trophy" class="h-5 w-5 inline mr-2"></i>
                        Gagnants de la Période
                    </button>
                    <button onclick="switchTab('leaderboard')" id="tab-leaderboard" class="tab-button px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        <i data-lucide="bar-chart" class="h-5 w-5 inline mr-2"></i>
                        Classement
                    </button>
                    <button onclick="switchTab('all-badges')" id="tab-all-badges" class="tab-button px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        <i data-lucide="award" class="h-5 w-5 inline mr-2"></i>
                        Tous les Badges
                    </button>
                    <button onclick="switchTab('statistics')" id="tab-statistics" class="tab-button px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        <i data-lucide="pie-chart" class="h-5 w-5 inline mr-2"></i>
                        Statistiques
                    </button>
                </nav>
            </div>
        </div>

        <div id="content-winners" class="tab-content">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div id="volunteer-week-card" class="bg-white rounded-xl shadow-lg overflow-hidden badge-card">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-4 text-white text-center">
                        <div class="badge-icon mb-2">🌟</div>
                        <h3 class="text-xl font-bold">Volontaire de la Semaine</h3>
                    </div>
                    <div class="p-6">
                        <div class="loading-skeleton h-32 rounded"></div>
                    </div>
                </div>

                <div id="volunteer-month-card" class="bg-white rounded-xl shadow-lg overflow-hidden badge-card">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-4 text-white text-center">
                        <div class="badge-icon mb-2">⭐</div>
                        <h3 class="text-xl font-bold">Volontaire du Mois</h3>
                    </div>
                    <div class="p-6">
                        <div class="loading-skeleton h-32 rounded"></div>
                    </div>
                </div>

                <div id="volunteer-year-card" class="bg-white rounded-xl shadow-lg overflow-hidden badge-card">
                    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 p-4 text-white text-center">
                        <div class="badge-icon mb-2">🏆</div>
                        <h3 class="text-xl font-bold">Volontaire de l'Année</h3>
                    </div>
                    <div class="p-6">
                        <div class="loading-skeleton h-32 rounded"></div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                        <i data-lucide="zap" class="h-6 w-6 mr-2 text-yellow-500"></i>
                        Top Performers
                    </h2>
                    <select id="category-filter" onchange="loadTopPerformers()" class="border border-gray-300 rounded-lg px-4 py-2">
                        <option value="all">Toutes Catégories</option>
                        <option value="tasks">Plus de Tâches</option>
                        <option value="fast">Plus Rapides</option>
                        <option value="connected">Plus Connectés</option>
                    </select>
                </div>
                <div id="top-performers-list">
                    <div class="loading-skeleton h-64 rounded"></div>
                </div>
            </div>
        </div>

        <div id="content-leaderboard" class="tab-content hidden">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                        <i data-lucide="bar-chart" class="h-6 w-6 mr-2 text-primary"></i>
                        Classement Général
                    </h2>
                    <select id="period-filter" onchange="loadLeaderboard()" class="border border-gray-300 rounded-lg px-4 py-2">
                        <option value="all">Tout Temps</option>
                        <option value="week">Cette Semaine</option>
                        <option value="month">Ce Mois</option>
                        <option value="year">Cette Année</option>
                    </select>
                </div>
                <div id="leaderboard-table">
                    <div class="loading-skeleton h-96 rounded"></div>
                </div>
            </div>
        </div>

        <div id="content-all-badges" class="tab-content hidden">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                        <i data-lucide="award" class="h-6 w-6 mr-2 text-primary"></i>
                        Badges Récemment Attribués
                    </h2>
                    <select id="hours-filter" onchange="loadRecentBadges()" class="border border-gray-300 rounded-lg px-4 py-2">
                        <option value="24">Dernières 24h</option>
                        <option value="48">Dernières 48h</option>
                        <option value="168">Dernière Semaine</option>
                    </select>
                </div>
                <div id="recent-badges-list">
                    <div class="loading-skeleton h-96 rounded"></div>
                </div>
            </div>
        </div>

        <div id="content-statistics" class="tab-content hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <i data-lucide="pie-chart" class="h-5 w-5 mr-2 text-primary"></i>
                        Statistiques Globales
                    </h3>
                    <div id="global-stats">
                        <div class="loading-skeleton h-48 rounded"></div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <i data-lucide="users" class="h-5 w-5 mr-2 text-purple-600"></i>
                        Volontaires les Plus Badgés
                    </h3>
                    <div id="top-badged">
                        <div class="loading-skeleton h-48 rounded"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <footer class="bg-gray-900 text-white py-12 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center mb-4">
                        <i data-lucide="cpu" class="h-8 w-8 text-primary mr-2"></i>
                        <span class="text-xl font-bold">VCUY1</span>
                    </div>
                    <p class="text-gray-400 text-sm">
                        Système de Calcul Distribué Volontaire de l'Université de Yaoundé I.
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Liens Rapides</h3>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="text-gray-400 hover:text-white transition-colors">Accueil</a></li>
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


    <script src="assets/js/badges-page.js"></script>
    
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
    </script>
</body>
</html>