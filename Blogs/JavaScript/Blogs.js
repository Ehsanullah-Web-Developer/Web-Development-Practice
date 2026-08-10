/* ============================================================
   script.js — All JavaScript logic for BlogSphere
   ============================================================ */

// ================================================================
//  DATA — 25 Blog Posts
// ================================================================

const BLOG_DATA = [
    {
        id: 1,
        title: "The Future of AI in Everyday Life",
        excerpt: "From smart assistants to predictive healthcare, AI is weaving into the fabric of daily life. Here's what's next.",
        content: "Artificial Intelligence is no longer a futuristic concept—it's here, and it's transforming how we live, work, and connect. In this deep dive, we explore the latest breakthroughs in natural language processing, computer vision, and reinforcement learning. We'll look at how AI-powered tools are revolutionizing education, healthcare, and creative industries. From personalized learning algorithms that adapt to each student's pace, to AI-driven diagnostic systems that detect diseases earlier than ever before, the potential is immense. But with great power comes great responsibility—we also examine the ethical challenges, bias in AI models, and the importance of human oversight. The future of AI isn't just about technology; it's about people.",
        image: "images/Blogimage11.jpg",
        author: "Dr. Maya Chen",
        date: "2026-03-10",
        category: "Technology",
        likes: 0,
        bookmarked: false
    },
    {
        id: 2,
        title: "10 JavaScript Tricks Every Developer Should Know",
        excerpt: "Level up your JS game with these powerful yet underrated techniques.",
        content: "JavaScript is the language of the web, and mastering it can dramatically boost your productivity. In this article, we cover ten essential tricks that every developer should have in their toolkit. From debouncing and throttling to using the spread operator for immutability, we break down each technique with practical examples. We also dive into advanced array methods, optional chaining, nullish coalescing, and how to write cleaner asynchronous code with async/await. Whether you're a beginner or a seasoned pro, these tips will help you write more efficient, readable, and maintainable JavaScript.",
        image: "images/Blogimage12.jpg",
        author: "Alex Rivera",
        date: "2026-03-08",
        category: "Programming",
        likes: 0,
        bookmarked: false
    },
    {
        id: 3,
        title: "Mindful Living: Finding Calm in a Chaotic World",
        excerpt: "Simple practices to cultivate mindfulness and reduce stress in your daily routine.",
        content: "In a world that never seems to slow down, mindfulness offers a sanctuary. This article explores the science behind mindfulness and provides actionable steps to incorporate it into your life. We cover breathwork techniques, journaling prompts, and the art of being present in everyday moments. Learn how to create a morning ritual that sets a positive tone for the day, and discover the power of gratitude and self-compassion. Mindfulness isn't about eliminating stress—it's about changing your relationship with it. With consistent practice, you can cultivate a sense of peace and clarity that transforms how you experience the world.",
        image: "images/Blogimage13.jpg",
        author: "Sarah Kim",
        date: "2026-03-05",
        category: "Lifestyle",
        likes: 0,
        bookmarked: false
    },
    {
        id: 4,
        title: "Wanderlust: Hidden Gems of Southeast Asia",
        excerpt: "Off-the-beaten-path destinations that will take your breath away.",
        content: "Southeast Asia is a tapestry of vibrant cultures, stunning landscapes, and unforgettable experiences. Beyond the well-trodden paths of Bali and Bangkok lie hidden gems waiting to be discovered. In this travelogue, we journey through the lush highlands of northern Vietnam, the pristine beaches of the Philippines' Palawan, and the ancient temples of Myanmar. We share insider tips on local cuisine, sustainable travel practices, and how to connect with communities in a meaningful way. Whether you're a solo backpacker or a family on vacation, these destinations offer something truly special—a chance to disconnect and immerse yourself in the beauty of the region.",
        image: "images/Blogimage14.jpg",
        author: "Marco Santos",
        date: "2026-03-02",
        category: "Travel",
        likes: 0,
        bookmarked: false
    },
    {
        id: 5,
        title: "Sustainable Fashion: Dressing with Purpose",
        excerpt: "How to build a wardrobe that's stylish, ethical, and kind to the planet.",
        content: "Fashion is one of the most polluting industries in the world, but change is happening. Sustainable fashion is about making conscious choices—from the materials we wear to the brands we support. In this article, we explore the rise of eco-friendly fabrics like organic cotton, hemp, and recycled polyester. We also highlight brands that are leading the way in fair trade and circular fashion. Learn how to build a capsule wardrobe that transcends trends, and discover the joy of second-hand shopping and clothing swaps. Dressing with purpose isn't just about looking good—it's about feeling good about the impact you're making.",
        image: "images/Blogimage15.jpg",
        author: "Elena Vogt",
        date: "2026-02-28",
        category: "Fashion",
        likes: 0,
        bookmarked: false
    },
    {
        id: 6,
        title: "Quantum Computing: The Next Frontier",
        excerpt: "A beginner-friendly introduction to quantum computers and their potential.",
        content: "Quantum computing promises to solve problems that are currently impossible for classical computers. But what exactly is it? In this article, we break down the basics of qubits, superposition, and entanglement in plain English. We explore how quantum computers could revolutionize fields like cryptography, drug discovery, and materials science. We also discuss the current state of the technology—from IBM's quantum processors to Google's quantum supremacy claim. While we're still in the early days, the potential is staggering. This is a must-read for anyone curious about the future of computing.",
        image: "images/Blogimage16.jpg",
        author: "Dr. Raj Patel",
        date: "2026-02-25",
        category: "Technology",
        likes: 0,
        bookmarked: false
    },
    {
        id: 7,
        title: "Mastering Python: Advanced Patterns",
        excerpt: "Go beyond the basics with these advanced Python design patterns.",
        content: "Python is beloved for its simplicity, but it's also incredibly powerful when used with advanced design patterns. In this article, we explore patterns like Singleton, Factory, Observer, and Decorator—with practical Python examples. We also cover context managers, descriptors, and metaclasses for those who want to push the language to its limits. Whether you're building a web application, a data pipeline, or a machine learning model, these patterns will help you write more modular, scalable, and maintainable code. Level up your Python skills today.",
        image: "images/Blogimage17.jpg",
        author: "Jamie Fox",
        date: "2026-02-22",
        category: "Programming",
        likes: 0,
        bookmarked: false
    },
    {
        id: 8,
        title: "The Art of Slow Travel",
        excerpt: "Why taking it slow is the best way to experience the world.",
        content: "In an age of bucket lists and quick getaways, slow travel is a radical act of presence. This approach emphasizes quality over quantity—spending more time in fewer places, connecting with locals, and immersing yourself in the culture. We share stories from our own slow travel adventures, from a month in a Tuscan village to a homestay in rural Japan. Learn how to plan a slow travel itinerary, what to pack, and how to embrace the unexpected. Slow travel isn't just a way to see the world—it's a way to see yourself.",
        image: "images/Blogimage18.jpg",
        author: "Nina Ikeda",
        date: "2026-02-19",
        category: "Travel",
        likes: 0,
        bookmarked: false
    },
    {
        id: 9,
        title: "Minimalist Wardrobe: Less is More",
        excerpt: "How to curate a closet that reflects your true style with fewer pieces.",
        content: "The minimalist wardrobe movement is about more than just decluttering—it's about intentionality. In this article, we guide you through the process of creating a capsule wardrobe that works for your lifestyle. We cover the essential pieces every closet needs, how to choose quality over quantity, and tips for mixing and matching to create endless outfits. We also discuss the environmental and mental benefits of owning fewer clothes. A minimalist wardrobe isn't boring—it's liberating. Discover the joy of getting dressed with purpose.",
        image: "images/Blogimage19.jpg",
        author: "Claire Bennett",
        date: "2026-02-16",
        category: "Fashion",
        likes: 0,
        bookmarked: false
    },
    {
        id: 10,
        title: "The Rise of No-Code Development",
        excerpt: "Building powerful applications without writing a single line of code.",
        content: "No-code platforms are democratizing software development, enabling entrepreneurs, designers, and business professionals to bring their ideas to life. In this article, we explore the best no-code tools available today, from website builders to workflow automation. We also discuss the limitations and when it might be better to bring in a developer. With case studies of successful no-code projects, we show you how to get started and build your first app in hours, not months. The future of development is visual, and it's here.",
        image: "images/Blogimage20.jpg",
        author: "Tom Harris",
        date: "2026-02-13",
        category: "Programming",
        likes: 0,
        bookmarked: false
    },
    {
        id: 11,
        title: "Digital Detox: Reclaiming Your Time",
        excerpt: "Practical strategies to reduce screen time and reconnect with the real world.",
        content: "Our devices are designed to keep us engaged, often at the expense of our well-being. A digital detox isn't about abandoning technology—it's about using it more mindfully. In this article, we share practical strategies for reducing screen time, from setting app limits to creating tech-free zones in your home. We also explore the psychological benefits of unplugging, including improved sleep, reduced anxiety, and deeper relationships. Whether you're looking for a weekend reset or a long-term lifestyle change, this guide will help you take back control.",
        image: "images/Blogimage21.jpg",
        author: "Laura Chen",
        date: "2026-02-10",
        category: "Lifestyle",
        likes: 0,
        bookmarked: false
    },
    {
        id: 12,
        title: "Street Food Adventures: Bangkok to Hanoi",
        excerpt: "A culinary journey through Southeast Asia's most vibrant street food scenes.",
        content: "Street food is the heart and soul of Southeast Asian cuisine. In this article, we take you on a flavor-packed journey from Bangkok's bustling night markets to Hanoi's ancient alleyways. We highlight must-try dishes like pad thai, banh mi, and pho, and share stories from the vendors who make them. We also provide tips for navigating street food safely and sustainably. Whether you're a foodie or a curious traveler, this article will leave you hungry for adventure.",
        image: "images/Blogimage22.jpg",
        author: "Minh Nguyen",
        date: "2026-02-07",
        category: "Travel",
        likes: 0,
        bookmarked: false
    },
    {
        id: 13,
        title: "Vintage Fashion: A Guide to Thrifting",
        excerpt: "How to find unique, high-quality vintage pieces that tell a story.",
        content: "Thrifting is more than a trend—it's a sustainable and creative way to express your personal style. In this guide, we share our top tips for finding hidden gems in thrift stores, from knowing which fabrics to look for to understanding vintage sizing. We also explore the history of iconic fashion eras—from the roaring twenties to the grunge nineties—and how to incorporate vintage pieces into a modern wardrobe. Whether you're a seasoned thrifter or a newbie, this article will inspire you to shop with intention and style.",
        image: "images/Blogimage23.jpg",
        author: "Sophie Laurent",
        date: "2026-02-04",
        category: "Fashion",
        likes: 0,
        bookmarked: false
    },
    {
        id: 14,
        title: "Understanding Blockchain Beyond Crypto",
        excerpt: "How blockchain technology is transforming industries from supply chain to healthcare.",
        content: "While blockchain is often associated with cryptocurrencies, its applications go far beyond digital money. In this article, we explore how blockchain is revolutionizing supply chain transparency, healthcare data management, and digital identity verification. We break down the technical concepts in simple terms and highlight real-world use cases from companies like IBM and Walmart. We also discuss the challenges of scalability and regulation. Blockchain has the potential to create a more transparent and equitable world—and we're just getting started.",
        image: "images/Blogimage24.jpg",
        author: "Dr. Anika Singh",
        date: "2026-02-01",
        category: "Technology",
        likes: 0,
        bookmarked: false
    },
    {
        id: 15,
        title: "Rust vs. Go: Which Language Should You Learn?",
        excerpt: "A head-to-head comparison of two modern systems programming languages.",
        content: "Rust and Go are two of the most exciting languages to emerge in the last decade, but they serve different purposes. In this article, we compare them across several dimensions—performance, memory safety, concurrency, learning curve, and ecosystem. We look at use cases where Rust's zero-cost abstractions shine, and where Go's simplicity and built-in concurrency make it the better choice. Whether you're building a web service, a CLI tool, or a system-level application, this guide will help you decide which language is right for your next project.",
        image: "images/Blogimage25.jpg",
        author: "Carla Mendez",
        date: "2026-01-28",
        category: "Programming",
        likes: 0,
        bookmarked: false
    },
    {
        id: 16,
        title: "The Power of Morning Routines",
        excerpt: "How successful people start their day and how you can too.",
        content: "A purposeful morning routine sets the tone for the entire day. In this article, we explore the morning habits of highly successful individuals—from CEOs to artists—and break down the science behind why they work. We cover key elements like hydration, movement, meditation, and goal-setting. We also provide a customizable template so you can design a routine that fits your lifestyle and goals. Whether you're a night owl or an early bird, these insights will help you start each day with intention and energy.",
        image: "images/Blogimage26.jpg",
        author: "James Okafor",
        date: "2026-01-25",
        category: "Lifestyle",
        likes: 0,
        bookmarked: false
    },
    {
        id: 17,
        title: "Safari in Kenya: A Wildlife Adventure",
        excerpt: "Experience the magic of the African savannah and its incredible wildlife.",
        content: "A safari in Kenya is a bucket-list experience for any nature lover. In this article, we share our journey through the Maasai Mara, Amboseli, and Lake Nakuru. We offer practical advice on when to go, what to pack, and how to choose a responsible tour operator. We also celebrate the incredible wildlife—from elephants and lions to rhinos and giraffes—and discuss conservation efforts that are protecting these animals for future generations. A safari is not just a trip; it's a profound connection with the natural world.",
        image: "images/Blogimage27.jpg",
        author: "David Ochieng",
        date: "2026-01-22",
        category: "Travel",
        likes: 0,
        bookmarked: false
    },
    {
        id: 18,
        title: "Athleisure: Style Meets Comfort",
        excerpt: "How to rock the athleisure trend without looking like you just left the gym.",
        content: "Athleisure has taken the fashion world by storm, blending comfort and style in a way that fits modern lifestyles. In this article, we show you how to master the athleisure look—from pairing leggings with blazers to styling sneakers with dresses. We highlight key brands and pieces that will elevate your wardrobe, and share tips on accessorizing to take your outfit from casual to chic. Whether you're running errands or meeting friends for brunch, athleisure offers the perfect balance of function and fashion.",
        image: "images/Blogimage28.jpg",
        author: "Mia Torres",
        date: "2026-01-19",
        category: "Fashion",
        likes: 0,
        bookmarked: false
    },
    {
        id: 19,
        title: "Edge Computing: The Future of Data Processing",
        excerpt: "Why processing data closer to the source is the next big thing in tech.",
        content: "Edge computing is shifting the paradigm of how data is processed and analyzed. Instead of sending all data to centralized cloud servers, edge computing processes data at the source—whether that's a factory floor, a smart city sensor, or a self-driving car. In this article, we explore the benefits of edge computing, including reduced latency, improved privacy, and lower bandwidth costs. We also look at real-world applications in healthcare, manufacturing, and autonomous vehicles. The edge is where the future happens.",
        image: "images/Blogimage29.jpg",
        author: "Priya Mehta",
        date: "2026-01-16",
        category: "Technology",
        likes: 0,
        bookmarked: false
    },
    {
        id: 20,
        title: "Functional Programming in JavaScript",
        excerpt: "Write cleaner, more predictable code with functional programming principles.",
        content: "Functional programming is a paradigm that emphasizes pure functions, immutability, and declarative code. In this article, we introduce the core concepts—map, filter, reduce, and beyond—and show you how to apply them in JavaScript. We discuss the benefits of functional programming, including easier debugging, better testability, and more predictable state management. We also compare it with object-oriented programming and discuss when to use each approach. Whether you're new to functional programming or looking to deepen your understanding, this article has something for you.",
        image: "images/Blogimage30.jpg",
        author: "Samir Gupta",
        date: "2026-01-13",
        category: "Programming",
        likes: 0,
        bookmarked: false
    },
    {
        id: 21,
        title: "The Benefits of Journaling for Mental Health",
        excerpt: "How putting pen to paper can improve your emotional well-being.",
        content: "Journaling is a simple yet powerful tool for mental health. In this article, we explore the therapeutic benefits of expressive writing, from reducing anxiety to improving mood. We share different journaling techniques—from gratitude journals to stream-of-consciousness writing—and provide prompts to get you started. We also discuss the science behind why journaling works, including its impact on the brain and nervous system. Whether you're dealing with stress, trauma, or just want to know yourself better, journaling can be a transformative practice.",
        image: "images/Blogimage31.jpg",
        author: "Dr. Emily Rose",
        date: "2026-01-10",
        category: "Lifestyle",
        likes: 0,
        bookmarked: false
    },
    {
        id: 22,
        title: "Exploring the Fjords of Norway",
        excerpt: "A journey through the breathtaking landscapes of the Norwegian fjords.",
        content: "Norway's fjords are among the most spectacular natural wonders on Earth. In this article, we share our adventure through the Geirangerfjord, Nærøyfjord, and Sognefjord. We offer practical advice on the best time to visit, how to get there, and what to pack. We also highlight the cultural richness of the region—from Viking history to local cuisine. Whether you're cruising the waters or hiking the cliffs, the fjords offer an experience that is both humbling and inspiring. Norway's natural beauty is unmatched.",
        image: "images/Blogimage32.jpg",
        author: "Erik Larsen",
        date: "2026-01-07",
        category: "Travel",
        likes: 0,
        bookmarked: false
    },
    {
        id: 23,
        title: "Ethical Fashion: The Brands to Watch",
        excerpt: "A curated list of fashion brands that are making a positive impact.",
        content: "Ethical fashion is more than a buzzword—it's a movement toward transparency, sustainability, and fair labor practices. In this article, we highlight brands that are leading the way, from Patagonia's environmental activism to Everlane's radical transparency. We also showcase emerging designers who are using innovative materials and production methods. We provide tips on how to identify truly ethical brands and what questions to ask when shopping. Supporting ethical fashion is one of the most impactful choices you can make as a consumer.",
        image: "images/Blogimage33.jpg",
        author: "Zara Ahmed",
        date: "2026-01-04",
        category: "Fashion",
        likes: 0,
        bookmarked: false
    },
    {
        id: 24,
        title: "The Evolution of Web Development",
        excerpt: "From static HTML pages to modern frameworks—a brief history.",
        content: "Web development has come a long way since the early days of the internet. In this article, we trace the evolution from static HTML pages to dynamic websites, the rise of CSS and JavaScript, and the explosion of frameworks like React, Vue, and Angular. We also look at the current trends—including serverless, JAMstack, and WebAssembly—and speculate on what the future holds. Whether you're a seasoned developer or just starting out, understanding the history of the web helps you appreciate the tools and techniques we use today.",
        image: "images/Blogimage34.jpg",
        author: "Chris Wong",
        date: "2026-01-01",
        category: "Programming",
        likes: 0,
        bookmarked: false
    },
    {
        id: 25,
        title: "The Power of Habit: How to Build Lasting Change",
        excerpt: "Scientifically proven strategies to form good habits and break bad ones.",
        content: "Habits shape our lives more than we realize. In this article, we dive into the science of habit formation, drawing on the work of Charles Duhigg and James Clear. We explore the habit loop—cue, routine, reward—and provide actionable strategies for building habits that stick. We also discuss how to break bad habits by replacing them with healthier alternatives. Whether you want to exercise more, eat better, or read more books, this article will give you the tools you need to make lasting change.",
        image: "images/Blogimage35.jpg",
        author: "Dr. Lisa Park",
        date: "2025-12-28",
        category: "Lifestyle",
        likes: 0,
        bookmarked: false
    }
];

