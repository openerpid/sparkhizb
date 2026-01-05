<?php
namespace Sparkhizb\Models\Syshab\McpReport;

use CodeIgniter\Model;
use Config\Database;

class VmcctrhproductionbclModel extends Model
{
    // If your view has a primary key, you can define it here.
    // If not, you might rely more on raw queries or careful Query Builder usage.
    protected $table = 'V_MCC_TR_HPRODUCTIONB_CL'; // Use the view name as the table name

    public function getViewData()
    {
        // Using Query Builder (simple select all)
        return $this->findAll(); // Equivalent to SELECT * FROM Your_SQL_Server_View_Name

        // Or using a raw query for more complex views/conditions:
        // $db = Database::connect(); // If not using the default connection
        // $sql = "SELECT * FROM Your_SQL_Server_View_Name WHERE some_column = ?";
        // $query = $this->db->query($sql, [1]); // Use query binding
        // return $query->getResultArray(); // Get results as an array of arrays
    }
}
