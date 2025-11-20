<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Téléchargements - VCUY1</title>
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
        .card-gradient {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .stats-gradient {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .download-gradient-blue {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        }
        .download-gradient-purple {
            background: linear-gradient(135deg, #9333ea 0%, #7e22ce 100%);
        }
        .download-gradient-green {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
        }
        .animate-pulse-slow {
            animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
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
                    <a href="downloads.php" class="text-primary font-semibold">Téléchargements</a>
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
                    <h1 class="text-3xl font-bold text-gray-900">Téléchargements</h1>
                    <p class="mt-2 text-gray-600">Choisissez l'application adaptée à votre rôle dans le système</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="bg-primary/10 px-4 py-2 rounded-lg">
                        <span class="text-sm font-semibold text-primary">3 Applications Disponibles</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- System Requirements Alert -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-6 mb-8 rounded-r-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i data-lucide="info" class="h-6 w-6 text-blue-500"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-semibold text-blue-900 mb-2">Configuration Requise</h3>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li class="flex items-center">
                            <i data-lucide="check-circle" class="h-4 w-4 mr-2"></i>
                            Python 3.10 ou supérieur
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="check-circle" class="h-4 w-4 mr-2"></i>
                            Docker (pour l'isolation des tâches)
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="check-circle" class="h-4 w-4 mr-2"></i>
                            2 GB RAM minimum (4 GB recommandé)
                        </li>
                        <li class="flex items-center">
                            <i data-lucide="check-circle" class="h-4 w-4 mr-2"></i>
                            Connexion Internet stable
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Applications Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            <!-- Volunteer App -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover-lift">
                <div class="download-gradient-blue p-6 text-white">
                    <div class="flex items-center justify-center mb-4">
                        <div class="bg-white/20 rounded-full p-4">
                            <i data-lucide="laptop" class="h-12 w-12"></i>
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-center">Application Volontaire</h2>
                    <p class="text-center text-blue-100 mt-2">Pour les contributeurs</p>
                </div>
                
                <div class="p-6">
                    
                    
                    <div class="space-y-3">
                        <a href="https://github.com/VC-UY/volunteer-app-2025" 
                           target="_blank"
                           class="flex items-center justify-center w-full bg-gray-900 text-white px-4 py-3 rounded-lg font-semibold hover:bg-gray-800 transition-all shadow-md hover:shadow-lg">
                            <i data-lucide="github" class="h-5 w-5 mr-2"></i>
                            Voir sur GitHub
                        </a>
                        
                        <a href="/api/downloads/volunteer" 
                           class="flex items-center justify-center w-full bg-primary text-white px-4 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-all shadow-md hover:shadow-lg">
                            <i data-lucide="download" class="h-5 w-5 mr-2"></i>
                            Télécharger (Linux)
                        </a>
                        
                        
                    </div>
                    
                    
                </div>
            </div>

            <!-- Manager App -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover-lift">
                <div class="download-gradient-purple p-6 text-white">
                    <div class="flex items-center justify-center mb-4">
                        <div class="bg-white/20 rounded-full p-4">
                            <i data-lucide="workflow" class="h-12 w-12"></i>
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-center">Manager de Workflow</h2>
                    <p class="text-center text-purple-100 mt-2">Pour les utilisateurs</p>
                </div>
                
                <div class="p-6">
                    
                    
                    <div class="space-y-3">
                        <a href="https://github.com/VC-UY/manager-app-2025" 
                           target="_blank"
                           class="flex items-center justify-center w-full bg-gray-900 text-white px-4 py-3 rounded-lg font-semibold hover:bg-gray-800 transition-all shadow-md hover:shadow-lg">
                            <i data-lucide="github" class="h-5 w-5 mr-2"></i>
                            Voir sur GitHub
                        </a>
                        
                        <a href="/api/downloads/manager" 
                           class="flex items-center justify-center w-full bg-purple-600 text-white px-4 py-3 rounded-lg font-semibold hover:bg-purple-700 transition-all shadow-md hover:shadow-lg">
                            <i data-lucide="download" class="h-5 w-5 mr-2"></i>
                            Télécharger (Linux)
                        </a>
                        
                       
                    </div>
                    
                   
                </div>
            </div>

            <!-- Coordinator App -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover-lift">
                <div class="download-gradient-green p-6 text-white">
                    <div class="flex items-center justify-center mb-4">
                        <div class="bg-white/20 rounded-full p-4">
                            <i data-lucide="server" class="h-12 w-12"></i>
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-center">Coordinateur</h2>
                    <p class="text-center text-green-100 mt-2">Pour les administrateurs</p>
                </div>
                
                <div class="p-6">
                    <div class="mb-6">
                        
                    
                    <div class="space-y-3">
                        <a href="https://github.com/VC-UY/coordinator-app-2025" 
                           target="_blank"
                           class="flex items-center justify-center w-full bg-gray-900 text-white px-4 py-3 rounded-lg font-semibold hover:bg-gray-800 transition-all shadow-md hover:shadow-lg">
                            <i data-lucide="github" class="h-5 w-5 mr-2"></i>
                            Voir sur GitHub
                        </a>
                        
                        <a href="/api/downloads/coordinator" 
                           class="flex items-center justify-center w-full bg-green-600 text-white px-4 py-3 rounded-lg font-semibold hover:bg-green-700 transition-all shadow-md hover:shadow-lg">
                            <i data-lucide="download" class="h-5 w-5 mr-2"></i>
                            Télécharger (Linux)
                        </a>
                        
                       
                    </div>
                    
                   
                </div>
            </div>
        </div>

        
        

        
        
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center mb-4">
                        <i data-lucide="cpu" class="h-8 w-8 text-primary mr-2"></i>
                        <span class="text-xl font-bold">VCUY1</span>
                    </div>
                    <p class="text-gray-400">
                        Système de calcul distribué volontaire développé à l'Université de Yaoundé I.
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Navigation</h3>
                    <ul class="space-y-2">
                        <li><a href="#accueil" class="text-gray-400 hover:text-white transition-colors">Accueil</a></li>
                        <li><a href="dashboard.php" class="text-gray-400 hover:text-white transition-colors">Tableau de bord</a></li>
                        <li><a href="volunteers.php" class="text-gray-400 hover:text-white transition-colors">Volontaires</a></li>
                        <li><a href="analytics.php" class="text-gray-400 hover:text-white transition-colors">Analyses</a></li>
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

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
    </script>
</body>
</html>