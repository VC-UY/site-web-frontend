// Real-time data management for VCUY1 website

class RealTimeManager {
    constructor() {
        this.apiBase = 'http://localhost:5000/api';
        this.updateInterval = 30000; // 30 seconds
        this.charts = {};
        this.lastUpdate = null;
        this.isConnected = true;
        this.retryCount = 0;
        this.maxRetries = 3;
        
        this.init();
    }
    
    init() {
        this.startPeriodicUpdates();
        this.setupConnectionMonitoring();
        this.setupVisibilityHandling();
    }
    
    // Start periodic data updates
    startPeriodicUpdates() {
        this.updateData();
        this.intervalId = setInterval(() => {
            this.updateData();
        }, this.updateInterval);
    }
    
    // Stop periodic updates
    stopPeriodicUpdates() {
        if (this.intervalId) {
            clearInterval(this.intervalId);
            this.intervalId = null;
        }
    }
    
    // Main data update function
    async updateData() {
        if (!this.isConnected && this.retryCount >= this.maxRetries) {
            console.log('Max retries reached, stopping updates');
            return;
        }
        
        try {
            await Promise.all([
                this.updateSystemMetrics(),
                this.updateVolunteers(),
                this.updateTasks(),
                this.updateAnalytics()
            ]);
            
            this.isConnected = true;
            this.retryCount = 0;
            this.lastUpdate = new Date();
            this.updateLastUpdateTime();
            
        } catch (error) {
            console.error('Error updating data:', error);
            this.handleConnectionError();
        }
    }
    
    // Update system metrics
    async updateSystemMetrics() {
        try {
            const response = await fetch(`${this.apiBase}/system-metrics`);
            const data = await response.json();
            
            if (data.success) {
                this.updateMetricsUI(data.data);
                this.notifySubscribers('metrics', data.data);
            }
        } catch (error) {
            console.error('Error fetching system metrics:', error);
            throw error;
        }
    }
    
    // Update volunteers data
    async updateVolunteers() {
        try {
            const response = await fetch(`${this.apiBase}/volunteers`);
            const data = await response.json();
            
            if (data.success) {
                this.updateVolunteersUI(data.data);
                this.notifySubscribers('volunteers', data.data);
            }
        } catch (error) {
            console.error('Error fetching volunteers:', error);
            throw error;
        }
    }
    
    // Update tasks data
    async updateTasks() {
        try {
            const response = await fetch(`${this.apiBase}/tasks?limit=10`);
            const data = await response.json();
            
            if (data.success) {
                this.updateTasksUI(data.data);
                this.notifySubscribers('tasks', data.data);
            }
        } catch (error) {
            console.error('Error fetching tasks:', error);
            throw error;
        }
    }
    
    // Update analytics data
    async updateAnalytics() {
        try {
            const [performanceResponse, costResponse] = await Promise.all([
                fetch(`${this.apiBase}/analytics/performance-history?days=1`),
                fetch(`${this.apiBase}/analytics/cost-savings`)
            ]);
            
            const performanceData = await performanceResponse.json();
            const costData = await costResponse.json();
            
            if (performanceData.success) {
                this.updatePerformanceChart(performanceData.data);
            }
            
            if (costData.success) {
                this.updateCostAnalytics(costData.data);
            }
        } catch (error) {
            console.error('Error fetching analytics:', error);
            throw error;
        }
    }
    
    // Update metrics UI elements
    updateMetricsUI(metrics) {
        const elements = {
            'active-volunteers': metrics.active_volunteers,
            'total-volunteers': metrics.total_volunteers,
            'completed-tasks': metrics.completed_tasks?.toLocaleString(),
            'total-tasks': metrics.total_tasks?.toLocaleString(),
            'cpu-usage': Math.round(metrics.cpu_usage) + '%',
            'memory-usage': Math.round(metrics.memory_usage) + '%',
            'cost-savings': '€' + Math.round(metrics.cost_savings).toLocaleString(),
            'network-throughput': Math.round(metrics.network_throughput) + ' MB/s'
        };
        
        Object.entries(elements).forEach(([id, value]) => {
            const element = document.getElementById(id);
            if (element && value !== undefined) {
                this.animateValueChange(element, value);
            }
        });
        
        // Update progress bars
        this.updateProgressBar('cpu-bar', metrics.cpu_usage);
        this.updateProgressBar('memory-bar', metrics.memory_usage);
        this.updateProgressBar('global-cpu-bar', metrics.cpu_usage);
        this.updateProgressBar('global-memory-bar', metrics.memory_usage);
    }
    