// ================================================================
//  STATE
// ================================================================

const state = {
    posts: [...BLOG_DATA],
    filteredPosts: [...BLOG_DATA],
    currentCategory: 'all',
    currentPage: 1,
    perPage: 6,
    sortBy: 'newest',
    searchQuery: '',
    isDark: false,
    likes: JSON.parse(localStorage.getItem('blog_likes')) || {},
    bookmarks: JSON.parse(localStorage.getItem('blog_bookmarks')) || {},
};

// ================================================================
//  DOM REFS
// ================================================================

const $ = (sel) => document.querySelector(sel);
const $$ = (sel) => document.querySelectorAll(sel);

const grid = $('#blogGrid');
const paginationEl = $('#pagination');
const categoryFilter = $('#categoryFilter');
const sortSelect = $('#sortSelect');
const searchInput = $('#searchInput');
const searchForm = $('#searchForm');
const searchOverlay = $('#searchOverlay');
const searchToggle = $('#searchToggle');
const themeToggle = $('#themeToggle');
const hamburger = $('#hamburger');
const navMenu = $('#navMenu');
const backToTop = $('#backToTop');
const progressBar = $('#progress-bar');

// Info modal
const infoModal = $('#infoModal');
const infoModalTitle = $('#infoModalTitle');
const infoModalMessage = $('#infoModalMessage');
const infoModalBtn = $('#infoModalBtn');

