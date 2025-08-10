<?php

namespace Sowhatnow\App\Controllers;
use Sowhatnow\Env;
use Sowhatnow\App\Models\QuizModel;

class QuizController {
    protected $conn;
    protected $query;
	protected $controller;
    public function __construct()
    {
	$this->controller = new AdminController();
	$this->conn =  new QuizModel();
    }	
    public function Home() {
	require Env::BASE_PATH."/app/Views/QuizHome.php";
    }
public function QuizControl() {
	    $this->controller->sessionStatus("Accesing the Quiz Control");
		require Env::BASE_PATH."/app/Views/QuizControl.php";
}
public function QuizQuestionControl() {
	    $this->controller->sessionStatus("Accesing the Quiz Control");
		require Env::BASE_PATH."/app/Views/QuizQuestionControl.php";
}


	public function AddQuiz($settings) {
	    $this->controller->sessionStatus("Accesing the Quiz add");
    $this->query = "INSERT INTO Quizes (
        QuizName,
        QuizDesc,
        QuizStarts,
        QuizDomain,
        QuizEnds,
        QuizQuestionScore,
        QuizHighScore,
        QuizTopScorer
    ) VALUES (
        :QuizName,
        :QuizDesc,
        :QuizStarts,
        :QuizDomain,
        :QuizEnds,
        :QuizQuestionScore,
        :QuizHighScore,
        :QuizTopScorer
    )";

    $data = $this->conn->AddQuiz($this->query, $settings);
echo	json_encode($data);
}

	public function ModifyQuiz($settings) {
	    //$this->controller->sessionStatus("Accesing the Quiz add");
    $this->query = "UPDATE Quizes 
	    SET
    QuizName = :QuizName,
    QuizDesc = :QuizDesc,
    QuizStarts = :QuizStarts,
    QuizDomain = :QuizDomain,
    QuizEnds = :QuizEnds,
    QuizQuestionScore = :QuizQuestionScore,
    QuizHighScore = :QuizHighScore,
    QuizTopScorer = :QuizTopScorer

    WHERE QuizId = :QuizId";

    $data = $this->conn->ModifyQuiz($this->query, $settings);
echo	json_encode($data);
}

	public function DeleteQuiz($settings) {
    
		$this->controller->sessionStatus("Accesing the Quiz delete");
	    $this->conn->DeleteQuiz($settings['QuizId']);
	}

	public function GetQuizzes() {
	$data = $this->conn->GetQuizzes()  ;
	echo json_encode($data);
	}	
public function AddQuizQuestion($settings) {
    $this->controller->sessionStatus("Accessing Quiz Question Add");

    $this->query = "INSERT INTO QuizQuestions (
        QuizId,
        QuizQuestionId,
        QuizQuestion,
        QuizQuestionImage,
        QuizAnswer,
        QuizOptions
    ) VALUES (
        :QuizId,
        :QuizQuestionId,
        :QuizQuestion,
	:QuizQuestionImage,
        :QuizAnswer,
        :QuizOptions
    )";

    $data = $this->conn->AddQuizQuestion($this->query, $settings);
    echo json_encode($data);
}

public function ModifyQuizQuestion($settings) {
    $this->controller->sessionStatus("Accessing Quiz Question Modify");

    $this->query = "UPDATE QuizQuestions SET
        QuizQuestion = :QuizQuestion,
        QuizAnswer = :QuizAnswer,
        QuizQuestionImage = :QuizQuestionImage,
        QuizOptions = :QuizOptions
    WHERE
        QuizId = :QuizId AND
        QuizQuestionId = :QuizQuestionId";

    $data = $this->conn->ModifyQuizQuestion($this->query, $settings);
    echo json_encode($data);
}

public function DeleteQuizQuestion($settings) {
    $this->controller->sessionStatus("Accessing Quiz Question Delete");

    $data = $this->conn->DeleteQuizQuestion($settings);
    echo json_encode(['success' => true, 'deleted' => $data]);
}
public function GetQuizQuestions ($settings) {
// the reason for having two get quizes is that this is for the cords or subcords
    $this->controller->sessionStatus("Accessing Quiz Question ");
	$data = 	$this->conn->GetQuiz($settings['QuizId']);
	echo json_encode($data);
}

public function GetQuiz($settings) {

	$dbPath = Env::BASE_PATH . "/app/Models/Database/clients.db";
$clientController  = new ClientController(); 
		$response = $clientController->ClientSessionStatus();
	if($response)  {
	$quizId = $settings['QuizId'];
	session_start();
	$clientId = $_SESSION['client_id'];
	$isregistered = $this->conn->RegisterClientForQuiz($clientId, $quizId);
	$data = 	$this->conn->GetQuiz($settings['QuizId']);

	require Env::BASE_PATH."/app/Views/QuizArena.php";
}
	else {
			echo '
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registration Successful</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: #f2f8f7;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      background: white;
      padding: 30px 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      max-width: 90%;
      text-align: center;
    }

    .success-icon {
      font-size: 60px;
      color: #2ecc71;
    }

    h1 {
      font-size: 24px;
      color: #333;
      margin: 20px 0 10px;
    }

    p {
      font-size: 16px;
      color: #666;
      margin-bottom: 25px;
    }

    .btn {
      display: inline-block;
      background-color: #2ecc71;
      color: white;
      text-decoration: none;
      padding: 12px 25px;
      border-radius: 5px;
      font-size: 16px;
      transition: background 0.3s;
    }

    .btn:hover {
      background-color: #27ae60;
    }

    @media (max-width: 480px) {
      h1 {
        font-size: 20px;
      }

      .btn {
        padding: 10px 20px;
        font-size: 14px;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <div class="success-icon">‼️‼️</div>
  <h1>Authentication Failed!</h1>
<p>Please Login </p>
  <a href="/client/" class="btn">Go to Login</a>
</div>

</body>
</html>
';

}
}
public function UpdateScoreClient($settings) {
		$clientController  = new ClientController(); 
		$response = $clientController->ClientSessionStatus();
		if($response) {
				session_start();
			$clientId = $_SESSION['client_id'];
			$data = $this->conn->UpdateScoreClient($clientId, $settings['QuizId'],$settings['QuizQuestionId'], $settings['selectedOption']);		
			echo json_encode($data);
		} else {
			echo json_encode(["Failed"=>"Couldn't submit"]);
		}
} 
	public function QuizLeaderBoards() {
	$dbPath = Env::BASE_PATH . "/app/Models/Database/clients.db";
	require Env::BASE_PATH."/app/Views/ClientLeaderboard.php";

	}
}
