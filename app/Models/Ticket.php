<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $fillable = [
        'protocol',
        'user_id',
        'category_id',
        'assigned_to',
        'title',
        'description',
        'priority',
        'status',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'assigned_to'
        );
    }

    public function comments(): HasMany
    {
        return $this->hasMany(TicketComment::class)
            ->orderBy('created_at');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'open' => 'Aberto',
            'in_progress' => 'Em atendimento',
            'waiting' => 'Aguardando usuário',
            'resolved' => 'Resolvido',
            'closed' => 'Fechado',
            default => 'Desconhecido',
        };
    }

    public function getStatusIconAttribute(): string
    {
        return match ($this->status) {
            'open' => '🟡',
            'in_progress' => '🔵',
            'waiting' => '🟣',
            'resolved' => '🟢',
            'closed' => '⚫',
            default => '⚪',
        };
    }

    public function getPriorityLabelAttribute(): string
    {
        return match ($this->priority) {
            'low' => 'Baixa',
            'normal' => 'Normal',
            'high' => 'Alta',
            'urgent' => 'Urgente',
            default => 'Normal',
        };
    }

    public function getPriorityIconAttribute(): string
    {
        return match ($this->priority) {
            'low' => '🟢',
            'normal' => '🔵',
            'high' => '🟠',
            'urgent' => '🔴',
            default => '🔵',
        };
    }
}