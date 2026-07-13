# 🚀 Quick Deployment Checklist

## Pre-Deployment (Local Environment)

- [ ] Test application locally: `php artisan serve`
- [ ] Run all tests: `php artisan test`
- [ ] Clear local cache: `php artisan cache:clear`
- [ ] Verify database migrations: `php artisan migrate:status`
- [ ] Test database seeding: `php artisan db:seed`
- [ ] Check for Laravel errors: `php artisan tinker`
- [ ] Verify all dependencies: `composer check-platform-reqs`
- [ ] Backup current production database (if existing)

---

## Environment Setup

### Shared Hosting / cPanel
```bash
# 1. Create database via cPanel
# 2. Create FTP account
# 3. Upload files to public_html/

# 4. Via SSH terminal
cd public_html/
cp .env.example .env
nano .env  # Edit database credentials

composer install --no-dev
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force

# 5. Set permissions
chmod -R 755 storage bootstrap/cache

# 6. Update document root to /public folder
```

### VPS (Ubuntu)
```bash
# Quick 3-minute setup
curl -fsSL https://your-domain.com/deploy.sh | bash

# Or manual:
sudo mkdir -p /var/www/hospital-app
cd /var/www/hospital-app
git clone <repo-url> .
cp .env.example .env
nano .env

composer install --no-dev
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force

sudo chown -R www-data:www-data .
chmod -R 755 storage bootstrap/cache
```

### Heroku
```bash
heroku create hospital-app
heroku addons:create cleardb:ignite
git push heroku main
heroku run php artisan migrate --force
heroku run php artisan db:seed
```

### DigitalOcean
```bash
# Connect GitHub → DigitalOcean App Platform
# Select repository
# Set environment variables (DB credentials)
# Deploy
```

### Docker
```bash
docker-compose up -d
docker-compose exec app php artisan migrate --force
docker-compose exec app php artisan db:seed --force
```

---

## Post-Deployment Verification

- [ ] Application accessible via domain
- [ ] Login page loads correctly
- [ ] Can login with admin credentials
- [ ] Dashboard displays statistics
- [ ] Database queries execute properly
- [ ] All menu items visible and clickable
- [ ] File uploads working (if applicable)
- [ ] Emails sending correctly (if configured)
- [ ] SSL certificate installed and working
- [ ] Redirects HTTP to HTTPS

---

## Security Hardening

- [ ] Change default admin password
  ```
  Email: admin@ghospital.gov.gh
  Password: [Change immediately]
  ```

- [ ] Set APP_DEBUG=false in .env
  ```env
  APP_DEBUG=false
  ```

- [ ] Hide Laravel version
  ```env
  APP_HIDE_LARAVEL=true
  ```

- [ ] Enable HTTPS/SSL
  ```bash
  # Let's Encrypt (free)
  sudo certbot certonly --nginx -d yourdomain.com
  ```

- [ ] Set secure file permissions
  ```bash
  chmod 755 storage bootstrap/cache
  chmod 644 .env
  chmod 755 public
  ```

- [ ] Disable directory listing
  ```nginx
  # In Nginx config
  autoindex off;
  ```

- [ ] Configure firewall (VPS)
  ```bash
  sudo ufw allow 22/tcp   # SSH
  sudo ufw allow 80/tcp   # HTTP
  sudo ufw allow 443/tcp  # HTTPS
  sudo ufw enable
  ```

- [ ] Enable automatic backups
  ```bash
  # Daily backup cron job
  0 2 * * * mysqldump -u user -p db > backup_$(date +\%Y\%m\%d).sql
  ```

---

## Performance Optimization

- [ ] Cache configuration
  ```bash
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  ```

- [ ] Optimize Composer
  ```bash
  composer install --optimize-autoloader --no-dev
  ```

- [ ] Enable database indexing
  - Already included in migrations ✓

- [ ] Setup cron job for scheduling
  ```bash
  * * * * * php /var/www/hospital-app/artisan schedule:run >> /dev/null 2>&1
  ```

- [ ] Configure CDN (optional)
  ```env
  ASSET_URL=https://cdn.yourdomain.com
  ```

---

## Monitoring Setup

### Log Monitoring
```bash
# View logs
tail -f storage/logs/laravel.log

# Or via application (if monitoring tool installed)
# Check dashboard regularly
```

