# Web Hosting Deployment Guide

Complete guide to deploying Ghana Hospital Management System to production hosting.

## Pre-Deployment Checklist

Before deploying to production, complete these steps:

```bash
# 1. Update .env for production
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# 2. Generate app key (if not already done)
php artisan key:generate

# 3. Clear cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 4. Optimize autoloader
composer install --optimize-autoloader --no-dev

# 5. Run database migrations
php artisan migrate --force

# 6. Backup your database
mysqldump -u root -p hospital_db > backup_pre_deployment.sql

# 7. Set proper file permissions
chmod -R 755 storage bootstrap/cache
chmod -R 777 storage/logs
```

---

## Platform-Specific Deployment Guides

### Option 1: Shared Hosting (cPanel/Plesk)

#### Requirements
- PHP 8.0+
- MySQL 5.7+
- SSH access
- Composer installed

#### Step-by-Step

**1. Upload Application Files**
```bash
# Via FTP or File Manager
- Upload all files to public_html/ or a subdirectory
- Do NOT upload .git, .env.local, or storage/logs
```

**2. Create MySQL Database**
```
Via cPanel:
1. Go to MySQL Databases
2. Create database: hospital_db
3. Create user: hospital_user
4. Assign user to database
5. Set password
```

**3. Configure Environment**
```bash
# Via SSH
cd public_html/
cp .env.example .env

# Edit .env with your database credentials
nano .env

# Key settings:
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=hospital_db
DB_USERNAME=hospital_user
DB_PASSWORD=your_strong_password
```

**4. Install Dependencies**
```bash
# Via SSH
composer install --no-dev

# Generate key
php artisan key:generate
```

**5. Setup Database**
```bash
php artisan migrate --force
php artisan db:seed --force
```

**6. Set Permissions**
```bash
# Make directories writable
chmod -R 755 storage bootstrap/cache
chmod -R 755 public

# Set proper ownership (ask hosting provider if needed)
chown -R nobody:nobody storage bootstrap/cache
```

**7. Configure Document Root**
```
Via cPanel:
- Go to Addon Domains (if subdomain)
- Or modify Document Root to point to /public directory
- Restart Apache/Nginx
```

**8. Setup SSL Certificate**
```
Via cPanel:
1. Go to AutoSSL
2. Install certificate for your domain
3. Update APP_URL in .env to https://
```

---

### Option 2: VPS (Ubuntu/CentOS)

#### Requirements
- Root or sudo access
- Basic Linux knowledge
- SSH client

#### Complete Setup Script

**1. Update System**
```bash
sudo apt update
sudo apt upgrade -y
```

**2. Install PHP & MySQL**
```bash
# PHP 8.1
sudo apt install -y php8.1 php8.1-mysql php8.1-xml php8.1-zip php8.1-bcmath

# MySQL 8.0
sudo apt install -y mysql-server

# Nginx
sudo apt install -y nginx

# Composer
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
```

**3. Create Application Directory**
```bash
sudo mkdir -p /var/www/hospital-app
cd /var/www/hospital-app

# Clone repository
git clone https://github.com/paulgeek/hospital-management-system.git .
```

**4. Configure Application**
```bash
cp .env.example .env

# Edit .env
sudo nano .env

# Set:
APP_ENV=production
APP_DEBUG=false
DB_HOST=localhost
DB_DATABASE=hospital_db
DB_USERNAME=hospital_user
DB_PASSWORD=strong_password
```

**5. Install Dependencies**
```bash
composer install --no-dev
php artisan key:generate
```

**6. Setup Database**
```bash
# Login to MySQL
sudo mysql

# Create database and user
CREATE DATABASE hospital_db;
CREATE USER 'hospital_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON hospital_db.* TO 'hospital_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# Run migrations
php artisan migrate --force
php artisan db:seed --force
```

**7. Configure Web Server (Nginx)**
```bash
# Create Nginx config
sudo nano /etc/nginx/sites-available/hospital-app

# Paste configuration:
```

```nginx
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    
    root /var/www/hospital-app/public;
    index index.php;

    # Redirect HTTP to HTTPS
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name yourdomain.com www.yourdomain.com;
    
    ssl_certificate /etc/ssl/certs/your-cert.crt;
    ssl_certificate_key /etc/ssl/private/your-key.key;
    
    root /var/www/hospital-app/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

**8. Enable Site & Setup SSL**
```bash
# Enable site
sudo ln -s /etc/nginx/sites-available/hospital-app /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx

