<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @OA\Schema(
 * schema="User",
 * type="object",
 * title="User",
 * properties={
 * @OA\Property(property="id", type="integer"),
 * @OA\Property(property="name", type="string"),
 * @OA\Property(property="email", type="string", format="email"),
 * @OA\Property(property="nick", type="string"),
 * @OA\Property(property="status", type="string"),
 * @OA\Property(property="user_type", type="string"),
 * @OA\Property(property="created_at", type="string", format="date-time"),
 * @OA\Property(property="updated_at", type="string", format="date-time"),
 * @OA\Property(property="projects", type="array", @OA\Items(ref="#/components/schemas/Project"), description="Projetos criados pelo usuário"),
 * @OA\Property(property="accessibleProjects", type="array", @OA\Items(ref="#/components/schemas/Project"), description="Projetos que o usuário tem acesso"),
 * @OA\Property(property="tasks", type="array", @OA\Items(ref="#/components/schemas/Task"), description="Tarefas pelas quais o usuário é responsável")
 * }
 * )
 */
class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nick',
        'status',
        'user_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'nick' => $this->nick,
        ];
    }
    

    /**
     * Os projetos que este usuário criou.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Os projetos aos quais o usuário tem acesso (como membro).
     */
    public function accessibleProjects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_user');
    }

    /**
     * As tarefas pelas quais o usuário é responsável.
     */
    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'task_user');
    }
}