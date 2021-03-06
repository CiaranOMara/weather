<?php

namespace App;

use App\Events\ReceivedTemperatureRecord;
use Illuminate\Database\Eloquent\Model;

class Temperature extends Model
{
    use ScopeTrait;

    public $fillable = ['value'];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $events = [
        'created' => ReceivedTemperatureRecord::class,
    ];

    public function signal() //TODO: move to tait or parent class.
    {
        $watchers = Trigger::where('observing', class_basename(get_class($this)))->get();

        foreach ($watchers as $watcher) {
            $watcher->observeSignal($this); //Note: observe is a static method of the model.
        }
    }
}