// Comment modal
const commentModal = $('#commentModal');
const commentModalClose = $('#commentModalClose');
const commentModalTitle = $('#commentModalTitle');
const commentList = $('#commentList');
const commentForm = $('#commentForm');
const commentText = $('#commentText');

const newsletterForm = $('#newsletterForm');
const newsEmail = $('#newsEmail');
const heroCommentBtn = $('#heroCommentBtn');

// ================================================================
//  HELPERS
// ================================================================

function formatDate(dateStr) {
    const d = new Date(dateStr);
    return d.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
}

function getInitials(name) {
    return name.split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 2);
}

function truncate(text, len = 150) {
    if (text.length <= len) return text;
    return text.slice(0, len) + '…';
}

function getCategoryIcon(cat) {
    const map = {
        Technology: 'fa-microchip',
        Programming: 'fa-code',
        Lifestyle: 'fa-leaf',
        Travel: 'fa-plane',
        Fashion: 'fa-tshirt'
    };
    return map[cat] || 'fa-tag';
}

// ================================================================
//  COMMENTS (localStorage)
// ================================================================

function getComments(postId) {
    const key = `blog_comments_${postId}`;
    return JSON.parse(localStorage.getItem(key)) || [];
}

function saveComments(postId, comments) {
    const key = `blog_comments_${postId}`;
    localStorage.setItem(key, JSON.stringify(comments));
}

