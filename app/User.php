<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Hash;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nickname', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

   public static function createUser($input)
   {
       $passHashed = Hash::make($input['password']);
       $input['password'] = $passHashed;
       $user = User::create($input);
       $user->save();
   }

    public static function validateUser($input)
    {
        $user = User::where("nickname", '=', $input['nickname'])->first();
        if($user){
            if(Hash::check($input['password'], $user->password)){
                return $user;
            }else{
                return "Password is not correct";
            }
        }else{
            return "The nickname is not registered";

        }

    }
}
