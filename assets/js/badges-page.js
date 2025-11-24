// Gestion de la page badges.php

// Variables globales
let currentTab = 'winners';

// Initialisation au chargement
document.addEventListener('DOMContentLoaded', function() {
    console.log('🏆 Page Badges initialisée');
    loadAllBadgesData();
});

// Charger toutes les données
async function loadAllBadgesData() {
    await Promise.all([
        loadVolunteersOfPeriod(),
        loadTopPerformers(),
        loadLeaderboard(),
        loadRecentBadges(),
        loadStatistics()
    ]);
}

// Rafraîchir les données
async function refreshBadges() {
    showNotification('🔄 Actualisation en cours...', 'info');
    await loadAllBadgesData();
    showNotification('✅ Données actualisées !', 'success');
}

// ====== ONGLETS ======

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
}

// ====== VOLONTAIRES DE LA PÉRIODE ======

async function loadVolunteersOfPeriod() {
    try {
        // Volontaire de la semaine
        const weekData = await badgesAPI.getVolunteerOfWeek();
        displayVolunteerCard('volunteer-week-card', weekData, 'from-blue-500 to-blue-600');
        
        // Volontaire du mois
        const monthData = await badgesAPI.getVolunteerOfMonth();
        displayVolunteerCard('volunteer-month-card', monthData, 'from-purple-500 to-purple-600');
        
        // Volontaire de l'année
        const yearData = await badgesAPI.getVolunteerOfYear();
        displayVolunteerCard('volunteer-year-card', yearData, 'from-yellow-500 to-yellow-600');
        
    } catch (error) {
        console.error('Erreur chargement volontaires période:', error);
        showNotification('❌ Erreur de chargement des volontaires de la période', 'error');
    }
}

function displayVolunteerCard(cardId, data, gradientClass) {
    const card = document.getElementById(cardId);
    const contentDiv = card.querySelector('.p-6');
    
    if (!data.success || !data.data.volunteer) {
        contentDiv.innerHTML = `
            <div class="text-center text-gray-500 py-8">
                <i data-lucide="info" class="h-12 w-12 mx-auto mb-2 opacity-50"></i>
                <p>Aucun volontaire pour cette période</p>
            </div>
        `;
        lucide.createIcons();
        return;
    }
    
    const volunteer = data.data.volunteer;
    
    contentDiv.innerHTML = `
        <div class="text-center">
            <div class="bg-gradient-to-r ${gradientClass} text-white rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4 text-3xl font-bold">
                ${volunteer.name.charAt(0)}
            </div>
            <h4 class="text-lg font-bold text-gray-900 mb-2">${volunteer.name}</h4>
            <p class="text-sm text-gray-600 mb-4">${volunteer.volunteer_id}</p>
            
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Tâches:</span>
                    <span class="font-semibold">${volunteer.tasks_completed || 0}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Score:</span>
                    <span class="font-semibold">${(volunteer.performance_score || 0).toFixed(1)}%</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Raison:</span>
                    <span class="font-semibold text-xs">${data.data.reason || 'Meilleur contributeur'}</span>
                </div>
            </div>
            
            <button onclick="viewVolunteerDetails('${volunteer.volunteer_id}')" 
                    class="mt-4 w-full bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                Voir le profil
            </button>
        </div>
    `;
    
    lucide.createIcons();
}

// ====== TOP PERFORMERS ======

async function loadTopPerformers() {
    const category = document.getElementById('category-filter')?.value || 'all';
    
    try {
        const data = await badgesAPI.getTopPerformers(category, 10);
        displayTopPerformers(data);
    } catch (error) {
        console.error('Erreur chargement top performers:', error);
        showNotification('❌ Erreur de chargement des top performers', 'error');
    }
}

function displayTopPerformers(data) {
    const container = document.getElementById('top-performers-list');
    
    if (!data.success || !data.data.performers || data.data.performers.length === 0) {
        container.innerHTML = `
            <div class="text-center text-gray-500 py-8">
                <i data-lucide="users" class="h-12 w-12 mx-auto mb-2 opacity-50"></i>
                <p>Aucun performer pour cette catégorie</p>
            </div>
        `;
        lucide.createIcons();
        return;
    }
    
    const performers = data.data.performers;
    
    container.innerHTML = `
        <div class="space-y-3">
            ${performers.map((performer, index) => `
                <div class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 rounded-full ${getRankColor(index + 1)} flex items-center justify-center text-white font-bold text-lg">
                            ${index + 1}
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h4 class="font-semibold text-gray-900">${performer.volunteer.name}</h4>
                        <p class="text-sm text-gray-600">${performer.volunteer.volunteer_id}</p>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-primary">${performer.metric_value.toFixed(1)}</div>
                        <div class="text-xs text-gray-600">${data.data.category_label || 'Score'}</div>
                    </div>
                    <button onclick="viewVolunteerDetails('${performer.volunteer.volunteer_id}')" 
                            class="ml-4 text-primary hover:text-blue-700">
                        <i data-lucide="chevron-right" class="h-5 w-5"></i>
                    </button>
                </div>
            `).join('')}
        </div>
    `;
    
    lucide.createIcons();
}

