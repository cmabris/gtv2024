<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Congratulations, you are now a Teacher!</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-md max-w-lg text-center border dark:bg-gray-800 dark:border-gray-700">
            <h1 class="text-4xl font-bold text-gray-800 mb-6 dark:text-white">Congratulations, {{ $user->name }}!</h1>
            <p class="text-base text-gray-700 sm:text-lg dark:text-gray-400 mb-6">You have been promoted to a Teacher. We are excited to see what you will bring to our community.</p>
            <p class="text-base text-gray-700 sm:text-lg dark:text-gray-400">Best regards,<br>The Administration Team</p>
        </div>
    </div>
</body>
</html>