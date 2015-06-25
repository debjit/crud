<?php
/**
 * User: mgalicz
 * Date: 2015.06.24.
 * Time: 13:25
 * Project: crud-tester
 */

namespace BlackfyreStudio\CRUD\Models;


use Illuminate\Database\Eloquent\Model;

class CrudRole extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'crud_roles';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['role_name','permissions'];
}