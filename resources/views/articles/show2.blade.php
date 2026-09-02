<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article->title }}</title>
    <meta name="description" content="{{ $article->meta_description }}">
    <meta name="keywords" content="{{ $article->meta_keywords }}">
    <meta name="robots" content="index, follow">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="{{ $article->title }}">
    <meta property="og:description" content="{{ $article->meta_description }}">
    <meta property="og:type" content="article">
    <meta property="og:locale" content="id_ID">
    <meta property="og:url" content="{{ route('articles.publicShow', $article->slug) }}">
    <meta property="og:image" content="{{ $article->image_url }}">

    <!-- Twitter Card Meta -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $article->title }}">
    <meta name="twitter:description" content="{{ $article->meta_description }}">
    <meta name="twitter:image" content="{{ $article->image_url }}">

    <!-- Schema Markup JSON-LD -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BlogPosting",
      "headline": "{{ addslashes($article->title) }}",
      "description": "{{ addslashes($article->meta_description) }}",
      "image": "{{ $article->image_url }}",
      "inLanguage": "id-ID",
      "datePublished": "{{ $article->created_at->toIso8601String() }}",
      "dateModified": "{{ $article->updated_at->toIso8601String() }}"
    }
    </script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #f0f4ff 0%, #eef2f6 100%);
            color: #334155;
            line-height: 1.8;
            margin: 0;
            padding: 40px 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background-color: #ffffff;
            padding: 45px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        h1 {
            font-size: 2.2rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 25px;
            line-height: 1.3;
        }

        .container h2 {
            font-size: 1.6rem;
            color: #0f172a;
            margin-top: 40px;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 3px solid #3b82f6;
            display: inline-block;
        }

        .container p {
            margin-bottom: 20px;
        }

        .container ul,
        .container ol {
            margin-bottom: 20px;
            padding-left: 20px;
        }

        .container li {
            margin-bottom: 10px;
        }

        .container blockquote {
            background-color: #eff6ff;
            border-left: 5px solid #3b82f6;
            padding: 20px;
            margin: 25px 0;
            border-radius: 0 8px 8px 0;
            font-style: italic;
            color: #1e3a8a;
        }

        .featured-image {
            width: 100%;
            max-height: 450px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 25px;
        }

        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 15px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="article-content">
            @if (!empty($article->image_url))
                <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="featured-image">
            @endif

            {!! $article->content !!}
        </div>
    </div>
</body>

</html>
