<?php

namespace Admin\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Exceptions\PageNotFoundException;

class Users extends BaseController
{
    private UserModel $model;

    public function __construct()
    {
        $this->model = new UserModel;
    }

    public function index()
    {
        helper("admin");

        $users = $this->model->orderBy("created_at")->paginate(3);

        return view("Admin\Views\Users\index", [
            "users" => $users,
            "pager" => $this->model->pager
        ]);
    }

    public function show($id)
    {
        $user = $this->getUserOr404($id);

        return view("Admin\Views\Users\show", [
            "user" => $user
        ]);
    }

    public function toggleBan($id)
    {
        $user = $this->getUserOr404($id);

        if ($user->isBanned()) {

            $user->unBan();

        } else {

            $user->ban();

        }

        return redirect()->back()
                         ->with("message", "User saved.");
        
    }

    public function groups($id)
    {
        $user = $this->getUserOr404($id);

        if ($this->request->is("post")) {

            $groups = $this->request->getPost("groups") ?? [];

            $user->syncGroups(...$groups);

            return redirect()->to("admin/users/$id")
                             ->with("message", "User saved.");

        }

        return view("Admin\Views\Users\groups", [
            "user" => $user
        ]);
    }

    public function permissions($id)
    {
        $user = $this->getUserOr404($id);

        if ($this->request->is("post")) {

            $permissions = $this->request->getPost("permissions") ?? [];

            $user->syncPermissions(...$permissions);

            return redirect()->to("admin/users/$id")
                             ->with("message", "User saved.");

        }

        return view("Admin\Views\Users\permissions", [
            "user" => $user
        ]);
    }

    private function getUserOr404($id): User
    {
        $user = $this->model->find($id);

        if ($user === null) {

            throw new PageNotFoundException("User with id $id not found");

        }

        return $user;
    }    
}
