<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admin = Role::find(1);

        // Define new roles
        $corpusCoranicumRole = new Role();
        $corpusCoranicumRole->name = "corpuscoranicum";
        $corpusCoranicumRole->display_name = "Corpus Coranicum Group";
        $corpusCoranicumRole->description = "Members of the Corpus Coranicum project. Editing access to all CC-relevant modules";
        $corpusCoranicumRole->save();

        $paleocoranRole = new Role();
        $paleocoranRole->name = "paleocoran_role";
        $paleocoranRole->display_name = "Paleocoran Group";
        $paleocoranRole->description = "Members of the Paleocoran project. Editing access to all Paleocoran relevant modules";
        $paleocoranRole->save();

        // Define new permissions
        $blogPermission = new Permission();
        $blogPermission->name = "blog_permission";
        $blogPermission->display_name = "Blog Editing Permission";
        $blogPermission->description = "User may edit blog entries";
        $blogPermission->save();

        $manuscriptPermission = new Permission();
        $manuscriptPermission->name = "handschriften_permission";
        $manuscriptPermission->display_name = "Manuscript Editing Permission";
        $manuscriptPermission->description = "User may edit manuscript and manuscript pages entries";
        $manuscriptPermission->save();

        $readingsPermission = new Permission();
        $readingsPermission->name = "lesarten_permission";
        $readingsPermission->display_name = "Variant Reading Editing Permission";
        $readingsPermission->description = "User may edit variant readings (Lesarten) entries";
        $readingsPermission->save();

        $umwelttextePermission = new Permission();
        $umwelttextePermission->name = "umwelttexte_permission";
        $umwelttextePermission->display_name = "TUK Editing Permission";
        $umwelttextePermission->description = "User may edit variant context (TUK) entries";
        $umwelttextePermission->save();

        $glossaryPermission = new Permission();
        $glossaryPermission->name = "glossar_permission";
        $glossaryPermission->display_name = "Glossary Editing Permission";
        $glossaryPermission->description = "User may edit glossary entries";
        $glossaryPermission->save();

        $ccTranslationsPermission = new Permission();
        $ccTranslationsPermission->name = "translation_cc_permission";
        $ccTranslationsPermission->display_name = "Translation (CC) Editing Permission";
        $ccTranslationsPermission->description = "User may translation entries for the Corpus Coranicum Project";
        $ccTranslationsPermission->save();

        $eventsPermission = new Permission();
        $eventsPermission->name = "events_permission";
        $eventsPermission->display_name = "Events (CC) Editing Permission";
        $eventsPermission->description = "User may event entries for the Corpus Coranicum Project";
        $eventsPermission->save();

        // Attach permissions
        $corpusCoranicumRole->attachPermission($blogPermission);
        $corpusCoranicumRole->attachPermission($manuscriptPermission);
        $corpusCoranicumRole->attachPermission($readingsPermission);
        $corpusCoranicumRole->attachPermission($umwelttextePermission);
        $corpusCoranicumRole->attachPermission($glossaryPermission);
        $corpusCoranicumRole->attachPermission($ccTranslationsPermission);
        $corpusCoranicumRole->attachPermission($eventsPermission);

        $paleocoranRole->attachPermission($manuscriptPermission);
        $paleocoranRole->attachPermission($readingsPermission);
        
    }
}
