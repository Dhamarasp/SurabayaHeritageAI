<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Conversation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'session_id',
        'user_id',
        'title',
        'is_active',
    ];

    /**
     * Get the messages for the conversation.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate a title for the conversation based on the first user message
     */
    public function generateTitle(): void
    {
        if (!$this->title) {
            $firstMessage = $this->messages()->where('role', 'user')->first();
            
            if ($firstMessage) {
                // Truncate the message to create a title
                $title = substr($firstMessage->content, 0, 50);
                if (strlen($firstMessage->content) > 50) {
                    $title .= '...';
                }
                
                $this->title = $title;
                $this->save();
            }
        }
    }
}
