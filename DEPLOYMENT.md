# Deployment Guide for Warung Pak Do

## Pre-deployment Checklist
- [ ] MySQL database created.
- [ ] Domain/Subdomain pointed to server.
- [ ] PHP 8.2+ installed.
- [ ] Composer installed.
- [ ] SSL certificate (HTTPS) ready.

## Server Requirements
- PHP 8.2+
- MySQL 8.0+
- Web Server (Nginx or Apache)
- Extensions: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML.

## Upload Project Files
1. Upload all project files (except `node_modules` and local environment files).
2. Set directory permissions: `storage` and `bootstrap/cache` must be writable.

## Database Migration
1. Export local SQL dump.
2. Import SQL dump to production MySQL database.
3. Run migrations: `php artisan migrate --force`

## Environment Configuration
1. Rename `.env.example` to `.env`.
2. Update database credentials in `.env`.
3. Set `APP_ENV=production`
4. Set `APP_DEBUG=false`
5. Generate app key: `php artisan key:generate`

## Storage & Assets
1. Link storage: `php artisan storage:link`
2. Install dependencies: `composer install --optimize-autoloader --no-dev`
3. Compile production assets: `npm install && npm run build`

## Security Notes
- Ensure `.env` is NOT publicly accessible.
- `APP_DEBUG` must be set to `false`.
- Ensure directory permissions are restrictive.

## Common Issues & Solutions
- **403 Forbidden**: Check directory permissions on `storage/` and `bootstrap/cache/`.
- **White Screen**: Check `storage/logs/laravel.log` for errors.
- **Vite Assets Not Found**: Ensure `npm run build` completed successfully.
