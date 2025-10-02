<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volontaires - VCUY1</title>
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
        .status-active { @apply bg-green-100 text-green-800; }
        .status-inactive { @apply bg-gray-100 text-gray-800; }
        .status-busy { @apply bg-yellow-100 text-yellow-800; }
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
                    <a href="volunteers.php" class="text-primary font-semibold">Volontaires</a>
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
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Réseau de Volontaires</h1>
                    <p class="mt-2 text-gray-600">Gérez et surveillez les performances de votre réseau de calcul distribué</p>
                </div>
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
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="bg-green-500 rounded-full w-12 h-12 flex items-center justify-center">
                        <i data-lucide="users" class="h-6 w-6 text-white"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Volontaires</p>
                        <p class="text-2xl font-bold text-gray-900" id="total-volunteers">--</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="bg-blue-500 rounded-full w-12 h-12 flex items-center justify-center">
                        <i data-lucide="activity" class="h-6 w-6 text-white"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Actifs</p>
                        <p class="text-2xl font-bold text-gray-900" id="active-volunteers">--</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="bg-purple-500 rounded-full w-12 h-12 flex items-center justify-center">
                        <i data-lucide="zap" class="h-6 w-6 text-white"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Performance Moyenne</p>
                        <p class="text-2xl font-bold text-gray-900" id="avg-performance">--%</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="bg-orange-500 rounded-full w-12 h-12 flex items-center justify-center">
                        <i data-lucide="clock" class="h-6 w-6 text-white"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Temps Total</p>
                        <p class="text-2xl font-bold text-gray-900" id="total-computation-time">--h</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400"></i>
                            <input type="text" id="search-input" placeholder="Rechercher un volontaire..." 
                                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                        <select id="status-filter" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="">Tous les statuts</option>
                            <option value="active">Actif</option>
                            <option value="busy">Occupé</option>
                            <option value="inactive">Inactif</option>
                        </select>
                    </div>
                    <div class="mt-4 sm:mt-0 flex items-center space-x-2">
                        <button onclick="toggleView('grid')" id="grid-view-btn" class="p-2 text-gray-400 hover:text-gray-600">
                            <i data-lucide="grid-3x3" class="h-5 w-5"></i>
                        </button>
                        <button onclick="toggleView('list')" id="list-view-btn" class="p-2 text-primary">
                            <i data-lucide="list" class="h-5 w-5"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Volunteers List/Grid -->
        <div id="volunteers-container">
            <!-- Volunteers will be loaded here -->
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between mt-8">
            <div class="text-sm text-gray-700">
                Affichage de <span id="showing-from">1</span> à <span id="showing-to">20</span> sur <span id="total-count">0</span> volontaires
            </div>
            <div class="flex items-center space-x-2">
                <button id="prev-page" class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700 disabled:opacity-50" disabled>
                    Précédent
                </button>
                <div id="page-numbers" class="flex space-x-1">
                    <!-- Page numbers will be generated here -->
                </div>
                <button id="next-page" class="px-3 py-2 text-sm text-gray-500 hover:text-gray-700">
                    Suivant
                </button>
            </div>
        </div>
    </div>

    <!-- Volunteer Detail Modal -->
    <div id="volunteer-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-screen overflow-y-auto">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900" id="modal-title">Détails du Volontaire</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                        <i data-lucide="x" class="h-6 w-6"></i>
                    </button>
                </div>
                <div id="modal-content" class="p-6">
                    <!-- Modal content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        let volunteers = [];
        let filteredVolunteers = [];
        let currentView = 'list';
        let currentPage = 1;
        let itemsPerPage = 20;
        
        // Load volunteers data
        async function loadVolunteers() {
            try {
                const response = await fetch('http://localhost:5000/api/volunteers');
                const data = await response.json();
                
                if (data.success) {
                    volunteers = data.data;
                    filteredVolunteers = [...volunteers];
                    updateStats();
                    renderVolunteers();
                    updateLastUpdate();
                }
            } catch (error) {
                console.error('Erreur lors du chargement des volontaires:', error);
            }
        }
        
        // Update statistics
        function updateStats() {
            const totalVolunteers = volunteers.length;
            const activeVolunteers = volunteers.filter(v => v.status === 'active').length;
            const avgPerformance = volunteers.reduce((sum, v) => sum + v.performance_score, 0) / totalVolunteers;
            const totalComputationTime = volunteers.reduce((sum, v) => sum + v.total_computation_time, 0);
            
            document.getElementById('total-volunteers').textContent = totalVolunteers;
            document.getElementById('active-volunteers').textContent = activeVolunteers;
            document.getElementById('avg-performance').textContent = Math.round(avgPerformance) + '%';
            document.getElementById('total-computation-time').textContent = Math.round(totalComputationTime) + 'h';
        }
        
        // Render volunteers based on current view
        function renderVolunteers() {
            const container = document.getElementById('volunteers-container');
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const pageVolunteers = filteredVolunteers.slice(startIndex, endIndex);
            
            if (currentView === 'grid') {
                container.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        ${pageVolunteers.map(volunteer => renderVolunteerCard(volunteer)).join('')}
                    </div>
                `;
            } else {
                container.innerHTML = `
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Volontaire</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ressources</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Performance</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tâches</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                ${pageVolunteers.map(volunteer => renderVolunteerRow(volunteer)).join('')}
                            </tbody>
                        </table>
                    </div>
                `;
            }
            
            updatePagination();
            lucide.createIcons();
        }
        
        // Render volunteer card for grid view
        function renderVolunteerCard(volunteer) {
            const statusClass = `status-${volunteer.status}`;
            const statusIcon = volunteer.status === 'active' ? 'check-circle' : 
                              volunteer.status === 'busy' ? 'clock' : 'x-circle';
            
            return `
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow cursor-pointer" onclick="showVolunteerDetails('${volunteer.volunteer_id}')">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <i data-lucide="user" class="h-6 w-6 text-white"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-semibold text-gray-900">${volunteer.name}</h3>
                                    <p class="text-sm text-gray-500">${volunteer.volunteer_id}</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusClass}">
                                <i data-lucide="${statusIcon}" class="h-3 w-3 mr-1"></i>
                                ${volunteer.status}
                            </span>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Performance:</span>
                                <span class="font-medium">${Math.round(volunteer.performance_score)}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: ${volunteer.performance_score}%"></div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500">CPU:</span>
                                    <span class="font-medium ml-1">${volunteer.cpu_cores} cores</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">RAM:</span>
                                    <span class="font-medium ml-1">${volunteer.memory_gb}GB</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Tâches:</span>
                                    <span class="font-medium ml-1">${volunteer.tasks_completed}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Temps:</span>
                                    <span class="font-medium ml-1">${Math.round(volunteer.total_computation_time)}h</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
        
        // Render volunteer row for list view
        function renderVolunteerRow(volunteer) {
            const statusClass = `status-${volunteer.status}`;
            const statusIcon = volunteer.status === 'active' ? 'check-circle' : 
                              volunteer.status === 'busy' ? 'clock' : 'x-circle';
            
            return `
                <tr class="hover:bg-gray-50 cursor-pointer" onclick="showVolunteerDetails('${volunteer.volunteer_id}')">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                <i data-lucide="user" class="h-5 w-5 text-white"></i>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">${volunteer.name}</div>
                                <div class="text-sm text-gray-500">${volunteer.volunteer_id}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusClass}">
                            <i data-lucide="${statusIcon}" class="h-3 w-3 mr-1"></i>
                            ${volunteer.status}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        ${volunteer.cpu_cores} cores, ${volunteer.memory_gb}GB RAM
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: ${volunteer.performance_score}%"></div>
                            </div>
                            <span class="text-sm text-gray-900">${Math.round(volunteer.performance_score)}%</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        ${volunteer.tasks_completed}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="event.stopPropagation(); showVolunteerDetails('${volunteer.volunteer_id}')" class="text-primary hover:text-blue-900">
                            Détails
                        </button>
                    </td>
                </tr>
            `;
        }
        
        // Show volunteer details modal
        async function showVolunteerDetails(volunteerId) {
            try {
                const response = await fetch(`http://localhost:5000/api/volunteers/${volunteerId}`);
                const data = await response.json();
                
                if (data.success) {
                    const volunteer = data.data.volunteer;
                    const performanceHistory = data.data.performance_history || [];
                    
                    document.getElementById('modal-title').textContent = `${volunteer.name} - Détails`;
                    document.getElementById('modal-content').innerHTML = `
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Informations Générales</h4>
                                    <dl class="space-y-2">
                                        <div class="flex justify-between">
                                            <dt class="text-sm text-gray-500">ID:</dt>
                                            <dd class="text-sm font-medium text-gray-900">${volunteer.volunteer_id}</dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="text-sm text-gray-500">Statut:</dt>
                                            <dd class="text-sm font-medium text-gray-900">${volunteer.status}</dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="text-sm text-gray-500">Rejoint le:</dt>
                                            <dd class="text-sm font-medium text-gray-900">${new Date(volunteer.joined_date).toLocaleDateString('fr-FR')}</dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="text-sm text-gray-500">Dernière activité:</dt>
                                            <dd class="text-sm font-medium text-gray-900">${new Date(volunteer.last_seen).toLocaleString('fr-FR')}</dd>
                                        </div>
                                    </dl>
                                </div>
                                
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Ressources</h4>
                                    <dl class="space-y-2">
                                        <div class="flex justify-between">
                                            <dt class="text-sm text-gray-500">CPU Cores:</dt>
                                            <dd class="text-sm font-medium text-gray-900">${volunteer.cpu_cores}</dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="text-sm text-gray-500">Mémoire:</dt>
                                            <dd class="text-sm font-medium text-gray-900">${volunteer.memory_gb} GB</dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="text-sm text-gray-500">Score de performance:</dt>
                                            <dd class="text-sm font-medium text-gray-900">${Math.round(volunteer.performance_score)}%</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                            
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-4">Statistiques</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="bg-blue-50 rounded-lg p-4">
                                        <div class="text-2xl font-bold text-blue-600">${volunteer.tasks_completed}</div>
                                        <div class="text-sm text-gray-600">Tâches complétées</div>
                                    </div>
                                    <div class="bg-green-50 rounded-lg p-4">
                                        <div class="text-2xl font-bold text-green-600">${Math.round(volunteer.total_computation_time)}h</div>
                                        <div class="text-sm text-gray-600">Temps de calcul</div>
                                    </div>
                                    <div class="bg-purple-50 rounded-lg p-4">
                                        <div class="text-2xl font-bold text-purple-600">${Math.round(volunteer.performance_score)}%</div>
                                        <div class="text-sm text-gray-600">Performance</div>
                                    </div>
                                </div>
                            </div>
                            
                            ${performanceHistory.length > 0 ? `
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Historique Récent</h4>
                                    <div class="max-h-64 overflow-y-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tâche</th>
                                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Temps</th>
                                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">CPU</th>
                                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200">
                                                ${performanceHistory.slice(0, 10).map(perf => `
                                                    <tr>
                                                        <td class="px-4 py-2 text-sm text-gray-900">${perf.task_id}</td>
                                                        <td class="px-4 py-2 text-sm text-gray-900">${Math.round(perf.execution_time)}s</td>
                                                        <td class="px-4 py-2 text-sm text-gray-900">${Math.round(perf.cpu_usage)}%</td>
                                                        <td class="px-4 py-2 text-sm">
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${perf.success ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                                                                ${perf.success ? 'Succès' : 'Échec'}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                `).join('')}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            ` : ''}
                        </div>
                    `;
                    
                    document.getElementById('volunteer-modal').classList.remove('hidden');
                    lucide.createIcons();
                }
            } catch (error) {
                console.error('Erreur lors du chargement des détails:', error);
            }
        }
        
        // Close modal
        function closeModal() {
            document.getElementById('volunteer-modal').classList.add('hidden');
        }
        
        // Toggle view between grid and list
        function toggleView(view) {
            currentView = view;
            currentPage = 1;
            
            // Update button states
            document.getElementById('grid-view-btn').className = view === 'grid' ? 'p-2 text-primary' : 'p-2 text-gray-400 hover:text-gray-600';
            document.getElementById('list-view-btn').className = view === 'list' ? 'p-2 text-primary' : 'p-2 text-gray-400 hover:text-gray-600';
            
            renderVolunteers();
        }
        
        // Filter volunteers
        function filterVolunteers() {
            const searchTerm = document.getElementById('search-input').value.toLowerCase();
            const statusFilter = document.getElementById('status-filter').value;
            
            filteredVolunteers = volunteers.filter(volunteer => {
                const matchesSearch = volunteer.name.toLowerCase().includes(searchTerm) || 
                                    volunteer.volunteer_id.toLowerCase().includes(searchTerm);
                const matchesStatus = !statusFilter || volunteer.status === statusFilter;
                
                return matchesSearch && matchesStatus;
            });
            
            currentPage = 1;
            renderVolunteers();
        }
        
        // Update pagination
        function updatePagination() {
            const totalPages = Math.ceil(filteredVolunteers.length / itemsPerPage);
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, filteredVolunteers.length);
            
            document.getElementById('showing-from').textContent = startIndex + 1;
            document.getElementById('showing-to').textContent = endIndex;
            document.getElementById('total-count').textContent = filteredVolunteers.length;
            
            // Update pagination buttons
            document.getElementById('prev-page').disabled = currentPage === 1;
            document.getElementById('next-page').disabled = currentPage === totalPages;
            
            // Generate page numbers
            const pageNumbers = document.getElementById('page-numbers');
            pageNumbers.innerHTML = '';
            
            for (let i = Math.max(1, currentPage - 2); i <= Math.min(totalPages, currentPage + 2); i++) {
                const button = document.createElement('button');
                button.textContent = i;
                button.className = i === currentPage ? 
                    'px-3 py-2 text-sm bg-primary text-white rounded' : 
                    'px-3 py-2 text-sm text-gray-500 hover:text-gray-700';
                button.onclick = () => goToPage(i);
                pageNumbers.appendChild(button);
            }
        }
        
        // Go to specific page
        function goToPage(page) {
            currentPage = page;
            renderVolunteers();
        }
        
        // Update last update time
        function updateLastUpdate() {
            document.getElementById('last-update').textContent = 'Dernière mise à jour: ' + new Date().toLocaleTimeString();
        }
        
        // Refresh data
        function refreshData() {
            loadVolunteers();
        }
        
        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            loadVolunteers();
            
            // Add event listeners
            document.getElementById('search-input').addEventListener('input', filterVolunteers);
            document.getElementById('status-filter').addEventListener('change', filterVolunteers);
            
            document.getElementById('prev-page').addEventListener('click', () => {
                if (currentPage > 1) goToPage(currentPage - 1);
            });
            
            document.getElementById('next-page').addEventListener('click', () => {
                const totalPages = Math.ceil(filteredVolunteers.length / itemsPerPage);
                if (currentPage < totalPages) goToPage(currentPage + 1);
            });
            
            // Close modal when clicking outside
            document.getElementById('volunteer-modal').addEventListener('click', function(e) {
                if (e.target === this) closeModal();
            });
            
            // Auto-refresh every 60 seconds
            setInterval(refreshData, 60000);
        });
    </script>
</body>
</html>

