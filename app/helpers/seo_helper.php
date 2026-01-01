<?php
function generateSchema($type, $data) {
    $schema = [
        "@context" => "https://schema.org"
    ];

    switch ($type) {
        case 'WebSite':
            $schema += [
                "@type" => "WebSite",
                "name" => $data['site_name'],
                "url" => SITE_URL,
                "description" => $data['site_description']
            ];
            break;
            
        case 'BlogPosting':
            $schema += [
                "@type" => "BlogPosting",
                "headline" => $data['title'],
                "description" => $data['excerpt'],
                "image" => SITE_URL . $data['featured_image'],
                "author" => [
                    "@type" => "Person",
                    "name" => $data['author_name']
                ],
                "datePublished" => date('c', strtotime($data['created_at'])),
                "dateModified" => date('c', strtotime($data['updated_at']))
            ];
            break;
    }

    return '<script type="application/ld+json">' . json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . '</script>';
}