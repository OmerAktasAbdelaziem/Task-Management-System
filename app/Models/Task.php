<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'project', 'name', 'priority', 'is_completed', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getAllTasks($search = null)
    {
        $query = static::query();

        if ($search !== null) {
            $query->whereNull('tasks.deleted_at');
            $query->where('tasks.name', 'like', '%' . $search . '%');
            $query->join('projects', 'tasks.project', '=', 'projects.id');
            $query->select('tasks.*', 'projects.name as project_name', 'projects.color as project_color');
            $query->orderBy('tasks.priority', 'ASC'); 
        } else {
            $query->whereNull('tasks.deleted_at');
            $query->join('projects', 'tasks.project', '=', 'projects.id');
            $query->select('tasks.*', 'projects.name as project_name', 'projects.color as project_color');
            $query->orderBy('tasks.priority', 'ASC'); 
        }

        return $query->get();
    }

    public static function getAllTasksWithFilters($filters = [])
    {
        $query = static::query();

        $query->join('projects', 'tasks.project', '=', 'projects.id')
            ->select('tasks.*', 'projects.name as project_name', 'projects.color as project_color')
            ->whereNull('tasks.deleted_at');

        if (isset($filters['project'])) {
            $query->where('tasks.project', $filters['project']);
        }

        if (isset($filters['is_completed'])) {
            $query->where('tasks.is_completed', $filters['is_completed']);
        }

        return $query->orderBy('tasks.priority', 'ASC')->get();
    }

    public static function createTask(array $data)
    {
        return static::create($data);
    }

    public function updateTask(array $data)
    {
        return $this->update($data);
    }

    public function deleteTask()
    {
        return $this->delete();
    }
}