function addComment(postId, text) {
    const comments = getComments(postId);
    const newComment = {
        id: Date.now(),
        author: 'Anonymous',
        text: text.trim(),
        date: new Date().toISOString()
    };
    comments.push(newComment);
    saveComments(postId, comments);
    return newComment;
}

function renderComments(postId) {
    const comments = getComments(postId);
    if (comments.length === 0) {
        commentList.innerHTML = `<div class="no-comments">No comments yet. Be the first!</div>`;
        return;
    }
    commentList.innerHTML = comments.map(c => `
        <div class="comment-item">
            <span class="comment-author">${c.author}</span>
            <span class="comment-date">${formatDate(c.date)}</span>
            <div class="comment-text">${c.text}</div>
        </div>
    `).join('');
}

// ================================================================
//  COMMENT MODAL
// ================================================================

let currentCommentPostId = null;

function openCommentModal(postId) {
    currentCommentPostId = postId;
    const post = state.posts.find(p => p.id === postId);
    if (!post) return;
    commentModalTitle.textContent = `Comments on "${post.title}"`;
    renderComments(postId);
    commentText.value = '';
    commentModal.classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeCommentModal() {
    commentModal.classList.remove('open');
    document.body.style.overflow = '';
    currentCommentPostId = null;
}

commentModalClose.addEventListener('click', closeCommentModal);
commentModal.addEventListener('click', function(e) {
    if (e.target === this) closeCommentModal();
});

commentForm.addEventListener('submit', function(e) {
    e.preventDefault();
    const text = commentText.value.trim();
    if (!text) return;
    if (currentCommentPostId === null) return;
    addComment(currentCommentPostId, text);
    renderComments(currentCommentPostId);
    commentText.value = '';
    // Show a small success info modal (optional, but we can just keep it)
    showInfoModal('💬 Comment Posted', 'Your comment has been added successfully!');
});

// ================================================================
//  INFO MODAL (for other confirmations)
// ================================================================

function showInfoModal(title, message) {
    infoModalTitle.textContent = title;
    infoModalMessage.textContent = message;
    infoModal.classList.add('open');
}

function closeInfoModal() {
    infoModal.classList.remove('open');
}

infoModalBtn.addEventListener('click', closeInfoModal);
infoModal.addEventListener('click', function(e) {
    if (e.target === this) closeInfoModal();
});

// Newsletter and other confirmations use infoModal
newsletterForm.addEventListener('submit', function(e) {
    e.preventDefault();
    const email = newsEmail.value.trim();
    if (email) {
        showInfoModal('📬 Subscribed!', `You're now subscribed with ${email}. Welcome to the BlogSphere community!`);
        newsEmail.value = '';
    } else {
        showInfoModal('⚠️ Oops!', 'Please enter a valid email address.');
    }
});

// ================================================================
//  RENDER POSTS
// ================================================================

function renderPosts() {
    const posts = state.filteredPosts;
    const start = (state.currentPage - 1) * state.perPage;
    const end = start + state.perPage;
    const pagePosts = posts.slice(start, end);

    if (pagePosts.length === 0) {
        grid.innerHTML = `
            <div style="grid-column:1/-1;text-align:center;padding:60px 0;color:var(--text-muted);">
                <i class="fas fa-search" style="font-size:2.4rem;margin-bottom:12px;display:block;"></i>
                <h3 style="font-size:1.2rem;color:var(--text-primary);">No posts found</h3>
                <p>Try adjusting your search or filter.</p>
            </div>
        `;
        paginationEl.innerHTML = '';
        return;
    }

    grid.innerHTML = pagePosts.map(post => `
        <div class="blog-card" data-id="${post.id}">
            <div class="card-img">
                <img src="${post.image}" alt="${post.title}" loading="lazy" />
                <span class="card-category"><i class="fas ${getCategoryIcon(post.category)}"></i> ${post.category}</span>
            </div>
            <div class="card-body">
                <h3 class="card-title">${post.title}</h3>
                <p class="card-excerpt">${truncate(post.content, 200)}</p>
                <div class="card-meta">
                    <span class="author">
                        <span class="avatar">${getInitials(post.author)}</span>
                        ${post.author}
                    </span>
                    <span><i class="far fa-calendar-alt"></i> ${formatDate(post.date)}</span>
                </div>
            </div>
            <div class="card-actions">
                <button class="like-btn ${state.likes[post.id] ? 'liked' : ''}" data-id="${post.id}">
                    <i class="${state.likes[post.id] ? 'fas' : 'far'} fa-heart"></i>
                    <span class="like-count">${state.likes[post.id] || 0}</span>
                </button>
                <button class="bookmark-btn ${state.bookmarks[post.id] ? 'bookmarked' : ''}" data-id="${post.id}">
                    <i class="${state.bookmarks[post.id] ? 'fas' : 'far'} fa-bookmark"></i>
                </button>
                <button class="comment-btn" data-id="${post.id}">
                    <i class="far fa-comment"></i> Comment
                </button>
            </div>
        </div>
    `).join('');

    renderPagination(posts.length);
    attachCardEvents();
}

function renderPagination(total) {
    const totalPages = Math.ceil(total / state.perPage);
    if (totalPages <= 1) {
        paginationEl.innerHTML = '';
        return;
    }

    let html = '';
    html += `<button class="page-btn" data-page="prev" ${state.currentPage === 1 ? 'disabled' : ''}><i class="fas fa-chevron-left"></i></button>`;

    for (let i = 1; i <= totalPages; i++) {
        html += `<button class="page-btn ${i === state.currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`;
    }

    html += `<button class="page-btn" data-page="next" ${state.currentPage === totalPages ? 'disabled' : ''}><i class="fas fa-chevron-right"></i></button>`;
    paginationEl.innerHTML = html;

    paginationEl.querySelectorAll('.page-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const page = btn.dataset.page;
            if (page === 'prev' && state.currentPage > 1) {
                state.currentPage--;
            } else if (page === 'next' && state.currentPage < totalPages) {
                state.currentPage++;
            } else if (page !== 'prev' && page !== 'next') {
                state.currentPage = parseInt(page);
            }
            renderPosts();
            window.scrollTo({ top: $('#blogSection').offsetTop - 100, behavior: 'smooth' });
        });
    });
}

