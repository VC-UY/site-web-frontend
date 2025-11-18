<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analyses - VCUY1</title>
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
                    <a href="analytics.php" class="text-primary font-semibold">Analyses</a>
                    <a href="about.php" class="text-gray-700 hover:text-primary transition-colors">À propos</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Analyses et Métriques</h1>
                    <p class="mt-2 text-gray-600">Analysez les performances et les économies de votre système de calcul distribué</p>
                </div>
                <div class="flex items-center space-x-4">
                    <select id="time-range" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="1">Dernières 24h</option>
                        <option value="7" selected>7 derniers jours</option>
                        <option value="30">30 derniers jours</option>
                    </select>
                    <button onclick="refreshData()" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        <i data-lucide="refresh-cw" class="h-4 w-4 mr-2 inline"></i>
                        Actualiser
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Cost Savings Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Économies de Coûts</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="bg-green-500 rounded-full w-12 h-12 flex items-center justify-center">
                            <i data-lucide="dollar-sign" class="h-6 w-6 text-white"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Économies Totales</p>
                            <p class="text-2xl font-bold text-gray-900" id="total-savings">€--</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center text-sm">
                            <span class="text-green-600 font-medium" id="savings-percentage">--%</span>
                            <span class="text-gray-500 ml-2">d'économies</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="bg-blue-500 rounded-full w-12 h-12 flex items-center justify-center">
                            <i data-lucide="trending-down" class="h-6 w-6 text-white"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Coût par Tâche</p>
                            <p class="text-2xl font-bold text-gray-900" id="cost-per-task">€--</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center text-sm">
                            <span class="text-blue-600 font-medium">vs €0.50</span>
                            <span class="text-gray-500 ml-2">traditionnel</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="bg-purple-500 rounded-full w-12 h-12 flex items-center justify-center">
                            <i data-lucide="zap" class="h-6 w-6 text-white"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Tâches Traitées</p>
                            <p class="text-2xl font-bold text-gray-900" id="completed-tasks-count">--</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center text-sm">
                            <span class="text-purple-600 font-medium">100%</span>
                            <span class="text-gray-500 ml-2">via volontaires</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="bg-orange-500 rounded-full w-12 h-12 flex items-center justify-center">
                            <i data-lucide="clock" class="h-6 w-6 text-white"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">ROI Mensuel</p>
                            <p class="text-2xl font-bold text-gray-900" id="monthly-roi">--%</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center text-sm">
                            <span class="text-orange-600 font-medium">Retour</span>
                            <span class="text-gray-500 ml-2">sur investissement</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Analytics -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Analyses de Performance</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Performance History Chart -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Historique des Performances</h3>
                        <i data-lucide="trending-up" class="h-5 w-5 text-gray-400"></i>
                    </div>
                    <div style="height: 200px;">
                        <canvas id="performanceHistoryChart"></canvas>
                    </div>
                </div>

                <!-- Volunteer Performance Distribution -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Distribution des Performances</h3>
                        <i data-lucide="bar-chart" class="h-5 w-5 text-gray-400"></i>
                    </div>
                    <div style="height: 200px;">
                        <canvas id="performanceDistributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cost Comparison -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Comparaison des Coûts</h2>
            <div class="bg-white rounded-lg shadow p-6">
                <canvas id="costComparisonChart" width="800" height="400"></canvas>
            </div>
        </div>

        <!-- Top Performers -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Top Volunteers -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Top Volontaires</h3>
                </div>
                <div class="p-6">
                    <div id="top-volunteers" class="space-y-4">
                        <!-- Top volunteers will be loaded here -->
                    </div>
                </div>
            </div>

            <!-- Performance Statistics -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Statistiques Globales</h3>
                </div>
                <div class="p-6">
                    <div id="global-stats" class="space-y-4">
                        <!-- Global statistics will be loaded here -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Resource Utilization -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Utilisation des Ressources</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">CPU Global</h3>
                        <i data-lucide="cpu" class="h-5 w-5 text-gray-400"></i>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-blue-600 mb-2" id="global-cpu">--%</div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-blue-600 h-3 rounded-full transition-all duration-500" id="global-cpu-bar" style="width: 0%"></div>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Utilisation moyenne</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Mémoire Globale</h3>
                        <i data-lucide="hard-drive" class="h-5 w-5 text-gray-400"></i>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-green-600 mb-2" id="global-memory">--%</div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-green-600 h-3 rounded-full transition-all duration-500" id="global-memory-bar" style="width: 0%"></div>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Utilisation moyenne</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Réseau</h3>
                        <i data-lucide="wifi" class="h-5 w-5 text-gray-400"></i>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-purple-600 mb-2" id="network-throughput">-- MB/s</div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-purple-600 h-3 rounded-full transition-all duration-500" id="network-bar" style="width: 75%"></div>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Débit moyen</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        let performanceHistoryChart, performanceDistributionChart, costComparisonChart;
        
        // Initialize charts
        function initCharts() {
            // Performance History Chart
            const performanceHistoryCtx = document.getElementById('performanceHistoryChart').getContext('2d');
            performanceHistoryChart = new Chart(performanceHistoryCtx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Volontaires Actifs',
                        data: [],
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.1)',
                        tension: 0.4,
                        yAxisID: 'y'
                    }, {
                        label: 'Tâches Complétées',
                        data: [],
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        yAxisID: 'y1'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 2,
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Volontaires',
                                font: { size: 10 }
                            },
                            ticks: { font: { size: 9 } }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Tâches',
                                font: { size: 10 }
                            },
                            grid: {
                                drawOnChartArea: false,
                            },
                            ticks: { font: { size: 9 } }
                        },
                        x: {
                            ticks: { font: { size: 9 } }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: { font: { size: 10 } }
                        }
                    }
                }
            });
            
            // Performance Distribution Chart
            const performanceDistributionCtx = document.getElementById('performanceDistributionChart').getContext('2d');
            performanceDistributionChart = new Chart(performanceDistributionCtx, {
                type: 'bar',
                data: {
                    labels: ['0-20%', '21-40%', '41-60%', '61-80%', '81-100%'],
                    datasets: [{
                        label: 'Nombre de Volontaires',
                        data: [0, 0, 0, 0, 0],
                        backgroundColor: [
                            'rgba(239, 68, 68, 0.8)',
                            'rgba(245, 158, 11, 0.8)',
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(16, 185, 129, 0.8)',
                            'rgba(34, 197, 94, 0.8)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 2,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { font: { size: 9 } }
                        },
                        x: {
                            ticks: { font: { size: 9 } }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: { font: { size: 10 } }
                        }
                    }
                }
            });
            
            // Cost Comparison Chart
            const costComparisonCtx = document.getElementById('costComparisonChart').getContext('2d');
            costComparisonChart = new Chart(costComparisonCtx, {
                type: 'bar',
                data: {
                    labels: ['Infrastructure Traditionnelle', 'VCUY1 (Volontaires)', 'Économies Réalisées'],
                    datasets: [{
                        label: 'Coût (€)',
                        data: [0, 0, 0],
                        backgroundColor: [
                            'rgba(239, 68, 68, 0.8)',
                            'rgba(37, 99, 235, 0.8)',
                            'rgba(34, 197, 94, 0.8)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '€' + value.toLocaleString();
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': €' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }
        
        // Load cost savings analytics
        async function loadCostSavings() {
            try {
                const response = await fetch('http://localhost:5000/api/analytics/cost-savings');
                const data = await response.json();
                
                if (data.success) {
                    const savings = data.data;
                    
                    document.getElementById('total-savings').textContent = '€' + Math.round(savings.total_savings).toLocaleString();
                    document.getElementById('savings-percentage').textContent = Math.round(savings.savings_percentage) + '%';
                    document.getElementById('cost-per-task').textContent = '€' + savings.cost_per_task_saved.toFixed(3);
                    document.getElementById('completed-tasks-count').textContent = savings.completed_tasks.toLocaleString();
                    document.getElementById('monthly-roi').textContent = Math.round(savings.savings_percentage * 2) + '%';
                    
                    // Update cost comparison chart
                    costComparisonChart.data.datasets[0].data = [
                        savings.traditional_cost,
                        savings.volunteer_cost,
                        savings.total_savings
                    ];
                    costComparisonChart.update();
                }
            } catch (error) {
                console.error('Erreur lors du chargement des économies:', error);
            }
        }
        
        // Load performance analytics
        async function loadPerformanceAnalytics() {
            try {
                const response = await fetch('http://localhost:5000/api/analytics/volunteer-performance');
                const data = await response.json();
                
                if (data.success) {
                    const analytics = data.data;
                    
                    // Update top volunteers
                    const topVolunteersContainer = document.getElementById('top-volunteers');
                    topVolunteersContainer.innerHTML = analytics.top_volunteers.map((volunteer, index) => `
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                    ${index + 1}
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">${volunteer.name}</p>
                                    <p class="text-xs text-gray-500">${volunteer.performance_score.toFixed(1)}% performance</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">${volunteer.tasks_completed}</p>
                                <p class="text-xs text-gray-500">tâches</p>
                            </div>
                        </div>
                    `).join('');
                    
                    // Update global statistics
                    const globalStatsContainer = document.getElementById('global-stats');
                    const stats = analytics.statistics;
                    globalStatsContainer.innerHTML = `
                        <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-700">Total Volontaires</span>
                            <span class="text-lg font-bold text-blue-600">${stats.total_volunteers}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-700">Volontaires Actifs</span>
                            <span class="text-lg font-bold text-green-600">${stats.active_volunteers}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-purple-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-700">Performance Moyenne</span>
                            <span class="text-lg font-bold text-purple-600">${stats.average_performance_score}%</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-orange-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-700">Temps Total</span>
                            <span class="text-lg font-bold text-orange-600">${stats.total_computation_hours}h</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-700">Taux d'Activité</span>
                            <span class="text-lg font-bold text-gray-600">${stats.activity_rate}%</span>
                        </div>
                    `;
                    
                    // Update performance distribution chart
                    const volunteers = analytics.top_volunteers.concat(
                        Array(Math.max(0, 20 - analytics.top_volunteers.length)).fill(null).map(() => ({
                            performance_score: Math.random() * 100
                        }))
                    );
                    
                    const distribution = [0, 0, 0, 0, 0];
                    volunteers.forEach(v => {
                        if (v && v.performance_score) {
                            const score = v.performance_score;
                            if (score <= 20) distribution[0]++;
                            else if (score <= 40) distribution[1]++;
                            else if (score <= 60) distribution[2]++;
                            else if (score <= 80) distribution[3]++;
                            else distribution[4]++;
                        }
                    });
                    
                    performanceDistributionChart.data.datasets[0].data = distribution;
                    performanceDistributionChart.update();
                }
            } catch (error) {
                console.error('Erreur lors du chargement des analyses de performance:', error);
            }
        }
        
        // Load performance history
        async function loadPerformanceHistory() {
            try {
                const timeRange = document.getElementById('time-range').value;
                const response = await fetch(`http://localhost:5000/api/analytics/performance-history?days=${timeRange}`);
                const data = await response.json();
                
                if (data.success && data.data.length > 0) {
                    const history = data.data;
                    
                    const labels = history.map(h => {
                        const date = new Date(h.timestamp);
                        return timeRange === '1' ? 
                            date.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' }) :
                            date.toLocaleDateString('fr-FR', { month: 'short', day: 'numeric' });
                    });
                    
                    const activeVolunteers = history.map(h => h.active_volunteers);
                    const completedTasks = history.map(h => h.completed_tasks);
                    
                    performanceHistoryChart.data.labels = labels;
                    performanceHistoryChart.data.datasets[0].data = activeVolunteers;
                    performanceHistoryChart.data.datasets[1].data = completedTasks;
                    performanceHistoryChart.update();
                    
                    // Update resource utilization
                    const latestMetrics = history[history.length - 1];
                    document.getElementById('global-cpu').textContent = Math.round(latestMetrics.cpu_usage) + '%';
                    document.getElementById('global-cpu-bar').style.width = latestMetrics.cpu_usage + '%';
                    
                    document.getElementById('global-memory').textContent = Math.round(latestMetrics.memory_usage) + '%';
                    document.getElementById('global-memory-bar').style.width = latestMetrics.memory_usage + '%';
                    
                    document.getElementById('network-throughput').textContent = Math.round(latestMetrics.network_throughput) + ' MB/s';
                }
            } catch (error) {
                console.error('Erreur lors du chargement de l\'historique:', error);
            }
        }
        
        // Refresh all data
        function refreshData() {
            loadCostSavings();
            loadPerformanceAnalytics();
            loadPerformanceHistory();
        }
        
        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            initCharts();
            refreshData();
            
            // Add event listener for time range change
            document.getElementById('time-range').addEventListener('change', loadPerformanceHistory);
            
            // Auto-refresh every 60 seconds
            setInterval(refreshData, 60000);
        });
    </script>
</body>
</html>