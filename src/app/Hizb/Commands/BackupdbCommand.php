<?php

namespace App\Hizb\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class BackupdbCommand extends BaseCommand
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
    protected $name = 'hizb:backupdb';

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
        // if (!is_dir('/backupDB')) {
        //     exec("sudo mkdir /backupDB");
        // }
        // exec("sudo chmod -R 777 /backupDB");

        // if (!is_dir('/backupDB/'.date('Y-m'))) {
        //     exec("sudo mkdir /backupDB/".date('Y-m'));
        // }
        // exec("sudo chmod -R 777 /backupDB/".date('Y-m'));

        // if (!is_dir('/backupDB/'.date('Y-m')."/".date('Y-m-d'))) {
        //     exec("sudo mkdir /backupDB/".date('Y-m')."/".date('Y-m-d'));
        // }
        // exec("sudo chmod -R 777 /backupDB/".date('Y-m')."/".date('Y-m-d'));

        // $databases = [
        //     "dorbitt",
        //     "dorbitt_approval",
        //     "dorbitt_asset",
        //     "dorbitt_blog",
        //     "dorbitt_booking",
        //     "dorbitt_crm",
        //     "dorbitt_document_approval",
        //     "dorbitt_email",
        //     "dorbitt_fico",
        //     "dorbitt_hcm",
        //     "dorbitt_ict",
        //     "dorbitt_inventory",
        //     "dorbitt_investasi",
        //     "dorbitt_pdc",
        //     "dorbitt_pm",
        //     "dorbitt_purchase",
        //     "dorbitt_saham",
        //     "dorbitt_she",
        //     "dorbitt_siakad",
        //     "dorbitt_sms",
        //     "dorbitt_tijket",
        //     "dorbitt_tire",
        //     "dorbitt_website",
        //     "hillcon_web"
        // ];

        // // foreach ($databases as $key => $value) {
        // //     // exec ("mysqldump --host 103.150.191.53 -u root --port 3306 -p'DorbitT344!?' ".$value." | gzip > /backupDB/".date('Y-m-d')."/".$value."_$(date +%F.%H%M%S).sql.gz");
        // //     // exec ("mysqldump --host 103.150.191.53 -u root --port 3306 -p'DorbitT344!?' ".$value." | gzip > /backupDB/".date('Y-m')."/".date('Y-m-d')."/".$value."_$(date +%F.%H%M%S).sql.gz");

        //     // exec ("mysqldump -u root -p'DorbitT344!?' ".$value." | gzip > /backupDB/".date('Y-m')."/".date('Y-m-d')."/".$value."_$(date +%F.%H%M%S).sql.gz");



        // //     // mysqldump --host 103.150.191.53 -u root --port 3306 -p'DorbitT344!?' --opt --all-databases > alldb.sql

        // //     /*Export:
        // //     mysqldump -u root -p --all-databases > /backupDB/alldb.sql
        // //     Look up the documentation for mysqldump. You may want to use some of the options mentioned in comments:

        // //     mysqldump -u root -p --opt --all-databases > alldb.sql
        // //     mysqldump -u root -p --all-databases --skip-lock-tables > alldb.sql
        // //     Import:
        // //     mysql -u root -p < alldb.sql*/
        // // }
        
        // exec("mysqldump -u root -p'DorbitT344!?' --opt --all-databases | gzip > /backupDB/".date('Y-m')."/".date('Y-m-d')."/alldb.sql.gz");
        // // mysqldump -u root -p'DorbitT344!?' --opt --all-databases | gzip > /backupDB/alldb.sql.gz
        // // mysqldump -u root -p --opt --all-databases | gzip > /backupDB/alldb.sql.gz

        echo "OK";
    }
}