function attachCardEvents() {
    // Like
    grid.querySelectorAll('.like-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const id = parseInt(this.dataset.id);
            toggleLike(id);
        });
    });

    // Bookmark
    grid.querySelectorAll('.bookmark-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const id = parseInt(this.dataset.id);
            toggleBookmark(id);
        });
    });

    // Comment - open comment modal
    grid.querySelectorAll('.comment-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const id = parseInt(this.dataset.id);
            openCommentModal(id);
        });
    });
}

// ================================================================
//  LIKES & BOOKMARKS (localStorage)
// ================================================================

function toggleLike(id) {
    state.likes[id] = (state.likes[id] || 0) + 1;
    localStorage.setItem('blog_likes', JSON.stringify(state.likes));
    renderPosts();
}

function toggleBookmark(id) {
    state.bookmarks[id] = !state.bookmarks[id];
    localStorage.setItem('blog_bookmarks', JSON.stringify(state.bookmarks));
    renderPosts();
}

// ================================================================
//  FILTER & SEARCH & SORT
// ================================================================

function applyFilters() {
    let result = [...state.posts];

    // Category filter
    if (state.currentCategory !== 'all') {
        result = result.filter(p => p.category === state.currentCategory);
    }

    // Search query
    if (state.searchQuery.trim()) {
        const q = state.searchQuery.trim().toLowerCase();
        result = result.filter(p =>
            p.title.toLowerCase().includes(q) ||
            p.author.toLowerCase().includes(q) ||
            p.category.toLowerCase().includes(q) ||
            p.content.toLowerCase().includes(q) ||
            formatDate(p.date).toLowerCase().includes(q)
        );
    }

    // Sort
    if (state.sortBy === 'newest') {
        result.sort((a, b) => new Date(b.date) - new Date(a.date));
    } else {
        result.sort((a, b) => new Date(a.date) - new Date(b.date));
    }

    state.filteredPosts = result;
    state.currentPage = 1;
    renderPosts();
}

