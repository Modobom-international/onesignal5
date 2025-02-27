<?php

namespace App\Console\Commands\TestCommand;

use Illuminate\Console\Command;
use App\Services\GoDaddyService;
use Auth;

class TestOther extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $url;
    protected $signature = 'test:other';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test other command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = 'a:223:{i:0;b:0;s:17:"flatsome_fallback";i:0;s:20:"topbar_elements_left";a:0:{}s:21:"topbar_elements_right";a:0:{}s:20:"header_elements_left";a:0:{}s:21:"header_elements_right";a:1:{i:0;s:6:"search";}s:27:"header_elements_bottom_left";a:0:{}s:29:"header_elements_bottom_center";a:0:{}s:28:"header_elements_bottom_right";a:0:{}s:27:"header_mobile_elements_left";a:1:{i:0;s:9:"menu-icon";}s:28:"header_mobile_elements_right";a:1:{i:0;s:6:"search";}s:26:"header_mobile_elements_top";a:0:{}s:14:"mobile_sidebar";a:2:{i:0;s:9:"languages";i:1;s:3:"nav";}s:14:"product_layout";s:19:"right-sidebar-small";s:23:"payment_icons_placement";s:6:"footer";s:14:"follow_twitter";s:33:"https://twitter.com/HktConsultant";s:15:"follow_facebook";s:55:"https://www.facebook.com/HKT-Consulting-100100888244238";s:16:"follow_instagram";s:40:"https://www.instagram.com/hktconsultant/";s:12:"follow_email";s:0:"";s:16:"flatsome_version";i:3;s:7:"backups";N;s:9:"smof_init";s:31:"Fri, 25 Aug 2017 15:18:23 +0000";s:9:"site_logo";s:58:"http://apklilo.com/wp-content/uploads/2024/08/sspaps-7.png";s:18:"custom_css_post_id";i:-1;s:17:"header_top_height";s:2:"48";s:9:"topbar_bg";s:7:"#ffffff";s:13:"nav_style_top";s:7:"divided";s:17:"contact_icon_size";s:4:"12px";s:13:"contact_email";s:16:"info@apklilo.com";s:19:"contact_email_label";s:22:"Info@HktConsultant.com";s:13:"contact_hours";s:0:"";s:13:"contact_phone";s:12:"0904.894.728";s:11:"topbar_left";s:46:"<span style=\"font-size: 12px;\">About Us</span>";s:13:"follow_google";s:0:"";s:14:"follow_youtube";s:38:"http://www.youtube.com/c/HKTConsultant";s:12:"social_icons";a:0:{}s:10:"logo_width";s:3:"700";s:12:"logo_padding";s:1:"0";s:19:"header_search_style";s:8:"dropdown";s:24:"header_search_form_style";s:0:"";s:18:"search_placeholder";s:10:"SEARCH APP";s:10:"site_width";s:4:"1200";s:18:"nav_menu_locations";a:3:{s:7:"primary";i:116;s:14:"primary_mobile";i:116;s:11:"top_bar_nav";i:0;}s:13:"header_height";s:2:"67";s:17:"box_shadow_header";s:1:"0";s:14:"header_divider";s:1:"1";s:11:"nav_spacing";s:6:"medium";s:10:"nav_height";s:2:"16";s:8:"nav_push";s:1:"0";s:14:"type_nav_color";s:7:"#ffffff";s:20:"type_nav_color_hover";s:7:"#ffffff";s:18:"header_icons_color";s:7:"#472f85";s:24:"header_icons_color_hover";s:7:"#472f85";s:25:"header_height_transparent";s:3:"265";s:13:"nav_uppercase";s:1:"0";s:13:"type_headings";a:6:{s:11:"font-family";s:135:"-apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, Oxygen-Sans, Ubuntu, Cantarell, \"Helvetica Neue\", sans-serif";s:7:"variant";s:7:"regular";s:11:"font-backup";s:0:"";s:11:"font-weight";i:400;s:10:"font-style";s:6:"normal";s:7:"subsets";N;}s:10:"type_texts";a:6:{s:11:"font-family";s:135:"-apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, Oxygen-Sans, Ubuntu, Cantarell, \"Helvetica Neue\", sans-serif";s:7:"variant";s:7:"regular";s:11:"font-backup";s:0:"";s:11:"font-weight";i:400;s:10:"font-style";s:6:"normal";s:7:"subsets";N;}s:9:"type_size";s:2:"91";s:16:"type_size_mobile";s:3:"100";s:8:"type_nav";a:6:{s:11:"font-family";s:135:"-apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, Oxygen-Sans, Ubuntu, Cantarell, \"Helvetica Neue\", sans-serif";s:7:"variant";s:7:"regular";s:11:"font-backup";s:0:"";s:11:"font-weight";i:400;s:10:"font-style";s:6:"normal";s:7:"subsets";N;}s:8:"nav_size";s:5:"large";s:13:"color_primary";s:7:"#ff6600";s:15:"color_secondary";s:7:"#1E73BE";s:11:"color_texts";s:7:"#212121";s:19:"type_headings_color";s:7:"#0F0F0F";s:11:"color_links";s:7:"#1e73be";s:18:"color_widget_links";s:7:"#0A2453";s:19:"html_scripts_header";s:0:"";s:19:"html_scripts_footer";s:0:"";}';

        $fixed_data = preg_replace_callback(
            '/s:(\d+):"(.*?)";/s',
            function ($matches) {
                $real_length = strlen($matches[2]);
                return 's:' . $real_length . ':"' . $matches[2] . '";';
            },
            $data
        );

        preg_match_all('/s:(\d+):"(.*?)";/', $fixed_data, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $real_length = strlen($match[2]);
            $declared_length = (int)$match[1];

            if ($real_length !== $declared_length) {
                echo "🔴 Lỗi: Chuỗi \"{$match[2]}\" có độ dài {$real_length} nhưng được khai báo là {$declared_length}!\n";
            }
        }

        var_dump($fixed_data);
    }
}
