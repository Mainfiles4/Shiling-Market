<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBalanceToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'balance' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2', // Adjust the constraint based on your requirements
                'default' => '0.00', // Optional: Set a default value if needed
                'after' => 'password_confirm', // Adjust the position of the column as necessary
                'null' => true, // If you want to allow null values, add this line and set it to TRUE
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'balance');
    }
}
