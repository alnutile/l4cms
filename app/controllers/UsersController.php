<?php

class UsersController extends BaseController {

    public $users;

    public function __construct(User $users = null) {
        $this->users    = ($users) ? $users : new User();
        $this->beforeFilter('csrf', array('on'=>'post'));
    }


    public function index()
    {
        $user = $this->users->all();
        return $user;
    }

    public function login()
    {
        return View::make('sessions.login');
    }

    public function show($id)
    {
        $user = $this->users->find($id);
        return $user;
    }

    public function edit($params)
    {
        $user = $this->users->find($params['uid']);
        return $user;
    }

    public function getLogout() {
        Auth::logout();
        return Redirect::to('login')->with('message', 'Your are now logged out!');
    }


    public function updatePassword()
    {

        $validator = Validator::make(Input::all(), array('password' => 'required|confirmed', 'email' => 'required', 'password_confirmation' => 'required'));

        if($validator->passes()) {
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make(Input::get('password'));
            $user->save();
            return $user;
        }
    }

    public function update()
    {
        $validator = Validator::make(Input::all(), array('email' => 'required|email'));
        $user_update = Input::all();
        if($validator->passes()) {
            $user = User::find($user_update['id']);
            if($user_update['email'] != $user->email) {
                if(User::where("email", 'LIKE', $user_update['email'])) {
                    return ['email' => ["Email is already in the system"]];
                }
            }
            $user->email = $user_update['email'];
            $user->firstname = (isset($user_post['firstname'])) ? $user_post['firstname'] : '';
            $user->lastname = (isset($user_post['lastname'])) ? $user_post['lastname'] : '';
            $user->admin = (isset($user_post['admin'])) ? $user_post['admin'] : 0;
            $user->active = (isset($user_post['active'])) ? $user_post['active'] : 0;
            $user->save();
            return array('error' => 0, 'data' => $user);
        } else {
            $errors = $validator->errors();
            return $errors;
        }
    }


    public function create()
    {
        $user = new User;
        return $user->getFillable();
    }

    public function store()
    {

        $user_post = Input::get('user');
        $validator = Validator::make($user_post, array('password' => 'required|confirmed', 'email' => 'required|email|unique:users', 'password_confirmation' => 'required'));

        if($validator->passes()) {
            $user = new User();
            $user->email        = $user_post['email'];
            $user->firstname    = (isset($user_post['firstname'])) ? $user_post['firstname'] : '';
            $user->lastname     = (isset($user_post['lastname'])) ? $user_post['lastname'] : '';
            $user->admin        = (isset($user_post['admin'])) ? 1 : 0;
            $user->active       = (isset($user_post['active'])) ? 1 : 0;
            $user->password     = $user_post['password'];
            $user->save();
            return array('error' => 0, 'data' => $user);
        } else {
            $errors = $validator->errors();
            return $errors;
        }
    }


    public function authenticate()
    {
        if (Auth::attempt(array('email'=>Input::get('email'), 'password'=>Input::get('password')))) {
            return Redirect::to('admin')->with('message', 'You are now logged in!');
        } else {
            Session::set('type', 'danger');
            return Redirect::to('login')
                ->with('message', 'Your username/password combination was incorrect')
                ->withInput();
        }
    }
}