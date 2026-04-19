<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #333;
        }
        h2 {
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        pre {
            background-color: #f4f4f4;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow-x: auto;
        }
        .api-section {
            margin-bottom: 40px;
        }
        .api-method {
            font-weight: bold;
            color: #007bff;
        }
        .param-list {
            margin: 10px 0;
        }
        .param-list li {
            margin: 5px 0;
        }
        .success-response, .error-response {
            background-color: #e6f7e6;
            padding: 10px;
            border-left: 5px solid #28a745;
            margin-bottom: 20px;
        }
        .error-response {
            background-color: #f8d7da;
            border-left-color: #dc3545;
        }
        footer {
            text-align: center;
            margin-top: 40px;
            padding: 20px;
            background-color: #333;
            color: white;
        }
    </style>
</head>
<body>

<header>
    <h1>API Documentation</h1>
    <p>Detailed API Information and Endpoints</p>
</header>

<div class="container">

    <!-- Register Step One -->
    <div class="api-section">
        <h2>1. Register Step One</h2>
        <p><strong>URL:</strong> <code>/api/register-step-one</code></p>
        <p><strong>Method:</strong> <span class="api-method">POST</span></p>
        <p><strong>Description:</strong> This API registers a new user in step one of the registration process. It accepts user email, password, and an optional referral code.</p>
        
        <h3>Headers:</h3>
        <ul class="param-list">
            <li><code>Content-Type: application/json</code></li>
            <li><code>API-Key: your_api_key</code></li>
        </ul>

        <h3>Body Parameters:</h3>
        <ul class="param-list">
            <li><strong>name</strong> (string, required): User's name.</li>
            <li><strong>email</strong> (string, required): User's email address.</li>
            <li><strong>password</strong> (string, required): User's password.</li>
            <li><strong>referral_code</strong> (string, optional): Referral code (if available).</li>
        </ul>

        <h3>Success Response:</h3>
        <pre class="success-response">
{
    "success": true,
    "user_id": 1,
    "token": "generated_token_string"
}
        </pre>

        <h3>Error Response:</h3>
        <pre class="error-response">
{
    "success": false,
    "message": "Error message explaining the issue"
}
        </pre>
    </div>

    <!-- Register Step Two -->
    <div class="api-section">
        <h2>2. Register Step Two</h2>
        <p><strong>URL:</strong> <code>/api/register-step-two</code></p>
        <p><strong>Method:</strong> <span class="api-method">POST</span></p>
        <p><strong>Description:</strong> Completes the user registration by collecting additional details such as name, age, height, weight, and gender.</p>

        <h3>Headers:</h3>
        <ul class="param-list">
            <li><code>Content-Type: application/json</code></li>
            <li><code>API-Key: your_api_key</code></li>
            <li><code>Authorization: Bearer token</code></li>
        </ul>

        <h3>Body Parameters:</h3>
        <ul class="param-list">
            <li><strong>first_name</strong> (string, required): User's first name.</li>
            <li><strong>last_name</strong> (string, required): User's last name.</li>
            <li><strong>age</strong> (integer, required): User's age.</li>
            <li><strong>height</strong> (integer, required): User's height in centimeters.</li>
            <li><strong>weight</strong> (integer, required): User's weight in kilograms.</li>
            <li><strong>gender</strong> (string, required): User's gender.</li>
        </ul>

        <h3>Success Response:</h3>
        <pre class="success-response">
{
    "success": true,
    "message": "User profile completed"
}
        </pre>

        <h3>Error Response:</h3>
        <pre class="error-response">
{
    "success": false,
    "message": "Error message explaining the issue"
}
        </pre>
    </div>

    <!-- Login -->
    <div class="api-section">
        <h2>3. Login</h2>
        <p><strong>URL:</strong> <code>/api/login</code></p>
        <p><strong>Method:</strong> <span class="api-method">POST</span></p>
        <p><strong>Description:</strong> Logs in a user with email and password.</p>

        <h3>Headers:</h3>
        <ul class="param-list">
            <li><code>Content-Type: application/json</code></li>
            <li><code>API-Key: your_api_key</code></li>
        </ul>

        <h3>Body Parameters:</h3>
        <ul class="param-list">
            <li><strong>email</strong> (string, required): User's email address.</li>
            <li><strong>password</strong> (string, required): User's password.</li>
        </ul>

        <h3>Success Response:</h3>
        <pre class="success-response">
{
    "success": true,
    "token": "generated_token_string"
}
        </pre>

        <h3>Error Response:</h3>
        <pre class="error-response">
{
    "success": false,
    "message": "Invalid email or password"
}
        </pre>
    </div>

    <!-- Log Steps -->
    <div class="api-section">
        <h2>4. Log Steps</h2>
        <p><strong>URL:</strong> <code>/api/log-steps</code></p>
        <p><strong>Method:</strong> <span class="api-method">POST</span></p>
        <p><strong>Description:</strong> Logs the number of steps a user has taken and converts them into points.</p>

        <h3>Headers:</h3>
        <ul class="param-list">
            <li><code>Content-Type: application/json</code></li>
            <li><code>API-Key: your_api_key</code></li>
            <li><code>Authorization: Bearer token</code></li>
        </ul>

        <h3>Body Parameters:</h3>
        <ul class="param-list">
            <li><strong>steps_count</strong> (integer, required): Number of steps the user has taken.</li>
        </ul>

        <h3>Success Response:</h3>
        <pre class="success-response">
{
    "success": true,
    "message": "Steps logged and points updated successfully",
    "points_earned": 10
}
        </pre>

        <h3>Error Response:</h3>
        <pre class="error-response">
{
    "success": false,
    "message": "Invalid steps data"
}
        </pre>
    </div>

    <!-- Create Package -->
    <div class="api-section">
        <h2>5. Create Package</h2>
        <p><strong>URL:</strong> <code>/api/packages</code></p>
        <p><strong>Method:</strong> <span class="api-method">POST</span></p>
        <p><strong>Description:</strong> Creates a new package that defines how many steps equal how many points.</p>

        <h3>Headers:</h3>
        <ul class="param-list">
            <li><code>Content-Type: application/json</code></li>
            <li><code>API-Key: your_api_key</code></li>
            <li><code>Authorization: Bearer token</code></li>
        </ul>

        <h3>Body Parameters:</h3>
        <ul class="param-list">
            <li><strong>steps_per_point</strong> (integer, required): The number of steps required to earn one point.</li>
        </ul>

        <h3>Success Response:</h3>
        <pre class="success-response">
{
    "success": true,
    "message": "Package created successfully",
    "package": {
        "id": 1,
        "steps_per_point": 1000
    }
}
        </pre>

        <h3>Error Response:</h3>
        <pre class="error-response">
{
    "success": false,
    "message": "Failed to create package"
}
        </pre>
    </div>

    <!-- Update Package -->
    <div class="api-section">
        <h2>6. Update Package</h2>
        <p><strong>URL:</strong> <code>/api/packages/{id}</code></p>
        <p><strong>Method:</strong> <span class="api-method">PUT</span></p>
        <p><strong>Description:</strong> Updates an existing package with a new steps-to-points ratio.</p>

        <h3>Headers:</h3>
        <ul class="param-list">
            <li><code>Content-Type: application/json</code></li>
            <li><code>API-Key: your_api_key</code></li>
            <li><code>Authorization: Bearer token</code></li>
        </ul>

        <h3>Body Parameters:</h3>
        <ul class="param-list">
            <li><strong>steps_per_point</strong> (integer, required): The new number of steps required to earn one point.</li>
        </ul>

        <h3>Success Response:</h3>
        <pre class="success-response">
{
    "success": true,
    "message": "Package updated successfully",
    "package": {
        "id": 1,
        "steps_per_point": 2000
    }
}
        </pre>

        <h3>Error Response:</h3>
        <pre class="error-response">
{
    "success": false,
    "message": "Failed to update package"
}
        </pre>
    </div>

    <!-- Delete Package -->
    <div class="api-section">
        <h2>7. Delete Package</h2>
        <p><strong>URL:</strong> <code>/api/packages/{id}</code></p>
        <p><strong>Method:</strong> <span class="api-method">DELETE</span></p>
        <p><strong>Description:</strong> Deletes an existing package.</p>

        <h3>Headers:</h3>
        <ul class="param-list">
            <li><code>API-Key: your_api_key</code></li>
            <li><code>Authorization: Bearer token</code></li>
        </ul>

        <h3>Success Response:</h3>
        <pre class="success-response">
{
    "success": true,
    "message": "Package deleted successfully"
}
        </pre>

        <h3>Error Response:</h3>
        <pre class="error-response">
{
    "success": false,
    "message": "Failed to delete package"
}
        </pre>
    </div>

    <!-- Redeem Reward -->
    <div class="api-section">
        <h2>8. Redeem Reward</h2>
        <p><strong>URL:</strong> <code>/api/redeem</code></p>
        <p><strong>Method:</strong> <span class="api-method">POST</span></p>
        <p><strong>Description:</strong> Allows a user to redeem their points for a reward.</p>

        <h3>Headers:</h3>
        <ul class="param-list">
            <li><code>Content-Type: application/json</code></li>
            <li><code>API-Key: your_api_key</code></li>
            <li><code>Authorization: Bearer token</code></li>
        </ul>

        <h3>Body Parameters:</h3>
        <ul class="param-list">
            <li><strong>reward_id</strong> (integer, required): The ID of the reward the user wants to redeem.</li>
        </ul>

        <h3>Success Response:</h3>
        <pre class="success-response">
{
    "success": true,
    "message": "Reward redeemed successfully",
    "reward": {
        "id": 1,
        "name": "Free Coffee",
        "points_cost": 100
    }
}
        </pre>

        <h3>Error Response:</h3>
        <pre class="error-response">
{
    "success": false,
    "message": "Failed to redeem reward"
}
        </pre>
    </div>

    <!-- Get Referral Code -->
    <div class="api-section">
        <h2>9. Get Referral Code</h2>
        <p><strong>URL:</strong> <code>/api/referral-code</code></p>
        <p><strong>Method:</strong> <span class="api-method">GET</span></p>
        <p><strong>Description:</strong> Retrieves the referral code for the logged-in user.</p>

        <h3>Headers:</h3>
        <ul class="param-list">
            <li><code>API-Key: your_api_key</code></li>
            <li><code>Authorization: Bearer token</code></li>
        </ul>

        <h3>Success Response:</h3>
        <pre class="success-response">
{
    "success": true,
    "referral_code": "ABC123"
}
        </pre>

        <h3>Error Response:</h3>
        <pre class="error-response">
{
    "success": false,
    "message": "Failed to retrieve referral code"
}
        </pre>
    </div>

    <!-- List Referrals -->
    <div class="api-section">
        <h2>10. List Referrals</h2>
        <p><strong>URL:</strong> <code>/api/referrals</code></p>
        <p><strong>Method:</strong> <span class="api-method">GET</span></p>
        <p><strong>Description:</strong> Lists the referrals made by the logged-in user.</p>

        <h3>Headers:</h3>
        <ul class="param-list">
            <li><code>API-Key: your_api_key</code></li>
            <li><code>Authorization: Bearer token</code></li>
        </ul>

        <h3>Success Response:</h3>
        <pre class="success-response">
{
    "success": true,
    "referrals": [
        {
            "id": 1,
            "name": "John Doe",
            "email": "johndoe@example.com"
        },
        {
            "id": 2,
            "name": "Jane Doe",
            "email": "janedoe@example.com"
        }
    ]
}
        </pre>

        <h3>Error Response:</h3>
        <pre class="error-response">
{
    "success": false,
    "message": "Failed to retrieve referrals"
}
        </pre>
    </div>

</div>

<footer>
    <p>&copy; 2024 Your Company. All rights reserved.</p>
</footer>

</body>
</html>
