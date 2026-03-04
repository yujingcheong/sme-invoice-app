<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio - <!-- REPLACE_WITH: Your Name --></title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-20">
        <div class="max-w-4xl mx-auto px-6">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                <!-- REPLACE_WITH: Your Full Name -->
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 mb-6">
                Business Systems Developer | Laravel Specialist
            </p>
            <p class="text-lg text-blue-50 max-w-2xl">
                I help Singapore SMEs digitalize manual workflows by building custom internal tools — invoice systems, inventory trackers, booking platforms, and CRMs that save time and reduce errors.
            </p>
        </div>
    </div>

    <!-- Demo Project Section -->
    <div class="max-w-4xl mx-auto px-6 py-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">Featured Project: SME Invoice Management System</h2>
        
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-12">
            <div class="md:flex">
                <div class="md:w-1/2 bg-gray-200 flex items-center justify-center p-8">
                    <!-- Placeholder for screenshot -->
                    <div class="text-center text-gray-500">
                        <svg class="w-24 h-24 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-sm">Invoice Management System</p>
                    </div>
                </div>
                <div class="md:w-1/2 p-8">
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">What It Does</h3>
                    <ul class="space-y-3 text-gray-700">
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span><strong>Generate invoices & quotations</strong> with automatic GST calculation (9% for Singapore)</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span><strong>Download professional PDFs</strong> instantly — no more manual formatting</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span><strong>Track payment status</strong> (draft, sent, paid) in one centralized dashboard</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span><strong>Convert quotations to invoices</strong> with one click — zero data re-entry</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span><strong>Customer database</strong> with search and history of all transactions</span>
                        </li>
                    </ul>
                    
                    @auth
                    <div class="mt-6">
                        <a href="{{ route('dashboard') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                            View Full Demo (You're Logged In)
                        </a>
                    </div>
                    @else
                    <div class="mt-6">
                        <a href="{{ route('register') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                            Try the Demo (Free Registration)
                        </a>
                    </div>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Tech Stack Section -->
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">Technical Skills</h2>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Backend Development</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-blue-600 rounded-full mr-3"></span>
                            PHP 8.x & Laravel 11/12 (advanced)
                        </li>
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-blue-600 rounded-full mr-3"></span>
                            Livewire 4 (reactive components)
                        </li>
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-blue-600 rounded-full mr-3"></span>
                            PostgreSQL, MySQL, SQLite
                        </li>
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-blue-600 rounded-full mr-3"></span>
                            RESTful API design
                        </li>
                    </ul>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Frontend & Tools</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-blue-600 rounded-full mr-3"></span>
                            Tailwind CSS (responsive design)
                        </li>
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-blue-600 rounded-full mr-3"></span>
                            HTML, CSS, JavaScript
                        </li>
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-blue-600 rounded-full mr-3"></span>
                            Git version control
                        </li>
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-blue-600 rounded-full mr-3"></span>
                            Docker deployment, Cloud hosting (Render, AWS)
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- What I Build Section -->
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">What I Can Build For You</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <div class="text-blue-600 mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Internal Tools</h3>
                    <p class="text-gray-600">Invoice systems, quotation managers, inventory trackers, CRM platforms</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <div class="text-blue-600 mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Booking Systems</h3>
                    <p class="text-gray-600">Appointment scheduling, resource booking, calendar management</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <div class="text-blue-600 mb-4">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Dashboards & Reports</h3>
                    <p class="text-gray-600">Revenue tracking, analytics, KPI monitoring, data visualization</p>
                </div>
            </div>
        </div>

        <!-- Contact Section -->
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg p-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Let's Work Together</h2>
            <p class="text-lg text-gray-700 mb-6 max-w-2xl mx-auto">
                I offer competitive rates vs Singapore-based developers (based in <!-- REPLACE_WITH: Malaysia or your location -->) with fast delivery and clear communication. Freelance projects start at <strong>SGD 1,500</strong>.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="mailto:<!-- REPLACE_WITH: your.email@domain.com -->" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-lg transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    Email Me
                </a>
                
                <a href="<!-- REPLACE_WITH: https://linkedin.com/in/yourprofile -->" target="_blank" class="inline-flex items-center border-2 border-blue-600 text-blue-600 hover:bg-blue-50 font-semibold px-8 py-3 rounded-lg transition">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                    LinkedIn Profile
                </a>
            </div>
            
            <p class="text-sm text-gray-600 mt-6">
                📱 WhatsApp: <!-- REPLACE_WITH: +65 XXXX XXXX or +60 XX XXXX XXXX --> | 
                🌍 Based in <!-- REPLACE_WITH: Your City, Country --> | 
                Available for remote freelance projects
            </p>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-8">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <p class="mb-2">
                Built with Laravel 12 + Livewire 4 + Tailwind CSS | Deployed on Render + Neon PostgreSQL
            </p>
            <p class="text-sm">
                © {{ date('Y') }} <!-- REPLACE_WITH: Your Name -->. All rights reserved.
            </p>
        </div>
    </footer>
</body>
</html>
