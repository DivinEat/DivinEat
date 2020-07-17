<?php

namespace App\Controllers\Admin;

use App\Models\User;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Routing\Router;
use App\Managers\UserManager;
use App\Forms\User\UpdateUserForm;
use App\Core\Controller\Controller;

class UserController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $userManager = new UserManager();
        $users = $userManager->findAll();

        $configTableUser = User::getShowUserTable($users);

        $response->render("admin.user.index", "admin", ["configTableUser" => $configTableUser]);
    }

    public function edit(Request $request, Response $response, array $args)
    {
        $user = (new UserManager())->find($args['user_id']);
        if (null === $user)
            return Router::redirect('admin.user.index');
        
        $form = $response->createForm(UpdateUserForm::class, $user);

        $response->render("admin.user.edit", "admin", ["updateUserForm" => $form]);
    }

    public function update(Request $request, Response $response, array $args)
    {
        $user = (new UserManager())->find($args['user_id']);
        if (null === $user)
            return Router::redirect('admin.user.index');

        $request->setInputPrefix('updateFormUser_');
        
        $user = $user->hydrate([
            'id' => $user->getId(),
            'firstname' => $request->get("firstname"),
            'lastname' => $request->get("lastname"),
            'email' => $request->get("email"),
            'status' => intval($request->get("status")),
            'role' => $request->get("role"),
        ]);

        if(! empty($request->get("pwd"))){
            $user->setPwd(password_hash($request->get("pwd"), PASSWORD_DEFAULT));
        }

        $form = $response->createForm(UpdateUserForm::class, $user);
        
        if (false === $form->handle($request))
            return $response->render("admin.user.edit", "admin", ["updateUserForm" => $form]);

        (new UserManager())->save($user);

        return Router::redirect('admin.user.edit', [$user->getId()]);
    }

    public function destroy(Request $request, Response $response, array $args)
    {
        $manager = new UserManager();
        $manager->delete($args["user_id"]);

        Router::redirect('admin.user.index');
    }
}