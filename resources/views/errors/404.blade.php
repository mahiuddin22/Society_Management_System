<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>404 | Page Not Found</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9fa;
      color: #333;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      text-align: center;
    }
    img {
      max-width: 250px;
      height: auto;
      margin-bottom: 20px;
    }
    h1 {
      font-size: 5em;
      color: #dc3545;
      margin: 0;
    }
    h2 {
      font-size: 1.8em;
      margin: 5px 0 15px;
    }
    p {
      font-size: 1.1em;
      margin: 8px 0;
    }
    a {
      color: #007bff;
      text-decoration: none;
      font-weight: bold;
    }
    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <img src="{{asset('assets/images/404.gif')}}" alt="404 Error">
  <h1>404</h1>
  <h2>Page Not Found</h2>
  <p>Sorry, the page you are looking for could not be found.</p>
  <p><a href="{{ url()->previous() }}">← Go Back</a></p>
</body>
</html>
