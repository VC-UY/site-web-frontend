

// Variables globales
let currentTab = 'overview';
let cpuTrendChart = null;
let memoryTrendChart = null;

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    console.log('📊 Page Performances initialisée');
    loadAllData();
    
    // Actualisation automatique toutes les 30 secondes
    setInterval(() => {
        if (currentTab === 'overview') {
            loadOverviewData();
        }
    }, 30000);
});

// ====== GESTION DES ONGLETS ======

function switchTab(tabName) {
    currentTab = tabName;
    
    // Mettre à jour les boutons
    document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.remove('active', 'border-primary', 'text-primary');
        btn.classList.add('border-transparent', 'text-gray-500');
    });
    
    const activeBtn = document.getElementById(`tab-${tabName}`);
    activeBtn.classList.add('active', 'border-primary', 'text-primary');
    activeBtn.classList.remove('border-transparent', 'text-gray-500');
    
    // Afficher le contenu correspondant
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    document.getElementById(`content-${tabName}`).classList.remove('hidden');
    
    // Charger les données de l'onglet
    loadTabData(tabName);
}

function loadTabData(tabName) {
    switch(tabName) {
        case 'overview':
            loadOverviewData();
            break;
        case 'volunteers':
            loadVolunteerRanking();
            break;
        case 'tasks':
            loadTasksData();
            break;
        case 'alerts':
            loadAlerts();
            break;
    }
}

// ====== CHARGEMENT DES DONNÉES ======

async function loadAllData() {
    await loadOverviewData();
}

async function refreshAllData() {
    showNotification('🔄 Actualisation en cours...', 'info');
    await loadAllData();
    showNotification('✅ Données actualisées !', 'success');
}

// ====== VUE D'ENSEMBLE ======

async function loadOverviewData() {
    const period = document.getElementById('period-filter')?.value || 'week';
    
    try {
        // Charger le rapport global
        const reportData = await performanceAPI.getPerformanceReport({ period });
        
        if (reportData.success) {
            updateGlobalStats(reportData.data);
        }
        
        // Charger les tendances
        await loadTrends(period);
        
    } catch (error) {
        console.error('Erreur chargement vue d\'ensemble:', error);
        showNotification('❌ Erreur de chargement des données', 'error');
    }
}

function updateGlobalStats(data) {
    // CPU
    const cpuCard = document.getElementById('stat-cpu');
    if (cpuCard && data.cpu_avg !== undefined) {
        cpuCard.querySelector('.text-3xl').textContent = data.cpu_avg.toFixed(1) + '%';
    }
    
    // Mémoire
    const memoryCard = document.getElementById('stat-memory');
    if (memoryCard && data.memory_avg !== undefined) {
        memoryCard.querySelector('.text-3xl').textContent = data.memory_avg.toFixed(1) + '%';
    }
    
    // Tâches
    const tasksCard = document.getElementById('stat-tasks');
    if (tasksCard && data.total_tasks !== undefined) {
        tasksCard.querySelector('.text-3xl').textContent = data.total_tasks;
    }
    
    // Performance
    const perfCard = document.getElementById('stat-performance');
    if (perfCard && data.performance_score !== undefined) {
        perfCard.querySelector('.text-3xl').textContent = data.performance_score.toFixed(1);
    }
}

async function loadTrends(period) {
    try {
        // Tendances CPU
        const cpuTrends = await performanceAPI.getPerformanceTrends('cpu', period);
        if (cpuTrends.success) {
            renderTrendChart('cpu-trend-chart', cpuTrends.data, 'CPU', 'rgb(59, 130, 246)');
        }
        
        // Tendances Mémoire
        const memoryTrends = await performanceAPI.getPerformanceTrends('memory', period);
        if (memoryTrends.success) {
            renderTrendChart('memory-trend-chart', memoryTrends.data, 'Mémoire', 'rgb(147, 51, 234)');
        }
        
    } catch (error) {
        console.error('Erreur chargement tendances:', error);
    }
}

function renderTrendChart(canvasId, data, label, color) {
    const ctx = document.getElementById(canvasId);
    if (!ctx) return;
    
    // Détruire l'ancien graphique si existe
    if (canvasId === 'cpu-trend-chart' && cpuTrendChart) {
        cpuTrendChart.destroy();
    }
    if (canvasId === 'memory-trend-chart' && memoryTrendChart) {
        memoryTrendChart.destroy();
    }
    
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.timestamps || data.labels || [],
            datasets: [{
                label: label,
                data: data.values || [],
                borderColor: color,
                backgroundColor: color.replace('rgb', 'rgba').replace(')', ', 0.1)'),
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });
    
    if (canvasId === 'cpu-trend-chart') {
        cpuTrendChart = chart;
    } else if (canvasId === 'memory-trend-chart') {
        memoryTrendChart = chart;
    }
}

