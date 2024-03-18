<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @property integer                                  $id 
 * @property integer                                  $user_id
 * @property User                                     $user
 * @property string                                   $title
 * @property string                                   $description
 * @property string                                   $location
 * @property string                                   $participant
 * @property \Datetime                                $date_initial
 * @property \Datetime                                $date_final
 * @property \Datetime                                $created_at 
 * @property \Datetime                                $created_at 
 * @property \Datetime                                $updated_at 
 * @property User                                     $user belongsTo
 */
class VacationPlan extends Model
{
    use HasFactory;

    /**
     *table name
     */
    protected $table = 'vacation_plan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'user_id',
        'description',
        'date_initial',
        'date_final',
        'location',
        'participant',
    ];

    /**
     * user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function toArray()
    {
        $data = parent::toArray();

        $data['date_final'] = $this->getDate('date_final');
        $data['date_initial'] = $this->getDate('date_initial');

        return $data;
    }



    public function getDate($attr)
    {
        $data = new DateTime($this->{$attr});
        return $data->format('m/d/Y H:i');
    }

    public function setDate($attr, $data)
    {
        $this->{$attr} = DateTime::createFromFormat('m/d/Y H:i', $data)->format("Y-m-d H:i:s");
    }


    public function verification()
    {
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return $user->id == $this->user_id;
    }
}