// ================================================================
//  HERO — pick a featured post
// ================================================================

function updateHero() {
    const featured = [...state.posts].sort((a, b) => new Date(b.date) - new Date(a.date))[0];
    if (!featured) return;

    $('#heroImage img').src = featured.image;
    $('#heroCategory').textContent = featured.category;
    $('#heroDate').textContent = formatDate(featured.date);
    $('#heroTitle').textContent = featured.title;
    $('#heroDesc').textContent = truncate(featured.content, 120);
    heroCommentBtn.dataset.id = featured.id;
}

// ================================================================
//  HERO COMMENT BUTTON
// ================================================================

heroCommentBtn.addEventListener('click', function() {
    const id = parseInt(this.dataset.id);
    if (id) openCommentModal(id);
});

// ================================================================
//  CATEGORY FILTER UI
// ================================================================

categoryFilter.addEventListener('click', function(e) {
    const btn = e.target.closest('button');
    if (!btn) return;

    categoryFilter.querySelectorAll('button').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    state.currentCategory = btn.dataset.cat;
    applyFilters();
});

// ================================================================
//  SORT
// ================================================================

sortSelect.addEventListener('change', function() {
    state.sortBy = this.value;
    applyFilters();
});

// ================================================================
//  SEARCH
// ================================================================