// ====== VOLONTAIRES ======

async function loadVolunteerRanking() {
    const sortBy = document.getElementById('ranking-criteria')?.value || 'performance_score';
    const container = document.getElementById('volunteer-ranking-list');
    
    try {
        const data = await performanceAPI.rankVolunteersByPerformance(sortBy, 20);
        
        if (!data.success || !data.data || data.data.length === 0) {
            container.innerHTML = `
                <div class="text-center text-gray-500 py-8">
                    <i data-lucide="users" class="h-12 w-12 mx-auto mb-2 opacity-50"></i>
                    <p>Aucun volontaire trouvé</p>
                </div>
            `;
            lucide.createIcons();
            return;
        }
        
        container.innerHTML = `
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rang</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Volontaire</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">CPU</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mémoire</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tâches</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Score</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        ${data.data.map((volunteer, index) => {
                            const rank = index + 1;
                            const rankEmoji = rank === 1 ? '🥇' : rank === 2 ? '🥈' : rank === 3 ? '🥉' : '';
                            const rankColor = rank === 1 ? 'text-yellow-600' : rank === 2 ? 'text-gray-600' : rank === 3 ? 'text-orange-600' : 'text-gray-900';
                            
                            return `
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-lg font-bold ${rankColor}">#${rank} ${rankEmoji}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold">
                                                ${(volunteer.name || volunteer.volunteer_id || '?').charAt(0)}
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-medium text-gray-900">${volunteer.name || volunteer.volunteer_id}</div>
                                                <div class="text-sm text-gray-500">${volunteer.volunteer_id || ''}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-semibold">${(volunteer.cpu_usage || 0).toFixed(1)}%</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-semibold">${(volunteer.memory_usage || 0).toFixed(1)}%</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-semibold">${volunteer.tasks_completed || 0}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-lg font-bold text-primary">${(volunteer.performance_score || 0).toFixed(1)}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <button onclick="viewVolunteerDetails('${volunteer.volunteer_id}')" class="text-primary hover:text-blue-700 font-medium">
                                            Voir détails
                                        </button>
                                    </td>
                                </tr>
                            `;
                        }).join('')}
                    </tbody>
                </table>
            </div>
        `;
        
        lucide.createIcons();
        
    } catch (error) {
        console.error('Erreur chargement classement volontaires:', error);
        showNotification('❌ Erreur de chargement du classement', 'error');
        container.innerHTML = `
            <div class="text-center text-red-500 py-8">
                <i data-lucide="alert-circle" class="h-12 w-12 mx-auto mb-2"></i>
                <p>Erreur de chargement des données</p>
            </div>
        `;
        lucide.createIcons();
    }
}

function viewVolunteerDetails(volunteerId) {
    window.location.href = `volunteer-details.php?id=${volunteerId}`;
}

// ====== TÂCHES ======

async function loadTasksData() {
    await Promise.all([
        loadTaskStats(),
        loadSlowTasks()
    ]);
}

async function loadTaskStats() {
    const container = document.getElementById('task-stats');
    
    try {
        const data = await performanceAPI.getTaskPerformanceStats();
        
        if (data.success) {
            container.innerHTML = `
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-4 bg-green-50 rounded-lg">
                        <span class="text-gray-700">Total des tâches</span>
                        <span class="text-2xl font-bold text-green-600">${data.data.total_tasks || 0}</span>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-blue-50 rounded-lg">
                        <span class="text-gray-700">Tâches complétées</span>
                        <span class="text-2xl font-bold text-blue-600">${data.data.completed_tasks || 0}</span>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-orange-50 rounded-lg">
                        <span class="text-gray-700">Temps moyen d'exécution</span>
                        <span class="text-2xl font-bold text-orange-600">${(data.data.avg_execution_time || 0).toFixed(1)}s</span>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-purple-50 rounded-lg">
                        <span class="text-gray-700">Taux de réussite</span>
                        <span class="text-2xl font-bold text-purple-600">${(data.data.success_rate || 0).toFixed(1)}%</span>
                    </div>
                </div>
            `;
        }
    } catch (error) {
        console.error('Erreur chargement stats tâches:', error);
        container.innerHTML = `<p class="text-center text-gray-500">Erreur de chargement</p>`;
    }
}

