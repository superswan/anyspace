<?php

function get_email_config() {
    $config_file = __DIR__ . "/../../email_config.php";
    if (file_exists($config_file)) {
        return include($config_file);
    }
    return array(
        'smtp_host' => '',
        'smtp_port' => '',
        'smtp_username' => '',
        'smtp_password' => '',
        'from_email' => '',
        'require_verification' => 0,
    );
}

function update_email_config($new_config) {
    $config_file = __DIR__ . "/../../email_config.php";
    $config = get_email_config();
    
    // Update only the provided fields
    foreach ($new_config as $key => $value) {
        if (array_key_exists($key, $config)) {
            $config[$key] = $value;
        }
    }
    
    // Save the updated config
    $config_content = "<?php\nreturn " . var_export($config, true) . ";\n";
    if (file_put_contents($config_file, $config_content) === false) {
        return false;
    }
    return true;
}