// ====== LEADERBOARD ======

async function loadLeaderboard() {
    const period = document.getElementById('period-filter')?.value || 'all';
    
    try {
        const data = await badgesAPI.getLeaderboard(period, 20);
        displayLeaderboard(data);
    } catch (error) {
        console.error('Erreur chargement leaderboard:', error);
        showNotification('❌ Erreur de chargement du classement', 'error');
    }
}

function displayLeaderboard(data) {
    const container = document.getElementById('leaderboard-table');
    
    if (!data.success || !data.data.leaderboard || data.data.leaderboard.length === 0) {
        container.innerHTML = `
            <div class="text-center text-gray-500 py-8">
                <i data-lucide="bar-chart" class="h-12 w-12 mx-auto mb-2 opacity-50"></i>
                <p>Aucune donnée de classement disponible</p>
            </div>
        `;
        lucide.createIcons();
        return;
    }
    
    const leaderboard = data.data.leaderboard;
    
    container.innerHTML = `
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rang</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Volontaire</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tâches</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Performance</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Score</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    ${leaderboard.map((entry, index) => `
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="text-lg font-bold ${getRankTextColor(entry.rank)}">#${entry.rank}</span>
                                    ${entry.rank <= 3 ? `<span class="ml-2">${getRankEmoji(entry.rank)}</span>` : ''}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold">
                                        ${entry.volunteer.name.charAt(0)}
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">${entry.volunteer.name}</div>
                                        <div class="text-sm text-gray-500">${entry.volunteer.volunteer_id}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold">${entry.volunteer.tasks_completed || 0}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold">${(entry.volunteer.performance_score || 0).toFixed(1)}%</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-lg font-bold text-primary">${entry.composite_score.toFixed(1)}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <button onclick="viewVolunteerDetails('${entry.volunteer.volunteer_id}')" 
                                        class="text-primary hover:text-blue-700 font-medium">
                                    Voir profil
                                </button>
                            </td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        </div>
        
        <div class="mt-4 text-center text-sm text-gray-600">
            <p>Total: ${data.data.total_volunteers} volontaires | Période: ${data.data.period}</p>
        </div>
    `;
    
    lucide.createIcons();
}

// ====== BADGES RÉCENTS ======

async function loadRecentBadges() {
    const hours = document.getElementById('hours-filter')?.value || 24;
    
    try {
        const data = await badgesAPI.getRecentBadges(hours, 20);
        displayRecentBadges(data);
    } catch (error) {
        console.error('Erreur chargement badges récents:', error);
        showNotification('❌ Erreur de chargement des badges récents', 'error');
    }
}

function displayRecentBadges(data) {
    const container = document.getElementById('recent-badges-list');
    
    if (!data.success || !data.data.badges || data.data.badges.length === 0) {
        container.innerHTML = `
            <div class="text-center text-gray-500 py-8">
                <i data-lucide="award" class="h-12 w-12 mx-auto mb-2 opacity-50"></i>
                <p>Aucun badge attribué récemment</p>
            </div>
        `;
        lucide.createIcons();
        return;
    }
    
    const badges = data.data.badges;
    
    container.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            ${badges.map(badge => `
                <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 text-4xl mr-4">
                            ${badge.badge.icon || '🏆'}
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900">${badge.badge.name}</h4>
                            <p class="text-sm text-gray-600 mb-2">${badge.badge.description || ''}</p>
                            <div class="flex items-center text-xs text-gray-500">
                                <i data-lucide="user" class="h-3 w-3 mr-1"></i>
                                <span>${badge.volunteer_id}</span>
                                <span class="mx-2">•</span>
                                <i data-lucide="clock" class="h-3 w-3 mr-1"></i>
                                <span>${formatDate(badge.earned_date)}</span>
                            </div>
                            ${badge.reason ? `<p class="mt-2 text-xs text-gray-700 italic">${badge.reason}</p>` : ''}
                        </div>
                    </div>
                </div>
            `).join('')}
        </div>
        
        <div class="mt-4 text-center text-sm text-gray-600">
            <p>${badges.length} badge(s) attribué(s) dans les ${data.data.period}</p>
        </div>
    `;
    
    lucide.createIcons();
}

