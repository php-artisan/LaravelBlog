<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Permission;

class RoleAndUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();
        DB::table('permissions')->delete();
        DB::table('users')->delete();
        DB::table('permission_role')->delete();
        DB::table('role_user')->delete();
        // Create Roles
        $subscriberRole = Role::create([
            'name' => '订阅者',
            'slug' => 'subscriber',
        ]);
        $contributorRole = Role::create([
            'name' => '投稿者',
            'slug' => 'contributor',
        ]);
        $authorRole = Role::create([
            'name' => '作者',
            'slug' => 'author',
        ]);
        $editorRole = Role::create([
            'name' => '编辑',
            'slug' => 'editor',
        ]);
        $adminRole = Role::create([
            'name' => '管理员',
            'slug' => 'admin',
        ]);
        // Create Permission
        $createArticlePermission = Permission::create([
            'name' => '发布文章',
            'slug' => 'article.create',
        ]);
        $uploadImagePermission = Permission::create([
            'name' => '上传图片',
            'slug' => 'image.upload',
        ]);
        $manageArticlePermission = Permission::create([
            'name' => '文章管理',
            'slug' => 'article.manage',
        ]);
        $manageImagePermission = Permission::create([
            'name' => '图片管理',
            'slug' => 'image.manage',
        ]);
        $manageUserPermission = Permission::create([
            'name' => '用户管理',
            'slug' => 'user.manage',
        ]);
        $manageSystemPermission = Permission::create([
            'name' => '系统设置',
            'slug' => 'system.manage',
        ]);

        $contributorRole->assignPermission($createArticlePermission->id);

        $authorRole->assignPermission($createArticlePermission->id);
        $authorRole->assignPermission($uploadImagePermission->id);

        $editorRole->assignPermission($createArticlePermission->id);
        $editorRole->assignPermission($uploadImagePermission->id);
        $editorRole->assignPermission($manageArticlePermission->id);
        $editorRole->assignPermission($manageImagePermission->id);

        // Create User
        $admin = User::create([
            'name' => env('ADMIN_NAME', 'Admin'),
            'email' => env('ADMIN_EMAIL', 'admin@laravel.blog'),
            'password' => bcrypt(env('ADMIN_PASSWORD', 'password'))
        ]);
        if(! $admin->save()) {
            Log::info('Unable to create admin '.$admin->username, (array)$admin->errors());
        } else {
            $admin->assignRole($adminRole->id);
            Log::info('Created admin "'.$admin->username.'" <'.$admin->email.'>');
        }
    }
}
