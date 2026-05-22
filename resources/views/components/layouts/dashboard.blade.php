<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard | Tani Monitoring' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-900">
    <div id="sidebarOverlay" class="fixed inset-0 z-40 hidden bg-slate-950/40 lg:hidden"></div>

    <div id="dashboardShell" class="min-h-screen">
        <x-layouts.sidebar />

        <div id="contentShell" class="flex min-h-screen flex-col transition-all duration-300 lg:pl-72">
            <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 backdrop-blur">
                <div class="flex h-16 items-center justify-between px-6">
                    <div class="flex items-center gap-3">
                        <button
                            type="button"
                            id="sidebarOpenMobile"
                            class="rounded px-3 border border-slate-200 bg-white py-1 text-slate-600 shadow-sm hover:bg-slate-50 lg:hidden"
                            aria-label="Buka menu">
                            ☰
                        </button>

                        <button
                            type="button"
                            id="sidebarToggleDesktop"
                            class="hidden rounded px-4 border border-slate-200 bg-white py-1 text-slate-600 shadow-sm hover:bg-slate-50 lg:inline-flex"
                            aria-label="Toggle sidebar">
                            ☰
                        </button>

                        <div>
                            <p class="text-sm font-semibold text-slate-950">
                                {{ $title ?? 'Dashboard' }}
                            </p>
                            <p class="hidden text-xs text-slate-500 sm:block">
                                Sistem Monitoring Tanah, Air, dan Marketplace Melon
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="hidden rounded-2xl bg-slate-50 px-4 py-2 text-right ring-1 ring-slate-200 sm:block">
                            <p class="text-sm font-bold text-slate-950">
                                {{ auth()->user()->name ?? 'User' }}
                            </p>
                            <p class="text-xs capitalize text-slate-500">
                                {{ auth()->user()->role ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </header>

            @if (isset($header))
            <section class="border-b border-slate-200 bg-white">
                <div class="mx-auto max-w-7xl px-6 py-6">
                    <h1 class="text-2xl font-bold text-slate-950">
                        {{ $header }}
                    </h1>
                </div>
            </section>
            @endif

            <main class="w-full flex-1">
                <div class="mx-auto max-w-7xl px-6 py-8">
                    {{ $slot }}
                </div>
            </main>

            <x-layouts.footer />
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const contentShell = document.getElementById('contentShell');
        const overlay = document.getElementById('sidebarOverlay');
        const openMobileButton = document.getElementById('sidebarOpenMobile');
        const closeMobileButton = document.getElementById('sidebarCloseMobile');
        const toggleDesktopButton = document.getElementById('sidebarToggleDesktop');

        function openMobileSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        }

        function closeMobileSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }

        function setDesktopCollapsed(isCollapsed) {
            const labels = document.querySelectorAll('.sidebar-label');
            const userCard = document.querySelector('.sidebar-user-card');
            const brand = document.querySelector('.sidebar-brand');

            if (isCollapsed) {
                sidebar.classList.remove('lg:w-72');
                sidebar.classList.add('lg:w-24');

                contentShell.classList.remove('lg:pl-72');
                contentShell.classList.add('lg:pl-24');

                labels.forEach((label) => {
                    label.classList.add('lg:hidden');
                });

                userCard?.classList.add('lg:p-2');
                brand?.classList.add('lg:justify-center');

                localStorage.setItem('sidebar_collapsed', 'true');
            } else {
                sidebar.classList.remove('lg:w-24');
                sidebar.classList.add('lg:w-72');

                contentShell.classList.remove('lg:pl-24');
                contentShell.classList.add('lg:pl-72');

                labels.forEach((label) => {
                    label.classList.remove('lg:hidden');
                });

                userCard?.classList.remove('lg:p-2');
                brand?.classList.remove('lg:justify-center');

                localStorage.setItem('sidebar_collapsed', 'false');
            }
        }

        function toggleDesktopSidebar() {
            const isCollapsed = sidebar.classList.contains('lg:w-24');
            setDesktopCollapsed(!isCollapsed);
        }

        openMobileButton?.addEventListener('click', openMobileSidebar);
        closeMobileButton?.addEventListener('click', closeMobileSidebar);
        overlay?.addEventListener('click', closeMobileSidebar);
        toggleDesktopButton?.addEventListener('click', toggleDesktopSidebar);

        const savedSidebarState = localStorage.getItem('sidebar_collapsed') === 'true';
        setDesktopCollapsed(savedSidebarState);
    </script>
</body>

</html>