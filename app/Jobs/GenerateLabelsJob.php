<?php

namespace App\Jobs;

use App\Models\Student;
use App\Models\Label;
use App\Service\MetisClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateLabelsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $studentData;
    protected $student;

    public function __construct($studentData, Student $student)
    {
        $this->studentData = $studentData;
        $this->student = $student;
    }

    public function handle()
    {
        $studentInfo = [
            'skills_interests' => $this->studentData[3],
            'registration_status' => $this->studentData[4],
            'comments_notes' => $this->studentData[5],
        ];

        $query = "Based on the following student information, suggest labels (e.g., 'programming', 'HR'):\n" . json_encode($studentInfo);
        $response = MetisClient::getClient()->chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'system', 'content' => "You are an assistant trained to generate labels for students based on their data. Each student has multiple labels, and each label can belong to multiple students. The labels must be in **Farsi** and should be one or two words maximum. Return the labels separated by commas '،' without any additional text."],
                ['role' => 'user', 'content' => $query],
            ],
        ]);

        $assistantMessage = $response->choices[0]->message->content ?? '';
        $labels = explode('،', $assistantMessage);

        foreach ($labels as $label) {
            $label = trim($label);
            if (!empty($label)) {
                $labelModel = Label::firstOrCreate(['name' => $label]);
                $this->student->labels()->syncWithoutDetaching([$labelModel->id]);
            }
        }
    }
}
