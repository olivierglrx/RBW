


# Rubidium web plugin V2.2

## Architecture


* index.php : first file read by WP.  Controls the inclusion of other files. It includes each index_subplugin.php of other folders. 
* cpt.php : Include all cpts. CPT will be singular name. 
* taconomies.php : Include all taxonomies. 
* Test >
    * test_index.php : create a test menu on the left to test codes. Very usefull in dev. 
    * test.js : use to make js test.  
    * test.css : use to make css test.  
* SuperAdmin >
    * index_superadmin.php : include others files of SuperAdmin, 
    * initial_plugin.php : create options "activated_plugins", "activated_acf_on_back","activated_site_options_list" and fill them with default values. 
    * activated_plugins.php :  
        1. Add Menu : 'RbW plugins'.
        2. Update the option "activated_plugins" The option 'activated_plugins' is an array with value the same string as the buttons WITHOUT spaces.
        3. Load the 'activated_button_js.js' ajax script for saving the option.  
    * functions_superadmin.php : create functions that can be used in all others files (eg. get_cpt, on_off_button)
    * show_ACF_back.php :   handle which acf will be displayed. Of course ACF have to be loaded first !  :warning: **:Warning:** **Change ACF-json Load endpoint !**
    * show_ACF_options.php : handle which acf-options (ie site-options) will be displayed. Of 
    course ACF options have to be loaded first !  (ACF plugin  is required) 
    * Functionalities >
        * ACF_to_WP_title.php : Modify the wordpress title according to the appropriate ACF .
        * add_post_to_front_menu.php : fill automatically menus with posts. It creates a new cpt "custom_menu", each post is to include all posts of a CPT inside a submenu. 
        * customiation_acf.php : Fill some acf choices with default values, handle autofill of some ACF...
        * cleaning_dashboard.php : 
            // 1 - Remove separator
            // 2 - Remove not necessary in wp_admin_bar
            // 3 - Remove not necessary in menu
            // 4 - Remove WP update
            // 5 - Remove warnings
            // 6 - Change the howdy menu
            // 7 - Remove publish meta box
            // 8 - Dashboard page customisation 
            // 9 - change media name
            // 10- Create option pages for every CPT
        * role.php : Delete WP role. Create RbW roles. Create the option "hide_show_menu" for deciding which menu sees each role.  Cleaning_dashboard and Role work together. 
        * multilingue.php : handle multilingue site, create a Session variable. 
        * token.php : create and handle tokens.
        
    
* publications > 
    * index_publications.php : 
        1. Load CPT  - from the cpt.php file in the root folder
        2. Load the taxonomies 
        3. Insert the submenus for the plugins (Arxiv, Pubmed, ORCID, HAL, Zotero)
        4. Specific update when one register a publication (eg put commas between authors)
        5. Handle the CSS for the publications plugins (namely the look of the tables)
    * menus_plugins_pub.php : insert the submenu for each subplugin (**:Warning:** **Is it a good idea to create a specific file for that, or should it be included in each subplugin ?**)
    * register_publications.php : handle specific function when register a publication (eg. separate each authors by commas).
    * arxiv >
        *
    * bibtex >
        * export.php : Export publications to bibtex format **Ugly presentation**

    * orcid > 
        *
    * pubmed >
        *
    * zotero >
        *
    * hal >
        *
    
    
* members > 
    * index_members.php  : include other files .
    * member_add_info.php : create the front page for members to modify their data. 
    * member_csv.php : plugin to include member via CSV.
    * member_mail.php : send email to member.
    * members_save_post.php : actualize data when updating member data. 

* post-types-order > // Not my plugin. Allow moving rows in CPT table list. 




<!-- Modif -->
9-9-22
* Include bibtex script for ORCID. 
* Fixing insert table in database (include #myTable  in tthe counter for checkbox)
* Fixing HAL plugin, var 'i' instead of 'ID'

3-10-22
* Create the Send email (admin) page (member_mail.php) 
* Contact us, now send email to contact@rubidiumweb.fr (cleaning_dashboard.php)
* Remove member_send_email for loggued member (member_add_info.php)
* Change admin menu order (cleaning_dashboard.php)

4-10-22
* Create page for common pub, common job, common news.
    
5-10-22
* debugging : adding bibtex js script in orcid plugin
* debugging : arxiv plugin, see more, years were not shown.
* debugging : adding ajax-call  scripts with nopriv parameter. 

10-10-22
* adding "rb-"  prefix to css classes.
* debugging ACF_to_WP_title 

19-10-22
* ACF member status tax update with new status. 
* member_status_tax menu shown only for admin. 
* Load ACF from the plugin




