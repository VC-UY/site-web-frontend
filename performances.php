<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Performances Système - VCUY1</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .metric-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .metric-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
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
                    <a href="badges.php" class="text-gray-700 hover:text-primary transition-colors">Badges</a>
                    <a href="performances.php" class="text-primary font-semibold">Performances</a>
                    <a href="downloads.php" class="text-gray-700 hover:text-primary transition-colors">Téléchargements</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">📊 Analyse de Performances</h1>
                    <p class="mt-2 text-gray-600">Surveillance et optimisation des performances système</p>
                </div>
                <div class="flex items-center space-x-4">
                    <select id="period-filter" onchange="loadAllData()" class="border border-gray-300 rounded-lg px-4 py-2">
                        <option value="day">Aujourd'hui</option>
                        <option value="week" selected>Cette Semaine</option>
                        <option value="month">Ce Mois</option>
                    </select>
                    <button onclick="refreshAllData()" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                        <i data-lucide="refresh-cw" class="h-4 w-4 mr-2"></i>
                        Actualiser
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        
        <!-- Onglets -->
        <div class="bg-white rounded-lg shadow-md mb-8">
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button onclick="switchTab('overview')" id="tab-overview" class="tab-button active px-6 py-4 text-sm font-medium border-b-2 border-primary text-primary">
                        <i data-lucide="layout-dashboard" class="h-5 w-5 inline mr-2"></i>
                        Vue d'Ensemble
                    </button>
                    <button onclick="switchTab('volunteers')" id="tab-volunteers" class="tab-button px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        <i data-lucide="users" class="h-5 w-5 inline mr-2"></i>
                        Volontaires
                    </button>
                    <button onclick="switchTab('tasks')" id="tab-tasks" class="tab-button px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        <i data-lucide="list-checks" class="h-5 w-5 inline mr-2"></i>
                        Tâches
                    </button>
                    <button onclick="switchTab('alerts')" id="tab-alerts" class="tab-button px-6 py-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        <i data-lucide="alert-triangle" class="h-5 w-5 inline mr-2"></i>
                        Alertes
                    </button>
                </nav>
            </div>
        </div>

        <!-- Tab: Vue d'Ensemble -->
        <div id="content-overview" class="tab-content">
            <!-- Statistiques Globales -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div id="stat-cpu" class="bg-white rounded-lg shadow-lg p-6 metric-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">CPU Moyen</p>
                            <p class="text-3xl font-bold text-blue-600">--</p>
                            <p class="text-xs text-gray-500 mt-1">Charge processeur</p>
                        </div>
                        <div class="bg-blue-100 rounded-full p-3">
                            <i data-lucide="cpu" class="h-8 w-8 text-blue-600"></i>
                        </div>
                    </div>
                </div>

                <div id="stat-memory" class="bg-white rounded-lg shadow-lg p-6 metric-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Mémoire Moyenne</p>
                            <p class="text-3xl font-bold text-purple-600">--</p>
                            <p class="text-xs text-gray-500 mt-1">Utilisation RAM</p>
                        </div>
                        <div class="bg-purple-100 rounded-full p-3">
                            <i data-lucide="hard-drive" class="h-8 w-8 text-purple-600"></i>
                        </div>
                    </div>
                </div>

                <div id="stat-tasks" class="bg-white rounded-lg shadow-lg p-6 metric-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Tâches Complétées</p>
                            <p class="text-3xl font-bold text-green-600">--</p>
                            <p class="text-xs text-gray-500 mt-1">Période actuelle</p>
                        </div>
                        <div class="bg-green-100 rounded-full p-3">
                            <i data-lucide="check-circle" class="h-8 w-8 text-green-600"></i>
                        </div>
                    </div>
                </div>

                <div id="stat-performance" class="bg-white rounded-lg shadow-lg p-6 metric-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Score Global</p>
                            <p class="text-3xl font-bold text-orange-600">--</p>
                            <p class="text-xs text-gray-500 mt-1">Performance moyenne</p>
                        </div>
                        <div class="bg-orange-100 rounded-full p-3">
                            <i data-lucide="activity" class="h-8 w-8 text-orange-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Graphiques -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i data-lucide="trending-up" class="h-5 w-5 mr-2 text-primary"></i>
                        Tendances CPU
                    </h3>
                    <canvas id="cpu-trend-chart"></canvas>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i data-lucide="trending-up" class="h-5 w-5 mr-2 text-purple-600"></i>
                        Tendances Mémoire
                    </h3>
                    <canvas id="memory-trend-chart"></canvas>
                </div>
            </div>
        </div>

        <!-- Tab: Volontaires -->
        <div id="content-volunteers" class="tab-content hidden">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                        <i data-lucide="trophy" class="h-6 w-6 mr-2 text-yellow-500"></i>
                        Classement des Volontaires par Performance
                    </h3>
                    <select id="ranking-criteria" onchange="loadVolunteerRanking()" class="border border-gray-300 rounded-lg px-4 py-2">
                        <option value="performance_score">Score Global</option>
                        <option value="cpu">CPU</option>
                        <option value="memory">Mémoire</option>
                        <option value="tasks">Tâches Complétées</option>
                    </select>
                </div>
                <div id="volunteer-ranking-list">
                    <div class="loading-skeleton h-96 rounded"></div>
                </div>
            </div>
        </div>

        <!-- Tab: Tâches -->
        <div id="content-tasks" class="tab-content hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Statistiques Tâches -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <i data-lucide="bar-chart" class="h-6 w-6 mr-2 text-primary"></i>
                        Statistiques des Tâches
                    </h3>
                    <div id="task-stats">
                        <div class="loading-skeleton h-64 rounded"></div>
                    </div>
                </div>

                <!-- Tâches Lentes -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <i data-lucide="clock" class="h-6 w-6 mr-2 text-red-500"></i>
                        Tâches Lentes
                    </h3>
                    <div id="slow-tasks-list">
                        <div class="loading-skeleton h-64 rounded"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab: Alertes -->
        <div id="content-alerts" class="tab-content hidden">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                        <i data-lucide="alert-triangle" class="h-6 w-6 mr-2 text-red-500"></i>
                        Alertes Système
                    </h3>
                    <div class="flex items-center space-x-4">
                        <select id="alert-metric" onchange="loadAlerts()" class="border border-gray-300 rounded-lg px-4 py-2">
                            <option value="cpu">CPU</option>
                            <option value="memory">Mémoire</option>
                            <option value="execution_time">Temps d'exécution</option>
                        </select>
                        <input type="number" id="alert-threshold" onchange="loadAlerts()" value="80" min="0" max="100" class="border border-gray-300 rounded-lg px-4 py-2 w-24" placeholder="Seuil">
                    </div>
                </div>
                <div id="alerts-list">
                    <div class="loading-skeleton h-96 rounded"></div>
                </div>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-gray-400">© 2025 VCUY1. Tous droits réservés.</p>
                <p class="text-gray-500 mt-2">Université de Yaoundé I - Cameroun</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="assets/js/performance-api.js"></script>
    <script src="assets/js/performances-page.js"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
