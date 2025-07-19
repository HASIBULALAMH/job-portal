<?php
// @formatter:off

/**
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */

// Override the auth() function to help the IDE
namespace {
    /**
     * Get the available auth instance.
     *
     * @param  string|null  $guard
     * @return \Illuminate\Contracts\Auth\Factory|\Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard|\Illuminate\Contracts\Auth\SupportsBasicAuth
     */
    function auth($guard = null)
    {
        if (is_null($guard)) {
            return app('auth');
        }
        
        return app('auth')->guard($guard);
    }
}

// Add type hints for the User model
namespace App\Models {
    /**
     * App\Models\User
     *
     * @property int $id
     * @property string $name
     * @property string $email
     * @property string $password
     * @property string $role
     * @property string|null $remember_token
     * @property \Illuminate\Support\Carbon|null $email_verified_at
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
     * @method static \Illuminate\Database\Query\Builder|User newModelQuery()
     * @method static \Illuminate\Database\Query\Builder|User newQuery()
     * @method static \Illuminate\Database\Query\Builder|User query()
     * @method static \Illuminate\Database\Query\Builder|User whereCreatedAt($value)
     * @method static \Illuminate\Database\Query\Builder|User whereEmail($value)
     * @method static \Illuminate\Database\Query\Builder|User whereEmailVerifiedAt($value)
     * @method static \Illuminate\Database\Query\Builder|User whereId($value)
     * @method static \Illuminate\Database\Query\Builder|User whereName($value)
     * @method static \Illuminate\Database\Query\Builder|User wherePassword($value)
     * @method static \Illuminate\Database\Query\Builder|User whereRememberToken($value)
     * @method static \Illuminate\Database\Query\Builder|User whereRole($value)
     * @method static \Illuminate\Database\Query\Builder|User whereUpdatedAt($value)
     * @mixin \Eloquent
     */
    class User {}
}

// Add type hints for the Auth facade
namespace Illuminate\Support\Facades {
    /**
     * @method static \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard guard(string|null $name = null)
     * @method static \Illuminate\Contracts\Auth\UserInterface|null user()
     * @method static bool check()
     * @method static bool guest()
     * @method static bool validate(array $credentials = [])
     * @method static int|string|null id()
     * @method static void setUser(\Illuminate\Contracts\Auth\Authenticatable $user)
     * @method static bool attempt(array $credentials = [], bool $remember = false)
     * @method static bool once(array $credentials = [])
     * @method static void login(\Illuminate\Contracts\Auth\Authenticatable $user, bool $remember = false)
     * @method static \Illuminate\Contracts\Auth\Authenticatable loginUsingId(mixed $id, bool $remember = false)
     * @method static bool onceUsingId(mixed $id)
     * @method static bool viaRemember()
     * @method static void logout()
     */
    class Auth {}
}