# Install Let's Encrypt SSL
sudo apt install -y certbot python3-certbot-nginx
sudo certbot certonly --nginx -d yourdomain.com -d www.yourdomain.com
```

**9. Set Permissions**
```bash
sudo chown -R www-data:www-data /var/www/hospital-app
sudo chmod -R 755 storage bootstrap/cache
sudo chmod -R 777 storage/logs
```

**10. Setup Cron Job for Scheduling**
```bash
# Edit crontab
sudo crontab -e

# Add this line:
* * * * * cd /var/www/hospital-app && php artisan schedule:run >> /dev/null 2>&1
```

---

### Option 3: Heroku (Cloud Platform)

#### Requirements
- Heroku account
- Heroku CLI installed
- Git installed

#### Deployment Steps

**1. Create Heroku App**
```bash
heroku create hospital-management-system
```

**2. Add MySQL Add-on**
```bash
heroku addons:create cleardb:ignite -a hospital-management-system
```

**3. Configure Environment**
```bash
heroku config:set APP_KEY=$(php artisan key:generate --show) -a hospital-management-system
heroku config:set APP_ENV=production -a hospital-management-system
heroku config:set APP_DEBUG=false -a hospital-management-system
```

**4. Create Procfile**
```bash
cat > Procfile << EOF
web: vendor/bin/heroku-php-apache2 public/
release: php artisan migrate --force
EOF
```

**5. Deploy**
```bash
git push heroku main

# Run seeders
heroku run php artisan db:seed -a hospital-management-system
```

**6. View Logs**
```bash
heroku logs --tail -a hospital-management-system
```

---

### Option 4: DigitalOcean App Platform

#### Step-by-Step

**1. Create Git Repository**
```bash
git init
git add .
git commit -m "Hospital Management System"
git push origin main
```

**2. Connect DigitalOcean to GitHub**
- Go to DigitalOcean Console
- Click "Apps"
- Click "Create App"
- Select your GitHub repository

**3. Configure App**
- Framework: PHP/Laravel
- Environment: Production
- Add MySQL database

**4. Set Environment Variables**
```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.ondigitalocean.app
DB_CONNECTION=mysql
DB_HOST=db-mysql-nyc1-xxxxx.ondigitalocean.com
DB_DATABASE=hospital_db
DB_USERNAME=hospital_user
DB_PASSWORD=your_password
```

**5. Deploy**
- Click "Deploy"
- DigitalOcean will build and deploy automatically

**6. Run Migrations**
```bash
# Via DigitalOcean Console
doctl apps create-deployment <app-id> --source-digest <commit-sha>
```

---

### Option 5: AWS (Amazon Web Services)

#### Using Elastic Beanstalk

**1. Install AWS CLI & EB CLI**
```bash
pip install awscli eb-cli
aws configure
```

**2. Initialize Elastic Beanstalk**
```bash
eb init -p "PHP 8.1" hospital-app
eb create hospital-app-env
```

**3. Configure Environment Variables**
```bash
eb setenv \
    APP_ENV=production \
    APP_DEBUG=false \
    DB_HOST=your-rds-endpoint.rds.amazonaws.com \
    DB_DATABASE=hospital_db \
    DB_USERNAME=hospital_user \
    DB_PASSWORD=strong_password
```

**4. Deploy**
```bash
eb deploy
```

**5. Setup RDS Database**
```
AWS Console:
1. Go to RDS
2. Create MySQL instance
3. Get endpoint and credentials
4. Update environment variables
```

**6. Enable HTTPS**
```
AWS Console:
1. Request SSL certificate from ACM
2. Attach to ALB
3. Update APP_URL to https://
```

---

### Option 6: Docker Deployment

#### Create Docker Setup

**1. Create Dockerfile**
```dockerfile
FROM php:8.1-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    mysql-client \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    bcmath \
    zip \
    xml

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Generate key
RUN php artisan key:generate

# Set permissions
RUN chown -R www-data:www-data /app

CMD ["php-fpm"]
```

**2. Create docker-compose.yml**
```yaml
version: '3.8'

services:
  app:
    build: .
    ports:
      - "9000:9000"
    volumes:
      - ./:/app
    environment:
      - DB_HOST=mysql
      - DB_DATABASE=hospital_db
      - DB_USERNAME=hospital_user
      - DB_PASSWORD=password
    depends_on:
      - mysql

  mysql:
    image: mysql:8.0
    ports:
      - "3306:3306"
    environment:
      - MYSQL_DATABASE=hospital_db
      - MYSQL_ROOT_PASSWORD=root_password
      - MYSQL_USER=hospital_user
      - MYSQL_PASSWORD=password
    volumes:
      - db_data:/var/lib/mysql

  nginx:
    image: nginx:alpine
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./:/app
      - ./nginx.conf:/etc/nginx/conf.d/default.conf
    depends_on:
      - app

volumes:
  db_data:
