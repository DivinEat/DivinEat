<?php
namespace App\Commands;

use App\core\Command\CommandInterface;
use App\core\Command\Receiver;
use App\models\User;
use App\Managers\UserManager;

class UserCreateCommand implements CommandInterface
{
    private $output;
    private $args;

    public function __construct(Receiver $receiver){
        $this->output = $receiver;
        $this->ouput->enableDate();
    }

    public function setArgs(array $args): self
    {
        $this->args = $args;

        return $this;
    }

    public function execute()
    {
        $this->ouput->write("Création d'un nouvel utilisateur");

        $user = new User();  
        $user->setFirstname($this->args[0]);
        $user->setLastname($this->args[1]);
        $user->setPwd($this->args[2]);
        $user->setEmail($this->args[3]);
        $user->setStatus(0);

        $this->output->write("Sauvegarde du nouvel utilisateur");
        $userManager = new UserManager();
        $userManager->save($user);

        $this->ouptput->write("Nouvel utilisateur sauvegardé");
        $this->ouptput->write($this->args[0]);
        $this->ouptput->write($this->args[1]);
        $this->ouptput->write($this->args[2]);

        $this->ouptput->printOutPut();
    }
}