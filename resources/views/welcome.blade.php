<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Management RESTful API</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #0b0f19;
            --bg-secondary: #111827;
            --bg-card: #1f2937;
            --border-color: rgba(255, 255, 255, 0.08);
            --text-main: #f3f4f6;
            --text-muted: #9ca3af;
            --accent-primary: #6366f1;
            --accent-primary-hover: #4f46e5;
            --accent-success: #10b981;
            --accent-warning: #f59e0b;
            --accent-danger: #ef4444;
            --font-sans: 'Plus Jakarta Sans', sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--bg-primary);
            color: var(--text-main);
            font-family: var(--font-sans);
            line-height: 1.6;
            padding: 2rem 1rem;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 2.5rem;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.8125rem;
            font-weight: 600;
            background: rgba(99, 102, 241, 0.15);
            color: #818cf8;
            border: 1px solid rgba(99, 102, 241, 0.3);
        }

        .badge-success {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border-color: rgba(16, 185, 129, 0.3);
        }

        h1 {
            font-size: 2.25rem;
            font-weight: 800;
            letter-spacing: -0.025em;
            background: linear-gradient(to right, #ffffff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .subtitle {
            color: var(--text-muted);
            margin-top: 0.25rem;
            font-size: 1rem;
        }

        /* Grid Layout */
        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        @media (max-width: 900px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }

        .card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--border-color);
        }

        .card-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Forms & Inputs */
        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-muted);
            margin-bottom: 0.375rem;
        }

        input, select, textarea {
            width: 100%;
            background: #1f2937;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 0.625rem 0.875rem;
            border-radius: 0.5rem;
            font-family: inherit;
            font-size: 0.9375rem;
            transition: all 0.2s ease;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--accent-primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            font-size: 0.9375rem;
            font-weight: 600;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--accent-primary);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--accent-primary-hover);
        }

        .btn-success {
            background: var(--accent-success);
            color: #fff;
        }

        .btn-secondary {
            background: #374151;
            color: #e5e7eb;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        .btn-danger {
            background: var(--accent-danger);
            color: #fff;
        }

        .token-display {
            background: #0f172a;
            border: 1px dashed rgba(99, 102, 241, 0.4);
            padding: 0.75rem;
            border-radius: 0.5rem;
            font-family: var(--font-mono);
            font-size: 0.8125rem;
            word-break: break-all;
            color: #a5b4fc;
            margin-top: 0.75rem;
        }

        /* Table & JSON Console */
        .console-box {
            background: #090d16;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 0.75rem;
            padding: 1rem;
            font-family: var(--font-mono);
            font-size: 0.8125rem;
            color: #38bdf8;
            max-height: 380px;
            overflow-y: auto;
            white-space: pre-wrap;
        }

        .courses-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            max-height: 400px;
            overflow-y: auto;
            margin-top: 1rem;
        }

        .course-item {
            background: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 1rem;
            border-radius: 0.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.2s ease;
        }

        .course-item:hover {
            border-color: rgba(99, 102, 241, 0.4);
            transform: translateY(-1px);
        }

        .course-title {
            font-weight: 600;
            color: #f8fafc;
            font-size: 0.9375rem;
        }

        .course-meta {
            font-size: 0.8125rem;
            color: var(--text-muted);
            margin-top: 0.25rem;
        }

        .price-tag {
            font-weight: 700;
            color: #34d399;
        }

        .pill {
            font-size: 0.75rem;
            padding: 0.15rem 0.5rem;
            border-radius: 9999px;
            font-weight: 600;
        }

        .pill-published {
            background: rgba(16, 185, 129, 0.2);
            color: #34d399;
        }

        .pill-draft {
            background: rgba(245, 158, 11, 0.2);
            color: #fbbf24;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            background: #10b981;
            box-shadow: 0 0 8px #10b981;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <div>
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
                    <span class="badge badge-success"><span class="status-dot" style="margin-right: 6px;"></span> API Online & Ready</span>
                    <span class="badge">Laravel 11 & Sanctum</span>
                    <span class="badge">Repository & Service Pattern</span>
                </div>
                <h1>Course Management REST API</h1>
                <p class="subtitle">Interactive API Playground & Live Test Dashboard</p>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <button class="btn btn-secondary" onclick="runHealthCheck()">🔍 Quick Health Check</button>
            </div>
        </header>

        <!-- Main Dashboard Grid -->
        <div class="grid">
            <!-- Left Column: Authentication & Actions -->
            <div>
                <!-- 1. Authentication Card -->
                <div class="card" style="margin-bottom: 1.5rem;">
                    <div class="card-header">
                        <div class="card-title">🔑 1. Sanctum Authentication</div>
                        <span id="authStatusBadge" class="badge" style="background: rgba(239, 68, 68, 0.15); color: #f87171; border-color: rgba(239, 68, 68, 0.3);">Unauthenticated</span>
                    </div>

                    <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 1rem;">
                        Default test credentials are provided. Click <strong>Quick Login</strong> to issue a bearer token.
                    </p>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 1rem;">
                        <div>
                            <label>Email</label>
                            <input type="email" id="authEmail" value="admin@example.com">
                        </div>
                        <div>
                            <label>Password</label>
                            <input type="password" id="authPassword" value="password123">
                        </div>
                    </div>

                    <div style="display: flex; gap: 0.75rem;">
                        <button class="btn btn-primary" onclick="loginUser()">⚡ Quick Login</button>
                        <button class="btn btn-secondary" onclick="getUserProfile()">👤 Get Profile (/api/user)</button>
                        <button class="btn btn-danger" onclick="logoutUser()">🚪 Logout</button>
                    </div>

                    <div id="tokenContainer" style="display: none;">
                        <div class="token-display">
                            <strong>Bearer Token:</strong> <span id="tokenText">None</span>
                        </div>
                    </div>
                </div>

                <!-- 2. Course Creation Card -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">➕ 2. Create New Course (POST /api/courses)</div>
                    </div>

                    <div class="form-group">
                        <label>Course Title *</label>
                        <input type="text" id="newTitle" placeholder="e.g. Master Vue 3 & Laravel REST API">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea id="newDesc" rows="2" placeholder="Course description..."></textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 1rem;">
                        <div>
                            <label>Price ($)</label>
                            <input type="number" id="newPrice" step="0.01" value="79.99">
                        </div>
                        <div>
                            <label>Status</label>
                            <select id="newPublished">
                                <option value="1">Published (true)</option>
                                <option value="0">Draft (false)</option>
                            </select>
                        </div>
                    </div>

                    <button class="btn btn-success" onclick="createCourse()">💾 Save Course</button>
                </div>
            </div>

            <!-- Right Column: Live Course Explorer & Live API Output -->
            <div>
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">📚 3. Live Courses Explorer (GET /api/courses)</div>
                        <button class="btn btn-secondary" style="padding: 0.35rem 0.75rem; font-size: 0.8125rem;" onclick="fetchCourses()">🔄 Refresh</button>
                    </div>

                    <!-- Search & Filters -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 0.75rem;">
                        <input type="text" id="searchQuery" placeholder="Search by title..." onkeyup="if(event.key==='Enter') fetchCourses()">
                        <select id="publishedFilter" onchange="fetchCourses()">
                            <option value="">All Statuses</option>
                            <option value="true">Published Only</option>
                            <option value="false">Draft Only</option>
                        </select>
                    </div>

                    <!-- Courses List -->
                    <div id="coursesList" class="courses-list">
                        <div style="text-align: center; color: var(--text-muted); padding: 2rem;">
                            Click <strong>"Quick Login"</strong> or <strong>"Refresh"</strong> to load seeded courses.
                        </div>
                    </div>

                    <!-- Live JSON Console -->
                    <div style="margin-top: 1.5rem;">
                        <label style="display: flex; justify-content: space-between; align-items: center;">
                            <span>📡 Live API Response Stream</span>
                            <span id="responseStatusBadge" class="badge">Ready</span>
                        </label>
                        <div id="jsonConsole" class="console-box">// API responses will appear here in real-time...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script for Live API Operations -->
    <script>
        let currentToken = '';

        function logResponse(data, status = 200) {
            const consoleBox = document.getElementById('jsonConsole');
            const statusBadge = document.getElementById('responseStatusBadge');
            
            consoleBox.textContent = JSON.stringify(data, null, 2);
            statusBadge.textContent = `HTTP ${status}`;
            if (status >= 200 && status < 300) {
                statusBadge.className = 'badge badge-success';
            } else {
                statusBadge.className = 'badge';
                statusBadge.style.background = 'rgba(239, 68, 68, 0.2)';
                statusBadge.style.color = '#f87171';
            }
        }

        async function loginUser() {
            const email = document.getElementById('authEmail').value;
            const password = document.getElementById('authPassword').value;

            try {
                const res = await fetch('/api/login', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({ email, password })
                });
                const data = await res.json();
                logResponse(data, res.status);

                if (data.success && data.data && data.data.token) {
                    currentToken = data.data.token;
                    document.getElementById('tokenText').textContent = currentToken;
                    document.getElementById('tokenContainer').style.display = 'block';
                    
                    const badge = document.getElementById('authStatusBadge');
                    badge.className = 'badge badge-success';
                    badge.textContent = 'Authenticated as ' + data.data.user.name;

                    fetchCourses();
                }
            } catch (err) {
                logResponse({ error: err.message }, 500);
            }
        }

        async function getUserProfile() {
            if (!currentToken) {
                alert('Please Login first!');
                return;
            }

            try {
                const res = await fetch('/api/user', {
                    headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${currentToken}` }
                });
                const data = await res.json();
                logResponse(data, res.status);
            } catch (err) {
                logResponse({ error: err.message }, 500);
            }
        }

        async function logoutUser() {
            if (!currentToken) {
                alert('Not logged in!');
                return;
            }

            try {
                const res = await fetch('/api/logout', {
                    method: 'POST',
                    headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${currentToken}` }
                });
                const data = await res.json();
                logResponse(data, res.status);

                currentToken = '';
                document.getElementById('tokenContainer').style.display = 'none';
                const badge = document.getElementById('authStatusBadge');
                badge.className = 'badge';
                badge.style.background = 'rgba(239, 68, 68, 0.15)';
                badge.style.color = '#f87171';
                badge.textContent = 'Unauthenticated';

                document.getElementById('coursesList').innerHTML = '<div style="text-align: center; color: var(--text-muted); padding: 2rem;">Logged out. Login to view protected courses.</div>';
            } catch (err) {
                logResponse({ error: err.message }, 500);
            }
        }

        async function fetchCourses() {
            const search = document.getElementById('searchQuery').value;
            const published = document.getElementById('publishedFilter').value;

            let url = `/api/courses?page=1&per_page=15`;
            if (search) url += `&search=${encodeURIComponent(search)}`;
            if (published !== '') url += `&published=${published}`;

            try {
                const headers = { 'Accept': 'application/json' };
                if (currentToken) headers['Authorization'] = `Bearer ${currentToken}`;

                const res = await fetch(url, { headers });
                const data = await res.json();
                logResponse(data, res.status);

                const listContainer = document.getElementById('coursesList');
                if (data.success && data.data && data.data.items) {
                    if (data.data.items.length === 0) {
                        listContainer.innerHTML = '<div style="text-align: center; color: var(--text-muted); padding: 1.5rem;">No courses found matching your criteria.</div>';
                        return;
                    }

                    listContainer.innerHTML = data.data.items.map(course => `
                        <div class="course-item">
                            <div>
                                <div class="course-title">#${course.id} ${escapeHtml(course.title)}</div>
                                <div class="course-meta">${escapeHtml(course.description || 'No description')}</div>
                            </div>
                            <div style="text-align: right; display: flex; flex-direction: column; align-items: flex-end; gap: 0.35rem;">
                                <span class="price-tag">$${Number(course.price).toFixed(2)}</span>
                                <span class="pill ${course.is_published ? 'pill-published' : 'pill-draft'}">
                                    ${course.is_published ? 'Published' : 'Draft'}
                                </span>
                                <button class="btn btn-danger" style="padding: 0.2rem 0.5rem; font-size: 0.75rem; margin-top: 0.25rem;" onclick="deleteCourse(${course.id})">Delete</button>
                            </div>
                        </div>
                    `).join('');
                } else {
                    listContainer.innerHTML = `<div style="text-align: center; color: #f87171; padding: 1.5rem;">${data.message || 'Unauthorized. Please login to view courses.'}</div>`;
                }
            } catch (err) {
                logResponse({ error: err.message }, 500);
            }
        }

        async function createCourse() {
            if (!currentToken) {
                alert('Please Login first before creating a course!');
                return;
            }

            const title = document.getElementById('newTitle').value;
            const description = document.getElementById('newDesc').value;
            const price = parseFloat(document.getElementById('newPrice').value) || 0;
            const is_published = document.getElementById('newPublished').value === '1';

            if (!title) {
                alert('Title is required!');
                return;
            }

            try {
                const res = await fetch('/api/courses', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${currentToken}`
                    },
                    body: JSON.stringify({ title, description, price, is_published })
                });

                const data = await res.json();
                logResponse(data, res.status);

                if (data.success) {
                    document.getElementById('newTitle').value = '';
                    document.getElementById('newDesc').value = '';
                    fetchCourses();
                }
            } catch (err) {
                logResponse({ error: err.message }, 500);
            }
        }

        async function deleteCourse(id) {
            if (!currentToken) {
                alert('Please Login first!');
                return;
            }

            if (!confirm(`Are you sure you want to delete course #${id}?`)) return;

            try {
                const res = await fetch(`/api/courses/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${currentToken}`
                    }
                });

                const data = await res.json();
                logResponse(data, res.status);
                if (data.success) {
                    fetchCourses();
                }
            } catch (err) {
                logResponse({ error: err.message }, 500);
            }
        }

        async function runHealthCheck() {
            try {
                const res = await fetch('/up');
                if (res.ok) {
                    alert('✅ Laravel Server is healthy & responsive!');
                }
            } catch (err) {
                alert('❌ Health check failed: ' + err.message);
            }
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Auto login on load for quick testing
        window.addEventListener('DOMContentLoaded', () => {
            loginUser();
        });
    </script>
</body>
</html>
