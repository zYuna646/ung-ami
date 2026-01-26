<?php

namespace App\Policies;

use App\Constants\AuditStatus;
use App\Models\Instrument;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InstrumentPolicy
{
    public function view(User $user, Instrument $instrument): bool
    {
        $areas = $instrument->units
            ->concat($instrument->faculties)
            ->concat($instrument->programs)
            ->filter(function ($item) {
                return $item->user !== null;
            })
            ->map(function ($item) {
                return $item->setAttribute('model_type', class_basename($item));
            })
            ->values();

        if ($user->isAuditee()) {
            return $instrument->units->contains(function ($unit) use ($user, $instrument) {
                $userInUnit = $unit->user && $unit->user->id === $user->id;

                $userMatchesUnit = !$unit?->user && (
                    ($unit?->unit_name === 'Fakultas' && $user->isFaculty()) ||
                    ($unit?->unit_name === 'Jurusan' && $user->isDepartment()) ||
                    ($unit?->unit_name === 'Program Studi' && $user->isProgram())
                );

                $data = $instrument->entityTeams()
                    ->where('entity_id', $user->entityId())
                    ->where('entity_type', $user->entityType())
                    ->first();

                return isset($data->team) && ($userInUnit || $userMatchesUnit);
            });
        }

        if ($user->isAuditor()) {
            foreach ($areas as $area) {
                $data = $instrument->entityTeams()
                    ->where('entity_id', $area->id)
                    ->where('entity_type', $area->model_type)
                    ->first();

                if ($data && $data->team) {
                    $isChiefAuditor = $data->team->chief == $user->auditor;
                    $isMemberAuditor = $data->team->members->contains($user->auditor);

                    if ($isChiefAuditor || $isMemberAuditor) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    public function viewAnySurvey(User $user): bool
    {
        return $user->isAuditee() || $user->isAuditor();
    }

    public function viewSurvey(User $user, Instrument $instrument): bool
    {
        return $user->isAuditee() || $user->isAuditor();
    }

    public function submitSurvey(User $user, Instrument $instrument): bool
    {
        $area = $user->entityId() . $user->entityType();

        // Get the current date
        $today = today(); // Assuming you're using Carbon for date handling

        return $user->isAuditee() &&
            ($instrument->auditStatus($area) == AuditStatus::PENDING ||
                $instrument->auditStatus($area) == AuditStatus::REJECTED ||
                $instrument->auditStatus($area) == AuditStatus::COMPLETE) &&
            $today->between($instrument->periode->start_date, $instrument->periode->end_date);
    }

    public function showAuditResults(User $user, Instrument $instrument): bool
    {
        $area = request('area');
        if ($user->isProgram()) {
            $area = $user->program->id . 'Program';
        }
        $status = $instrument->auditStatus($area);
        return $user->isAuditor() || ($user->isAuditee() && ($status == AuditStatus::PROCESS || $status == AuditStatus::COMPLETE));
    }

    public function submitAuditResults(User $user, Instrument $instrument): bool
    {
        $status = $instrument->auditStatus(request('area'));
        return $user->isAuditor() && ($status == AuditStatus::PENDING || $status == AuditStatus::REJECTED || $status == AuditStatus::COMPLETE);
    }

    public function showComplianceResults(User $user, Instrument $instrument): bool
    {
        $area = request('area');
        if ($user->isProgram()) {
            $area = $user->program->id . 'Program';
        }
        $status = $instrument->auditStatus($area);
        return $user->isAuditor() || ($user->isAuditee() && ($status == AuditStatus::PROCESS || $status == AuditStatus::COMPLETE));
    }

    public function submitComplianceResults(User $user, Instrument $instrument): bool
    {
        $status = $instrument->auditStatus(request('area'));
        return $user->isAuditor() && ($status == AuditStatus::PENDING || $status == AuditStatus::REJECTED || $status == AuditStatus::COMPLETE);
    }

    public function showNoncomplianceResults(User $user, Instrument $instrument): bool
    {
        $area = request('area');
        if ($user->isProgram()) {
            $area = $user->program->id . 'Program';
        }
        $status = $instrument->auditStatus($area);
        return $user->isAuditor() || ($user->isAuditee() && ($status == AuditStatus::PROCESS || $status == AuditStatus::COMPLETE));
    }

    public function submitNoncomplianceResults(User $user, Instrument $instrument): bool
    {
        $status = $instrument->auditStatus(request('area'));
        return $user->isAuditor() && ($status == AuditStatus::PENDING || $status == AuditStatus::REJECTED || $status == AuditStatus::COMPLETE);
    }

    public function showPTK(User $user, Instrument $instrument): bool
    {
        $area = request('area');
        if ($user->isProgram()) {
            $area = $user->program->id . 'Program';
        }
        $status = $instrument->auditStatus($area);
        return $user->isAuditor() || ($user->isAuditee() && ($status == AuditStatus::PROCESS || $status == AuditStatus::COMPLETE));
    }

    public function submitPTK(User $user, Instrument $instrument): bool
    {
        $status = $instrument->auditStatus(request('area'));
        return $user->isAuditor() && ($status == AuditStatus::PENDING || $status == AuditStatus::REJECTED || $status == AuditStatus::COMPLETE);
    }

    public function showPTP(User $user, Instrument $instrument): bool
    {
        $area = request('area');
        if ($user->isProgram()) {
            $area = $user->program->id . 'Program';
        }
        $status = $instrument->auditStatus($area);
        return $user->isAuditor() || ($user->isAuditee() && ($status == AuditStatus::PROCESS || $status == AuditStatus::COMPLETE));
    }

    public function submitPTP(User $user, Instrument $instrument): bool
    {
        $status = $instrument->auditStatus(request('area'));
        return $user->isAuditor() && ($status == AuditStatus::PENDING || $status == AuditStatus::REJECTED || $status == AuditStatus::COMPLETE);
    }

    public function processAudit(User $user, Instrument $instrument): bool
    {
        $status = $instrument->auditStatus(request('area'));
        return $user->isAuditor() && ($status == AuditStatus::PENDING || $status == AuditStatus::REJECTED);
    }

    public function rejectAudit(User $user, Instrument $instrument): bool
    {
        $status = $instrument->auditStatus(request('area') ?? $user->entityId() . $user->entityType());
        return $user->isAuditee() && $status == AuditStatus::PROCESS;
    }

    public function completeAudit(User $user, Instrument $instrument): bool
    {
        $status = $instrument->auditStatus(request('area') ?? $user->entityId() . $user->entityType());
        return $user->isAuditee() && $status == AuditStatus::PROCESS;
    }

    public function showReport(User $user, Instrument $instrument): bool
    {
        $status = $instrument->auditStatus(request('area') ?? $user->entityId() . $user->entityType());
        return $status == AuditStatus::COMPLETE;
    }
}
