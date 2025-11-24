
class PerformanceAPI {
    constructor(baseURL = 'http://127.0.0.1:5000/api/performance') {
        this.baseURL = baseURL;
    }

    /**
     * Méthode générique pour les appels API
     */
    async fetch(endpoint, options = {}) {
        try {
            const response = await fetch(`${this.baseURL}${endpoint}`, {
                headers: {
                    'Content-Type': 'application/json',
                    ...options.headers
                },
                ...options
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            return await response.json();
        } catch (error) {
            console.error('Performance API Error:', error);
            throw error;
        }
    }

    

    /**
     * Récupérer les performances d'un volontaire spécifique
     * @param {string} volunteerId - ID du volontaire (ex: 'vol_009')
     */
    async getVolunteerPerformances(volunteerId) {
        return this.fetch(`/volunteers/${volunteerId}`);
    }

    /**
     * Récupérer le rapport de performances pour une période
     * @param {object} params - Paramètres de filtrage
     * @param {string} params.start_date - Date de début (format: YYYY-MM-DD)
     * @param {string} params.end_date - Date de fin (format: YYYY-MM-DD)
     * @param {string} params.period - Période ('day', 'week', 'month')
     */
    async getPerformanceReport(params = {}) {
        const queryParams = new URLSearchParams();
        
        if (params.start_date) queryParams.append('start_date', params.start_date);
        if (params.end_date) queryParams.append('end_date', params.end_date);
        if (params.period) queryParams.append('period', params.period);
        
        const queryString = queryParams.toString();
        return this.fetch(`/report${queryString ? '?' + queryString : ''}`);
    }

    /**
     * Récupérer les statistiques de performances des tâches
     */
    async getTaskPerformanceStats(params = {}) {
        const queryParams = new URLSearchParams();
        
        if (params.start_date) queryParams.append('start_date', params.start_date);
        if (params.end_date) queryParams.append('end_date', params.end_date);
        
        const queryString = queryParams.toString();
        return this.fetch(`/tasks/stats${queryString ? '?' + queryString : ''}`);
    }

    /**
     * Identifier les tâches lentes
     * @param {number} threshold - Seuil en secondes
     */
    async getSlowTasks(threshold = 60) {
        return this.fetch(`/tasks/slow?threshold=${threshold}`);
    }

    /**
     * Classer les volontaires par performances
     * @param {string} sortBy - Critère de tri ('cpu', 'memory', 'tasks', 'performance_score')
     * @param {number} limit - Nombre de résultats
     */
    async rankVolunteersByPerformance(sortBy = 'performance_score', limit = 10) {
        return this.fetch(`/volunteers/ranking?sort_by=${sortBy}&limit=${limit}`);
    }

    /**
     * Récupérer les alertes basées sur un seuil
     * @param {string} metric - Métrique ('cpu', 'memory', 'execution_time')
     * @param {number} threshold - Valeur seuil
     */
    async getAlerts(metric = 'cpu', threshold = 80) {
        return this.fetch(`/alerts?metric=${metric}&threshold=${threshold}`);
    }

    /**
     * Récupérer toutes les performances (endpoint supposé)
     */
    async getAllPerformances(params = {}) {
        const queryParams = new URLSearchParams();
        
        if (params.period) queryParams.append('period', params.period);
        if (params.limit) queryParams.append('limit', params.limit);
        if (params.offset) queryParams.append('offset', params.offset);
        
        const queryString = queryParams.toString();
        return this.fetch(`/${queryString ? '?' + queryString : ''}`);
    }

    /**
     * Récupérer les statistiques globales
     */
    async getGlobalStats(period = 'week') {
        return this.fetch(`/stats?period=${period}`);
    }

    /**
     * Récupérer l'historique de performances d'un volontaire
     * @param {string} volunteerId - ID du volontaire
     * @param {string} period - Période ('day', 'week', 'month')
     */
    async getVolunteerHistory(volunteerId, period = 'week') {
        return this.fetch(`/volunteers/${volunteerId}/history?period=${period}`);
    }

    /**
     * Comparer les performances de plusieurs volontaires
     * @param {array} volunteerIds - Liste des IDs de volontaires
     */
    async compareVolunteers(volunteerIds) {
        return this.fetch(`/volunteers/compare`, {
            method: 'POST',
            body: JSON.stringify({ volunteer_ids: volunteerIds })
        });
    }

    /**
     * Récupérer les tendances de performances
     * @param {string} metric - Métrique ('cpu', 'memory', 'tasks')
     * @param {string} period - Période
     */
    async getPerformanceTrends(metric = 'cpu', period = 'week') {
        return this.fetch(`/trends?metric=${metric}&period=${period}`);
    }
}

// Export pour utilisation globale
const performanceAPI = new PerformanceAPI();
