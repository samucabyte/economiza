<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExpenseCategory extends Model
{
    use HasFactory;
    protected $fillable = ['name','user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function expenses():HasMany
    {
        return $this->hasMany(Expense::class, 'category_id');
    }
}
