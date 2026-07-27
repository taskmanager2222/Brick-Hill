<?php

use App\Models\StaffUser;
use App\Models\User;
use App\Models\UserAvatar;
use App\Models\UserSettings;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

require __DIR__ . '/../vendor/autoload.php';

const INFINITYFREE_INSTALLER_VERSION = '2026-06-21-staff-db-fix';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$key = env('INSTALLER_KEY');
$providedKey = $_POST['key'] ?? $_GET['key'] ?? '';

if (!$key || !hash_equals($key, $providedKey)) {
    http_response_code(403);
    exit('Forbidden. Set INSTALLER_KEY in .env and pass it as ?key=...');
}

$message = null;
$error = null;

function installer_create_storage_dirs(): void
{
    $directories = [
        public_path('brkcdn'),
        public_path('brkcdn/uploads'),
        public_path('brkcdn/thumbnails'),
        public_path('brkcdn/thumbnails/avatars'),
        public_path('brkcdn/thumbnails/clans'),
        public_path('brkcdn/thumbnails/games'),
        public_path('brkcdn/thumbnails/items'),
        public_path('brkcdn/default'),
        public_path('brkcdn/default/games'),
        storage_path('framework/cache/data'),
        storage_path('framework/sessions'),
        storage_path('framework/views'),
        storage_path('logs'),
    ];

    foreach ($directories as $directory) {
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
    }
}

function installer_staff_permissions(): array
{
    return [
        'can_view_item_info',
        'can_edit_item_info',
        'can_scrub_item_info',
        'can_create_hat_items',
        'can_create_face_items',
        'can_create_tool_items',
        'can_create_head_items',
        'can_view_user_info',
        'can_view_user_emails',
        'can_edit_user_info',
        'can_scrub_user_info',
        'can_reset_user_passwords',
        'can_give_items',
        'can_give_currency',
        'can_take_items',
        'can_take_currency',
        'can_ban_users',
        'can_unban_users',
        'can_ip_ban_users',
        'can_ip_unban_users',
        'can_review_pending_assets',
        'can_review_pending_reports',
        'can_edit_forum_posts',
        'can_delete_forum_posts',
        'can_pin_forum_posts',
        'can_lock_forum_posts',
        'can_manage_forum_categories',
        'can_manage_forum_topics',
        'can_manage_staff',
        'can_manage_site',
        'can_render_thumbnails',
    ];
}

try {
    installer_create_storage_dirs();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        if ($action === 'migrate') {
            Artisan::call('migrate', ['--force' => true]);
            $message = nl2br(e(Artisan::output()));
        }

        if ($action === 'clear') {
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            Artisan::call('cache:clear');
            $message = 'Caches cleared.';
        }

        if ($action === 'admin') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (!$username || !$password) {
                throw new RuntimeException('Username and password are required.');
            }

            DB::transaction(function () use ($username, $email, $password) {
                $user = User::firstOrCreate(
                    ['username' => $username],
                    [
                        'email' => $email ?: null,
                        'password' => Hash::make($password),
                        'next_currency_payout' => now(),
                    ]
                );

                $user->password = Hash::make($password);
                $user->email = $email ?: $user->email;
                $user->save();

                $avatar = UserAvatar::where('user_id', $user->id)->first() ?: new UserAvatar;
                $avatar->user_id = $user->id;
                $avatar->save();

                $settings = UserSettings::where('user_id', $user->id)->first() ?: new UserSettings;
                $settings->user_id = $user->id;
                $settings->save();

                $staffData = [
                    'user_id' => $user->id,
                    'password' => Hash::make($password),
                    'ping' => time(),
                    'updated_at' => now(),
                ];

                foreach (installer_staff_permissions() as $permission) {
                    $staffData[$permission] = true;
                }

                $staffUser = StaffUser::where('user_id', $user->id)->first();

                if ($staffUser) {
                    DB::table('staff_users')->where('user_id', $user->id)->update($staffData);
                } else {
                    $staffData['created_at'] = now();
                    DB::table('staff_users')->insert($staffData);
                }
            });

            $message = 'Admin user created or updated.';
        }
    }
} catch (Throwable $exception) {
    $error = $exception->getMessage();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>InfinityFree Installer</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 760px; margin: 40px auto; padding: 0 16px; line-height: 1.5; }
        form { border: 1px solid #ddd; padding: 16px; margin: 16px 0; }
        input { display: block; width: 100%; box-sizing: border-box; margin: 8px 0 12px; padding: 8px; }
        button { padding: 8px 14px; cursor: pointer; }
        .ok { background: #e6ffed; border: 1px solid #9be9a8; padding: 12px; }
        .error { background: #ffebe9; border: 1px solid #ff8182; padding: 12px; }
        code { background: #f6f8fa; padding: 2px 4px; }
    </style>
</head>
<body>
    <h1>InfinityFree Installer</h1>
    <p>Version: <code><?= e(INFINITYFREE_INSTALLER_VERSION) ?></code></p>
    <p>Delete this file after setup: <code>public/infinityfree-install.php</code>.</p>

    <?php if ($message): ?><div class="ok"><?= $message ?></div><?php endif; ?>
    <?php if ($error): ?><div class="error"><?= e($error) ?></div><?php endif; ?>

    <form method="post">
        <input type="hidden" name="key" value="<?= e($providedKey) ?>">
        <input type="hidden" name="action" value="migrate">
        <button type="submit">Run database migrations</button>
    </form>

    <form method="post">
        <input type="hidden" name="key" value="<?= e($providedKey) ?>">
        <input type="hidden" name="action" value="clear">
        <button type="submit">Clear Laravel caches</button>
    </form>

    <form method="post">
        <input type="hidden" name="key" value="<?= e($providedKey) ?>">
        <input type="hidden" name="action" value="admin">
        <label>Admin username</label>
        <input name="username" required>
        <label>Email</label>
        <input name="email" type="email">
        <label>Password</label>
        <input name="password" type="password" required>
        <button type="submit">Create/update admin</button>
    </form>
</body>
</html>
