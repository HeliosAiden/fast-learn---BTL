<?php
define('_DIR_ROOT', str_replace("\\", '/', __DIR__));
require _DIR_ROOT . '\vendor\autoload.php';

// Load the .env file
$dotenv = Dotenv\Dotenv::createImmutable(_DIR_ROOT);
$dotenv->load();

class Admin {

    private $__db;

    public function __construct()
    {
        $config = $this -> load_configs();
        $default_admin_config = $config['default_admin_config'];
        $hashing_config = $config['hashing_config'];
        $db_config = $config['db_config'];

        if (!$default_admin_config || !$db_config || !$hashing_config) {
            die("Error: Missing environment config variables.");
        }
        $adminUsername = $default_admin_config['username'];
        $adminPassword = $default_admin_config['password'];
        $adminEmail = $default_admin_config['email'];

        if (!$adminUsername || !$adminPassword || !$adminEmail) {
            die("Error: Missing environment variables for admin.");
        }

        $options = ['cost' => $hashing_config['cost']];
        $hashedPassword = password_hash($adminPassword, constant($hashing_config['algorithm']), $options);

        $data = [
            'username' => $adminUsername,
            'password_hash' => $hashedPassword,
            'email' => $adminEmail,
            'role' => 'Admin',
            'state' => 'Active'
        ];

        $this->__db = new Database($db_config);
        $this -> insert_admin($data);
    }

    private function load_configs() {
        $config_dir = scandir(_DIR_ROOT . '/configs');
        if (!empty($config_dir)) {
            foreach ($config_dir as $item) {
                echo $item;
                if ($item !== '.' && $item !== '..' && file_exists(_DIR_ROOT . '/configs/' . $item) && $item !== 'routes.php') {
                    require_once _DIR_ROOT .  '/configs/' . $item;
                }
            }
        }
        if (!empty($config['database'])) {
            $db_config = array_filter($config['database']);
            if (!empty($db_config)) {
                require 'core/Connection.php';
                require 'core/Database.php';
            }
        }
        if (!empty($config['hashing'])) {
            $hashing_config = array_filter($config['hashing']);
        }
        if (!empty($config['default_admin'])) {
            $default_admin_config = array_filter($config['default_admin']);
        }

        return ['db_config' => $db_config, 'hashing_config' => $hashing_config, 'default_admin_config' => $default_admin_config];
    }

    private function insert_admin($data) {
        try {
            // Prepare the SQL statement
            $response = $this->__db->insert('users', $data);

            $username = $data['username'];

            // Execute the statement
            if ($response) {
                echo "Admin user $username inserted successfully.";
            } else {
                echo "Error inserting admin user.";
            }
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    }
}

new Admin();