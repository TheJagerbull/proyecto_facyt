 <?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * Check whether the site is offline or not.
 *
 */
class site_offline_hook {
 
    public function __construct() {
        log_message('debug','Accessing site_offline hook!');
    }
 
    public function is_offline() {
        if(file_exists(APPPATH.'config/application.php')) {
            include(APPPATH.'config/application.php');
//            echo_pre($_SERVER['REMOTE_ADDR']);
//             echo_pre($config['offline_allowed_ips']);
             //             echo_pre(in_array($_SERVER['REMOTE_ADDR'],$config['offline_allowed_ips']));
            if(isset($config['is_offline']) && $config['is_offline']===TRUE) {
                if (isset($config['offline_allowed_ips']) && in_array($_SERVER['REMOTE_ADDR'], $config['offline_allowed_ips']) === FALSE) {
                    $this->show_site_offline();
                    exit;
                }
            }
        }
    }
 
    private function show_site_offline() {
//        echo '<html><body>Sitio en mantenimiento.</body></html>';
//        redirect(site_url('mantenimiento'));
        include("mantenimiento2.php"); 
    }
 
}
