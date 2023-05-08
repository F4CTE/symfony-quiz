<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\RightAnswer;
use App\Entity\WrongAnswer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
    
        $data =  $this->importJsonsFromFolder('jsonFixturesData');
        foreach($data as $row){
            $question = new Question();
            $question->setText($row['question']);
            foreach($row['goodAnswers'] as $goodAnswer) {
                $answer = new RightAnswer();
                $answer->setText($goodAnswer);
                $question->addRightAnswer($answer);
                $manager->persist($answer);

            }
            foreach($row['wrongAnswers'] as $wrongAnswer) {
                $answer = new WrongAnswer();
                $answer->setText($wrongAnswer);
                $question->addWrongAnswer($answer);
                $manager->persist($answer);
            }
            $manager->persist($question);

        }

        $manager->flush();

    }

    private function importJsonsFromFolder(string $folderName):array
    {
        $results = [];
        $files = scandir(__DIR__.'../../' . $folderName . '/');
        for($i=2; $i<count($files); $i++){
            $file = json_decode(file_get_contents(__DIR__.'../../' . $folderName . '/'. $files[$i]),true);
        foreach($file as $question){
            $results[] = $question;
        }
        }
        return $results;
    }

}

