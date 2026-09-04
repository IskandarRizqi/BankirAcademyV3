<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $article->title }}</title>
    <style>
        body {
            font-family: sans-serif;
            color: #333;
            line-height: 1.6;
            font-size: 12pt;
        }

        h1 {
            font-size: 20pt;
            color: #1a202c;
            margin-bottom: 5px;
        }

        .meta {
            font-size: 9pt;
            color: #718096;
            margin-bottom: 20px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 10px;
        }

        .featured-img {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            margin-bottom: 20px;
            border-radius: 6px;
        }

        .content {
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <h1>{{ $article->title }}</h1>
    <div class="meta">
        <strong>Keyword:</strong> {{ $article->keyword }} |
        <strong>Tanggal:</strong> {{ $article->created_at ? $article->created_at->format('d M Y') : '-' }}
    </div>

    @if (!empty($article->image_url))
        <img src="{{ $article->image_url }}" class="featured-img">
    @endif

    <div class="content">
        {!! $article->content !!}
    </div>
</body>

</html>
