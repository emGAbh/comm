<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Forward the data to the local Python backend
    $python_url = 'http://192.168.1.111:5000/process_registration';
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ),
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($python_url, false, $context);

    if ($result === FALSE) {
        echo "Error forwarding to Python backend";
    } else {
        echo $result;  // Relay response back to the Flutter app if needed
    }
}
?>