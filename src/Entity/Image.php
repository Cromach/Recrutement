<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
* @ORM\Entity()
* @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
* @ORM\Table(name="images")
* */
class Image
{

    /**
    * @ORM\Id()
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    private $id;

    /**
    * @ORM\Column(type="string")
    */
    private $name;

    /**
    * @ORM\Column(type="string")
    */
    private $path;

    /**
    * @ORM\Column(type="datetime", name="date")
    */
    private $date;

    public function __construct() {
      $this->date = new \Datetime();
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getPath() {
        return $this->path;
    }

    public function setPath($path) {
        $this->path = $path;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

}
?>