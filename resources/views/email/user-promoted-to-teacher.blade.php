<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.7/dist/flowbite.min.css" />
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen">
            <!-- Page Content -->
            <main class="p-20">
                <div class="mt-4 p-4 max-w-lg text-center space-y-4 bg-white rounded-lg border shadow-md sm:p-8 dark:bg-gray-800 dark:border-gray-700 mx-auto">
                    <h5 class="text-4xl font-bold whitespace-nowrap text-gray-800">GTV</h5>
                    <p class="text-base text-gray-700 sm:text-lg dark:text-gray-400 font-bold">Promotion Announcement</p>
                    <div class="space-y-1">
                        <h1 class="text-4xl font-bold text-gray-800 mb-6 dark:text-white">Congratulations, {{ $user->name }}!</h1>
                        <p class="text-base text-gray-700 sm:text-lg dark:text-gray-400 mb-6">You have been promoted to a Teacher. We are excited to see what you will bring to our community.</p>
                        <p class="text-base text-gray-700 sm:text-lg dark:text-gray-400">Best regards,<br>The Administration Team</p>
                    </div>
                </div>
            </main>
        </div>

        <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
    </body>
</html>