// Service pour gérer les appels API Badges
class BadgesAPI {
    constructor(baseURL = 'http://localhost:5000/api') {
        this.baseURL = baseURL;
    }

    // Méthode générique pour les appels API
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
            console.error('API Error:', error);
            throw error;
        }
    }

    // ====== ENDPOINTS BADGES ======

    // Volontaire de la période
    async getVolunteerOfWeek() {
        return this.fetch('/badges/volunteer-of-week');
    }

    async getVolunteerOfMonth() {
        return this.fetch('/badges/volunteer-of-month');
    }

    async getVolunteerOfYear() {
        return this.fetch('/badges/volunteer-of-year');
    }

    // Leaderboard
    async getLeaderboard(period = 'all', limit = 10) {
        return this.fetch(`/badges/leaderboard?period=${period}&limit=${limit}`);
    }

    // Top Performers
    async getTopPerformers(category = 'all', limit = 10) {
        return this.fetch(`/badges/top-performers?category=${category}&limit=${limit}`);
    }

    // Badges d'un volontaire
    async getVolunteerBadges(volunteerId) {
        return this.fetch(`/badges/volunteer/${volunteerId}/badges`);
    }

    // ====== ENDPOINTS BADGES ATTRIBUÉS ======

    // Tous les badges attribués
    async getAttributedBadges(filters = {}) {
        const params = new URLSearchParams();
        
        if (filters.period) params.append('period', filters.period);
        if (filters.volunteer_id) params.append('volunteer_id', filters.volunteer_id);
        if (filters.badge_id) params.append('badge_id', filters.badge_id);
        if (filters.limit) params.append('limit', filters.limit);
        if (filters.offset) params.append('offset', filters.offset);

        const queryString = params.toString();
        return this.fetch(`/badges/attributed${queryString ? '?' + queryString : ''}`);
    }

    // Badges attribués à un volontaire
    async getVolunteerAttributedBadges(volunteerId, includeRevoked = false) {
        return this.fetch(`/badges/volunteer/${volunteerId}/attributed?include_revoked=${includeRevoked}`);
    }

    // Badges récents
    async getRecentBadges(hours = 24, limit = 20) {
        return this.fetch(`/badges/attributed/recent?hours=${hours}&limit=${limit}`);
    }

    // Statistiques
    async getBadgesStatistics() {
        return this.fetch('/badges/attributed/statistics');
    }

    // Détails d'une attribution
    async getAttributionDetails(attributionId) {
        return this.fetch(`/badges/attributed/${attributionId}`);
    }
}

// Export pour utilisation
const badgesAPI = new BadgesAPI();