searchToggle.addEventListener('click', function() {
    searchOverlay.classList.toggle('open');
    if (searchOverlay.classList.contains('open')) {
        searchInput.focus();
    }
});

searchForm.addEventListener('submit', function(e) {
    e.preventDefault();
    state.searchQuery = searchInput.value;
    applyFilters();
    searchOverlay.classList.remove('open');
    document.getElementById('blogSection').scrollIntoView({ behavior: 'smooth' });
});

// Category links in footer — trigger filter
document.querySelectorAll('[data-cat]').forEach(el => {
    el.addEventListener('click', function(e) {
        e.preventDefault();
        const cat = this.dataset.cat;
        state.currentCategory = cat;
        categoryFilter.querySelectorAll('button').forEach(b => {
            b.classList.toggle('active', b.dataset.cat === cat);
        });
        applyFilters();
        document.getElementById('blogSection').scrollIntoView({ behavior: 'smooth' });
    });
});

// ================================================================
//  THEME
// ================================================================

function toggleTheme() {
    state.isDark = !state.isDark;
    document.documentElement.setAttribute('data-theme', state.isDark ? 'dark' : 'light');
    themeToggle.innerHTML = state.isDark ? '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>';
    localStorage.setItem('blog_theme', state.isDark ? 'dark' : 'light');
}

