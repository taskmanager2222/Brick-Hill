<h1>
<img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework.svg" alt="License"></a>
</p>

</h1>

<br>

This project uses Laravel 8. InfinityFree supports PHP/MySQL and `.htaccess`, but it usually does not provide SSH, Git, or Composer on the server. For that reason, prepare the project locally and upload the whole folder to `htdocs`, including `vendor`.

Brick Hill names, marks, and related branding belong to Mooshimity LTD.

## License

This project is licensed under the GNU Affero General Public License v3.0 or later.
See `LICENSE` for the full license text and `THIRD_PARTY_NOTICES.md` for preserved notices from upstream MIT-licensed code.

## 1. Prepare Locally

```bash
composer install --no-dev --optimize-autoloader
copy .env.infinityfree.example .env
php artisan key:generate
```

Edit `.env` with your `MySQL Connection Details` details:

```env
APP_URL=https://example.gt.tc
DB_HOST=sqlXXX.infinityfree.com
DB_DATABASE=if0_00000000_name
DB_USERNAME=if0_00000000
DB_PASSWORD=your_mysql_password
INSTALLER_KEY=a-long-secret-key
```

Leave `MAIN_SITE_DOMAIN` and `ADMIN_SITE_DOMAIN` empty if you are using only one domain. This will make the admin panel available at `/admin`.

## 2. Upload Files

Upload all of this project's contents to `htdocs`, including:

- `app`, `bootstrap`, `config`, `database`, `public`, `resources`, `routes`, `storage`
- `vendor`
- `.env`
- `.htaccess`

## 3. Install Through The Browser

Open:

```text
https://example.gt.tc/infinityfree-install.php?key=YOUR_INSTALLER_KEY
```

Use the buttons in this order:

1. `Run database migrations`
2. `Create/update admin`
3. `Clear Laravel caches`

Afterwards, delete `public/infinityfree-install.php` from the server.

## 4. Login

Website:

```text
https://example.gt.tc
```

Admin panel:

```text
https://example.gt.tc/admin/login.php
```

## Notes

- Uploaded files and thumbnails are stored in `public/brkcdn`, served as `//brkcdn`.
- The 3D renderer is not included with InfinityFree. Without `RENDER_URL`, some thumbnail/avatar generation will not work automatically.
- If you see a 500 error, check `storage/logs/laravel.log`, folder permissions, and the MySQL details in `.env`.


## Credits

FoxxoSnoot: Made the source.

IdkHowToWx: I uploaded the source and modified it.

taskmanager: Modified it.

© 2026 Mooshimity. All Rights Reserved Brick Hill™ is a registered trademark of Mooshimity, Ltd.
