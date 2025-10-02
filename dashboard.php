<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - VCUY1</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .animate-pulse-slow {
            animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
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
                    <a href="dashboard.php" class="text-primary font-semibold">Tableau de bord</a>
                    <a href="volunteers.php" class="text-gray-700 hover:text-primary transition-colors">Volontaires</a>
                    <a href="analytics.php" class="text-gray-700 hover:text-primary transition-colors">Analyses</a>
                    <a href="about.php" class="text-gray-700 hover:text-primary transition-colors">À propos</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold text-gray-900">Tableau de Bord</h1>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center text-sm text-gray-500">
                        <i data-lucide="clock" class="h-4 w-4 mr-1"></i>
                        <span id="last-update">Dernière mise à jour: --:--</span>
                    </div>
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
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="stats-gradient rounded-full w-12 h-12 flex items-center justify-center">
                        <i data-lucide="users" class="h-6 w-6 text-white"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Volontaires Actifs</p>
                        <p class="text-2xl font-bold text-gray-900" id="active-volunteers">--</p>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm">
                        <span class="text-green-600 font-medium" id="volunteers-change">+0%</span>
                        <span class="text-gray-500 ml-2">depuis hier</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="stats-gradient rounded-full w-12 h-12 flex items-center justify-center">
                        <i data-lucide="zap" class="h-6 w-6 text-white"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Tâches Complétées</p>
                        <p class="text-2xl font-bold text-gray-900" id="completed-tasks">--</p>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm">
                        <span class="text-green-600 font-medium" id="tasks-change">+0%</span>
                        <span class="text-gray-500 ml-2">depuis hier</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="stats-gradient rounded-full w-12 h-12 flex items-center justify-center">
                        <i data-lucide="activity" class="h-6 w-6 text-white"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Utilisation CPU</p>
                        <p class="text-2xl font-bold text-gray-900" id="cpu-usage">--%</p>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-500" id="cpu-bar" style="width: 0%"></div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="stats-gradient rounded-full w-12 h-12 flex items-center justify-center">
                        <i data-lucide="dollar-sign" class="h-6 w-6 text-white"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Économies</p>
                        <p class="text-2xl font-bold text-gray-900" id="cost-savings">€--</p>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-sm">
                        <span class="text-green-600 font-medium" id="savings-change">+0%</span>
                        <span class="text-gray-500 ml-2">ce mois</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Performance Chart -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Performance Système</h3>
                    <div class="flex space-x-2">
                        <button class="text-sm text-gray-500 hover:text-gray-700">1H</button>
                        <button class="text-sm text-primary font-medium">24H</button>
                        <button class="text-sm text-gray-500 hover:text-gray-700">7J</button>
                    </div>
                </div>
                <canvas id="performanceChart" width="400" height="200"></canvas>
            </div>

            <!-- Tasks Distribution -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Distribution des Tâches</h3>
                    <i data-lucide="pie-chart" class="h-5 w-5 text-gray-400"></i>
                </div>
                <canvas id="tasksChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Active Volunteers -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Volontaires Actifs</h3>
                </div>
                <div class="p-6">
                    <div id="volunteers-list" class="space-y-4">
                        <!-- Volunteers will be loaded here -->
                    </div>
                </div>
            </div>

            <!-- Recent Tasks -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Tâches Récentes</h3>
                </div>
                <div class="p-6">
                    <div id="tasks-list" class="space-y-4">
                        <!-- Tasks will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        let performanceChart, tasksChart;
        
        // Initialize charts
        function initCharts() {
            // Performance Chart
            const performanceCtx = document.getElementById('performanceChart').getContext('2d');
            performanceChart = new Chart(performanceCtx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'CPU Usage (%)',
                        data: [],
                        borderColor: '#2563eb',
                        backgroundColor: 'rgba(37, 99, 235, 0.1)',
                        tension: 0.4
                    }, {
                        label: 'Memory Usage (%)',
                        data: [],
                        borderColor: '#f97316',
                        backgroundColor: 'rgba(249, 115, 22, 0.1)',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });
            
            // Tasks Chart
            const tasksCtx = document.getElementById('tasksChart').getContext('2d');
            tasksChart = new Chart(tasksCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Complétées', 'En cours', 'En attente', 'Échouées'],
                    datasets: [{
                        data: [0, 0, 0, 0],
                        backgroundColor: ['#10b981', '#2563eb', '#f59e0b', '#ef4444']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }
        
        // Load system metrics
        async function loadSystemMetrics() {
            try {
                const response = await fetch('http://localhost:5000/api/system-metrics');
                const data = await response.json();
                
                if (data.success) {
                    const metrics = data.data;
                    
                    // Update stats cards
                    document.getElementById('active-volunteers').textContent = metrics.active_volunteers;
                    document.getElementById('completed-tasks').textContent = metrics.completed_tasks.toLocaleString();
                    document.getElementById('cpu-usage').textContent = Math.round(metrics.cpu_usage) + '%';
                    document.getElementById('cost-savings').textContent = '€' + Math.round(metrics.cost_savings).toLocaleString();
                    
                    // Update CPU bar
                    document.getElementById('cpu-bar').style.width = metrics.cpu_usage + '%';
                    
                    // Update last update time
                    document.getElementById('last-update').textContent = 'Dernière mise à jour: ' + new Date().toLocaleTimeString();
                }
            } catch (error) {
                console.error('Erreur lors du chargement des métriques:', error);
            }
        }
        
        // Load volunteers
        async function loadVolunteers() {
            try {
                const response = await fetch('http://localhost:5000/api/volunteers');
                const data = await response.json();
                
                if (data.success) {
                    const volunteers = data.data.filter(v => v.status === 'active').slice(0, 5);
                    const volunteersList = document.getElementById('volunteers-list');
                    
                    volunteersList.innerHTML = volunteers.map(volunteer => `
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <i data-lucide="user" class="h-4 w-4 text-white"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">${volunteer.name}</p>
                                    <p class="text-xs text-gray-500">${volunteer.cpu_cores} cores, ${volunteer.memory_gb}GB RAM</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">${volunteer.tasks_completed}</p>
                                <p class="text-xs text-gray-500">tâches</p>
                            </div>
                        </div>
                    `).join('');
                    
                    // Reinitialize icons
                    lucide.createIcons();
                }
            } catch (error) {
                console.error('Erreur lors du chargement des volontaires:', error);
            }
        }
        
        // Load recent tasks
        async function loadRecentTasks() {
            try {
                const response = await fetch('http://localhost:5000/api/tasks?limit=5');
                const data = await response.json();
                
                if (data.success) {
                    const tasks = data.data.slice(0, 5);
                    const tasksList = document.getElementById('tasks-list');
                    
                    tasksList.innerHTML = tasks.map(task => {
                        const statusColors = {
                            'completed': 'bg-green-100 text-green-800',
                            'running': 'bg-blue-100 text-blue-800',
                            'pending': 'bg-yellow-100 text-yellow-800',
                            'failed': 'bg-red-100 text-red-800'
                        };
                        
                        return `
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gray-400 rounded-full flex items-center justify-center">
                                        <i data-lucide="zap" class="h-4 w-4 text-white"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">${task.task_id}</p>
                                        <p class="text-xs text-gray-500">${task.workflow_id}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusColors[task.status] || 'bg-gray-100 text-gray-800'}">
                                        ${task.status}
                                    </span>
                                </div>
                            </div>
                        `;
                    }).join('');
                    
                    // Update tasks chart
                    const statusCounts = {
                        completed: tasks.filter(t => t.status === 'completed').length,
                        running: tasks.filter(t => t.status === 'running').length,
                        pending: tasks.filter(t => t.status === 'pending').length,
                        failed: tasks.filter(t => t.status === 'failed').length
                    };
                    
                    tasksChart.data.datasets[0].data = [
                        statusCounts.completed,
                        statusCounts.running,
                        statusCounts.pending,
                        statusCounts.failed
                    ];
                    tasksChart.update();
                    
                    // Reinitialize icons
                    lucide.createIcons();
                }
            } catch (error) {
                console.error('Erreur lors du chargement des tâches:', error);
            }
        }
        
        // Load performance history
        async function loadPerformanceHistory() {
            try {
                const response = await fetch('http://localhost:5000/api/analytics/performance-history?days=1');
                const data = await response.json();
                
                if (data.success && data.data.length > 0) {
                    const history = data.data.slice(-24); // Last 24 hours
                    
                    const labels = history.map(h => new Date(h.timestamp).toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' }));
                    const cpuData = history.map(h => h.cpu_usage);
                    const memoryData = history.map(h => h.memory_usage);
                    
                    performanceChart.data.labels = labels;
                    performanceChart.data.datasets[0].data = cpuData;
                    performanceChart.data.datasets[1].data = memoryData;
                    performanceChart.update();
                }
            } catch (error) {
                console.error('Erreur lors du chargement de l\'historique:', error);
            }
        }
        
        // Refresh all data
        function refreshData() {
            loadSystemMetrics();
            loadVolunteers();
            loadRecentTasks();
            loadPerformanceHistory();
        }
        
        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            initCharts();
            refreshData();
            
            // Register charts with real-time manager
            if (window.realTimeManager) {
                window.realTimeManager.registerChart('performanceChart', performanceChart);
                window.realTimeManager.registerChart('tasksChart', tasksChart);
            }
            
            // Auto-refresh every 30 seconds
            setInterval(refreshData, 30000);
        });
    </script>
</body>
</html>

