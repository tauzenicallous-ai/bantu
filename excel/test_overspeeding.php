<?php
include "conn.php";
 include "post_request.php";
include "get_request.php";
 
$sql1 = "CALL sp_getNavixyBranch";

            // Execute the stored procedure
            if ($select1 = mysqli_query($connection, $sql1)) {
                $CompData = []; // Initialize the array to hold results

                do {
                    while ($result1 = mysqli_fetch_assoc($select1)) {
                        $CompData[] = $result1; // Store results in the array
                    }
                } while (mysqli_next_result($connection));
    
        foreach ($CompData as $row) {
            $BranchName=$row['branch'];
            $deviceIds =array_filter(explode(",", $row['devices'])); // Split string into array
           //$deviceIds =  $row['devices'] ;
          // $deviceIds = array_column($row['devices'], 'deviceId'); // Extract device IDs

            // Output branch name and device IDs
          //  echo "Branch Name: $BranchName\n";
          //  echo "Device IDs: " . implode(", ", $deviceIds) . "\n"; // Print device IDs
              $reportID;
$hash;

$login_url = "http://tracking.bantutrack.com/api-v2/user/auth";
    $payload = [
        'login' => 'bantutrackzw@gmail.com', // Sanitize input
        'password' => 'Navixy@200'
    ];
    
    $login = new post_request($login_url, $payload);
    $response = $login->response;

    if ($response) {
        $data = json_decode($response, true);
        $status = $data['success'] ?? '0';
        $hash = $data['hash'] ;

    }
   
$url = "http://tracking.bantutrack.com/api-v2/report/tracker/generate";
$date = new DateTime();
$date->modify('-1 day');
$previousDay = $date->format('Y-m-d'); // Format as needed
 
$senddata = array(
    'hash' => ''.$hash.'',
    'title' => 'overspeeding',
    'trackers' => $deviceIds,
    'from' => '2026-03-01 00:00:00',
    'to' => '2026-03-22 23:59:59',
    'time_filter' => array(  // Changed from ':' to '=>'
        'from' => '00:00:00',
        'to' => '23:59:59',
        'weekdays' => [
            1,
            2,
            3,
            4,
            5,
            6,
            7
        ]
    ),
    'plugin' => array(  // Changed from ':' to '=>'
        'hide_empty_tabs' => true,
        'plugin_id' => 27,
        'max_speed' => 118,
        'min_duration_minutes' => 1,
        'show_seconds' => false,
        'include_summary_sheet_only' => false,
        'split' => true,
        'show_idle_duration' => false,
        'show_coordinates' => false,
        'filter' => true,
        'group_by_driver' => false
    )
);

//echo json_encode($senddata);
//exit;
// Initialize cURL
$ch = curl_init();


// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($senddata)); // Encode data as JSON
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']); // Set header to indicate JSON content

// Add this line to disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // Execute the request
    $response = curl_exec($ch);

    // Handle potential errors
    if ($response === false) {
        error_log("cURL Error: " . curl_error($ch));
    }

    // Decode the JSON response if available
    $responseData = json_decode($response, true);
//print_r($responseData);
    // Handle the response
    if (isset($responseData['success']) && $responseData['success'] === true) {
       
        $reportID = $responseData['id'];
       
    } else {
        echo "empty data"; // Handle other responses as needed
    }
    sleep(30);
 sendDataToAPI($reportID,$BranchName,$hash);
    // Close cURL resource
    curl_close($ch);
                     }
                    
                }
                
function sendDataToAPI($reportID,$mybranchName,$hash) {
    echo "my report ID ".$reportID."<br>";
    
  $test='';
$login_url = "https://tracking.bantutrack.com/api-v2/report/tracker/download";
$pay_load = array(
    'hash' => ''.$hash.'',
    'report_id' => (int)$reportID,//3003899,//3003892,//3003884,//3003880,//3003877,//2999320, //2999311,
    'format' => 'xlsx'
);


// Initialize cURL
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $login_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($pay_load)); // Encode data as JSON
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']); // Set header to indicate JSON content

// Add this line to disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // Execute the request
    $response = curl_exec($ch);

    // Handle potential errors
    if ($response === false) {
        error_log("cURL Error: " . curl_error($ch));
    }
if ($response) {
    // Specify the file path and name
    $file_path = 'Overspeeding/'.$mybranchName.'-' . time() . '.xlsx'; // Use a timestamp for uniqueness

    // Check if the directory exists
    if (!is_dir('Overspeeding')) {
        mkdir('Overspeeding', 0755, true); // Create directory if it doesn't exist
    }

    // Save the response to the file
    file_put_contents($file_path, $response);
    echo "File has been saved as: " . $file_path;
     
    // After this, use the Google Maps API to convert coordinates to address
} else {
    echo "Failed to download the file.";
}
 //InsertDataToAPI($file_path);
    // Close cURL resource
    curl_close($ch);

   
}


?>