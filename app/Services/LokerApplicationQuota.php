<?php

namespace App\Services;

use App\Models\LokerApply;

class LokerApplicationQuota
{
    public function countForUser(int $userId): int
    {
        return LokerApply::query()
            ->where('user_id', $userId)
            ->count();
    }

    public function limit(): int
    {
        return max(0, (int) config('app.loker_non_membership_application_limit', 5));
    }

    public function hasReachedLimit(int $userId): bool
    {
        return $this->countForUser($userId) >= $this->limit();
    }
}
