<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MembershipApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'pdf_path',
        'image_path',
        'user_id',
    ];


    /**
     * The membersihp application s associated with a specific user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUserName($query, $name)
    {
        return $query->whereHas('user', function ($query) use ($name) {
            $query->SearchFullName($name);
        });
    }

    public function scopeUserMembershipApplication($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
