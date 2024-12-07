<?php

    namespace App;

    use App\Models\User\Role;
    use App\Traits\HasAccess;
    use Backpack\CRUD\CrudTrait;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Spatie\Permission\Traits\HasRoles;

    class User extends Authenticatable
    {
        use Notifiable;
        use CrudTrait;
        use HasRoles;
        use HasAccess;

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'name', 'email', 'password', 'consumer_key', 'msisdn', 'last_login_at',
            'last_login_ip', 'sg_code', 'va05name', 'parent_user_id', 'image', 'is_active', 'sg_code2'
        ];

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

        /*
        |--------------------------------------------------------------------------
        | RELATIONS
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | FUNCTIONS
        |--------------------------------------------------------------------------
        */
        public function getSuperiors($depth = 2, $isArray = false, $column = null)
        {
            $superiors = collect();
            $user = $this;

            while ($user->parentUser && $depth > 0) {
                $superiors->push($user->parentUser);
                $user = $user->parentUser;
                $depth--;
            }

            if($isArray) {
                if($column) {
                    return array_column($superiors->toArray(), $column);
                }

                return $superiors->toArray();
            }

            return $superiors;
        }

        public function getSubordinates($depth = 2, $isArray = false)
        {
            $subordinates = collect([$this]);

            if ($depth > 1) {
                foreach ($this->subordinates as $subordinate) {
                    $subordinates = $this->subordinates->merge($this->getSubordinates($subordinate, $depth - 1));
                }
            }

            if($isArray) {
                return $subordinates->pluck('id')->toArray();
            }

            return $subordinates;
        }

        public function showCreator(): string
        {
            return '<i class="fa fa-user-circle" data-toggle="tooltip" title="'.$this->email.'"></i> &nbsp;'.$this->name.'</span>';
        }

        /*
        |--------------------------------------------------------------------------
        | SCOPES
        |--------------------------------------------------------------------------
        */
        public function scopeNotAdmin($query)
        {
            return $query->where('id', auth()->id())->whereHas('role', function ($query) {
                $query->where('name', '<>', Role::ADMINISTRATOR);
            });
        }

        public function scopeNotAsAdmin($query)
        {
            return $query->whereHas('role', function ($query) {
                $query->where('name', '<>', Role::ADMINISTRATOR);
            });
        }

        public function getNameWithEmailAttribute() {
            return $this->name;
        }

        /*
        |--------------------------------------------------------------------------
        | ACCESSORS
        |--------------------------------------------------------------------------
        */
    }
