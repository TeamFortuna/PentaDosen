<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\EventModel;

class KalenderController extends Controller
{
    protected $eventModel;

    public function __construct()
    {
        $this->eventModel = new EventModel();
        helper(['form', 'url']);
    }

    public function index()
    {

        $data['user'] = [
            'id' => session()->get('id'),
            'nama' => session()->get('nama'),
            'nidn' => session()->get('nidn'),
            'nip' => session()->get('nip'),
            'inisial' => session()->get('inisial'),
            'jabatan' => session()->get('jabatan'),
            'universitas' => session()->get('universitas'),
            'fakultas' => session()->get('fakultas'),
            'jurusan' => session()->get('jurusan'),
            'email' => session()->get('email'),
            'username' => session()->get('username')
        ];
        return view('kalender', $data);
    }

    public function getEvents()
    {
        $start = $this->request->getGet('start');
        $end = $this->request->getGet('end');
        $userId = session()->get('user_id') ?? 1; // Default to 1 if no session

        $events = $this->eventModel->where('user_id', $userId)
            ->where('start_date >=', $start)
            ->where('start_date <=', $end)
            ->orWhere('end_date >=', $start)
            ->where('end_date <=', $end)
            ->findAll();

        $formattedEvents = [];
        foreach ($events as $event) {
            $formattedEvents[] = [
                'id' => $event['id'],
                'title' => $event['title'],
                'description' => $event['description'],
                'start' => $event['start_date'],
                'end' => $event['end_date'],
                'color' => $event['color'],
                'className' => $event['class_name'],
                'extendedProps' => [
                    'description' => $event['description'],
                    'type' => $event['color'] === '#F43F5E' ? 'deadline' : ($event['color'] === '#6366F1' ? 'research' : ($event['color'] === '#3B82F6' ? 'publication' : ($event['color'] === '#8B5CF6' ? 'hki' : 'other')))
                ]
            ];
        }

        return $this->response->setJSON($formattedEvents);
    }

    public function addEvent()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'title' => 'required',
            'start_date' => 'required',
            'end_date' => 'permit_empty',
            'color' => 'permit_empty',
            'class_name' => 'permit_empty',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $validation->getErrors()
            ]);
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description') ?? '',
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date') ?? $this->request->getPost('start_date'),
            'color' => $this->request->getPost('color') ?? '#6366F1',
            'class_name' => $this->request->getPost('class_name') ?? 'event-research',
            'user_id' => session()->get('user_id') ?? 1,
        ];

        try {
            if ($this->eventModel->insert($data)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Event added successfully',
                    'event_id' => $this->eventModel->getInsertID()
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to add event',
                    'errors' => $this->eventModel->errors()
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Exception: ' . $e->getMessage()
            ]);
        }
    }

    public function updateEvent($id)
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'title' => 'required',
            'start_date' => 'required',
            'end_date' => 'permit_empty',
            'color' => 'permit_empty',
            'class_name' => 'permit_empty',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['status' => 'error', 'message' => $validation->getErrors()]);
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description') ?? '',
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date') ?? $this->request->getPost('start_date'),
            'color' => $this->request->getPost('color') ?? '#6366F1',
            'class_name' => $this->request->getPost('class_name') ?? 'event-research',
        ];

        try {
            if ($this->eventModel->update($id, $data)) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Event updated successfully']);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to update event',
                    'errors' => $this->eventModel->errors()
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Exception: ' . $e->getMessage()
            ]);
        }
    }

    public function deleteEvent($id)
    {
        $event = $this->eventModel->find($id);

        if (!$event) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Event not found']);
        }

        try {
            if ($this->eventModel->delete($id)) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Event deleted successfully']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete event']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Exception: ' . $e->getMessage()
            ]);
        }
    }
}