    // Update volunteers UI
    updateVolunteersUI(volunteers) {
        const activeVolunteers = volunteers.filter(v => v.status === 'active');
        
        // Update volunteer counts
        const totalElement = document.getElementById('total-volunteers');
        const activeElement = document.getElementById('active-volunteers');
        
        if (totalElement) this.animateValueChange(totalElement, volunteers.length);
        if (activeElement) this.animateValueChange(activeElement, activeVolunteers.length);
        
        // Update volunteer list if on volunteers page
        if (window.location.pathname.includes('volunteers.php')) {
            this.updateVolunteersList(volunteers);
        }
        
        // Update dashboard volunteer list
        this.updateDashboardVolunteers(activeVolunteers.slice(0, 5));
    }
    
    // Update tasks UI
    updateTasksUI(tasks) {
        // Update task counts by status
        const statusCounts = {
            completed: tasks.filter(t => t.status === 'completed').length,
            running: tasks.filter(t => t.status === 'running').length,
            pending: tasks.filter(t => t.status === 'pending').length,
            failed: tasks.filter(t => t.status === 'failed').length
        };
        
        // Update dashboard tasks list
        this.updateDashboardTasks(tasks.slice(0, 5));
        
        // Update tasks chart if available
        if (this.charts.tasksChart) {
            this.charts.tasksChart.data.datasets[0].data = [
                statusCounts.completed,
                statusCounts.running,
                statusCounts.pending,
                statusCounts.failed
            ];
            this.charts.tasksChart.update('none');
        }
    }
    
    // Update performance chart
    updatePerformanceChart(performanceData) {
        if (!this.charts.performanceChart || !performanceData.length) return;
        
        const chart = this.charts.performanceChart;
        const latest24 = performanceData.slice(-24);
        
        const labels = latest24.map(p => 
            new Date(p.timestamp).toLocaleTimeString('fr-FR', { 
                hour: '2-digit', 
                minute: '2-digit' 
            })
        );
        
        const cpuData = latest24.map(p => p.cpu_usage);
        const memoryData = latest24.map(p => p.memory_usage);
        
        // Smooth update
        chart.data.labels = labels;
        if (window.VCUY1Animations) {
            window.VCUY1Animations.animateChartUpdate(chart, [cpuData, memoryData]);
        } else {
            chart.data.datasets[0].data = cpuData;
            chart.data.datasets[1].data = memoryData;
            chart.update('none');
        }
    }
    
    // Update cost analytics
    updateCostAnalytics(costData) {
        const elements = {
            'total-savings': '€' + Math.round(costData.total_savings).toLocaleString(),
            'savings-percentage': Math.round(costData.savings_percentage) + '%',
            'cost-per-task': '€' + costData.cost_per_task_saved.toFixed(3),
            'completed-tasks-count': costData.completed_tasks.toLocaleString(),
            'monthly-roi': Math.round(costData.savings_percentage * 2) + '%'
        };
        
        Object.entries(elements).forEach(([id, value]) => {
            const element = document.getElementById(id);
            if (element) {
                this.animateValueChange(element, value);
            }
        });
    }
    
    // Animate value changes
    animateValueChange(element, newValue) {
        const currentValue = element.textContent;
        if (currentValue !== newValue.toString()) {
            element.style.transition = 'all 0.3s ease';
            element.style.transform = 'scale(1.05)';
            element.style.color = '#10b981'; // Green color for updates
            
            setTimeout(() => {
                element.textContent = newValue;
                element.style.transform = 'scale(1)';
                element.style.color = '';
            }, 150);
        }
    }
    
    // Update progress bar
    updateProgressBar(id, percentage) {
        const bar = document.getElementById(id);
        if (bar) {
            bar.style.transition = 'width 0.5s ease';
            bar.style.width = percentage + '%';
        }
    }
    
