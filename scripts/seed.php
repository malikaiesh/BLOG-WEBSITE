<?php
require_once __DIR__ . '/../config/init.php';

$db = Database::getInstance()->getConnection();

echo "Starting database seeding...\n";

try {
    // 1. Clear existing data if tables exist
    echo "Cleaning old data...\n";
    $db->exec("TRUNCATE blogs, categories, users RESTART IDENTITY CASCADE");

    // 2. Seed Users
    echo "Seeding users...\n";
    $users = [
        ['Admin', 'admin@blog.com', password_hash('admin123', PASSWORD_BCRYPT), 'admin', 'Primary site administrator and lead editor.'],
        ['John Doe', 'john@example.com', password_hash('author123', PASSWORD_BCRYPT), 'author', 'Tech enthusiast and software engineer with 10 years of experience.'],
        ['Jane Smith', 'jane@example.com', password_hash('author123', PASSWORD_BCRYPT), 'author', 'Travel blogger and world explorer focusing on sustainable tourism.'],
        ['Mike Ross', 'mike@example.com', password_hash('author123', PASSWORD_BCRYPT), 'author', 'Lifestyle coach and health nutrition expert.'],
    ];

    $userIds = [];
    $stmt = $db->prepare("INSERT INTO users (name, email, password, role, bio, created_at) VALUES (?, ?, ?, ?, ?, NOW()) RETURNING id");
    foreach ($users as $user) {
        $stmt->execute($user);
        $userIds[] = $stmt->fetchColumn();
    }

    // 3. Seed Categories
    echo "Seeding categories...\n";
    $categories = [
        ['Technology', 'technology', 'Deep dives into the latest hardware, software, and AI developments.'],
        ['Travel', 'travel', 'Breathtaking destinations and practical guides for your next adventure.'],
        ['Lifestyle', 'lifestyle', 'Tips and insights for a healthier, more balanced daily life.'],
        ['Business', 'business', 'Analysis of market trends and entrepreneurial success stories.'],
        ['Health', 'health', 'Evidence-based advice on fitness, nutrition, and mental well-being.'],
    ];

    $categoryIds = [];
    $stmt = $db->prepare("INSERT INTO categories (name, slug, description) VALUES (?, ?, ?) RETURNING id");
    foreach ($categories as $cat) {
        $stmt->execute($cat);
        $categoryIds[$cat[1]] = $stmt->fetchColumn();
    }

    // 4. Seed Blogs
    echo "Seeding blog posts...\n";
    $blogs = [
        [
            'The Future of Artificial Intelligence', 'future-ai-2026', 
            'AI is moving faster than ever. What can we expect in the next 12 months?',
            '<h1>The Next Frontier of AI</h1><p>Artificial Intelligence has evolved from a buzzword into a fundamental part of our technological infrastructure. In 2026, we are seeing the rise of truly agentic AI systems that don\'t just process information but act on it.</p><h2>The Shift to Autonomy</h2><p>The previous generation of LLMs was reactive. The current generation is proactive, capable of managing complex workflows across multiple platforms without constant human supervision.</p>',
            '/uploads/sample/tech.jpg', $categoryIds['technology'], $userIds[1], 'published', 1520
        ],
        [
            'Exploring the Streets of Tokyo', 'tokyo-travel-guide', 
            'A comprehensive guide to the best hidden spots in the Japanese capital.',
            '<h1>Uncovering Tokyo</h1><p>Tokyo is a city of contrasts, where ancient shrines sit in the shadow of neon-lit skyscrapers. While many tourists flock to Shibuya Crossing, the real soul of the city is found in its backstreets.</p><h2>Yanesen: The Old Heart</h2><p>This neighborhood survived the bombings of WWII, preserving a glimpse into the Tokyo of the past.</p>',
            '/uploads/sample/travel.jpg', $categoryIds['travel'], $userIds[2], 'published', 2450
        ],
        [
            'Building a Successful Startup in 2026', 'startup-success-2026', 
            'Key lessons from this year\'s fastest-growing unicorn companies.',
            '<h1>The Lean Startup Reimagined</h1><p>The venture capital landscape has shifted significantly. Efficiency is now prized over growth at all costs.</p><h2>Profitability is the New Growth</h2><p>Investors are looking for sustainable business models from day one.</p>',
            '/uploads/sample/post11.jpg', $categoryIds['business'], $userIds[0], 'published', 890
        ],
        [
            '10 Minutes Yoga for Busy Professionals', 'yoga-for-professionals', 
            'Improve your posture and reduce stress with these simple daily exercises.',
            '<h1>Yoga at Your Desk</h1><p>Long hours sitting down can lead to significant back pain and decreased focus. These five poses can be done anywhere.</p>',
            '/uploads/sample/post13.jpg', $categoryIds['health'], $userIds[3], 'published', 1230
        ],
        [
            'The Evolution of Electric Vehicles', 'evolution-ev-2026', 
            'How solid-state batteries are finally making gas cars obsolete.',
            '<h1>Powering the Future</h1><p>We\'ve reached the tipping point. The range anxiety that once plagued potential EV buyers is a thing of the past.</p>',
            '/uploads/sample/post14.jpg', $categoryIds['technology'], $userIds[1], 'published', 3100
        ],
        [
            'Sustainable Travel: Leaving No Trace', 'sustainable-travel-tips', 
            'How to see the world without harming the environment.',
            '<h1>Travel Responsibly</h1><p>Tourism accounts for a significant portion of global carbon emissions. Here is how you can minimize your footprint.</p>',
            '/uploads/sample/post6.jpg', $categoryIds['travel'], $userIds[2], 'published', 560
        ],
        [
            'The Science of Sleep and Productivity', 'science-of-sleep', 
            'Why your late-night work sessions are actually hurting your output.',
            '<h1>Rest to Work Better</h1><p>Sleep is not a luxury; it\'s a biological necessity for high-level cognitive function.</p>',
            '/uploads/sample/post5.jpg', $categoryIds['health'], $userIds[3], 'published', 4200
        ],
        [
            'Mindful Eating in a Fast-Food World', 'mindful-eating-guide', 
            'Reconnecting with your food for better digestion and health.',
            '<h1>Slow Down and Taste</h1><p>In our rush to get through the day, we often treat eating as a chore rather than an experience.</p>',
            '/uploads/sample/post12.jpg', $categoryIds['lifestyle'], $userIds[3], 'published', 780
        ],
        [
            'Remote Team Building in the Metaverse', 'remote-teams-metaverse', 
            'Is VR the answer to the loneliness of distributed work?',
            '<h1>Collaboration in VR</h1><p>Video calls are exhausting. Spatially-aware audio and 3D environments are making digital presence feel real.</p>',
            '/uploads/sample/post1.jpg', $categoryIds['technology'], $userIds[1], 'published', 1100
        ],
        [
            'The Hidden Costs of Fast Fashion', 'hidden-costs-fast-fashion', 
            'Understanding the environmental and social impact of your wardrobe.',
            '<h1>Think Before You Buy</h1><p>The $10 t-shirt comes with a much higher price tag for the planet.</p>',
            '/uploads/sample/post3.jpg', $categoryIds['lifestyle'], $userIds[0], 'published', 2100
        ],
        [
            'Hiking the Patagonia Wilderness', 'patagonia-hiking-guide', 
            'What you need to know before tackling the world\'s most beautiful trails.',
            '<h1>The End of the World</h1><p>Patagonia is rugged, unpredictable, and absolutely stunning.</p>',
            '/uploads/sample/travel.jpg', $categoryIds['travel'], $userIds[2], 'published', 3400
        ],
        [
            'The Rise of Solo Entrepreneurship', 'solo-entrepreneurship-rise', 
            'How one-person businesses are reaching million-dollar revenues.',
            '<h1>The Power of One</h1><p>Automation and AI are allowing individuals to scale like never before.</p>',
            '/uploads/sample/post11.jpg', $categoryIds['business'], $userIds[0], 'published', 1500
        ],
        [
            'Advanced React Patterns for 2026', 'advanced-react-2026', 
            'Mastering the latest features in the world\'s most popular UI library.',
            '<h1>Next-Gen React</h1><p>Server Components were just the beginning. Let\'s look at what\'s next.</p>',
            '/uploads/sample/tech.jpg', $categoryIds['technology'], $userIds[1], 'published', 2800
        ],
        [
            'Healthy Mediterranean Dinner Recipes', 'mediterranean-dinner-recipes', 
            'Quick, easy, and delicious meals for your weeknight routine.',
            '<h1>Dinner in 20 Minutes</h1><p>Healthy cooking doesn\'t have to be time-consuming.</p>',
            '/uploads/sample/food.jpg', $categoryIds['lifestyle'], $userIds[3], 'published', 950
        ],
        [
            'Digital Detox: A Weekend Guide', 'digital-detox-weekend', 
            'How to disconnect from the internet and reconnect with yourself.',
            '<h1>Unplugging</h1><p>Give your brain a break from the constant stream of notifications.</p>',
            '/uploads/sample/post8.jpg', $categoryIds['lifestyle'], $userIds[0], 'published', 1800
        ]
    ];

    $stmt = $db->prepare("INSERT INTO blogs (title, slug, excerpt, content, featured_image, category_id, author_id, status, views, meta_title, meta_description, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW() - (INTERVAL '1 day' * ?), NOW())");
    
    foreach ($blogs as $index => $blog) {
        $stmt->execute([
            $blog[0], $blog[1], $blog[2], $blog[3], $blog[4], $blog[5], $blog[6], $blog[7], $blog[8],
            $blog[0], $blog[2], rand(1, 30) // Meta title, meta description, and random creation date within last 30 days
        ]);
    }

    echo "Seeding completed successfully!\n";

} catch (Exception $e) {
    die("Error seeding database: " . $e->getMessage() . "\n");
}
