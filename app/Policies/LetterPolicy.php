<?php

namespace App\Policies;

use App\Models\Letter;
use App\Models\User;

class LetterPolicy
{
    public function view(User $user, Letter $letter): bool
    {
        if ($user->hasRole('super-admin')) return true;
        if ($user->hasRole('admin')) return true;

        return $letter->sender_id === $user->id || $letter->recipient_id === $user->id;
    }

    public function delete(User $user, Letter $letter): bool
    {
        if ($user->hasRole('super-admin')) return true;
        if ($user->hasRole('admin')) return true;

        // supervisor hanya boleh hapus surat yang dia kirim
        return $letter->sender_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'admin', 'supervisor']);
    }
}
