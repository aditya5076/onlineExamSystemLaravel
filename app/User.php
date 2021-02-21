<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'visible_password', 'occupation', 'address', 'phone', 'bio', 'is_admin'
    ];
    private $limit = 10;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function storeUsers($data)
    {
        $data['visible_password'] = $data['password']; //from input field
        $data['password'] = bcrypt($data['password']); //from db column
        $data['is_admin'] = 0;
        return User::create($data);
    }

    public function updateUser($data, $id)
    {
        $user = User::findOrFail($id);
        // to check if user want to update password
        if ($data['password']) {
            $user->visible_password = $data['password'];
            $user->password = bcrypt($data['password']); //from db column
        }

        $user->name = $data['name'];
        $user->address = $data['address'];
        $user->occupation = $data['occupation'];
        $user->phone = $data['phone'];
        $user->save();
        return $user;
    }

    public function getAllUsers()
    {
        return User::paginate($this->limit);
    }
}
