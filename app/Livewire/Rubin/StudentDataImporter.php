<?php

namespace App\Livewire\Rubin;

use App\Livewire\Actions\Logout;
use App\Models\ChatHistory;
use App\Models\GlobalChat;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Student;
use App\Jobs\GenerateLabelsJob;
use App\Models\Label;

class StudentDataImporter extends Component
{
    use WithFileUploads;
    public $csvfile;
    public $csvData = [];
    public $headers = [];

    public function uploadcsv()
    {
        $this->validate(['csvfile' => 'required|file|mimes:csv,txt|max:2048']);
        $this->clearExistingStudents();

        $filePath = $this->csvfile->store('csv-files');
        $csvContent = Storage::get($filePath);

        $this->parseCsv($csvContent);
        session()->flash('success', 'فایل CSV با موفقیت بارگذاری شد!');
    }

    public function parseCsv($csvContent)
    {
        $lines = explode("\n", $csvContent);
        $this->csvData = [];
        $this->headers = [];
        $isHeader = true;

        foreach ($lines as $line) {
            $data = str_getcsv($line);
            if ($isHeader) {
                $this->headers = $data;
                $isHeader = false;
            } elseif (count($data) > 1) {
                $this->csvData[] = $data;
                $this->saveStudent($data);
            }
        }
    }

    public function saveStudent($data)
    {
        $student = Student::create([
            'first_name' => trim($data[0]),
            'last_name' => trim($data[1]),
            'contact_info' => trim($data[2]),
            'skills_interests' => trim($data[3]),
            'registration_status' => trim($data[4]) === 'active',
            'comments_notes' => trim($data[5]),
        ]);

        $this->generateLabels($data, $student);
    }

    public function generateLabels($studentData, $student)
    {
        GenerateLabelsJob::dispatch($studentData, $student);
    }
    

    public function clearExistingStudents()
    {
        ChatHistory::truncate();
        GlobalChat::truncate();
        Student::truncate();
        Label::truncate();
    }

    public function logout()
{
    auth()->logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect()->route('login');
}

    public function render()
    {
        return view('livewire.rubin.Student-Data-Importer');
    }
}