// ====== STATISTIQUES ======

async function loadStatistics() {
    try {
        const data = await badgesAPI.getBadgesStatistics();
        displayStatistics(data);
    } catch (error) {
        console.error('Erreur chargement statistiques:', error);
        showNotification('❌ Erreur de chargement des statistiques', 'error');
    }
}

function displayStatistics(data) {
    if (!data.success) return;
    
    const stats = data.data;
    
    // Stats globales
    const globalStatsContainer = document.getElementById('global-stats');
    globalStatsContainer.innerHTML = `
        <div class="space-y-4">
            <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                <span class="text-gray-700">Total Badges Attribués</span>
                <span class="text-2xl font-bold text-primary">${stats.total_attributions || 0}</span>
            </div>
            
            ${stats.by_period && Object.keys(stats.by_period).length > 0 ? `
                <div>
                    <h4 class="font-semibold text-gray-700 mb-2">Par Période</h4>
                    ${Object.entries(stats.by_period).map(([period, count]) => `
                        <div class="flex justify-between items-center p-2">
                            <span class="text-sm text-gray-600">${period}</span>
                            <span class="font-semibold">${count}</span>
                        </div>
                    `).join('')}
                </div>
            ` : ''}
            
            ${stats.by_category && Object.keys(stats.by_category).length > 0 ? `
                <div>
                    <h4 class="font-semibold text-gray-700 mb-2">Par Catégorie</h4>
                    ${Object.entries(stats.by_category).map(([category, count]) => `
                        <div class="flex justify-between items-center p-2">
                            <span class="text-sm text-gray-600">${category}</span>
                            <span class="font-semibold">${count}</span>
                        </div>
                    `).join('')}
                </div>
            ` : ''}
        </div>
    `;
    
    // Top volontaires badgés
    const topBadgedContainer = document.getElementById('top-badged');
    if (stats.top_volunteers && stats.top_volunteers.length > 0) {
        topBadgedContainer.innerHTML = `
            <div class="space-y-2">
                ${stats.top_volunteers.slice(0, 5).map((vol, index) => `
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <span class="w-8 h-8 rounded-full ${getRankColor(index + 1)} text-white flex items-center justify-center text-sm font-bold mr-3">
                                ${index + 1}
                            </span>
                            <span class="font-medium text-gray-900">${vol.volunteer_id}</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-2xl font-bold text-primary mr-2">${vol.badge_count}</span>
                            <i data-lucide="award" class="h-5 w-5 text-yellow-500"></i>
                        </div>
                    </div>
                `).join('')}
            </div>
        `;
    } else {
        topBadgedContainer.innerHTML = `
            <div class="text-center text-gray-500 py-8">
                <i data-lucide="users" class="h-12 w-12 mx-auto mb-2 opacity-50"></i>
                <p>Aucune donnée disponible</p>
            </div>
        `;
    }
    
    lucide.createIcons();
}

// ====== FONCTIONS UTILITAIRES ======

function getRankColor(rank) {
    if (rank === 1) return 'bg-yellow-500';
    if (rank === 2) return 'bg-gray-400';
    if (rank === 3) return 'bg-orange-600';
    return 'bg-primary';
}

function getRankTextColor(rank) {
    if (rank === 1) return 'text-yellow-600';
    if (rank === 2) return 'text-gray-600';
    if (rank === 3) return 'text-orange-600';
    return 'text-primary';
}

function getRankEmoji(rank) {
    if (rank === 1) return '🥇';
    if (rank === 2) return '🥈';
    if (rank === 3) return '🥉';
    return '';
}

function formatDate(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diff = now - date;
    
    const minutes = Math.floor(diff / 60000);
    const hours = Math.floor(diff / 3600000);
    const days = Math.floor(diff / 86400000);
    
    if (minutes < 60) return `Il y a ${minutes}min`;
    if (hours < 24) return `Il y a ${hours}h`;
    if (days < 7) return `Il y a ${days}j`;
    
    return date.toLocaleDateString('fr-FR');
}

function viewVolunteerDetails(volunteerId) {
    window.location.href = `volunteer-details.php?id=${volunteerId}`;
}

function showNotification(message, type = 'info') {
    // Créer une notification toast
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