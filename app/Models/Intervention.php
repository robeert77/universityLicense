<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Intervention extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'user_id', 'title', 'description', 'date', 'start_time', 'end_time'
    ];

    public function scopeFilters(Builder $query, array $filters)
    {
        if (!empty($filters['title'])) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

       if (!empty($filters['start_date'])) {
           $query->where('date', '>=', $filters['start_date']);
       }

        if (!empty($filters['end_date'])) {
            $query->where('date', '<=', $filters['end_date']);
        }

        return $query;
    }

    public static function getDurationForMonthForUser(Carbon $date, ?User $user = null) : array
    {
        $user ??= auth()->user();

        $interventions = self::where('user_id', $user->id)
            ->whereMonth('date', $date->month)
            ->whereYear('date', $date->year)
            ->get(['start_time', 'end_time']);

        $totalSeconds = 0;

        foreach ($interventions as $intervention) {
            $start = Carbon::parse($intervention->start_time);
            $end = Carbon::parse($intervention->end_time);
            $totalSeconds += $start->diffInSeconds($end);
        }

        return [
            'h' => (int) ($totalSeconds / 3600),
            'm' => (int) (($totalSeconds % 3600) / 60),
        ];
    }

    public static function getInterventionDaysByMonthAndYear(Carbon $date, Company $company)
    {
        return self::whereMonth('date', $date->month)
            ->whereYear('date', $date->year)
            ->where('company_id', $company->id)
            ->orderBy('date', 'asc')
            ->pluck('date')
            ->map(fn($date) => Carbon::parse($date)->day)
            ->unique()
            ->values();
    }

    public function validationRules(): array
    {
        return [
            'company_id'    => 'required|exists:companies,id',
            'user_id'       => 'nullable|exists:users,id',
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'date'          => 'required|date',
            'start_time'    => 'required|date_format:H:i',
            'end_time'      => 'nullable|date_format:H:i',
        ];
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
