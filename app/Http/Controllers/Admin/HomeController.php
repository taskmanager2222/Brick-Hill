<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $options = [];
        $user = staffUser();

        if ($user->staff('can_create_hat_items'))
            $options[] = [route('admin.create_item.index', 'hat'), 'Create Hat', 'fas fa-hat-cowboy', '#0082ff'];

        if ($user->staff('can_create_face_items'))
            $options[] = [route('admin.create_item.index', 'face'), 'Create Face', 'fas fa-kiss-wink-heart', '#0082ff'];

        if ($user->staff('can_create_tool_items'))
            $options[] = [route('admin.create_item.index', 'tool'), 'Create Tool', 'fas fa-hammer', '#0082ff'];

        if ($user->staff('can_create_head_items'))
            $options[] = [route('admin.create_item.index', 'head'), 'Create Head', 'fas fa-head-side', '#0082ff'];

        if ($user->staff('can_view_user_info'))
            $options[] = [route('admin.users.index'), 'Users', 'fas fa-user', '#28a745'];

        if ($user->staff('can_view_item_info'))
            $options[] = [route('admin.items.index'), 'Items', 'fas fa-tshirt', '#28a745'];

        if ($user->staff('can_review_pending_assets'))
            $options[] = [route('admin.asset_approval.index', ''), 'Pending Assets', 'fas fa-image', '#ffc107'];

        if ($user->staff('can_review_pending_reports'))
            $options[] = [route('admin.reports.index'), 'Pending Reports', 'fas fa-flag', '#ffc107'];

        if ($user->staff('can_manage_forum_topics'))
            $options[] = [route('admin.manage.forum_topics.index'), 'Forum Topics', 'fas fa-comments', '#6610f2'];

        if ($user->staff('can_manage_staff'))
            $options[] = [route('admin.manage.staff.index'), 'Staff', 'fas fa-users', '#6610f2'];

        if ($user->staff('can_manage_site'))
            $options[] = [route('admin.manage.site.index'), 'Site Settings', 'fas fa-cog', '#6610f2'];

        return view('admin.index')->with([
            'options' => $options,
            'adminPoints' => $user->admin_points ?? 0
        ]);
    }
}
