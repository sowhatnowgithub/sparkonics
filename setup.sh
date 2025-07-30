#!/bin/bash

# Sparkonics Docker Setup Script
set -e

echo "🚀 Setting up Sparkonics Docker environment..."

# Create necessary directories
echo "📁 Creating directory structure..."
mkdir -p nginx/ssl nginx/logs

# Copy nginx configuration to the correct location
if [ ! -f "nginx/nginx.conf" ]; then
    echo "📋 nginx.conf not found in nginx/ directory!"
    echo "Please make sure you have the nginx.conf file in the nginx/ directory"
    echo "You can find it in the nginx-config artifact"
    exit 1
fi

# Generate self-signed SSL certificate if it doesn't exist
if [ ! -f "nginx/ssl/sparkonics.crt" ] || [ ! -f "nginx/ssl/sparkonics.key" ]; then
    echo "🔐 Generating self-signed SSL certificate..."
    openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
        -keyout nginx/ssl/sparkonics.key \
        -out nginx/ssl/sparkonics.crt \
        -subj "/C=US/ST=State/L=City/O=Sparkonics/CN=localhost"
    echo "✅ SSL certificate generated"
else
    echo "✅ SSL certificate already exists"
fi

# Set proper permissions
echo "🔧 Setting permissions..."
chmod 600 nginx/ssl/sparkonics.key
chmod 644 nginx/ssl/sparkonics.crt

# Create .env file if it doesn't exist
if [ ! -f ".env" ]; then
    echo "📝 Creating .env file..."
    cat > .env << 'EOF'
# Environment Configuration
PHP_ENV=production
NGINX_HOST=localhost
NGINX_PORT=443

# Database Configuration (if needed)
DB_HOST=localhost
DB_PORT=3306
DB_NAME=sparkonics
DB_USER=root
DB_PASSWORD=

# API Configuration
API_PORT=1978
WS_PORT=9501

# SSL Configuration
SSL_CERT_PATH=/etc/nginx/ssl/sparkonics.crt
SSL_KEY_PATH=/etc/nginx/ssl/sparkonics.key
EOF
    echo "✅ .env file created"
else
    echo "✅ .env file already exists"
fi

# Create composer.json if it doesn't exist
if [ ! -f "composer.json" ]; then
    echo "📦 Creating composer.json..."
    cat > composer.json << 'EOF'
{
    "name": "sparkonics/web-app",
    "description": "Sparkonics Web Application",
    "type": "project",
    "require": {
        "php": ">=8.2",
        "openswoole/ide-helper": "^22.0"
    },
    "require-dev": {
        "phpunit/phpunit": "^10.0"
    },
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Api\\": "api/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests/"
        }
    },
    "config": {
        "optimize-autoloader": true,
        "sort-packages": true
    },
    "minimum-stability": "stable",
    "prefer-stable": true
}
EOF
    echo "✅ composer.json created"
else
    echo "✅ composer.json already exists"
fi

# Create health check script for API
echo "🏥 Creating health check endpoints..."
mkdir -p api
if [ ! -f "api/health.php" ]; then
    cat > api/health.php << 'EOF'
<?php
header('Content-Type: application/json');
header('Cache-Control: no-cache');

$response = [
    'status' => 'healthy',
    'timestamp' => time(),
    'service' => 'sparkonics-api'
];

echo json_encode($response);
EOF
fi

# Create basic 404 and 50x error pages
echo "📄 Creating error pages..."
mkdir -p public
if [ ! -f "public/404.html" ]; then
    cat > public/404.html << 'EOF'
<!DOCTYPE html>
<html>
<head>
    <title>404 - Page Not Found</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        .error-container { max-width: 600px; margin: 0 auto; }
        h1 { color: #e74c3c; font-size: 72px; margin: 0; }
        p { color: #7f8c8d; font-size: 18px; }
        a { color: #3498db; text-decoration: none; }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>404</h1>
        <p>The page you're looking for doesn't exist.</p>
        <a href="/">Return to Homepage</a>
    </div>
</body>
</html>
EOF
fi

if [ ! -f "public/50x.html" ]; then
    cat > public/50x.html << 'EOF'
<!DOCTYPE html>
<html>
<head>
    <title>500 - Server Error</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        .error-container { max-width: 600px; margin: 0 auto; }
        h1 { color: #e74c3c; font-size: 72px; margin: 0; }
        p { color: #7f8c8d; font-size: 18px; }
        a { color: #3498db; text-decoration: none; }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>500</h1>
        <p>Something went wrong on our end.</p>
        <a href="/">Return to Homepage</a>
    </div>
</body>
</html>
EOF
fi

echo "🐳 Building and starting Docker containers..."
docker-compose down --remove-orphans
docker-compose build --no-cache
docker-compose up -d

echo "⏳ Waiting for services to start..."
sleep 10

# Check if services are running
echo "🔍 Checking service health..."
if docker-compose ps | grep -q "Up"; then
    echo "✅ Services are running!"
    echo ""
    echo "🌐 Your application is available at:"
    echo "   HTTP:  http://localhost (redirects to HTTPS)"
    echo "   HTTPS: https://localhost"
    echo "   API:   https://localhost/api/"
    echo "   WS:    wss://localhost/ws"
    echo ""
    echo "📊 To view logs:"
    echo "   docker-compose logs -f"
    echo ""
    echo "🛑 To stop services:"
    echo "   docker-compose down"
else
    echo "❌ Some services failed to start. Check logs:"
    echo "   docker-compose logs"
fi

echo ""
echo "🎉 Setup complete!"