```

**3. Deploy with Docker**
```bash
docker-compose up -d
docker-compose exec app php artisan migrate --force
docker-compose exec app php artisan db:seed --force
```

---

## Post-Deployment Configuration

### 1. Enable HTTPS/SSL

```bash
# Certbot (Let's Encrypt)
sudo certbot certonly --nginx -d yourdomain.com

# Update .env
APP_URL=https://yourdomain.com
```

### 2. Setup Email (Optional)

```env
# In .env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=support@ghospital.gov.gh
MAIL_FROM_NAME="Ghana Hospital Management System"
```

### 3. Database Backup

```bash
# Daily automated backup
0 2 * * * mysqldump -u hospital_user -p hospital_db > /backups/hospital_$(date +\%Y\%m\%d).sql

# Or use backup service
# AWS S3, DigitalOcean Spaces, Google Cloud Storage
```

### 4. Performance Optimization

```bash
# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader

# Clear old cache if needed
php artisan cache:clear
php artisan view:clear
```

### 5. Monitoring & Logging

```env
# Enable detailed logging
LOG_CHANNEL=stack
LOG_LEVEL=debug

# Send logs to external service
LOG_SLACK_WEBHOOK_URL=your-webhook-url
```

---

## Security Recommendations

### 1. Environment Variables
- Never commit .env to Git
- Use platform secrets management
- Rotate keys regularly

### 2. Database Security
- Use strong passwords (min 16 characters)
- Enable SSL for database connections
- Regular backups
- Restrict database access to app only

### 3. Application Security
- Keep Laravel and packages updated: `composer update`
- Run security checks: `composer audit`
- Enable HTTPS only
- Set secure cookie flags
- Use rate limiting

### 4. File Permissions
```bash
# Correct permissions
chmod 755 bootstrap/cache storage
chmod 644 .env
chmod 755 public
chmod 755 artisan
```

### 5. Admin Credentials
- Change default admin password immediately
- Use strong passwords
- Enable 2FA if possible
- Audit user accounts regularly

---

## Troubleshooting Deployment

### Issue: 500 Server Error

**Solution:**
```bash
# Check logs
tail -f storage/logs/laravel.log

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Check permissions
sudo chown -R www-data:www-data storage bootstrap
chmod -R 755 storage bootstrap
```

### Issue: Database Connection Error

**Solution:**
```bash
# Verify .env database settings
cat .env | grep DB_

# Test connection
php artisan tinker
DB::connection()->getPdo();

# Check MySQL status
sudo systemctl status mysql
sudo mysql -u root -p
```

### Issue: Slow Performance

**Solution:**
```bash
# Enable caching
php artisan config:cache
php artisan route:cache

# Optimize database
php artisan optimize
composer install --optimize-autoloader

# Check slow queries
SET GLOBAL slow_query_log = 'ON';
SET GLOBAL long_query_time = 2;
```

### Issue: SSL Certificate Error

**Solution:**
```bash
# Renew certificate
sudo certbot renew

# Check certificate
sudo certbot certificates

# Auto-renew
sudo systemctl enable certbot.timer
```

---

## Recommended Hosting Providers

| Provider | Best For | Cost | Setup |
|----------|----------|------|-------|
| **Heroku** | Quick deployment | $7-50/month | Very Easy |
| **DigitalOcean** | Balance of cost/performance | $4-24/month | Easy |
| **AWS** | Enterprise/scaling | Pay-as-you-go | Moderate |
| **Linode** | VPS with good support | $5-30/month | Moderate |
| **Shared Hosting** | Budget-friendly | $5-15/month | Easy |
| **Docker (Any Platform)** | Flexibility | Varies | Complex |

---

## Monitoring & Maintenance

### Daily Tasks
- Check error logs
- Monitor database size
- Verify backups completed

### Weekly Tasks
- Review application logs
- Check for security updates
- Test backup restoration

### Monthly Tasks
- Update dependencies: `composer update`
- Run security audit: `composer audit`
- Review user accounts
- Analyze performance metrics

### Quarterly Tasks
- Security audit
- Database optimization
- Review disaster recovery plan
- Test failover procedures

---

## Domain & DNS Setup

```
DNS Records Needed:

A Record:
  @  ->  your-server-ip

CNAME Record (for www):
  www  ->  yourdomain.com

MX Records (if using email):
  mail.yourdomain.com (priority 10)

TXT Record (for DKIM):
  Add mail authentication records
```

---

## Support Resources

- **Laravel Docs**: https://laravel.com/docs
- **Deployment Guides**: https://laravel.com/docs/9.x/deployment
- **Health & Hospital Systems**: Contact your hosting provider
- **Emergency Support**: Depends on hosting plan

---

**Your Ghana Hospital Management System is ready for production deployment!** 🚀
