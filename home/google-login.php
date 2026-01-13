<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: https://ecom.byethost22.com");
header("Cross-Origin-Opener-Policy: same-origin-allow-popups");
header("Content-Type: application/json");

session_start();

$con = mysqli_connect("sql213.byethost22.com", "b22_39801860", "Salman@56", "b22_39801860_main");

if (mysqli_connect_errno()) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

if (!isset($_POST['id_token'])) {
    http_response_code(400);
    echo json_encode(["error" => "ID token missing"]);
    exit;
}

$id_token = $_POST['id_token'];
$client_id = "523383009766-827vl2sd1blo2sap2qo5ron7044evodl.apps.googleusercontent.com";

// Verify token
$verify_url = "https://oauth2.googleapis.com/tokeninfo?id_token=" . urlencode($id_token);
$response = @file_get_contents($verify_url);

if ($response === false) {
    http_response_code(502);
    echo json_encode(["error" => "Failed to contact Google token endpoint"]);
    exit;
}

$data = json_decode($response, true);

if (!is_array($data) || !isset($data['aud']) || $data['aud'] !== $client_id) {
    http_response_code(401);
    echo json_encode(["error" => "Invalid ID token"]);
    exit;
}

$email = $data['email'];
$name = $data['name'];
$google_id = $data['sub'];
$picture = $data['picture'];
$username = explode("@", $email)[0];
$created_at = date('Y-m-d H:i:s');

// Check if user exists
$sql = "SELECT phone, address, google_id, password FROM Account WHERE email = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$new_user = false;
$needs_info = false;

if ($result->num_rows === 0) {
    // New user: Insert new Google account
    $password = NULL;
    $phone = "";
    $address = "";

    $insert_sql = "INSERT INTO Account (username, password, email, phone, address, name, google_id)
                   VALUES (?, ?, ?, ?, ?, ?, ?)";
    $insert_stmt = $con->prepare($insert_sql);
    $insert_stmt->bind_param("sssssss", $username, $password, $email, $phone, $address, $name, $google_id);
    $insert_stmt->execute();
    $new_user = true;
    $needs_info = true;

} else {
    // Existing user
    $row = $result->fetch_assoc();

    // 🚫 Conflict: Account created with password, not Google
    if (!empty($row['password']) && empty($row['google_id'])) {
        http_response_code(409); // Conflict
        echo json_encode([
            "status" => "error",
            "error" => "This email is already registered with a password. Please login using your username and password."
        ]);
        exit;
    }

    // ✅ It's a Google account, check if phone/address is missing
    if (empty($row['phone']) || empty($row['address'])) {
        $needs_info = true;
    }
}

$_SESSION['username'] = $username;

// Return JSON response with redirect if needed
$response_data = [
    "status" => "success",
    "username" => $username
];

if ($needs_info) {
    $response_data["redirect"] = "googleinfo.php";
}

echo json_encode($response_data);
?>
