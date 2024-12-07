<?php

    namespace App\Traits;

    use App\User;
    use Backpack\CRUD\Exception\AccessDeniedException;

    trait HasAccess
    {
        public function isAdmin()
        {
            return auth()->user()->hasRole('Administrator');
        }

        public function to($permission)
        {
            $request = Request();
            if (!$request->ajax()) {
                $allow = false;
                if ($this->isAdmin()) {
                    $allow = true;
                }
                else {
                    $permissions = auth()->user()->getAllPermissions();

                    if (is_array($permission)) {
                        foreach ($permission as $perm) {
                            if ($permissions->contains('name', $perm)) {
                                $allow = true;
                                break;
                            }
                        }
                    } else {
                        if ($permissions->contains('name', $permission)) {
                            $allow = true;
                        }
                    }
                }

                if (!$allow) {
                    abort(403, 'You do not have permission to access this page!');
                }
            }
        }

        public static function access($permission)
        {
            $permissions = auth()->user()->getAllPermissions();

            return $permissions->contains('name', $permission);
        }

        public function hasAccessOrFail($permissions, $permissionRequired = null)
        {
            if (!$this->hasAnyPermissions($permissions, $permissionRequired)) {
                throw new AccessDeniedException(trans('backpack::crud.unauthorized_access'));
            }

            return true;
        }

//        public static function hasAccess($permissions = null)
//        {
//            if (!$permissions) {
//                $permissions = [\App\Models\ForwardOrder\ForwardOrderRole::ACCESS];
//            }
//
//            if (!is_array($permissions)) {
//                $permissions = [$permissions];
//            }
//
//            $hasAccess = false;
//            foreach ($permissions[1] as $permission) {
//                $permissionModel = Permission::where('name', $permission)->first();
//
//                dd($permission);
//                // Check if the permission exists and if it has a roleList
//                $hasAccess = $permissionModel && $permissionModel->roleList;
//                if ($hasAccess) {
//                    break;
//                }
//            }
//
//            return $hasAccess;
//        }

        public function hasAnyPermissions($permissions = null, $permissionRequired = null)
        {
            if ($this->isAdmin()) {
                return true;
            }

            if (!is_array($permissions)) {
                $permissions = [$permissions];
            }

            //            $hasAccess = false;
            //            $hasPermission = $this->hasAllowedRoles($permissions);
            //            if ($hasPermission) {
            //                return true;
            //            }

            $hasAccess = false;
            foreach ($permissions as $permission) {
                $hasPermission = $this->hasAllowedRoles($permission);

                if ($hasPermission) {
                    $hasAccess = true;
                    break;
                }
            }

            if ($permissionRequired !== null) {
                $hasRequired = $this->hasAllowedRoles($permissionRequired);

                if ($hasRequired) {
                    return true;
                } else {
                    $hasAccess = false;
                }
            }

            return $hasAccess;
        }

        public function getUsersByPermission($permissionName)
        {
            if (!is_array($permissionName)) {
                $permissionName = [$permissionName];
            }

            return User::whereHas('permission', function ($query) use ($permissionName) {
                $query->whereIn('name', $permissionName);
            })->get();
        }

        public function getUsersByRolePermission($permissionName)
        {
            if (!is_array($permissionName)) {
                $permissionName = [$permissionName];
            }

            return User::whereHas('role.permission', function ($query) use ($permissionName) {
                $query->whereIn('name', $permissionName);
            })->get();
        }

        public function hasAllowedRoles($allowedRoles)
        {
            $usersByPermission = $this->getUsersByPermission($allowedRoles);
            $usersByRolePermission = $this->getUsersByRolePermission($allowedRoles);

            $mergedUsers = $usersByPermission->merge($usersByRolePermission);
            $userIds = $mergedUsers->pluck('id')->toArray();

            $loggedInUserId = auth()->id();
            $isUserInBothArrays = in_array($loggedInUserId, $userIds);

            return $isUserInBothArrays;
        }

        public function hasAccessSales()
        {
            return User::where('id', auth()->id())->whereHas('role', function ($query) {
                $query->whereIn('name', [
                    'Sales',
                    'Sales Manager',
                    'Sales Division Manager',
                ]);
            })->exists();
        }

        public function hasAccessProduct()
        {
            return User::where('id', auth()->id())->whereHas('role', function ($query) {
                $query->whereIn('name', [
                    'Staff Product',
                    'Product Manager',
                    'Product Division Manager',
                ]);
            })->exists();
        }

    }
