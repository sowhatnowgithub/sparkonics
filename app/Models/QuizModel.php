<?php
namespace Sowhatnow\App\Models;
use PDOException;
use Sowhatnow\Env;
class QuizModel extends AdminModel
{
    public $dbConn;
    public function __construct()
    {
        $dbPath = Env::BASE_PATH . "/app/Models/Database/clients.db";
        try {
            $this->dbConn = new \PDO("sqlite:$dbPath");
            $this->dbConn->setAttribute(
                \PDO::ATTR_ERRMODE,
                \PDO::ERRMODE_EXCEPTION,
            );
            $this->dbConn->setAttribute(
                \PDO::ATTR_DEFAULT_FETCH_MODE,
                \PDO::FETCH_ASSOC,
            );
        } catch (PDOException $e) {
            echo "Failed to connect to db";
        }
    }
    
public function AddQuiz($query, $settings): array
{
    try {
        $stmt = $this->dbConn->prepare($query);

        // Bind parameters securely
        $stmt->bindParam(":QuizName", $settings["QuizName"]);
        $stmt->bindParam(":QuizDesc", $settings["QuizDesc"]);
        $stmt->bindParam(":QuizStarts", $settings["QuizStarts"]);
        $stmt->bindParam(":QuizDomain", $settings["QuizDomain"]);
        $stmt->bindParam(":QuizEnds", $settings["QuizEnds"]);
        $stmt->bindParam(":QuizQuestionScore", $settings["QuizQuestionScore"]);
        $stmt->bindParam(":QuizHighScore", $settings["QuizHighScore"]);
        $stmt->bindParam(":QuizTopScorer", $settings["QuizTopScorer"]);

        $stmt->execute();

        return ["Success" => "Quiz added successful mhl"];
    } catch (\PDOException $e) {
        return ["Error" => "Failed to insert quiz: " . $e->getMessage()];
    }
}
     
public function ModifyQuiz($query, $settings): array
{
    try {
        $stmt = $this->dbConn->prepare($query);

        // Bind parameters securely
        $stmt->bindParam(":QuizName", $settings["QuizName"]);
        $stmt->bindParam(":QuizDesc", $settings["QuizDesc"]);
        $stmt->bindParam(":QuizStarts", $settings["QuizStarts"]);
        $stmt->bindParam(":QuizDomain", $settings["QuizDomain"]);
        $stmt->bindParam(":QuizEnds", $settings["QuizEnds"]);
        $stmt->bindParam(":QuizQuestionScore", $settings["QuizQuestionScore"]);
        $stmt->bindParam(":QuizHighScore", $settings["QuizHighScore"]);
        $stmt->bindParam(":QuizTopScorer", $settings["QuizTopScorer"]);
        $stmt->bindParam(":QuizId", $settings["QuizId"]);

        $stmt->execute();

        return ["Success" => "Quiz added successful mhl"];
    } catch (\PDOException $e) {
        return ["Error" => "Failed to insert quiz: " . $e->getMessage()];
    }
}
public function DeleteQuiz($quizId)
    {
        try {
            $query = "DELETE FROM Quizes Where QuizId = :quizId";
            $stmt = $this->dbConn->prepare($query);
            $stmt->bindParam(":quizId", $quizId, \PDO::PARAM_INT);
            $stmt->execute();
            $stmt = null;

            return json_encode(["success" => "true"]);
        } catch (\PDOException $e) {
            return json_encode(["success" => "false"]);
        }
    }

public function AddQuizQuestion($query, $settings): array
{
    try {
        $stmt = $this->dbConn->prepare($query);

        $stmt->bindParam(":QuizId", $settings["QuizId"], \PDO::PARAM_INT);
        $stmt->bindParam(":QuizQuestionId", $settings["QuizQuestionId"], \PDO::PARAM_INT);
        $stmt->bindParam(":QuizQuestion", $settings["QuizQuestion"]);
        $stmt->bindParam(":QuizQuestionImage", $settings["QuizQuestionImage"]);
        $stmt->bindParam(":QuizAnswer", $settings["QuizAnswer"], \PDO::PARAM_INT);
        $stmt->bindParam(":QuizOptions", $settings["QuizOptions"]);

        $stmt->execute();

        return ["Success" => "Question added successfully"];
    } catch (\PDOException $e) {
        return ["Error" => "Failed to insert question: " . $e->getMessage()];
    }
}
public function ModifyQuizQuestion($query, $settings): array
{
    try {
        $stmt = $this->dbConn->prepare($query);

        $stmt->bindParam(":QuizId", $settings["QuizId"], \PDO::PARAM_INT);
        $stmt->bindParam(":QuizQuestionId", $settings["QuizQuestionId"], \PDO::PARAM_INT);
        $stmt->bindParam(":QuizQuestion", $settings["QuizQuestion"]);
        $stmt->bindParam(":QuizQuestionImage", $settings["QuizQuestionImage"]);
        $stmt->bindParam(":QuizAnswer", $settings["QuizAnswer"], \PDO::PARAM_INT);
        $stmt->bindParam(":QuizOptions", $settings["QuizOptions"]);

        $stmt->execute();

        return ["Success" => "Question modified successfully"];
    } catch (\PDOException $e) {
        return ["Error" => "Failed to update question: " . $e->getMessage()];
    }
}
public function DeleteQuizQuestion($settings)
{
    try {
        $query = "DELETE FROM QuizQuestions WHERE QuizId = :QuizId AND QuizQuestionId = :QuizQuestionId";
        $stmt = $this->dbConn->prepare($query);

        $stmt->bindParam(":QuizId", $settings["QuizId"], \PDO::PARAM_INT);
        $stmt->bindParam(":QuizQuestionId", $settings["QuizQuestionId"], \PDO::PARAM_INT);

        $stmt->execute();
        return json_encode(["success" => true]);
    } catch (\PDOException $e) {
        return json_encode(["success" => false, "error" => $e->getMessage()]);
    }
}
public function GetQuiz($quizId) {
   try {
            $this->query = "SELECT * FROM Quizes WHERE QuizId = :quizId";
            $stmt = $this->dbConn->prepare($this->query);
            $stmt->execute([$quizId]);
            $quizzes = $stmt->fetchAll();
$stmt = null;
$this->query = "SELECT QuizId, QuizQuestionId, QuizQuestion, QuizQuestionImage, QuizOptions FROM QuizQuestions  WHERE QuizId = :quizId";
            $stmt = $this->dbConn->prepare($this->query);
            $stmt->execute([$quizId]);
            $questions = $stmt->fetchAll();

            $stmt = null;
            if ($quizzes != false) {
                return ["quiz" => $quizzes, "questions" => $questions];
            } else {
                return ["Error" => "Failed to $quizId"];
            }
        } catch (\PDOException $e) {
var_dump($e);
            return ["Error" => "Failed to fetch"];
        } 
 
}

