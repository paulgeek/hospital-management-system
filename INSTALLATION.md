# Installation & Setup Guide

## System Requirements

- **PHP**: 8.0 or higher
- **Laravel**: 9.0 or higher
- **MySQL**: 5.7 or higher
- **Composer**: Latest version
- **Node.js**: 14.0 or higher (optional, for asset compilation)

## Step-by-Step Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd hospital-management-system
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Environment Configuration

```bash
# Copy example environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

Edit `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hospital_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Create Database

```bash
# Create database in MySQL
mysql -u root -p -e "CREATE DATABASE hospital_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 5. Run Migrations

```bash
php artisan migrate
```

### 6. Seed Database with Default Data

```bash
php artisan db:seed
```

This will create:
- Default system roles and permissions
- 5 test healthcare facilities
- 5 test user accounts with different roles
- Admin account with credentials

### 7. Start Development Server

```bash
php artisan serve
```

The application will be available at: `http://localhost:8000`

## Default Login Credentials

After seeding, use these credentials to login:

### Administrator
- **Email**: admin@ghospital.gov.gh
- **Password**: Admin@123456

### Test Accounts

| Role | Email | Password |
|------|-------|----------|
| Doctor | doctor@ghospital.gov.gh | Doctor@12345 |
| Nurse | nurse@ghospital.gov.gh | Nurse@12345 |
| NHIS Officer | nhis@ghospital.gov.gh | NHIS@12345 |
| Finance Officer | finance@ghospital.gov.gh | Finance@12345 |

## Production Deployment

### 1. Set Environment to Production

Edit `.env`:
```env
APP_ENV=production
APP_DEBUG=false
```

### 2. Optimize for Production

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. Set Proper Permissions

```bash
chmod -R 755 storage bootstrap/cache
chmod -R 777 storage bootstrap/cache
```

### 4. Configure Web Server

#### Apache (.htaccess already included)

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews
    </IfModule>

    RewriteEngine On
    RewriteBase /

    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^ index.php [QSA,L]
</IfModule>
```

#### Nginx

```nginx
server {
    listen 80;
    server_name example.com;

    root /var/www/html/hospital-management-system/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### 5. Enable SSL Certificate

Use Let's Encrypt or your preferred SSL provider.

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Verify MySQL is running
   - Check `.env` database credentials
   - Ensure database exists

2. **Permission Denied Errors**
   - Run: `chmod -R 755 storage bootstrap/cache`

3. **Class Not Found Error**
   - Run: `composer dump-autoload`

4. **Migration Errors**
   - Run: `php artisan migrate:refresh --seed`
   - Check Laravel logs: `storage/logs/laravel.log`

5. **Port 8000 Already in Use**
   - Use different port: `php artisan serve --port=8001`

## Database Backup

### Regular Backups

```bash
# Backup database
mysqldump -u root -p hospital_db > backup_$(date +%Y%m%d_%H%M%S).sql

# Restore from backup
mysql -u root -p hospital_db < backup_file.sql
```

## Scheduled Tasks

Add to crontab for automatic scheduling:

```bash
* * * * * php /path/to/hospital-management-system/artisan schedule:run
```

## Security Best Practices

1. **Change Default Passwords**: Update all test account passwords
2. **Update Dependencies**: Run `composer update` regularly
3. **Enable HTTPS**: Always use SSL/TLS certificates
4. **Backup Data**: Regular database backups
5. **Monitor Logs**: Check application logs regularly
6. **User Access Control**: Assign proper roles and permissions

## Support

For technical support and issues:
- Email: support@ghospital.gov.gh
- Documentation: /docs directory
- Issue Tracker: GitHub repository

## Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [PHP Documentation](https://www.php.net/manual/)
