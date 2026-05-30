<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voice Input Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            max-width: 600px;
            margin: auto;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .voice-button {
            background-color: #0074d9;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 3px;
            margin-bottom: 10px;
        }
        .voice-button:hover {
            background-color: #0056a0;
        }
    </style>
</head>
<body>
    <h2>Enter Data with Voice Input</h2>
    <form id="dataForm" action="submit.php" method="POST">
        <label for="commodity_class">Commodity Class:</label>
        <input type="text" id="commodity_class" name="commodity_class" placeholder="Enter commodity class">
        <button type="button" class="voice-button" onclick="startRecognition('commodity_class')">Speak Commodity Class</button>

        <label for="symbol">Symbol:</label>
        <input type="text" id="symbol" name="symbol" placeholder="Enter symbol">
        <button type="button" class="voice-button" onclick="startRecognition('symbol')">Speak Symbol</button>

        <label for="warehouse">Warehouse:</label>
        <input type="text" id="warehouse" name="warehouse" placeholder="Enter warehouse">
        <button type="button" class="voice-button" onclick="startRecognition('warehouse')">Speak Warehouse</button>

        <label for="current_lower_limit">Current Lower Limit:</label>
        <input type="number" id="current_lower_limit" name="current_lower_limit" placeholder="Enter current lower limit">
        <button type="button" class="voice-button" onclick="startRecognition('current_lower_limit')">Speak Lower Limit</button>

        <label for="upper_limit">Upper Limit:</label>
        <input type="number" id="upper_limit" name="upper_limit" placeholder="Enter upper limit">
        <button type="button" class="voice-button" onclick="startRecognition('upper_limit')">Speak Upper Limit</button>

        <input type="submit" value="Submit">
    </form>

    <script>
        function startRecognition(fieldId) {
            const field = document.getElementById(fieldId);
            const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
            recognition.lang = 'en-US';
            recognition.interimResults = false;
            recognition.maxAlternatives = 1;

            recognition.onresult = function(event) {
                field.value = event.results[0][0].transcript;
            };

            recognition.onerror = function(event) {
                console.error('Speech recognition error detected: ' + event.error);
            };

            recognition.start();
        }
    </script>
</body>
</html>
