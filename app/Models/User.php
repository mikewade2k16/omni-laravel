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
use App\Enums\UserLevelEnum;
use App\Enums\UserStatusEnum;
use App\Enums\UserTypeEnum;

/**
 * @OA\Schema(
 * schema="User",
 * type="object",
 * title="User",
 * description="Modelo de dados do usuário, contendo informações de autenticação e perfil.",
 * @OA\Property(property="id", type="integer", readOnly=true, description="ID único do usuário"),
 * @OA\Property(property="name", type="string", description="Nome completo do usuário", example="João da Silva"),
 * @OA\Property(property="email", type="string", format="email", description="Endereço de e-mail do usuário", example="joao.silva@example.com"),
 * @OA\Property(property="password", type="string", format="password", writeOnly=true, description="Senha do usuário (apenas para escrita)"),
 * @OA\Property(property="nick", type="string", description="Apelido ou nome de usuário", example="joao.s"),
 * @OA\Property(property="status", type="string", enum={"active", "inactive", "suspended"}, description="Status da conta do usuário", example="active"),
 * @OA\Property(property="user_type", type="string", enum={"admin", "manager", "member", "client"}, description="Tipo de usuário no sistema", example="member"),
 * @OA\Property(property="level", type="string", enum={"beginner", "intermediate", "advanced", "specialist"}, description="Nível de experiência ou cargo do usuário", example="intermediate"),
 * @OA\Property(property="email_verified_at", type="string", format="date-time", readOnly=true, nullable=true, description="Data e hora da verificação do e-mail"),
 * @OA\Property(property="projects", type="array", @OA\Items(ref="#/components/schemas/Project"), description="Lista de projetos criados pelo usuário (geralmente carregado sob demanda)."),
 * @OA\Property(property="accessibleProjects", type="array", @OA\Items(ref="#/components/schemas/Project"), description="Lista de projetos aos quais o usuário tem acesso como membro (geralmente carregado sob demanda)."),
 * @OA\Property(property="tasks", type="array", @OA\Items(ref="#/components/schemas/Task"), description="Lista de tarefas atribuídas ao usuário (geralmente carregado sob demanda)."),
 * @OA\Property(property="client_id", type="integer", nullable=true, description="ID do cliente ou organização associada. Opcional.", example="1"),
 * @OA\Property(property="phone", type="string", nullable=true, description="Número de telefone. Opcional.", example="5511987654321"),
 * @OA\Property(property="profile_image", type="string", nullable=true, description="URL ou caminho para a imagem de perfil. Opcional.", example="/images/profile/default.jpg"),
 * @OA\Property(property="preferences", type="object", nullable=true, description="Preferências do usuário em formato JSON. Opcional.", example={"theme": "dark"}),
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
        'level',
        'client_id',    
        'phone',        
        'profile_image',
        'preferences',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'last_login', 
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'status' => UserStatusEnum::class,
        'level' => UserLevelEnum::class,
        'user_type' => UserTypeEnum::class,
        'client_id' => 'int',       
        'phone' => 'string',        
        'profile_image' => 'string',
        'preferences' => 'array',   
        'last_login' => 'datetime',
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