const savedTheme = localStorage.getItem('blog_theme');
if (savedTheme === 'dark') {
    state.isDark = true;
    document.documentElement.setAttribute('data-theme', 'dark');
    themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
}

themeToggle.addEventListener('click', toggleTheme);

// ================================================================
//  MOBILE HAMBURGER
// ================================================================

hamburger.addEventListener('click', function() {
    this.classList.toggle('active');
    navMenu.classList.toggle('open');
});

navMenu.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
        hamburger.classList.remove('active');
        navMenu.classList.remove('open');
    });
});

// ================================================================
//  BACK TO TOP & PROGRESS BAR
// ================================================================

window.addEventListener('scroll', function() {
    const scrollY = window.scrollY;
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
    const progress = docHeight > 0 ? (scrollY / docHeight) * 100 : 0;
    progressBar.style.width = progress + '%';

    if (scrollY > 400) {
        backToTop.classList.add('visible');
    } else {
        backToTop.classList.remove('visible');
    }
});

backToTop.addEventListener('click', function() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

// ================================================================
//  INIT
// ================================================================

function init() {
    updateHero();
    applyFilters();
}

init();

// ================================================================
//  KEYBOARD SHORTCUT: Ctrl+K to open search
// ================================================================

document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        searchToggle.click();
    }
    if (e.key === 'Escape') {
        if (searchOverlay.classList.contains('open')) {
            searchOverlay.classList.remove('open');
        }
        if (commentModal.classList.contains('open')) {
            closeCommentModal();
        }
        if (infoModal.classList.contains('open')) {
            closeInfoModal();
        }
    }
});

console.log('🚀 BlogSphere loaded — 25 posts ready with real comments!');
console.log('💡 Tip: Press Ctrl+K to search.');