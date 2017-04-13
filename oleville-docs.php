<?php
/*
  Plugin Name: Oleville Documents
  Plugin URI: http://www.oleville.com
  Description: Provides Senate Document functionality
  Version: 1.0
  Author: Elijah Verdoorn, Erich Kauffman
	Author URI: www.elijahverdoorn.com
  License: GPL2
*/
/*
  Copyright 2017 Elijah Verdoorn  (email : elijah@elijahverdoorn.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if(!class_exists('Oleville_Docs'))
{
    class Oleville_Docs
    {
        /**
         * Construct the plugin object
         */
        public function __construct()
        {
        		// Register member post type
        		require_once(sprintf("%s/docs-type.php", dirname(__FILE__)));
        		$oleville_docs_type = new Oleville_Docs_Type();

            //activate shortcode
            require_once(sprintf("%s/shortcodes.php", dirname(__FILE__)));
            $oleville_docs_shortcode = new Oleville_Docs_Shortcode();
        }

        /**
         * Activate the plugin
         */
        public static function activate()
        {
            // Do nothing
        }

        /**
         * Deactivate the plugin
         */
        public static function deactivate()
        {
            // Do nothing
        }
	}
}

if(class_exists('Oleville_Docs'))
{
    // Installation and uninstallation hooks
    register_activation_hook(__FILE__, array('Oleville_Docs', 'activate'));
    register_deactivation_hook(__FILE__, array('Oleville_Docs', 'deactivate'));

    // instantiate the plugin class
    $oleville_docs = new Oleville_Docs();
}
