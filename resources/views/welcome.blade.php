<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sepakat-AI - Landing Page</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom scrollbar for services cards if needed on desktop */
        .services-scroll::-webkit-scrollbar {
            height: 6px;
        }

        .services-scroll::-webkit-scrollbar-thumb {
            background-color: #4f46e5;
            border-radius: 9999px;
        }

        .services-scroll {
            scrollbar-width: thin;
            scrollbar-color: #4f46e5 transparent;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 font-sans leading-relaxed">

    <!-- Hero Section -->
    <section
        class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-tr from-indigo-600 via-purple-700 to-pink-600 px-6 text-center text-white">
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold mb-4 drop-shadow-lg">Sepakat-AI</h1>
        <p class="max-w-2xl text-lg sm:text-xl md:text-2xl font-light mb-8 drop-shadow-md">
            Sistem Evaluasi dan Pendampingan Kolaboratif dengan AI
        </p>
        <div class="flex gap-3">
            <a href="#register"
                class="inline-block bg-white text-indigo-700 font-semibold rounded-lg px-8 py-3 shadow-lg hover:bg-indigo-100 transition">
                Daftar Sekarang
            </a>
            <a href="/admin" class="bg-black hover:bg-white hover:text-black text-white px-8 py-2 rounded-md">
                Masuk
            </a>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-16 px-6 max-w-5xl mx-auto">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-900">Layanan Unggulan Sepakat-AI</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">

            <div
                class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center text-center hover:shadow-xl transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-indigo-600 mb-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 11c0 2-1.5 4.5-4 4.5S4 13 4 11a4 4 0 018 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 9v1m0 2v.5a1.5 1.5 0 003 0V11a1.5 1.5 0 00-3 0zM13 12H8m9 6v.25a2.25 2.25 0 01-4.5 0V18m2.25-8v.-1" />
                </svg>
                <h3 class="text-xl font-semibold mb-2 text-gray-900">Evaluasi Otomatis</h3>
                <p class="text-gray-600 text-sm">AI membantu evaluasi performa secara cepat dan objektif.</p>
            </div>

            <div
                class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center text-center hover:shadow-xl transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-indigo-600 mb-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 12v3m-6 1h12m-6-5v.01M12 4v2m0 0v6m0 0h.01" />
                </svg>
                <h3 class="text-xl font-semibold mb-2 text-gray-900">Pendampingan Kolaboratif</h3>
                <p class="text-gray-600 text-sm">Memfasilitasi kerja sama tim dengan bimbingan AI yang cerdas.</p>
            </div>

            <div
                class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center text-center hover:shadow-xl transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-indigo-600 mb-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13 16h-1v-4h-1m6 0h1v4h-1m-6 0H7v-4H6m8 4v-4m-6 4v-4" />
                </svg>
                <h3 class="text-xl font-semibold mb-2 text-gray-900">Rekomendasi Berbasis Data</h3>
                <p class="text-gray-600 text-sm">AI memberikan solusi dan saran berdasarkan analisis data real-time.</p>
            </div>

            <div
                class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center text-center hover:shadow-xl transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-indigo-600 mb-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14v7" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 21c-2.76 0-5-1.79-5-4V8l5 3 5-3v9c0 2.21-2.24 4-5 4z" />
                </svg>
                <h3 class="text-xl font-semibold mb-2 text-gray-900">Keamanan Data Terjamin</h3>
                <p class="text-gray-600 text-sm">Menjamin kerahasiaan dan keamanan informasi Anda dengan teknologi
                    terkini.</p>
            </div>

        </div>
    </section>

    <!-- Register Section -->
    <livewire:components.create-user-home />

    <footer class="text-center py-6 text-gray-500 text-sm">
        &copy; 2024 Sepakat-AI. All rights reserved.
    </footer>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('success-notif', (message) => {
                Toastify({
                    text: message.message,
                    duration: 3000,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    style: {
                        background: "linear-gradient(to right, #00b09b, #96c93d)",
                    }, // Callback after click
                }).showToast();
            });
            Livewire.on('error-notif', (message) => {
                Toastify({
                    text: message.message,
                    duration: 3000,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    style: {
                        background: "linear-gradient(to right, #ff6f91, #ff807d, #ff966d, #ffae61, #ffc75f)",
                    }, // Callback after click
                }).showToast();
            });
        });
    </script>
</body>

</html>
</content>
</create_file>
