<?php

namespace App\Livewire\Rubin;

use App\Livewire\Actions\Logout;
use Livewire\Component;
use App\Models\Student;
use App\Models\Label;
use App\Models\ChatHistory;
use App\Models\GlobalChat;
use App\Service\MetisClient;
use App\Jobs\GenerateLabelsJob;
use Livewire\WithPagination;

class StudentManagementDashboard extends Component
{
    use WithPagination;
    
    public $selectedStudent = null, $messages = [], $userMessage = '', $globalUserMessage = '';
    public $globalMessages = [], $showStudentList = true, $showGlobalChat = false, $showLabelsView = false;
    public $currentLabel = null, $studentsForLabel = [], $labels = [], $showStudentDetails = false;

    public $editMode = false;
    public $editableStudent = [
        'first_name' => '',
        'last_name' => '',
        'contact_info' => '',
        'skills_interests' => '',
        'registration_status' => '',
        'comments_notes' => '',
    ];

    public function mount()
    {
        $this->globalMessages = GlobalChat::orderBy('created_at', 'asc')->get()->map(fn($msg) => ['user' => $msg->sender === 'user', 'message' => $msg->message])->toArray();
        $this->labels = Label::all();
    }

    public function showStudentsForLabel($labelId)
    {
        $this->currentLabel = Label::with('students')->find($labelId);
        $this->studentsForLabel = $this->currentLabel ? $this->currentLabel->students : [];
        $this->showLabelsView = true;
        $this->showStudentList = false;
        $this->showStudentDetails = false;
    }

    public function toggleLabels()
    {
        $this->showLabelsView = !$this->showLabelsView;
        $this->showStudentList = !$this->showLabelsView;
        $this->showStudentDetails = false;
        $this->studentsForLabel = [];
        $this->currentLabel = null;
    }

    public function toggleStudentList()
    {
        $this->showStudentList = !$this->showStudentList;
        if ($this->showStudentList) {
            $this->showLabelsView = false;
            $this->showStudentDetails = false;
        }
    }

    public function toggleGlobalChat()
    {
        $this->showGlobalChat = !$this->showGlobalChat;
    }

    public function loadMessages($studentId)
    {
        return ChatHistory::where('student_id', $studentId)->orderBy('created_at', 'asc')
            ->get()->map(fn($msg) => ['user' => $msg->sender === 'user', 'message' => $msg->message])->toArray();
    }

    public function showStudent($studentId)
    {
        $this->selectedStudent = Student::with('labels')->find($studentId);
        $this->messages = $this->loadMessages($studentId);
        $this->showStudentDetails = true;
        $this->showStudentList = false;
        $this->showLabelsView = false;

        $this->editableStudent = [
            'first_name' => $this->selectedStudent->first_name,
            'last_name' => $this->selectedStudent->last_name,
            'contact_info' => $this->selectedStudent->contact_info,
            'skills_interests' => $this->selectedStudent->skills_interests,
            'registration_status' => $this->selectedStudent->registration_status,
            'comments_notes' => $this->selectedStudent->comments_notes,
        ];
    }

    public function toggleEditMode()
    {
        $this->editMode = !$this->editMode;
    }

    public function saveStudentChanges()
    {
        if (!$this->selectedStudent) return;

        $this->selectedStudent->update($this->editableStudent);
        $this->editMode = false;

        session()->flash('message', 'اطلاعات دانشجو با موفقیت بروزرسانی شد.');
    }

    public function sendMessage()
    {
        if (empty($this->userMessage) || !$this->selectedStudent) return;

        $this->messages[] = ['user' => true, 'message' => $this->userMessage];
        $this->saveMessage($this->selectedStudent->id, $this->userMessage, 'user');

        $studentInfo = $this->selectedStudent->toJson();
        $query = "Student Info: $studentInfo\nUser Message: $this->userMessage";

        $response = MetisClient::getClient()->chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'system', 'content' => 'You are an assistant trained to help with student data.'],
                ['role' => 'user', 'content' => $query],
            ],
        ]);

        $assistantMessage = $response->choices[0]->message->content ?? 'Sorry, something went wrong.';
        $this->messages[] = ['user' => false, 'message' => $assistantMessage];
        $this->saveMessage($this->selectedStudent->id, $assistantMessage, 'assistant');
        $this->userMessage = '';
    }

    public function saveMessage($studentId, $message, $sender)
    {
        ChatHistory::create(['student_id' => $studentId, 'message' => $message, 'sender' => $sender]);
    }

    public function saveGlobalMessage($message, $sender)
    {
        GlobalChat::create(['message' => $message, 'sender' => $sender]);
    }

    public function sendGlobalMessage()
    {
        if (empty($this->globalUserMessage)) return;

        $this->globalMessages[] = ['user' => true, 'message' => $this->globalUserMessage];
        $this->saveGlobalMessage($this->globalUserMessage, 'user');

        $allStudentsInfo = Student::all()->map(fn($student) => $student->toJson())->join("\n");
        $query = "All Students Info: \n$allStudentsInfo\nUser Message: $this->globalUserMessage";

        $response = MetisClient::getClient()->chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'system', 'content' => 'You are an assistant trained to help with student data. Answer in Persian.'],
                ['role' => 'user', 'content' => $query],
            ],
        ]);

        $assistantMessage = $response->choices[0]->message->content ?? 'Sorry, something went wrong.';
        $this->globalMessages[] = ['user' => false, 'message' => $assistantMessage];
        $this->saveGlobalMessage($assistantMessage, 'assistant');
        $this->globalUserMessage = '';
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
        return view('livewire.rubin.Student-Management-Dashboard', [
            'students' => Student::paginate(10),
        ]);
    }
}