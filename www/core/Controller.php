<?php 

namespace App\core;

use SplObserver;
use SplObjectStorage;
use App\core\Builder\FormBuilder;
use App\core\Events\ControllerEvent;

class Controller implements \SplSubject
{
    protected $observers;
    protected $event;

    public function __construct()
    {
        $this->event = new ControllerEvent(); 
        $this->observers = new SplObjectStorage();
        $this->attach($this->event);
    }

    public function createForm(string $class, Model &$model = null): Form
    {
        $form = new $class;
        $form->configureOptions();
        $form->buildForm(new FormBuilder());
       
        if($model){
            $form->setModel($model);
            $form->associateValue();
        }
            

        return $form;
    }

    public function redirectTo(string $controller, $action)
    {

    }

    public function getUser()
    {

    }

    public function render(string $controller, string $template = "back", array $params = null)
    { 
        $this->notify();
        $this->detach($this->event);

        $myView = new View($controller, $template);
        foreach($params as $key => $param) {
            $myView->assign($key, $param);
        }
    }

    public function attach(SplObserver $observer)
    {
        $this->observers->attach($observer);
    }

    public function detach(SplObserver $observer)
    {
        $this->observers->detach($observer);
    }

    public function notify()
    {
        /** @var SplObserver $observer */
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
}