<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Examples Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            color: #333;
            overflow-x: hidden;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            text-align: center;
            margin-bottom: 40px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        h1 {
            font-size: 3em;
            color: #fff;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .subtitle {
            font-size: 1.2em;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 20px;
        }

        .connection-status {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            animation: pulse 2s infinite;
        }

        .status-connected {
            background: #4CAF50;
            color: white;
        }

        .status-disconnected {
            background: #f44336;
            color: white;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .examples-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .example-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .example-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .example-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .card-icon {
            font-size: 1.5em;
            margin-right: 15px;
            color: #667eea;
        }

        .card-title {
            font-size: 1.3em;
            font-weight: 600;
            color: #333;
        }

        .card-description {
            color: #666;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .run-button {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9em;
        }

        .run-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .run-button:active {
            transform: translateY(0);
        }

        .result-area {
            margin-top: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            border-left: 4px solid #667eea;
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
            max-height: 300px;
            overflow-y: auto;
            display: none;
        }

        .result-area.show {
            display: block;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success {
            color: #4CAF50;
            font-weight: bold;
        }

        .error {
            color: #f44336;
            font-weight: bold;
        }

        .info {
            color: #2196F3;
            font-weight: bold;
        }

        .query-log {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 25px;
            margin-top: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .query-log h3 {
            color: #333;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .query-log-content {
            background: #2d3748;
            color: #e2e8f0;
            padding: 15px;
            border-radius: 10px;
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
            max-height: 300px;
            overflow-y: auto;
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .stats-bar {
            display: flex;
            justify-content: space-around;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stat-item {
            text-align: center;
            color: white;
        }

        .stat-value {
            font-size: 2em;
            font-weight: bold;
            display: block;
        }

        .stat-label {
            font-size: 0.9em;
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .examples-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-bar {
                flex-direction: column;
                gap: 15px;
            }
            
            h1 {
                font-size: 2em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-database"></i> Database Examples Dashboard</h1>
            <p class="subtitle">Interactive PHP Database Operations with Custom Db Library</p>
            <div class="connection-status status-connected">
                <i class="fas fa-wifi"></i> Connected to Database
            </div>
        </header>

        <div class="stats-bar">
            <div class="stat-item">
                <span class="stat-value" id="totalQueries">0</span>
                <span class="stat-label">Total Queries</span>
            </div>
            <div class="stat-item">
                <span class="stat-value" id="executionTime">0ms</span>
                <span class="stat-label">Execution Time</span>
            </div>
            <div class="stat-item">
                <span class="stat-value" id="successRate">100%</span>
                <span class="stat-label">Success Rate</span>
            </div>
        </div>

        <div class="examples-grid">
            <div class="example-card">
                <div class="card-header">
                    <i class="fas fa-plus-circle card-icon"></i>
                    <h3 class="card-title">Insert New Post</h3>
                </div>
                <p class="card-description">Create a new blog post with title, content, image, and category information.</p>
                <button class="run-button" onclick="runExample('insert')">
                    <i class="fas fa-play"></i> Run Insert Example
                </button>
                <div class="result-area" id="result-insert"></div>
            </div>

            <div class="example-card">
                <div class="card-header">
                    <i class="fas fa-list card-icon"></i>
                    <h3 class="card-title">Select All Posts</h3>
                </div>
                <p class="card-description">Retrieve all active posts from the database with proper filtering.</p>
                <button class="run-button" onclick="runExample('select')">
                    <i class="fas fa-play"></i> Run Select Example
                </button>
                <div class="result-area" id="result-select"></div>
            </div>

            <div class="example-card">
                <div class="card-header">
                    <i class="fas fa-search card-icon"></i>
                    <h3 class="card-title">Search Posts</h3>
                </div>
                <p class="card-description">Search for posts by title using LIKE queries with wildcards.</p>
                <button class="run-button" onclick="runExample('search')">
                    <i class="fas fa-play"></i> Run Search Example
                </button>
                <div class="result-area" id="result-search"></div>
            </div>

            <div class="example-card">
                <div class="card-header">
                    <i class="fas fa-edit card-icon"></i>
                    <h3 class="card-title">Update Post</h3>
                </div>
                <p class="card-description">Modify existing post data including title, content, and modification timestamp.</p>
                <button class="run-button" onclick="runExample('update')">
                    <i class="fas fa-play"></i> Run Update Example
                </button>
                <div class="result-area" id="result-update"></div>
            </div>

            <div class="example-card">
                <div class="card-header">
                    <i class="fas fa-chart-bar card-icon"></i>
                    <h3 class="card-title">Count by Category</h3>
                </div>
                <p class="card-description">Aggregate data to count posts grouped by category ID.</p>
                <button class="run-button" onclick="runExample('count')">
                    <i class="fas fa-play"></i> Run Count Example
                </button>
                <div class="result-area" id="result-count"></div>
            </div>

            <div class="example-card">
                <div class="card-header">
                    <i class="fas fa-exchange-alt card-icon"></i>
                    <h3 class="card-title">Transaction Example</h3>
                </div>
                <p class="card-description">Demonstrate transaction handling with multiple operations and rollback capability.</p>
                <button class="run-button" onclick="runExample('transaction')">
                    <i class="fas fa-play"></i> Run Transaction Example
                </button>
                <div class="result-area" id="result-transaction"></div>
            </div>

            <div class="example-card">
                <div class="card-header">
                    <i class="fas fa-archive card-icon"></i>
                    <h3 class="card-title">Archive Posts</h3>
                </div>
                <p class="card-description">Soft delete posts by setting archive flag instead of physical deletion.</p>
                <button class="run-button" onclick="runExample('archive')">
                    <i class="fas fa-play"></i> Run Archive Example
                </button>
                <div class="result-area" id="result-archive"></div>
            </div>

            <div class="example-card">
                <div class="card-header">
                    <i class="fas fa-layer-group card-icon"></i>
                    <h3 class="card-title">Pagination</h3>
                </div>
                <p class="card-description">Implement pagination with LIMIT and OFFSET for better performance.</p>
                <button class="run-button" onclick="runExample('pagination')">
                    <i class="fas fa-play"></i> Run Pagination Example
                </button>
                <div class="result-area" id="result-pagination"></div>
            </div>
        </div>

        <div class="query-log">
            <h3><i class="fas fa-code"></i> Query Log</h3>
            <div class="query-log-content" id="queryLogContent">
                <div class="info">🔍 Query execution logs will appear here...</div>
            </div>
        </div>
    </div>

    <script>
        let totalQueries = 0;
        let totalTime = 0;
        let successfulQueries = 0;

        function updateStats() {
            document.getElementById('totalQueries').textContent = totalQueries;
            document.getElementById('executionTime').textContent = totalTime.toFixed(2) + 'ms';
            document.getElementById('successRate').textContent = 
                totalQueries > 0 ? Math.round((successfulQueries / totalQueries) * 100) + '%' : '100%';
        }

        function addToQueryLog(message, type = 'info') {
            const logContent = document.getElementById('queryLogContent');
            const timestamp = new Date().toLocaleTimeString();
            const icon = type === 'success' ? '✅' : type === 'error' ? '❌' : '🔍';
            
            logContent.innerHTML += `<div class="${type}">[${timestamp}] ${icon} ${message}</div>`;
            logContent.scrollTop = logContent.scrollHeight;
        }

        function runExample(type) {
            const resultArea = document.getElementById(`result-${type}`);
            const button = event.target;
            
            // Show loading state
            button.innerHTML = '<div class="loading"></div>Running...';
            button.disabled = true;
            
            // Show result area
            resultArea.classList.add('show');
            
            // Simulate database operations
            setTimeout(() => {
                totalQueries++;
                const executionTime = Math.random() * 100 + 10; // Simulate execution time
                totalTime += executionTime;
                
                let result = '';
                let success = true;
                
                switch(type) {
                    case 'insert':
                        result = `<div class="success">✅ Post inserted successfully!</div>
                                <div>Last Insert ID: ${Math.floor(Math.random() * 1000) + 1}</div>
                                <div>Execution time: ${executionTime.toFixed(2)}ms</div>`;
                        addToQueryLog(`INSERT INTO tbl_posts executed successfully (${executionTime.toFixed(2)}ms)`, 'success');
                        break;
                        
                    case 'select':
                        const postCount = Math.floor(Math.random() * 10) + 1;
                        result = `<div class="success">✅ Found ${postCount} active posts:</div>`;
                        for(let i = 1; i <= postCount; i++) {
                            result += `<div>- ID: ${i}, Title: "Sample Post ${i}", Created: ${new Date().toISOString()}</div>`;
                        }
                        result += `<div>Execution time: ${executionTime.toFixed(2)}ms</div>`;
                        addToQueryLog(`SELECT query returned ${postCount} rows (${executionTime.toFixed(2)}ms)`, 'success');
                        break;
                        
                    case 'search':
                        const searchResults = Math.floor(Math.random() * 5) + 1;
                        result = `<div class="success">✅ Found ${searchResults} posts matching 'Blog':</div>`;
                        for(let i = 1; i <= searchResults; i++) {
                            result += `<div>- "My Blog Post ${i}" (ID: ${i})</div>`;
                        }
                        result += `<div>Execution time: ${executionTime.toFixed(2)}ms</div>`;
                        addToQueryLog(`SEARCH query with LIKE operator (${executionTime.toFixed(2)}ms)`, 'success');
                        break;
                        
                    case 'update':
                        result = `<div class="success">✅ Post updated successfully!</div>
                                <div>Affected rows: 1</div>
                                <div>Execution time: ${executionTime.toFixed(2)}ms</div>`;
                        addToQueryLog(`UPDATE query affected 1 row (${executionTime.toFixed(2)}ms)`, 'success');
                        break;
                        
                    case 'count':
                        result = `<div class="success">✅ Posts per category:</div>
                                <div>- Category ID 1: ${Math.floor(Math.random() * 10) + 1} posts</div>
                                <div>- Category ID 2: ${Math.floor(Math.random() * 10) + 1} posts</div>
                                <div>- Category ID 3: ${Math.floor(Math.random() * 10) + 1} posts</div>
                                <div>Execution time: ${executionTime.toFixed(2)}ms</div>`;
                        addToQueryLog(`COUNT with GROUP BY executed (${executionTime.toFixed(2)}ms)`, 'success');
                        break;
                        
                    case 'transaction':
                        result = `<div class="success">✅ Transaction completed successfully!</div>
                                <div>Inserted 3 posts in batch</div>
                                <div>All changes committed</div>
                                <div>Execution time: ${executionTime.toFixed(2)}ms</div>`;
                        addToQueryLog(`TRANSACTION with 3 INSERT operations committed (${executionTime.toFixed(2)}ms)`, 'success');
                        break;
                        
                    case 'archive':
                        const archivedCount = Math.floor(Math.random() * 5);
                        result = `<div class="success">✅ Archived old posts</div>
                                <div>Affected rows: ${archivedCount}</div>
                                <div>Execution time: ${executionTime.toFixed(2)}ms</div>`;
                        addToQueryLog(`ARCHIVE operation affected ${archivedCount} rows (${executionTime.toFixed(2)}ms)`, 'success');
                        break;
                        
                    case 'pagination':
                        const pageResults = Math.floor(Math.random() * 5) + 1;
                        result = `<div class="success">✅ Page 1 (showing 5 posts):</div>`;
                        for(let i = 1; i <= pageResults; i++) {
                            result += `<div>- Post ${i} (${new Date().toISOString()})</div>`;
                        }
                        result += `<div>Execution time: ${executionTime.toFixed(2)}ms</div>`;
                        addToQueryLog(`PAGINATION query with LIMIT/OFFSET (${executionTime.toFixed(2)}ms)`, 'success');
                        break;
                }
                
                if (success) {
                    successfulQueries++;
                }
                
                resultArea.innerHTML = result;
                updateStats();
                
                // Reset button
                button.innerHTML = '<i class="fas fa-play"></i> Run ' + type.charAt(0).toUpperCase() + type.slice(1) + ' Example';
                button.disabled = false;
                
            }, 1000 + Math.random() * 1000); // Simulate variable execution time
        }

        // Initialize stats
        updateStats();
        
        // Add some initial log entries
        addToQueryLog('Database connection established', 'success');
        addToQueryLog('Ready to execute queries', 'info');
    </script>
</body>
</html>