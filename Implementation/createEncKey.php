<?php

// Make sure no env file exists
if(file_exists(".env")) {
    print("Please delete the .env file before continuing. Creating a new env file will invalidate all past passwords.");
    exit;
}

// Generate the encryption key
$encrypt_key = base64_encode(openssl_random_pseudo_bytes(32));

// Open the env file and put the key in the correct spot
$env_file = fopen('.env', 'w');

// Now, let's just create the env file while we generate the key
$write_data =
"db_host=localhost
db_user=username
db_password=password
db_name=pokemon_league\n
encrypt_key=" . $encrypt_key;

// Write everything to the env file
fwrite($env_file, $write_data);

// Warn the user of where to put the env file
print("NEVER put the .env file in any publicly accessible folder, or on GitHub. Doing so can cause major security vulnerabilities.");

?>