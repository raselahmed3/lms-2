<?php

namespace App\Http\Livewire;

use App\Models\Course;
use App\Models\Curriculum;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CourseCreate extends Component
{

    public $name;
    public $description;
    public $image;
    public $price;
    public $selectedDays = [];
    public $time;
    public $end_date;

    public $days = [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday'
    ];

    protected $rules = [
        'name' => 'required|unique:courses,name',
        'description' => 'required',
        'image' => 'required',
        'price' => 'required',
    ];


    public function formSubmit() {
        $this->validate();
        $course = Course::create([
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'price' => $this->price,
            'user_id' => Auth::user()->id
        ]);

        $course_id = $course->id;
        foreach($this->selectedDays as $day) {

            $i = 1;
            $start_date = new DateTime(Carbon::now());
            $end_date =   new DateTime($this->end_date);
            $interval =  new DateInterval('P1D');
            $date_range = new DatePeriod($start_date, $interval, $end_date);
            foreach ($date_range as $date) {
                if($date->format("l") === "Sunday"){
                    $curriculum = Curriculum::create([
                        'name' => $this->name.' '.$i++,
                        'course_id' => $course_id,
                    ]);
                }
            }
            $i++;
        }

        flash()->addSuccess('Course created successfully');

        return redirect()->route('course.index');
    }


    public function render()
    {
        return view('livewire.course-create');
    }
}
