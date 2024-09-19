<?php

namespace Database\Seeders;

use App\Enums\PermissionGroup;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            
            // [ 'name' => 'Manage questions', 'permission_group' => PermissionGroup::Questions, 'description' => 'Enable to view, add, edit and delete questions'],
            // [ 'name' => 'Manage unvetted questions', 'permission_group' => PermissionGroup::Questions, 'description' => 'Enable to view, add, edit unvetted questions'],
            // [ 'name' => 'Manage vetted questions', 'permission_group' => PermissionGroup::Questions, 'description' => 'Enable to view, add, edit vetted questions'],
            // [ 'name' => 'Manage question bank', 'permission_group' => PermissionGroup::QuestionBank, 'description' => 'Enable to view questions in question bank'],
            // [ 'name' => 'Manage question papers', 'permission_group' => PermissionGroup::QuestionBank, 'description' => 'Enable to view, add, edit and delete question papers'],

            [ 'name' => 'Manage Question Scenarios', 'permission_group' => PermissionGroup::Descriptions, 'description' => 'Enable to view, add, edit and delete paper scenarios'],
            
            [ 'name' => 'Manage paper sections', 'permission_group' => PermissionGroup::Sections, 'description' => 'Enable to view, add, edit and delete paper sections'],

            //User Management
            // [ 'name' => 'Assign permissions', 'permission_group' => PermissionGroup::UserManagement, 'description' => 'Enable to assign permissions to users or roles'],
            // [ 'name' => 'Assign roles', 'permission_group' => PermissionGroup::UserManagement, 'description' => 'Enable for assigning roles to users or permissions' ],
            // [ 'name' => 'Manage roles', 'permission_group' => PermissionGroup::UserManagement, 'description' => 'Enable to create, edit and view user roles' ],
            // [ 'name' => 'Manage users', 'permission_group' => PermissionGroup::UserManagement, 'description' => 'Enable to creat, edit and view user' ],
            
            // //Customer Management
            // [ 'name' => 'Add contacts', 'permission_group' => PermissionGroup::CustomerManagement, 'description' => 'Enable to add contacts'],
            // [ 'name' => 'Update contacts', 'permission_group' => PermissionGroup::CustomerManagement, 'description' => 'Enable to edit contacts'],
            // [ 'name' => 'View contacts', 'permission_group' => PermissionGroup::CustomerManagement, 'description' => 'Enable to view contacts'],
            // [ 'name' => 'Delete contacts', 'permission_group' => PermissionGroup::CustomerManagement, 'description' => 'Enable to delete contacts'],
            // [ 'name' => 'Add customers', 'permission_group' => PermissionGroup::CustomerManagement, 'description' => 'Enable to add customers'],
            // [ 'name' => 'Update customers', 'permission_group' => PermissionGroup::CustomerManagement, 'description' => 'Enable to edit customers'],
            // [ 'name' => 'View customers', 'permission_group' => PermissionGroup::CustomerManagement, 'description' => 'Enable to view customers'],
            // [ 'name' => 'Delete customers', 'permission_group' => PermissionGroup::CustomerManagement, 'description' => 'Enable to delete customers'],

            // [ 'name' => 'Manage channels', 'permission_group' => PermissionGroup::CustomerManagement, 'description' => 'Enable to add, edit, view and delete customers'],

            // [ 'name' => 'Manage categories', 'permission_group' => PermissionGroup::CustomerManagement, 'description' => 'Enable to add, edit, view and delete Categories'],


            // [ 'name' => 'Manage teams', 'permission_group' => PermissionGroup::TicketCategories, 'description' => 'Enable to view, add, edit and delete teams'],

            // //Email Templates
            // [ 'name' => 'Add email templates', 'permission_group' => PermissionGroup::EmailTemplate, 'description' => 'Enable to add email templates'],
            // [ 'name' => 'Update email templates', 'permission_group' => PermissionGroup::EmailTemplate, 'description' => 'Enable to edit email templates'],
            // [ 'name' => 'View email templates', 'permission_group' => PermissionGroup::EmailTemplate, 'description' => 'Enable to view email templates'],
            // [ 'name' => 'Delete email templates', 'permission_group' => PermissionGroup::EmailTemplate, 'description' => 'Enable to delete email templates'],

        ];

        foreach ($permissions as $key=>$value){
            Permission::updateOrCreate(
                $value
            );
        }



    }
}