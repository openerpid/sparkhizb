<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Sparkhizb\UmmuHelper;
use Sparkhizb\UmmuInstall;

class HizbInstallCommand extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'CodeIgniter';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'hizb:install';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = '';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'command:name [arguments] [options]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        // $ummu = new UmmuHelper();
        // echo $ummu->install_link('dev');

        // if (is_link(FCPATH."uploads")) {
        //     exec("rm -rf ".FCPATH."uploads");
        // }

        // if (is_link(FCPATH."vendor/dorbitt-lib")) {
        //     exec("rm -rf ".FCPATH."vendor/dorbitt-lib");
        // }

        // if (is_link(FCPATH."Gasset")) {
        //     exec("rm -rf ".FCPATH."Gasset");
        // }

        $mygallery_path = APPPATH.'Commands/InstallMyGalleryCommand.php';

        if (is_link($mygallery_path)) {
            exec("rm -rf ". $mygallery_path);
        }

        exec("sudo ln -s ".ROOTPATH."vendor/sparkhizb/lib/src/Commands/InstallMyGalleryCommand.php". " " .$mygallery_path);

        // if ($mode == 'dev') {
        //     exec("ln -s ".WRITEPATH."uploads"." ".FCPATH);
        //     exec("ln -s /var/www/html/dorbitt/dorbitt_lib/src/Gasset"." ".FCPATH."vendor/dorbitt-lib");
        //     exec("ln -s /var/www/html/dorbitt/dorbitt_lib/src/Gasset"." ".FCPATH."Gasset");
        //     exec("ln -s /var/www/html/dorbitt/dorbitt_lib/src/Gviews"." ".APPPATH."Gviews");
        // }else{
        //     exec("ln -s ".WRITEPATH."uploads"." ".FCPATH);
        //     exec("sudo ln -s ".ROOTPATH."vendor/dorbitt/lib/src/Gasset"." ".FCPATH."vendor/dorbitt-lib");
        //     exec("sudo ln -s ".ROOTPATH."vendor/dorbitt/lib/src/Gasset"." ".FCPATH."Gasset");
        //     exec("sudo ln -s ".ROOTPATH."vendor/dorbitt/lib/src/Gviews"." ".APPPATH."Gviews");
        // }
    }
}
