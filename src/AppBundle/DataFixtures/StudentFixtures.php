<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class StudentFixtures extends Fixture
{

    private $cities = ["Paris", "Lyon", "Bordeaux", "Rennes", "Marseille"];

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $students = array(
            $this->prepare("Mocquet", "Guy", "54 rue du Pérou"),
            $this->prepare("Lennon", "John", "424 rue de grand champ"),
            $this->prepare("Mitterand", "François", "10 rue Charles Porcher"),
            $this->prepare("Moulin", "Jean", "759 boulevard de la République"),
            $this->prepare("Churchill", "Winston", "22 rue Napoléon"),
            $this->prepare("Camus", "Albert", "80 rue du 14 juillet")
        );
        foreach ($students as $student) {
            $manager->persist($student);
        }
        $manager->flush();
    }

    /**
     * @param $lastname
     * @param $firstname
     * @param $address1
     * @return Student
     */
    private function prepare($lastname, $firstname, $address1)
    {
        $student = new Student();
        $student->setLastname($lastname);
        $student->setFirstname($firstname);
        $student->setAddress1($address1);
        $student->setPostcode(mt_rand(10000, 99999));
        $student->setCity($this->cities[mt_rand(0, count($this->cities) - 1)]);
        $student->setPhone("06" . mt_rand(10000000, 99999999));
        $student->setEmail("{$firstname}.{$lastname}@yopmail.com");
        return $student;
    }

}
