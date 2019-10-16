<?php

namespace Silvanite\NovaToolPermissions\Nova;

use Laravel\Nova\Panel;
use Silvanite\Brandenburg\Role as RoleModel;
use Silvanite\NovaFieldCheckboxes\Checkboxes;

class AccessControl
{
    public static function make($additionalFields = [])
    {
        return new Panel(__('Access Control'), array_merge(self::fields(), $additionalFields));
    }

    public static function fields()
    {
        return [
            Checkboxes::make(__('Roles To Allow Access'), 'access_roles')->options(collect(
                    RoleModel::all()->filter(function ($value) {
                        return $value->hasPermission('canBeGivenPrivateAccess');
                    })
                )
                ->mapWithKeys(function ($role) {
                    return [
                        $role->id => __($role->name),
                    ];
                })
                ->sort()
                ->toArray())
                ->withoutTypeCasting(),
        ];
    }
}