<?php

namespace Database\Seeders;

use App\Enums\EmailTemplateModule;
use App\Models\EmailTemplate;
use App\Models\EmailTemplateFolder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $folder = EmailTemplateFolder::updateOrCreate(
            [ 'name' => 'Public Email Templates'],
            [
                'description' => 'Holds all public email templates',
                'is_system_template' => true
            ]
        );

        $templates = [
            [
                'email_template_folder_id' => $folder->id,
                'module' => EmailTemplateModule::Ticket,
                'name' => 'Ticket Assigned',
                'email_subject' => 'Ticket Assignment',
                'message' => 'You have been assigned ticket',
                'is_system_template' => true
            ],
        ];

        foreach ($templates as $key=>$value){
            EmailTemplate::updateOrCreate(
                $value
            );
        }
    }
}