    public function GetQuizzes() {
   try {
            $this->query = "SELECT * FROM Quizes";
            $stmt = $this->dbConn->prepare($this->query);
            $stmt->execute();
            $quizzes = $stmt->fetchAll();
            $stmt = null;
            if ($quizzes != false) {
                return $quizzes;
            } else {
                return ["Error" => "Failed to fetcI"];
            }
        } catch (\PDOException $e) {
var_dump($e);
            return ["Error" => "Failed to fetch"];
        } 
    }
public function RegisterClientForQuiz($clientId, $quizId) {

    try {
        $sql = "INSERT INTO QuizClient (QuizId, ClientId, QuizQuestionOptions, QuizTotalScore)
                VALUES (:quizId, :clientId, :options, :score)";
        
        $stmt = $this->dbConn->prepare($sql);
        $result = $stmt->execute([
            ':quizId' => $quizId,
            ':clientId' => $clientId,
            ':options' => "",
            ':score' => 0
        ]);

	$stmt = null;
        if ($result) {
            return ["success"=>"Registered"];
        } else {
            return ["insert_faile"=> "Failed"];
        }

    } catch (PDOException $e) {
        // You can also log $e->getMessage() for debugging
        return ["Error" => "error: " . $e->getMessage()];
    }	
}
public function UpdateScoreClient($clientId,$quizId, $questionId, $optionSelected) {
try {

	$sql = "SELECT * FROM QuizClient WHERE QuizId = :quizId AND ClientId = :clientId";
        $stmt = $this->dbConn->prepare($sql);
	$stmt->execute([':quizId'=> $quizId, ':clientId' => $clientId]);
	$quizClient = $stmt->fetchAll();
	$quizClient = $quizClient[0];
	$stmt = null;
	$score = (int)$quizClient['QuizTotalScore'];
	$quizOptions = $quizClient['QuizQuestionOptions'];	
	$sql = "SELECT * FROM Quizes WHERE QuizId = :quizId";
        $stmt = $this->dbConn->prepare($sql);
	$stmt->execute([':quizId'=> $quizId]);	
        $quizData = $stmt->fetchAll();
	$quizData = $quizData[0];
	$stmt = null;
	
	$sql = "SELECT * FROM QuizQuestions WHERE QuizId = :quizId AND QuizQuestionId = :questionId";
        $stmt = $this->dbConn->prepare($sql);
	$stmt->execute([':quizId'=> $quizId, ':questionId' => $questionId]);
	$quizQuestion = $stmt->fetchAll();
	$quizQuestion = $quizQuestion[0];
	$stmt = null;
	$eachQuestionScore =(int) $quizData['QuizQuestionScore'];
	$isCorrect = $quizQuestion['QuizAnswer'] == $optionSelected ? 1 : 0;
	$currentOption = $questionId."&".$optionSelected."&".$isCorrect;
	$sql = "SELECT COUNT(*) FROM QuizQuestions WHERE QuizId = :quizId";
        $stmt = $this->dbConn->prepare($sql);
	$stmt->execute([':quizId'=> $quizId]);
	$totalQuestions = $stmt->fetchColumn();
	$stmt = null;

	$currentOption ="$quizOptions,$currentOption";
$entries = explode(',', $currentOption);

$wrongQuestions = [];
$correctQuestions = [];

foreach ($entries as $entry) {
    list($qid, $option, $isCorrect) = explode('&', $entry);
    
    if ((int)$isCorrect === 0) {
        $wrongQuestions[$qid] = true;   // mark question as answered wrong once
    } else {
        $correctQuestions[$qid] = true; // mark question as answered correctly
    }
}

// Unique count of wrong questions
$losingScore = count($wrongQuestions);
	if($isCorrect == 1) {
	if($score <= ($totalQuestions-$losingScore)*(int)$eachQuestionScore) {
	$score = $score +(int)$eachQuestionScore;
} else {
$score = 0;
}
	} else {
	$score = $score - (int)$eachQuestionScore;
if($score < 0) $score = 0;
}
	
$sql = "UPDATE QuizClient 
        SET QuizQuestionOptions = :options, QuizTotalScore = :score 
        WHERE QuizId = :quizId AND ClientId = :clientId";
        $stmt = $this->dbConn->prepare($sql);
        $result = $stmt->execute([
            ':quizId' => $quizId,
            ':clientId' => $clientId,
            ':options' => $currentOption,
            ':score' => $score
        ]);
	$stmt = null;
        if ($result) {
            return ["success"=>"Registered", "score" => $totalQuestions];
        } else {
            return ["insert_faile"=> "Failed"];
        }
}	 catch(\PDOException $e) {
		return ["Error" => "Failed to update".$e->getMessage()];
	}
	
}
 
}
