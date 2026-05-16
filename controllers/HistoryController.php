<?php

class HistoryController {
    private History $history;

    public function __construct(History $history) {
        $this->history = $history;
    }

    // ─────────────────────────────
    // VISIT HISTORY
    // ─────────────────────────────
    public function logVisit(int $customerId, string $visitDate, int $visitId): void {
        $this->history->insert(
            $customerId,
            'visit',
            null,
            $visitDate,
            $visitId
        );
    }

    // ─────────────────────────────
    // PLAN HISTORY
    // ─────────────────────────────
    public function logPlanChange(
        int $customerId,
        ?string $oldPlan,
        string $newPlan,
        int $membershipId
    ): void {
        $this->history->insert(
            $customerId,
            'plan',
            $oldPlan,
            $newPlan,
            $membershipId
        );
    }

    // ─────────────────────────────
    // TRAINER HISTORY
    // ─────────────────────────────
    public function logTrainerChange(
        int $customerId,
        ?int $oldTrainer,
        int $newTrainer,
        int $coachingId
    ): void {
        $this->history->insert(
            $customerId,
            'trainer',
            $oldTrainer,
            $newTrainer,
            $coachingId
        );
    }

    // ─────────────────────────────
    // GET HISTORY
    // ─────────────────────────────
    public function getByCustomer(int $customerId): array {
        return $this->history->getByCustomer($customerId);
    }
}