### Database Monitoring
```bash
# Check database size
SELECT sum(data_length+index_length) 
FROM information_schema.tables 
WHERE table_schema='hospital_db';

# Check slow queries
SHOW VARIABLES LIKE '%slow%';
```

### Server Monitoring
- [ ] CPU usage < 80%
- [ ] RAM usage < 90%
- [ ] Disk space > 20% free
- [ ] Uptime > 99%

---

## Backup & Recovery

### Automated Daily Backup
```bash
# Add to crontab
0 2 * * * mysqldump -u hospital_user -p hospital_db | gzip > /backups/hospital_$(date +\%Y\%m\%d).sql.gz

# Keep 30 days of backups
find /backups -name "hospital_*.sql.gz" -mtime +30 -delete
```

### Manual Backup
```bash
# Database
mysqldump -u hospital_user -p hospital_db > hospital_backup.sql

# Application files
tar -czf hospital_app_backup.tar.gz /var/www/hospital-app

# Both
mysqldump -u hospital_user -p hospital_db | gzip > db_backup.sql.gz
```

### Restore from Backup
```bash
# Database
mysql -u hospital_user -p hospital_db < hospital_backup.sql

# Or from gzip
gunzip < db_backup.sql.gz | mysql -u hospital_user -p hospital_db
```

---

## Maintenance Schedule

### Daily
- [ ] Check error logs: `tail -f storage/logs/laravel.log`
- [ ] Verify application is accessible
- [ ] Check database backup completed

### Weekly
- [ ] Review application logs
- [ ] Check available disk space
- [ ] Verify backup integrity

### Monthly
- [ ] Update dependencies
  ```bash
  composer update
  composer audit
  ```
- [ ] Check security updates
  ```bash
  php artisan laravel:update
  ```
- [ ] Audit user accounts
- [ ] Review slow queries

### Quarterly
- [ ] Security audit
- [ ] Performance optimization
- [ ] Database cleanup
- [ ] Disaster recovery test

### Annually
- [ ] Complete security review
- [ ] Capacity planning
- [ ] License renewal check
- [ ] Compliance audit

---

## Troubleshooting Quick Links

| Issue | Solution |
|-------|----------|
| 500 Server Error | Check: `storage/logs/laravel.log` |
| Database Error | Verify: `.env` database credentials |
| Slow Performance | Run: `php artisan optimize` |
| Permission Error | Fix: `chmod -R 755 storage bootstrap` |
| SSL Error | Renew: `sudo certbot renew` |
| Mail Not Sending | Check: `.env` MAIL_* settings |
| File Upload Error | Verify: `storage/app/public` writable |

---

## Important Contacts

- **Hosting Support**: [Your provider contact]
- **Domain Registrar**: [Your registrar]
- **Database Backup Provider**: [Provider name]
- **SSL Certificate Provider**: Let's Encrypt / [Other]
- **Emergency Contact**: [Your contact]

---

## Deployment Statistics

| Metric | Value |
|--------|-------|
| Total Files | 51 |
| Database Tables | 8 |
| Pre-configured Users | 5 |
| User Roles | 7 |
| Permissions | 24+ |
| Views | 18 |
| Controllers | 6 |
| Migrations | 8 |

---

## What to Do After Deployment

1. ✅ Login with admin account
2. ✅ Create additional admin users
3. ✅ Change default credentials
4. ✅ Configure email settings (optional)
5. ✅ Setup automated backups
6. ✅ Enable monitoring
7. ✅ Train staff on system usage
8. ✅ Document customizations
9. ✅ Plan for maintenance
10. ✅ Setup disaster recovery

---

## Success Indicators

Once deployed, you should see:
- ✅ Application loads in < 2 seconds
- ✅ All menu items visible and functional
- ✅ Dashboard displays correct statistics
- ✅ Database queries execute properly
- ✅ No console errors (F12 DevTools)
- ✅ SSL certificate active
- ✅ All user roles working
- ✅ Search functionality working
- ✅ Pagination functional
- ✅ Backups running automatically

---

**Deployment Complete! Your Ghana Hospital Management System is now live! 🎉**

For support: See DEPLOYMENT.md for detailed guides for each platform.
