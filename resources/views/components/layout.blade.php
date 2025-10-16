<!doctype html>
<html class="h-full">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $title ?? 'Contracts' }}</title>
  @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-full">
  <div class="max-w-5xl mx-auto p-6">{{ $slot }}</div>
</body>
</html>
