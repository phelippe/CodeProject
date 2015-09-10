<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Project extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'name',
        'description',
        'progress',
        'status',
        'due_date',
        'owner_id',
        'client_id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        #'owner_id',
        #'client_id',
        #'pivot',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function tasks()
    {
        return $this->hasMany(ProjectTask::class);
    }

    public function notes(){
        return $this->hasMany(ProjectNote::class);
    }

    public function members(){
        return $this->belongsToMany(User::class, 'project_members');
    }

    public function files(){
        return $this->hasMany(ProjectFile::class);
    }
}
