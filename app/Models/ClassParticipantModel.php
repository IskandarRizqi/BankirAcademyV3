<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassParticipantModel extends Model
{
	use HasFactory;
	protected $table = 'class_participant';
	protected $fillable = [
		'class_id',
		'user_id',
		'payment_id',
		'certificate',
		'review',
		'review_point',
		'review_time',
		'jumlah',
	];

	public function classPayment()
	{
		return $this->belongsTo(ClassPaymentModel::class, 'payment_id');
	}

	public static function totalRegisteredForClass(int $classId): int
	{
		return (int) static::query()
			->where('class_id', $classId)
			->whereHas('classPayment', function ($query) {
				$query->where('status', 1);
			})
			->sum('jumlah');
	}

	public static function remainingQuotaForClass(int $classId, ?int $participantLimit): ?int
	{
		if (!$participantLimit || $participantLimit < 1) {
			return null;
		}

		return max(0, $participantLimit - static::totalRegisteredForClass($classId));
	}

	public static function hasAvailableQuota(int $classId, int $requestedParticipants, ?int $participantLimit): bool
	{
		$remainingQuota = static::remainingQuotaForClass($classId, $participantLimit);

		return $remainingQuota === null || $requestedParticipants <= $remainingQuota;
	}
}