async function loadSlowTasks() {
    const container = document.getElementById('slow-tasks-list');
    
    try {
        const data = await performanceAPI.getSlowTasks(60); // Seuil: 60 secondes
        
        if (!data.success || !data.data || data.data.length === 0) {
            container.innerHTML = `
                <div class="text-center text-gray-500 py-8">
                    <i data-lucide="check-circle" class="h-12 w-12 mx-auto mb-2 opacity-50 text-green-500"></i>
                    <p>Aucune tâche lente détectée !</p>
                </div>
            `;
            lucide.createIcons();
            return;
        }
        
        container.innerHTML = `
            <div class="space-y-3">
                ${data.data.slice(0, 10).map(task => `
                    <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">${task.task_id}</p>
                            <p class="text-sm text-gray-600">Volontaire: ${task.volunteer_id}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-bold text-red-600">${(task.execution_time || 0).toFixed(1)}s</p>
                            <p class="text-xs text-gray-500">Temps d'exécution</p>
                        </div>
                    </div>
                `).join('')}
            </div>
        `;
        
        lucide.createIcons();
        
    } catch (error) {
        console.error('Erreur chargement tâches lentes:', error);
        container.innerHTML = `<p class="text-center text-gray-500">Erreur de chargement</p>`;
    }
}

// ====== ALERTES ======

async function loadAlerts() {
    const metric = document.getElementById('alert-metric')?.value || 'cpu';
    const threshold = parseInt(document.getElementById('alert-threshold')?.value) || 80;
    const container = document.getElementById('alerts-list');
    
    try {
        const data = await performanceAPI.getAlerts(metric, threshold);
        
        if (!data.success || !data.data || data.data.length === 0) {
            container.innerHTML = `
                <div class="text-center text-gray-500 py-8">
                    <i data-lucide="check-circle" class="h-12 w-12 mx-auto mb-2 opacity-50 text-green-500"></i>
                    <p>Aucune alerte active</p>
                    <p class="text-sm mt-2">Tous les systèmes fonctionnent normalement</p>
                </div>
            `;
            lucide.createIcons();
            return;
        }
        
        container.innerHTML = `
            <div class="space-y-4">
                ${data.data.map(alert => {
                    const severity = alert.value > threshold * 1.5 ? 'critical' : alert.value > threshold * 1.2 ? 'high' : 'medium';
                    const severityColor = severity === 'critical' ? 'red' : severity === 'high' ? 'orange' : 'yellow';
                    const severityLabel = severity === 'critical' ? 'Critique' : severity === 'high' ? 'Élevé' : 'Moyen';
                    
                    return `
                        <div class="flex items-center p-4 bg-${severityColor}-50 border-l-4 border-${severityColor}-500 rounded-r-lg">
                            <div class="flex-shrink-0">
                                <i data-lucide="alert-triangle" class="h-8 w-8 text-${severityColor}-600"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <h4 class="font-semibold text-gray-900">
                                    ${alert.volunteer_id || alert.task_id || 'Système'}
                                </h4>
                                <p class="text-sm text-gray-700">
                                    ${metric.toUpperCase()}: ${alert.value.toFixed(1)}${metric === 'cpu' || metric === 'memory' ? '%' : ''}
                                    (Seuil: ${threshold}${metric === 'cpu' || metric === 'memory' ? '%' : ''})
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    ${new Date(alert.timestamp).toLocaleString('fr-FR')}
                                </p>
                            </div>
                            <div class="ml-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-${severityColor}-100 text-${severityColor}-800">
                                    ${severityLabel}
                                </span>
                            </div>
                        </div>
                    `;
                }).join('')}
            </div>
        `;
        
        lucide.createIcons();
        
    } catch (error) {
        console.error('Erreur chargement alertes:', error);
        showNotification('❌ Erreur de chargement des alertes', 'error');
        container.innerHTML = `
            <div class="text-center text-red-500 py-8">
                <i data-lucide="alert-circle" class="h-12 w-12 mx-auto mb-2"></i>
                <p>Erreur de chargement des alertes</p>
            </div>
        `;
        lucide.createIcons();
    }
}

// ====== UTILITAIRES ======

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${
        type === 'success' ? 'bg-green-500' :
        type === 'error' ? 'bg-red-500' :
        'bg-blue-500'
    } text-white`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