    // Update dashboard volunteers list
    updateDashboardVolunteers(volunteers) {
        const container = document.getElementById('volunteers-list');
        if (!container) return;
        
        container.innerHTML = volunteers.map(volunteer => `
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover-card">
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
        if (window.lucide) {
            window.lucide.createIcons();
        }
    }
    
    // Update dashboard tasks list
    updateDashboardTasks(tasks) {
        const container = document.getElementById('tasks-list');
        if (!container) return;
        
        const statusColors = {
            'completed': 'bg-green-100 text-green-800',
            'running': 'bg-blue-100 text-blue-800',
            'pending': 'bg-yellow-100 text-yellow-800',
            'failed': 'bg-red-100 text-red-800'
        };
        
        container.innerHTML = tasks.map(task => `
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover-card">
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
        `).join('');
        
        // Reinitialize icons
        if (window.lucide) {
            window.lucide.createIcons();
        }
    }
    
    // Update last update time
    updateLastUpdateTime() {
        const elements = document.querySelectorAll('#last-update');
        const timeString = this.lastUpdate.toLocaleTimeString('fr-FR');
        
        elements.forEach(element => {
            element.textContent = `Dernière mise à jour: ${timeString}`;
        });
    }
    
    // Handle connection errors
    handleConnectionError() {
        this.isConnected = false;
        this.retryCount++;
        
        // Show connection status
        this.showConnectionStatus(false);
        
        // Retry with exponential backoff
        const retryDelay = Math.min(1000 * Math.pow(2, this.retryCount), 30000);
        setTimeout(() => {
            if (this.retryCount < this.maxRetries) {
                this.updateData();
            }
        }, retryDelay);
    }
    
    // Show connection status
    showConnectionStatus(connected) {
        const statusElements = document.querySelectorAll('.connection-status');
        
        statusElements.forEach(element => {
            element.innerHTML = connected ? 
                '<i data-lucide="wifi" class="h-4 w-4 text-green-500"></i> <span class="text-green-500">Connecté</span>' :
                '<i data-lucide="wifi-off" class="h-4 w-4 text-red-500"></i> <span class="text-red-500">Déconnecté</span>';
        });
        
        if (window.lucide) {
            window.lucide.createIcons();
        }
    }
    
    // Setup connection monitoring
    setupConnectionMonitoring() {
        window.addEventListener('online', () => {
            this.isConnected = true;
            this.retryCount = 0;
            this.showConnectionStatus(true);
            this.updateData();
        });
        
        window.addEventListener('offline', () => {
            this.isConnected = false;
            this.showConnectionStatus(false);
        });
    }
    
    // Setup page visibility handling
    setupVisibilityHandling() {
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                this.stopPeriodicUpdates();
            } else {
                this.startPeriodicUpdates();
            }
        });
    }
    
    // Register chart for updates
    registerChart(name, chart) {
        this.charts[name] = chart;
    }
    
    // Subscriber pattern for custom updates
    subscribe(event, callback) {
        if (!this.subscribers) {
            this.subscribers = {};
        }
        
        if (!this.subscribers[event]) {
            this.subscribers[event] = [];
        }
        
        this.subscribers[event].push(callback);
    }
    
    // Notify subscribers
    notifySubscribers(event, data) {
        if (this.subscribers && this.subscribers[event]) {
            this.subscribers[event].forEach(callback => {
                try {
                    callback(data);
                } catch (error) {
                    console.error('Error in subscriber callback:', error);
                }
            });
        }
    }
    
    // Manual refresh
    refresh() {
        this.updateData();
    }
    
    // Cleanup
    destroy() {
        this.stopPeriodicUpdates();
        this.charts = {};
        this.subscribers = {};
    }
}

// Initialize real-time manager when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.realTimeManager = new RealTimeManager();
    
    // Add refresh button functionality
    const refreshButtons = document.querySelectorAll('[onclick="refreshData()"]');
    refreshButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            window.realTimeManager.refresh();
            
            // Visual feedback
            button.innerHTML = '<i data-lucide="loader-2" class="h-4 w-4 mr-2 inline animate-spin"></i>Actualisation...';
            
            setTimeout(() => {
                button.innerHTML = '<i data-lucide="refresh-cw" class="h-4 w-4 mr-2 inline"></i>Actualiser';
                if (window.lucide) {
                    window.lucide.createIcons();
                }
            }, 1000);
        });
    });
});

// Export for global use
window.RealTimeManager = RealTimeManager;

