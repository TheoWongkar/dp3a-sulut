<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-[#141652] font-sans">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div x-show="sidebarOpen" class="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden" @click="sidebarOpen = false">
        </div>
        <aside
            class="fixed inset-y-0 z-30 w-64 bg-[#141652] shadow-md lg:static lg:shadow-none lg:translate-x-0 transform transition-transform duration-300"
            :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">
            <div class="py-4 flex items-center gap-2 justify-center">
                <x-application-logo class="size-14"></x-application-logo>
                <div>
                    <h1 class="text-3xl font-bold text-white leading-none items-center">
                        DP3A <span class="block text-lg font-semibold text-gray-500">Sulawesi Utara</span>
                    </h1>
                </div>
            </div>
            <nav class="flex-1 p-4">
                <a href="#"
                    class="block px-4 py-1.5 text-gray-600 rounded hover:bg-gray-200 hover:text-gray-900">Dashboard</a>
                <a href="#"
                    class="block px-4 py-1.5 text-gray-600 rounded hover:bg-gray-200 hover:text-gray-900">Users</a>
                <a href="#"
                    class="block px-4 py-1.5 text-gray-600 rounded hover:bg-gray-200 hover:text-gray-900">Settings</a>
                <a href="#"
                    class="block px-4 py-1.5 text-gray-600 rounded hover:bg-gray-200 hover:text-gray-900">Reports</a>
            </nav>
        </aside>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="flex items-center justify-between px-4 py-2 bg-white shadow">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 lg:hidden focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
                <h2 class="text-xl font-bold text-gray-700">Dashboard</h2>
                <div class="flex items-center space-x-4">
                    <button class="p-2 text-gray-500 bg-gray-100 rounded-full focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-9.33-5.373M9 21h6a2 2 0 002-2v-1a6 6 0 00-6-6H9">
                            </path>
                        </svg>
                    </button>
                    <img src="https://via.placeholder.com/32" alt="Profile" class="w-8 h-8 rounded-full">
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 p-4 overflow-y-auto">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4 mb-6">
                    <div class="p-4 bg-white shadow rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500">Total Users</h3>
                        <p class="text-2xl font-bold text-gray-900">1,234</p>
                    </div>
                    <div class="p-4 bg-white shadow rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500">Active Users</h3>
                        <p class="text-2xl font-bold text-gray-900">567</p>
                    </div>
                    <div class="p-4 bg-white shadow rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500">New Signups</h3>
                        <p class="text-2xl font-bold text-gray-900">45</p>
                    </div>
                    <div class="p-4 bg-white shadow rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500">Revenue</h3>
                        <p class="text-2xl font-bold text-gray-900">$12,345</p>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="bg-white shadow rounded-lg p-4">
                    <h3 class="text-lg font-bold text-gray-700 mb-4">Recent Transactions</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th
                                        class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">
                                        #</th>
                                    <th
                                        class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">
                                        Name</th>
                                    <th
                                        class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">
                                        Date</th>
                                    <th
                                        class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">
                                        Amount</th>
                                    <th
                                        class="border border-gray-300 px-4 py-2 text-left text-sm font-medium text-gray-700">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">1</td>
                                    <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">John Doe</td>
                                    <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">2025-01-01</td>
                                    <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">$500</td>
                                    <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">Completed</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">2</td>
                                    <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">Jane Smith</td>
                                    <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">2025-01-02</td>
                                    <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">$300</td>
                                    <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">Pending</td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">3</td>
                                    <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">Alice Brown</td>
                                    <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">2025-01-03</td>
                                    <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">$700</td>
                                    <td class="border border-gray-300 px-4 py-2 text-sm text-gray-700">Failed</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>
