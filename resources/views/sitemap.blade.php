<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>2023-05-08</lastmod>
        <changefreq>yearly</changefreq>
        <priority>1.0</priority>
    </url>
    @foreach(config('app.languages') as $code => $language)
    <url>
        <loc>{{ url('/'.$code) }}</loc>
        <lastmod>2023-05-08</lastmod>
        <changefreq>yearly</changefreq>
        <priority>1.0</priority>
    </url>
    @endforeach
    @foreach($articles as $article)
    <url>
        <loc>{{ route('front.article',['language' => $article->language, 'slug' => $article->slug]) }}</loc>
        <lastmod>2023-05-08</lastmod>
        <changefreq>yearly</changefreq>
        <priority>1.0</priority>
    </url>
    @endforeach
</urlset>
