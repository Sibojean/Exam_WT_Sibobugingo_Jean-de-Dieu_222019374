<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Home Page</title>
<style>
  body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background:  center/cover no-repeat;
    /* Replace 'background-image.jpg' with your image path */
    /* background-color: #FFFFFF; /* White fallback */
    color: none; /* White */
    background-blend-mode: none;
    height: 100vh;
  }

  .overlay {
    background-color:  none
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    position: relative;
    z-index: 1; /* Ensure overlay is above the background */
  }

  .container {
    position: relative;
    z-index: 2; /* Ensure container is above the overlay */
  }

  h1 {
    font-size: 3rem;
    margin-bottom: 20px;
  }

  p {
    font-size: 1.2rem;
    margin-bottom: 30px;
  }

  .btn {
    display: inline-block;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1.2rem;
    text-decoration: none;
    color: red; /* White */
    background-color: green; /* Blue */
    transition: background-color 0.8s ease;
  }

  .btn:hover {
    background-color: #0056b3; /* Darker Blue */
    box-shadow: 2px;
  }

  .btn-register {
    background-color: blue; /* Black */
    margin-left: 20px;
  }

  .btn-register:hover {
    background-color: #333333; /* Darker Black */
  }
</style>
</head>
<body style="background-image: url('./image/ss.jpg');"> <!-- Corrected placement of body tag --> 
<div class="overlay">
  <div class="container">
    <h2>Welcome to Our Website VIRTUAL OCCUPATIONAL THERAPISTS SESSIONS PLATFORM</h2>
    <p>Good life to all</p>
    <a href="login.php" class="btn">Login</a>
    <a href="register.php" class="btn btn-register">Register</a>
  </div>
</div>

</body>
</html>